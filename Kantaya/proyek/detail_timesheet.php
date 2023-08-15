<?php
/************************************************
Nama File : detail_timesheet.php
Fungsi    : Tampilan detail time sheet
            personil tertentu dalam satu proyek.
Dibuat    :	
 Tgl.     : 07-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   : 

************************************************/

include ('../lib/cek_sesi.inc');
include ('../lib/akses_unit.php');
include ('../lib/fs_kalender.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

$tglkegiatan = $pthn."-".$pbln."-".$ptgl;
$tgldibuat = date("Y-m-d H:i:s");
$tgldiubah = date("Y-m-d H:i:s");

echo "<html>\n";
echo "<head>\n";
echo "<title>Detail Time Sheet Tiap Personil</title>\n";
echo "<link rel=stylesheet type='text/css' href='".$css."'>";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>";
?>

<script language="JavaScript">
<!--
function showCldList(fld, dflt, range) {
  window.open("/lib/kalender.php?pfld="+fld+"&pdflt="+dflt+"&prange="+range, "List", "width=270,height=180");
};
// -->
</script>

<?php
echo "</head>\n";
echo "<body>\n";


$sqlwherekegiatan = "";

if ($psubmitkegiatan=="Refresh") {
	 if ($ptglmulai=='0' or $pblnmulai=='0' or $pthnmulai=='0') {
	 		$tglmulai = date("Y-m-d", mktime(0,0,0,0,0,0)); 
	 } else {
	 		$tglmulai = date("Y-m-d", mktime(0,0,0,$pblnmulai,$ptglmulai,$pthnmulai)); 	 
			$sqlwherekegiatan = $sqlwherekegiatan."AND tgl_kegiatan >= '$tglmulai' ";
	 }
	 if ($ptglakhir=='0' or $pblnakhir=='0' or $pthnakhir=='0') {
	 		$tglakhir = date("Y-m-d", mktime(0,0,0,12,31,2010)); 
	 } else {
	 		$tglakhir = date("Y-m-d", mktime(0,0,0,$pblnakhir,$ptglakhir,$pthnakhir)); 
			$sqlwherekegiatan = $sqlwherekegiatan."AND tgl_kegiatan <= '$tglakhir' ";	 	 
	 }
	 if ($tglakhir <= $tglmulai) {
	 		echo "
					 <table width='100%' Border='0'>
					 				<tr>
											<td class='judul1' align='left'>Konfirmasi</td>
									</tr>
									<tr>
											<td><b>S.d. Tgl.</b> lebih kecil atau sama dengan <b>Dari Tgl.</b>, Anda dianggap ingin menampilkan semua kegiatan.</td>
									</tr>
						</table>
			";
	 		$tglmulai = date("Y-m-d", mktime(0,0,0,0,0,0));
	 		$tglakhir = date("Y-m-d", mktime(0,0,0,12,31,2010));	
			$sqlwherekegiatan = "";
			$sqlwherekegiatan = $sqlwherekegiatan."AND tgl_kegiatan >= '$tglmulai' ";
			$sqlwherekegiatan = $sqlwherekegiatan."AND tgl_kegiatan <= '$tglakhir' ";
	 }	 
}

if ($psubmit=="Simpan") {
 if ($ptotaljam=="" or $proyek=='0' or $kegiatan=='0') {
 		echo " <table width='100%' Border='0'>
				 	 <tr>
				 		 			<td class='judul1' align='left'>Konfirmasi</td>
				 	 </tr>
				 	 <tr>
				 		 	 <td>Ada Field Wajib yang belum diisi, penyimpanan dibatalkan.</td>
				 	 </tr>	
					 </table>	
 		";
		$batal = "ya";
		echo "</body>\n";
		echo "</html>\n";
  } else {
 	 $kodepersonil = $kode_pengguna;	
	 $sqltext = "INSERT INTO timesheet_proyek (kode_proyek, no_kegiatan, tgl_kegiatan, kode_personil, total_jam, dibuat_oleh, tgl_dibuat, diubah_oleh, tgl_diubah) VALUES (".$proyek.",'".$kegiatan."','".$tglkegiatan."',".$kode_pengguna.",".$ptotaljam.",".$kode_pengguna.",'".$tgldibuat."',".$kode_pengguna.",'".$tgldiubah."')";
	 $hsl_simpan = mysql_query($sqltext, $db);
	  if (mysql_error())  {
	 		echo "
					 <table width='100%' Border='0'>
					 				<tr>
											<td class='judul1' align='left'>Konfirmasi</td>
									</tr>
									<tr>
											<td><b>Error : </b>".mysql_error()."<br>Penyimpanan gagal.</td>
									</tr>
						</table>
			";
			$batal = "ya";
	  }
  }		
}

//Jika $batal<>"ya".

if ($batal<>"ya") {

$hsl_proyek = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran FROM proyek WHERE kode_proyek='$proyek'", $db) or mysql_error();
while ($baris=mysql_fetch_array($hsl_proyek)) {
			$noproyek = $baris["no_proyek"];
			$namaproyek = $baris["nama_proyek"];
			$thnanggaran = $baris["tahun_anggaran"];			
}
mysql_free_result ($hsl_proyek);

$hsl_personil = mysql_query("SELECT nama_pengguna FROM pengguna WHERE kode_pengguna='$kodepersonil'", $db) or mysql_error();
$namapersonil = mysql_result($hsl_personil,0,"nama_pengguna");
mysql_free_result ($hsl_personil);
	
echo "
<form name=detailtimesheet method=post action=detail_timesheet.php>
<table width='100%' Border='0'>
	<tr>
			<td class='judul1' align='left' colspan=4><b>Detail Time Sheet Tiap Personil Proyek</b></td>
	</tr>
	<tr>
			<td width=15% >No. Proyek</td><td colspan=3> : ".$noproyek."</td>
			<input type=hidden name=proyek value=".$proyek.">
	</tr>	
	<tr>
			<td width=15% >Nama Proyek</td><td colspan=3> : ".$namaproyek."</td>
	</tr>
	<tr>
			<td width=15% >Tahun</td><td colspan=3> : ".$thnanggaran."</td>
	</tr>
	<tr>
			<td width=15% >Personil</td><td colspan=3> : <font color=red>".$namapersonil."</font></td>
			<input type=hidden name=kodepersonil value=".$kodepersonil.">			
	</tr>	
	<tr>
			<td width=15% >Dari Tgl.</td>
				    <td colspan=2> : 
		<select name=ptglmulai>
";
if ($psubmitkegiatan == "Refresh" and $ptglmulai<>'0' and $pblnmulai<>'0' and $pthnmulai<>'0') {		
	 echo "	<option selected value=".$ptglmulai.">".$ptglmulai;
} else {	 
	echo "	<option selected value='0'>Tgl.";
}	
			for ($i=1; $i<=31; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pblnmulai>
";
if ($psubmitkegiatan == "Refresh" and $ptglmulai<>'0' and $pblnmulai<>'0' and $pthnmulai<>'0') {		
	 echo "	<option selected value=".$pblnmulai.">".namabulan("S", $pblnmulai);
} else {	 
	echo "	<option selected value='0'>Bulan";
}	
			for ($i=1; $i<=12; $i++) {
				$nmbln = namabulan("S", $i);
echo"				<option value=".$i.">".$nmbln;
			}
echo"
		</select>
		<select name=pthnmulai>
";
if ($psubmitkegiatan == "Refresh" and $ptglmulai<>'0' and $pblnmulai<>'0' and $pthnmulai<>'0') {		
	 echo "	<option selected value=".$pthnmulai.">".$pthnmulai;
} else {	 
	echo "	<option selected value='0'>Tahun";
}	
			for ($i=2001; $i<=2002; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
";
?>

<?php
		$range = date('Y').",".(date('Y')+1);
		$tglsaatini = date('j')."/".date('n')."/".date('Y');
?>
		 <a href="javascript:showCldList('detailtimesheet,ptglmulai,pblnmulai,pthnmulai','<?=$tglsaatini?>','<?=$range?>')"><font size=1><img border=0 width=17 height=18 src=cld.gif></font></a> 
<?php
echo"
	    </td>
			<td  colspan=2><input type=submit name=psubmitkegiatan value='Semua'</td>
	</tr>	
	<tr>
			<td width=15% >s.d. Tgl.</td>
				    <td colspan=2> : 
		<select name=ptglakhir>
";
if ($psubmitkegiatan == "Refresh"  and $ptglakhir<>'0' and $pblnakhir<>'0' and $pthnakhir<>'0') {		
	 echo "	<option selected value=".$ptglakhir.">".$ptglakhir;
} else {	 
	echo "	<option selected value='0'>Tgl.";
}	
			for ($i=1; $i<=31; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pblnakhir>
";
if ($psubmitkegiatan == "Refresh"  and $ptglakhir<>'0' and $pblnakhir<>'0' and $pthnakhir<>'0') {		
	 echo "	<option selected value=".$pblnakhir.">".namabulan("S", $pblnakhir);
} else {	 
	echo "	<option selected value='0'>Bulan";
}	
			for ($i=1; $i<=12; $i++) {
				$nmbln = namabulan("S", $i);
echo"				<option value=".$i.">".$nmbln;
			}
echo"
		</select>
		<select name=pthnakhir>
";
if ($psubmitkegiatan == "Refresh"  and $ptglakhir<>'0' and $pblnakhir<>'0' and $pthnakhir<>'0') {		
	 echo "	<option selected value=".$pthnakhir.">".$pthnakhir;
} else {	 
	echo "	<option selected value='0'>Tahun";
}		
			for ($i=2001; $i<=2002; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
";
?>

<?php
		$range = date('Y').",".(date('Y')+1);
		$tglsaatini = date('j')."/".date('n')."/".date('Y');
?>
		 <a href="javascript:showCldList('detailtimesheet,ptglakhir,pblnakhir,pthnakhir','<?=$tglsaatini?>','<?=$range?>')"><font size=1><img border=0 width=17 height=18 src=cld.gif></font></a> 
<?php
echo"
	    </td>
			<td  colspan=2><input type=submit name=psubmitkegiatan value='Refresh'</td>			
	</tr>	
	<tr>
			<td class='judul2' align=center>Tanggal</td>
			<td class='judul2' width=5% align=center>No. Kegiatan</td>			
			<td class='judul2' align=center>Nama Kegiatan</td>
			<td class='judul2' align=center>Jam</td>
   </tr>			
";

$sqlselect = "SELECT tgl_kegiatan, no_kegiatan, total_jam FROM timesheet_proyek "; 
$sqlwhere = "WHERE kode_proyek='$proyek' AND kode_personil='$kodepersonil' ".$sqlwherekegiatan; 
$sqlorderby = "ORDER BY tgl_kegiatan ";
$sqltext = $sqlselect.$sqlwhere.$sqlorderby;

$hsl_detailtimesheet = mysql_query($sqltext, $db) or mysql_error();
while ($baris=mysql_fetch_array($hsl_detailtimesheet)) {
			$tglkegiatan = $baris["tgl_kegiatan"];
			$totaljam = $baris["total_jam"];
			$totaljamsetahun = $totaljamsetahun + $totaljam;
			$nokegiatan = $baris["no_kegiatan"];
			$hsl_namakegiatan = mysql_query("SELECT nama_kegiatan FROM jadwal_proyek WHERE no_kegiatan='$nokegiatan'", $db) or mysql_error();
			$namakegiatan = mysql_result($hsl_namakegiatan,0,"nama_kegiatan");
			
			list($th,$bl,$tg) = split('-',$tglkegiatan);
			if ($bl[0]=="0") { $bl=$bl[1]; }
			$nm_bl = namabulan('S', $bl);
		
			echo "<tr>
					 			<td class='isi2' align=center>".$tg." ".$nm_bl.". ".$th."</a></td>
					 			<td class='isi2' align=center>".$nokegiatan."</a></td>
					 			<td class='isi2'>".$namakegiatan."</a></td>
					 			<td class='isi2' align=right>".$totaljam."</a></td>																								
						</tr>";	
			mysql_free_result ($hsl_namakegiatan);
}	
mysql_free_result ($hsl_detailtimesheet);

echo "	

	<tr>
			<td class='judul2' align=center colspan=2>Total Jam</td>
			<td class='isi2'>&nbsp;</td>		
			<td class='isi2' align=right><b>".$totaljamsetahun."</b></td>
   </tr>		
</table>	
</form>
";

}

echo "</body>\n";
echo "</html>\n";

?>



