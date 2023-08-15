<?php
/******************************************
Nama File : keberadaan.php
Fungsi    : Menyimpan sekaligus menampilkan
            keberadaan pengguna berdasarkan
            unit kerja yang dipilih.
Dibuat    :	
 Tgl.     : 02-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

include ('../lib/cek_sesi.inc'); 
include ('../lib/fs_kalender.php');
include ('akses_unit_kebawah.php'); 
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

function list_abjad($pseunit, $punitnav, $abjad) {
  echo"
   		 <table width=100% >
			 				<tr>
	";
							 if ($abjad=="Semua") {
	echo"						<td class='judul2'>Semua</td> ";							 
							 } else {
	echo"						<td class='judul2'><a href='keberadaan.php?pabjad=Semua&punitnav=".$punitnav."&pseunit=".$pseunit."'>Semua</a></td>  ";
							 }
						
									$A = ord("A");
									$Z = ord("Z");

	 								for ($i=$A; $i<=$Z; $i++) {
											$huruf = chr($i);
											if ($abjad==$huruf) {
  echo"									 <td align=center class='judul2'>$huruf</td>	";
											} else {
  echo"									 <td align=center class='judul2'><a href='keberadaan.php?pabjad=".$huruf."&punitnav=".$punitnav."&pseunit=".$pseunit."'>$huruf</a></td>	";
											}											
	 								}
	echo" 
	 						</tr>
				</table>
	";
}


//Tampilkan keberadaan pengguna per abjad di unit bersangkutan.
function keberadaan_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db) {
global $dimana;
list_abjad($pseunit, $punitnav, $pabjad);

list_akses_unit($db,$punitnav,&$aksesunit);

$ttlunit = count($aksesunit);
for ($i=0; $i<$ttlunit; $i++) {
				$unit[$i] = $aksesunit[$i][0];
}
$sqlwhere = "WHERE (unit_kerja = '".$punitnav."' OR unit_kerja = '";
if ($ttlunit<>0) {
  foreach ($unit as $isi) {
		  		$sqlwhere = $sqlwhere.$isi."' OR unit_kerja = '";
  }
}
$sqlwhere = substr ($sqlwhere, 0, -18).")";

if ($pkatakunci<>"") {
	 $sqlwhere = $sqlwhere." AND nama_pengguna LIKE '%$pkatakunci%'";
}

$sqltext = "SELECT kode_pengguna, nama_pengguna, unit_kerja FROM pengguna ";
$sqltext = $sqltext.$sqlwhere." ORDER BY nama_pengguna";

$unt = mysql_query("SELECT nama_unit FROM unit_kerja WHERE kode_unit = '$punitnav'", $db) or mysql_error();
$nmunt = mysql_result($unt,0,"nama_unit");
echo"
<table width=100% >
";

//if ($pseunit=="ya") {
echo"
  <tr>
			<td class='judul2' colspan=6 >".$nmunt."</td>
	</tr>
";

//}
echo"
	<tr>
		<td align=center class='judul2'>Nama</td>
";

if ($pseunit=="tidak") {		
echo"				<td class='judul2'>Unit</td> ";
}		

echo"
		<td align=center class='judul2'>Berada</td>
		<td align=center class='judul2'>Data<br>Tgl. Jam</td>
		<td align=center class='judul2'>Ket.</td>
		<td align=center class='judul2'>Cek Agenda</td>		
	</tr>
";
  $hasil = mysql_query($sqltext, $db);
	while ($baris=mysql_fetch_array($hasil)) {
	  $kodepgn 		= $baris["kode_pengguna"];
		$nama 			= $baris["nama_pengguna"];
		$kodeunit 	= $baris["unit_kerja"];
		$hsl_unit = mysql_query("SELECT nama_unit FROM unit_kerja WHERE kode_unit ='$kodeunit'", $db);
		$namaunit = mysql_result($hsl_unit,0,"nama_unit");
		$hsl = mysql_query("SELECT COUNT('x') FROM dimana WHERE kode_pengguna ='$kodepgn'", $db);
		$j = mysql_fetch_array($hsl)	;
		$hsl_dimana = mysql_query("SELECT keberadaan, keterangan, tanggal_dibuat FROM dimana WHERE kode_pengguna ='$kodepgn'", $db);
		if ($j[0]>0) {
			 $keberadaan = mysql_result($hsl_dimana,0,"keberadaan");
			 $datatgljam = mysql_result($hsl_dimana,0,"tanggal_dibuat");
			 $keterangan = mysql_result($hsl_dimana,0,"keterangan");
			 $ket_popup = mysql_result($hsl_dimana,0,"keterangan");			 
		} else {
			 $keberadaan = "-1";
			 $datatgljam = "-";
			 $keterangan = "-";
		}
		
		if ($keterangan==NULL or $keterangan=="") {
			 $keterangan = "-";
		}
		if ($keterangan<>"-") {
			 $keterangan = substr($keterangan,0,3)."...";
		}
		$jam = substr($datatgljam,11,8);
	list($th, $bl, $tg) = split('-',substr($datatgljam,0,10));

//------khusus menampilkan yang sesuai abjad di unit bersangkutan------------
if (($pabjad==strtoupper($nama[0])) or ($pabjad=="Semua"))  {
	
echo"
	<tr>
		<td class='isi2'>".$nama."</td>
";

if ($pseunit=="tidak") {		
echo"		<td class='isi2'>".$namaunit."</td> ";
}

echo"
		<td align=center class='isi2'><font color=red>".$dimana[$keberadaan]."</font></td>
";
if ($tg=="") {
echo " <td align=center class='isi2' width=25% >-</td> ";
} else {
echo " <td align=center class='isi2' width=25% >".$tg." ".namabulan("S",$bl).". ".$th."<br>".$jam."</td>";
}
$tglini = date("j");
$blnini = date("n");
$thnini = date("Y");
echo"
		<td align=center class='isi2'><a href=\"javascript:pop_up_keterangan('$kodepgn')\">".$keterangan."</a></td>
		<td align=center class='isi2'><a href=\"../agenda/agenda_umum.php?ptgl=$tglini&pbln=$blnini&pthn=$thnini&kd_pengguna=$kodepgn\">Cek</a></td>		
	</tr>
";
}
//---------------------------


	}
echo"
</table>
";

//mysql_free_result($hasil);				 
}

//Simpan keberadaan pengguna dan tampilkan hasilnya.
function simpan_keberadaan($pseunit, $punitnav, $pabjad, $ppengguna, $pnamapengguna, $pdimana, $pket, $tgldibuat, $tgldiubah, $db) {

			   $jmlpgn 	= mysql_query("SELECT COUNT(kode_pengguna) FROM dimana WHERE kode_pengguna='$ppengguna'") or mysql_error();
				 $ada =	mysql_result($jmlpgn,0,"COUNT(kode_pengguna)");
				 if ($ada>0) { 	
			   		$hapus = mysql_query("DELETE FROM dimana WHERE kode_pengguna='$ppengguna'") or mysql_error();
				 }
				 $hsl_simpan = mysql_query("INSERT INTO dimana (kode_pengguna, keberadaan, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ("
											.$ppengguna.",'".$pdimana."','".$pket."',".$ppengguna.",'".$tgldibuat."',".$ppengguna.",'".$tgldiubah."')", $db) or mysql_error();
				 $pkatakunci = $pnamapengguna;																						
	 			 keberadaan_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db);

}


echo "<html>\n";
echo "<head>\n";
echo "<title>Keberadaan Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>

<span id="pendule" style="font-size:12pt;font-weight:bold;color:white;position:absolute;left:270;top:15;"></span>

<SCRIPT LANGUAGE="JavaScript">
<!-- Original:  Xavier R. (xav@lougaou.com) -->
<!-- Modified:  Benjamin Wright, Editor -->
<!-- Web Site:  http://www.lougaou.com/ -->

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->

<!-- Begin
function clock() {
if (!document.layers && !document.all) return;
var digital = new Date();
var hours = digital.getHours();
var minutes = digital.getMinutes();
var seconds = digital.getSeconds();
var amOrPm = "AM";

if (minutes <= 9) minutes = "0" + minutes;
if (seconds <= 9) seconds = "0" + seconds;
dispTime = "Pk. " + hours + ":" + minutes + ":" + seconds;

if (document.layers) {
document.layers.pendule.document.write("<font size=3 color=white><b>"+dispTime+"</b></font>");
//document.layers.pendule.document.write(dispTime);
document.layers.pendule.document.close();
}
else
if (document.all)
pendule.innerHTML = dispTime;
setTimeout("clock()", 1000);
}


function pop_up_keterangan(kode) {
		 window.open("popup_ket.php?kd_pengguna="+kode, "List", "width=300,height=200");
}

//  End -->
</script>


<?php
echo "</head>\n";
echo "<body>\n";
//echo "<body onLoad='clock()'>\n";

//Inisialisasi array keberadaan.
$dimana = array (
		"0" => "Tidak Masuk",
		"1" => "Di Dalam Kantor",
		"2" => "Di Luar kantor",
		"3" => "Rapat",
		"-1" => "?"
);

//Judul keberadaan.
$tgl = date("d");
$bln = namabulan("P", date("n"));
$thn = date("Y");
$hari = namahari("P", date("w"));
$jam = date("H");
$mnt = date("i");
$dtk = date("s");
echo"
<table width=100% >
	<tr>
		<td class='judul1'>".$hari.", ".$tgl." ".$bln." ".$thn."</td>
	</tr>
</table>
";

$ppengguna = $kode_pengguna;
$tgldibuat = date("Y-m-d H:i:s");
$tgldiubah = date("Y-m-d H:i:s");


//Jika ada perintah simpan keberadaan atau lihat keberadaan per unit.
if ($psubmit=="Simpan") {
	 $punitnav = $unit_pengguna;
	 $pabjad = "Semua";
	 $pseunit = "ya";		 
	 $pnamapengguna = $nama_pengguna;
	 if ($pket=="" or $pket==NULL) { $pket = "-"; }
	 simpan_keberadaan($pseunit, $punitnav, $pabjad, $ppengguna, $pnamapengguna, $pdimana, $pket, $tgldibuat, $tgldiubah, $db);
} elseif ($punitnav=="") {
   $punitnav = $unit_pengguna;
 	 $pabjad = "Semua";
	 $pseunit = "ya";	 
	 keberadaan_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db);
} elseif ($pcari=="" and $punitnav<>"") {
	 keberadaan_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db);
}


if ($pcari=="Cari!" and $pkatakunci<>"")  {
 	 $pabjad = "Semua";
	 keberadaan_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db);
}

mysql_close ($db);

echo "</body>";
echo "</html>"; 

?>


