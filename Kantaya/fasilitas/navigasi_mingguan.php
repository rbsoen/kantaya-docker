<?php
/******************************************
Nama File : navigasi_mingguan.php
Fungsi    : Navigasi pemesanan mingguan.
Dibuat    :	
 Tgl.     : 17-09-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

include ('../lib/cek_sesi.inc');  
include ('../lib/fs_kalender.php');
include ('../lib/akses_unit.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

$tgl_ini = date("j");
$bln_ini = date("n");
$thn_ini = date("Y");
$jam_ini = date("H");

if ((!isset($P1)) or (!isset($P2))) {
		$bulan = date("n");
		$tahun = date("Y");
} else {
		$bulan = $P1;
		$tahun = $P2;
}		

function cari_mingguke_dan_semuatgl_dimingguini() {
  global $tgl_ini, $bln_ini, $thn_ini;
	$tgl1_hari = date("w",mktime(0,0,0,$bln_ini,1,$thn_ini));
	$jml_hari = jmlharidlmbulan ($bln_ini, $thn_ini);
	$jml_kolom = 7;
	$jml_baris = ceil(($jml_hari+$tgl1_hari-1)/7);
	$mulai = $tgl1_hari-1;
	$tgl = 0;
	if ($mulai < 0) {
		$mulai = 6;
	}
	for ($i=0; $i<$jml_baris; $i++) {
		for ($j=0; $j<$jml_kolom; $j++) {
			if ($i == 0) {
				if ($j >= $mulai) {
					$tgl = $tgl + 1;
				}	else {
					$tgl = 0;
				}
			} else {
				if ($tgl > 0 && $tgl < $jml_hari) {
					$tgl = $tgl + 1;
				}	else {
					$tgl = 0;
				}
			}
			$kalender[$i][$j] = $tgl;
			if ($tgl==$tgl_ini) {
				 $n=$i;
			}
		}
	}
	$kl0 = $kalender[$n][0];
	$kl1 = $kalender[$n][1];
	$kl2 = $kalender[$n][2];
	$kl3 = $kalender[$n][3];
	$kl4 = $kalender[$n][4];
	$kl5 = $kalender[$n][5];
	$kl6 = $kalender[$n][6];
	$mingguke = $n+1;
			
	return array ($kl0, $kl1, $kl2, $kl3, $kl4, $kl5, $kl6, $mingguke);
}
list ($kal0, $kal1, $kal2, $kal3, $kal4, $kal5, $kal6, $mingguke) = cari_mingguke_dan_semuatgl_dimingguini();
//echo $kal0."-".$kal1."-".$kal2."-".$kal3."-".$kal4."-".$kal5."-".$kal6."-".$mingguke;

echo "<html>\n";
echo "<head>\n";
echo "<title>Navigasi Daftar Pemesanan Mingguan (Detail)</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";

?>

<script language="JavaScript">
<!--
function onsubmit(flag,bln,thn)
{
  var M = bln;
  var Y = thn;

  if (flag==1) 
    Y--;
  if (flag==2) 
    M--;
  if (flag==3) 
    M++;
  if (flag==4) 
    Y++;
  if (M==0) {
    M = 12;
    Y--;
  }
  if (M==13) {
    M = 1;
    Y++;
  }
  window.location.href = "navigasi_mingguan.php?P1="+M+"&P2="+Y;
 // return True;  
};

function showCldList(fld, dflt, range) {
  window.open("/lib/kalender.php?pfld="+fld+"&pdflt="+dflt+"&prange="+range, "List", "width=270,height=180");
};

function detailmingguan(kal0,kal1,kal2,kal3,kal4,kal5,kal6,mingguke,bln,thn) {
	fas = document.nav_mingguan.fasilitas;
	var kodefas = fas.options[fas.selectedIndex].value;
	window.open("detail_mingguan.php?pfas="+kodefas+"&pkal0="+kal0+"&pkal1="+kal1+"&pkal2="+kal2+"&pkal3="+kal3+"&pkal4="+kal4+"&pkal5="+kal5+"&pkal6="+kal6+"&pmingguke="+mingguke+"&pbln="+bln+"&pthn="+thn, "isi");
}

function pesandetail() {
	fas = document.nav_mingguan.fasilitas;
	var kodefas = fas.options[fas.selectedIndex].value;
	window.open("pemesanan.php?pfas="+kodefas, "isi");
}

function pesancepat(pemesan) {
	fas = document.nav_mingguan.fasilitas;
	var kodefas = fas.options[fas.selectedIndex].value;
	tgml = document.nav_mingguan.ptglmulai;
	var tglmulai = tgml.options[tgml.selectedIndex].value;
	blml = document.nav_mingguan.pblnmulai;
	var blnmulai = blml.options[blml.selectedIndex].value;
	thml = document.nav_mingguan.pthnmulai;
	var thnmulai = thml.options[thml.selectedIndex].value;	
	jamml = document.nav_mingguan.pjammulai;
	var jammulai = jamml.options[jamml.selectedIndex].value;
	mntml = document.nav_mingguan.pmenitmulai;
	var menitmulai = mntml.options[mntml.selectedIndex].value;
	jamakr = document.nav_mingguan.pjamakhir;
	var jamakhir = jamakr.options[jamakr.selectedIndex].value;
	mntakr = document.nav_mingguan.pmenitakhir;
	var menitakhir = mntakr.options[mntakr.selectedIndex].value;
	var kep = document.nav_mingguan.pkeperluan.value;
	window.open("simpan_pemesanan.php?ppemesan="+pemesan+"&pfas="+kodefas+"&ptglmulai="+tglmulai+"&pblnmulai="+blnmulai+"&pthnmulai="+thnmulai+"&ptglakhir="+tglmulai+"&pblnakhir="+blnmulai+"&pthnakhir="+thnmulai+"&pjammulai="+jammulai+"&pmenitmulai="+menitmulai+"&pjamakhir="+jamakhir+"&pmenitakhir="+menitakhir+"&pketerangan=NULL"+"&pkeperluan="+kep+"&submit=Simpan", "isi");
}

function harian(tgl, bln, thn) {
	window.open("navigasi_harian.php", "navigasi");
	fas = document.nav_mingguan.fasilitas;
	var kodefas = fas.options[fas.selectedIndex].value;
	window.open("detail_harian.php?pfas="+kodefas+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
}

function bulanan(bln, thn) {
	window.open("navigasi_bulanan.php", "navigasi");
	fas = document.nav_mingguan.fasilitas;
	var kodefas = fas.options[fas.selectedIndex].value;
	window.open("detail_bulanan.php?pfas="+kodefas+"&pbln="+bln+"&pthn="+thn, "isi");
}

function ubahdetailmingguan(kal0,kal1,kal2,kal3,kal4,kal5,kal6,mingguke,bln,thn) {
	fas = document.nav_mingguan.fasilitas;
	var kodefas = fas.options[fas.selectedIndex].value;
  //window.open("navigasi_mingguan.php", "navigasi");	
	window.open("detail_mingguan.php?pfas="+kodefas+"&pkal0="+kal0+"&pkal1="+kal1+"&pkal2="+kal2+"&pkal3="+kal3+"&pkal4="+kal4+"&pkal5="+kal5+"&pkal6="+kal6+"&pmingguke="+mingguke+"&pbln="+bln+"&pthn="+thn, "isi");
};


// -->
</script>


<?php

echo "</head>\n";
echo "<body>\n";
echo "<form name=nav_mingguan method=post action=navigasi_mingguan.php>";


list_akses_unit($db,$unit_pengguna,&$aksesunit);
$ttlunit = count($aksesunit);
for ($i=0; $i<$ttlunit; $i++) {
				$unit[$i] = $aksesunit[$i][0];
}
$sqlwhere = "WHERE unit = '";
foreach ($unit as $isi) {
				$sqlwhere = $sqlwhere.$isi."' OR unit = '";
}
$sqlwhere = substr ($sqlwhere, 0, -12);
$sqltext = "SELECT kode_fas, nama_fas, unit FROM fasilitas ";
$sqltext = $sqltext.$sqlwhere." ORDER BY unit";

echo"
<table width=100% >
	<tr>
			<td class='judul1' >Mingguan</td>
	</tr>
</table>
";
//echo $kal0."-".$kal1."-".$kal2."-".$kal3."-".$kal4."-".$kal5."-".$kal6."-".$mingguke;
echo "
<table width=100% >
	<tr><td><font size=2>Pilih Fasilitas :</font></td></tr>
	<tr height=30><td align=center>
    <select name='fasilitas' onChange=\"ubahdetailmingguan('$kal0','$kal1','$kal2','$kal3','$kal4','$kal5','$kal6','$mingguke','$bulan','$tahun')\">				
";
						$hsl_fas = mysql_query($sqltext, $db);
						while ($baris=mysql_fetch_array($hsl_fas)) {
									echo "	<option value=".$baris["kode_fas"].">".$baris["nama_fas"];
						}
						mysql_free_result ($hsl_fas);
;

echo"
		</select>
	</td></tr>
	<tr><td class='judul2'>Kalender</td></tr>
</table>

<table width=100% >
	<tr>
		<td class='judul2'><center><b><a href=\"javascript:harian('$tgl_ini','$bln_ini','$thn_ini')\">Harian</a></center></td>
		<td class='judul2'><center><b>Mingguan</center></td>
		<td class='judul2'><center><a href=\"javascript:bulanan('$bln_ini','$thn_ini')\">Bulanan</a></center></td>
	</tr>
</table>

<table width=100% >
  <tr>
    <td  class='judul2' colspan=7 align=center><b>
";
?>
	<?php
		print("<font size=2><b><a href=\"javascript:onsubmit(1,'$bulan','$tahun')\"> << </a></b>&nbsp;</font>\n");
		print("<font size=2><b><a href=\"javascript:onsubmit(2,'$bulan','$tahun')\"> < </a></b>&nbsp;</font>\n");
		print("<font size=2>".namabulan('P',$bulan)."&nbsp;$tahun&nbsp;&nbsp;</font>\n");
		print("<font size=2><b><a href=\"javascript:onsubmit(3,'$bulan','$tahun')\"> > </a></b>&nbsp;</font>\n");
		print("<font size=2><b><a href=\"javascript:onsubmit(4,'$bulan','$tahun')\"> >></a></b>&nbsp;</font>\n");
	?>
<?php
echo"
    </b></td>
  </tr>
";

	$tgl1_hari = date("w",mktime(0,0,0,$bulan,1,$tahun));
	$mulai = $tgl1_hari-1;
	if ($mulai < 0) {
		$mulai = 6;
	}
	$jml_hari = jmlharidlmbulan ($bulan, $tahun);
	$jml_kolom = 7;
	$jml_baris = ceil(($jml_hari+$mulai)/7);
	$tgl = 0;	

	for ($i=0; $i<$jml_baris; $i++) {

echo"
	<tr>
";
		for ($j=0; $j<$jml_kolom; $j++) {
			if ($i == 0) {
				if ($j >= $mulai) {
					$tgl = $tgl + 1;
				}
				else {
					$tgl = 0;
				}
			}
			else {
				if ($tgl > 0 && $tgl < $jml_hari) {
					$tgl = $tgl + 1;
				}
				else {
					$tgl = 0;
				}
			}
			$kalender[$i][$j] = $tgl;

		}
			$kl0 = $kalender[$i][0];
			$kl1 = $kalender[$i][1];
			$kl2 = $kalender[$i][2];
			$kl3 = $kalender[$i][3];
			$kl4 = $kalender[$i][4];
			$kl5 = $kalender[$i][5];
			$kl6 = $kalender[$i][6];
			$mingguke = $i+1;


echo"
		<td><a href=\"javascript:detailmingguan('$kl0','$kl1','$kl2','$kl3','$kl4','$kl5','$kl6','$mingguke','$bulan','$tahun')\"><center><font size=2>Minggu ke-".($i+1)."</font></center></a></td>
	</tr>
";
	}
echo"
</table>


<table width=100% >
	<tr>
		<td class='judul2'>Tgl. : <b>".date("d")." ".namabulan("P",date("n"))." ".date("Y")."</b></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>	
</table>


<table width=100% >
	<tr>
			<td class='judul1' >Pemesanan</td>
	</tr>
</table>
<table width=100% >
	<tr>
		<td class='judul2'><font size=2><b>Pesan Cepat</b></font></td>
				<td class='judul3' align=center><a href=\"javascript:pesandetail()\">Pesan Detail</a></td>
	</tr>
</table>

<table width=100% >
	<tr>
		<td width=3% class='judul3'>Tgl.</td>
		<td class='isi1'>
			<select name=ptglmulai>
							<option selected value=".$tgl_ini.">".$tgl_ini;
				for ($i=1; $i<=31; $i++) {
echo"					<option value=".$i.">".$i;
				}
echo"
			</select>
			<select name=pblnmulai>
							<option selected value=".$bln_ini.">".namabulan("S", $bln_ini);
				for ($i=1; $i<=12; $i++) {
					$nmbln = namabulan("S", $i);
echo"					<option value=".$i.">".$nmbln;
				}
echo"
			</select>
			<select name=pthnmulai>
";
				for ($i=2001; $i<=2002; $i++) {
echo"					<option value=".$i.">".$i;
				}
echo"
			</select>
";
?>
<?php
			$range = date('Y').",".(date('Y')+1);
			$tglsaatini = date('j')."/".date('n')."/".date('Y')
?>
			<a href="javascript:showCldList('nav_mingguan,ptglmulai,pblnmulai,pthnmulai','<?=$tglsaatini?>','<?=$range?>')"><font size=1><img border=0 width=14 height=15 src=cld.gif></font></a> 
<?php
echo"	
		</td>

	</tr>
	<tr>
		<td class='judul3'>Jam<br>Mulai</td>
		<td class='isi1'>
			<select name=pjammulai>
							<option selected value=".$jam_ini.">".$jam_ini;
				for ($i=0; $i<=23; $i++) {
					if (strlen($i)==1) { $i="0".$i; }
echo"					<option value=".$i.">".$i;
				}
echo"
			</select>
			<select name=pmenitmulai>
";
				for ($i=0; $i<=30; $i=$i+30) {
					if (strlen($i)==1) { $i="0".$i; }
echo"					<option value=".$i.">".$i;
				}
echo"
			</select>
		</td>

	</tr>
	<tr>
		<td class='judul3'>Jam Akhir</td>
		<td class='isi1'>
			<select name=pjamakhir>
							<option selected value=".$jam_ini.">".$jam_ini;
				for ($i=0; $i<=23; $i++) {
					if (strlen($i)==1) { $i="0".$i; }
echo"					<option value=".$i.">".$i;
				}
echo"
			</select>
			<select name=pmenitakhir>
";
				for ($i=0; $i<=30; $i=$i+30) {
					if (strlen($i)==1) { $i="0".$i; }
echo"					<option value=".$i.">".$i;
				}
echo"
			</select>
		</td>
	</tr>
	<tr>
		<td class='judul3'>Kep.</td>
		<td class='isi1' width=100><input type=text size=15 name=pkeperluan></input></td>
	</tr>
	</table>
	
<table width=100% >
	<tr>
		<td align=center><input type=button name=pesan value=PESAN onclick=\"javascript:pesancepat('$kode_pengguna')\"></td>
	</tr>
	<tr>
		<td height=20></td>
	</tr>
	<tr>
			<td class='judul1'>Fasilitas</td>
	</tr>		
	<tr>
";
if ($level==1) {
	echo"
		<td><font size=2><a href=\"setup.php\" target=\"isi\">Pendaftaran Fasilitas</a></font></td>
	    ";
}
echo"
	</tr>
	<tr>
		<td><font size=2><a href=\"list.php\" target=\"isi\">List Fasilitas</a></font></td>
	</tr>
	<tr>
		<td height=20></td>
	</tr>
</table>
</form>
";

mysql_close ($db);

echo "</body>";
echo "</html>";

?>



