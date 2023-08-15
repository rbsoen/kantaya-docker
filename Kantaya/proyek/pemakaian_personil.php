<?php
/***********************************************
Nama File : pemakaian_personil.php
Fungsi    : Tampilan perencanaan penugasan
            personil dalam semua proyek selama
            setahun tertentu. (Ditampilkan
            per bulan).
Dibuat    :	
 Tgl.     : 14-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   : 

************************************************/

include ('../lib/cek_sesi.inc'); 
include ('../lib/fs_kalender.php');
include ('akses_unit_kebawah.php'); 
include ('rekap_pemakaian_personil.php');
require("../lib/kantaya_cfg.php");
$css = "../css/".$tampilan_css.".css";

//Warna indikasi orang jam.
$hijau = "#00B03A";
$kuning = "#FFCC00";
$merah = "red";
$hitam = "black";

//Angka batas bisa, hampir penuh dan sudah penuh.
$bisabawah = 0;
$bisaatas = 80;
$hampirbawah = 81;
$hampiratas = 120;
$penuhbawah = 121;
$penuhatas = 160;


function list_abjad($pseunit, $punitnav, $abjad) {
  echo"
   		 <table width=100% >
			 				<tr>
	";
							 if ($abjad=="Semua") {
	echo"						<td class='judul2'>Semua</td> ";							 
							 } else {
	echo"						<td class='judul2'><a href='pemakaian_personil.php?pabjad=Semua&punitnav=".$punitnav."&pseunit=".$pseunit."'>Semua</a></td>  ";
							 }
						
									$A = ord("A");
									$Z = ord("Z");

	 								for ($i=$A; $i<=$Z; $i++) {
											$huruf = chr($i);
											if ($abjad==$huruf) {
  echo"									 <td align=center class='judul2'>$huruf</td>	";
											} else {
  echo"									 <td align=center class='judul2'><a href='pemakaian_personil.php?pabjad=".$huruf."&punitnav=".$punitnav."&pseunit=".$pseunit."'>$huruf</a></td>	";
											}											
	 								}
	echo" 
	 						</tr>
				</table>
	";
}


//Tampilkan pemakaian personil per abjad di unit bersangkutan.
function pemakaian_personil_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db) {
global $dimana, $hijau, $kuning, $merah, $hitam, $thn, $totalorangjamperbulan;
global $bisabawah, $bisaatas, $hampirbawah, $hampiratas, $penuhbawah, $penuhatas;

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

echo"
  <tr>
			<td class='judul2' colspan=14 >".$nmunt."</td>
	</tr>
";

echo"
	<tr>
		<td class='judul2'>Nama</td>
";

if ($pseunit=="tidak") {		
echo"				<td class='judul2'>Unit</td> ";
}		

for ($i=1; $i<=12; $i++) {
		echo "<td class='judul2' width=5% align=center>".namabulan("S",$i)."</td>";
}

echo"
	</tr>
";
  $hasil = mysql_query($sqltext, $db);
	while ($baris=mysql_fetch_array($hasil)) {
	  $kodepgn 		= $baris["kode_pengguna"];
		$nama 			= $baris["nama_pengguna"];
		$kodeunit 	= $baris["unit_kerja"];
		$hsl_unit = mysql_query("SELECT singkatan_unit FROM unit_kerja WHERE kode_unit ='$kodeunit'", $db);
		$namaunit = mysql_result($hsl_unit,0,"singkatan_unit");
		
//------khusus menampilkan yang sesuai abjad di unit bersangkutan------------
if (($pabjad==strtoupper($nama[0])) or ($pabjad=="Semua"))  {
	
echo"
	<tr>
		<td class='isi2'>".$nama."</td>
";

if ($pseunit=="tidak") {		
	 echo"		<td class='isi2'>".$namaunit."</td> ";
}

for ($i=1; $i<=12; $i++) {
		$total = round($totalorangjamperbulan[$kodepgn][$i][$thn]);
		if ($total<=$bisaatas) { 
			 $warnadasar = $hijau; 
			 $warnatext = $hitam;
		} elseif ($total>$bisabawah AND $total <=$hampiratas) { 
			 $warnadasar = $kuning;
			 $warnatext = $hitam;			 
		} else { 
			 $warnadasar = $merah;
			 $warnatext = $kuning;			 
		}
		echo "<td width=5% align=center bgcolor=".$warnadasar."><font color=".$warnatext.">".$total."</font></td>";
}


echo"
	</tr>
";
}
//---------------------------

	}
echo"
</table>
<table width=100% border='0' >
	<tr>
			&nbsp
	</tr>
	<tr>
		<td colspan=2><b>Keterangan : </b></td>
	</tr>
	<tr>
		<td width=5% bgcolor=".$hijau.">&nbsp</td><td> = ".$bisabawah." - ".$bisaatas." Orang Jam</td>
	</tr>
	<tr>
		<td width=5% bgcolor=".$kuning.">&nbsp</td><td> = ".$hampirbawah." - ".$hampiratas." Orang Jam</td>
	</tr>
	<tr>
		<td width=5% bgcolor=".$merah.">&nbsp</td><td> = ".$penuhbawah." - ".$penuhatas." Orang Jam</td>
	</tr>
</table>
";

//mysql_free_result($hasil);				 
}

echo "<html>\n";
echo "<head>\n";
echo "<title>Pemakaian Personil</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

$db = mysql_connect($host, $root) or mysql_error(); 
mysql_select_db($database, $db) or mysql_error(); 

//Judul Pemakaian Personil.
$tgl = date("d");
$bln = namabulan("P", date("n"));
$thn = date("Y");
$hari = namahari("P", date("w"));
$jam = date("H");
$mnt = date("i");
$dtk = date("s");

echo"
<table width=100% border='0'>
	<tr>
		<td class='judul1' colspan=3>Pemakaian Personil dalam Kegiatan Proyek</td>
	</tr>
	<tr>
			<td width=20% >Tahun</td><td width=2% > : </td><td><b><font color=red>".$thn."</font></b></td>
	</tr>	
	<tr>
			<td width=20% >Satuan</td><td width=2% > : </td><td>Orang Jam</td>
	</tr>		
</table>
";

$ppengguna = $kode_pengguna;
$tgldibuat = date("Y-m-d H:i:s");
$tgldiubah = date("Y-m-d H:i:s");


//Pengisian array data rekap total orang jam per bulan per tahun.
$hasil = mysql_query("SELECT kode_proyek, no_kegiatan, kode_pengguna, orang_jam FROM penugasan_personil", $db);
while ($baris=mysql_fetch_array($hasil)) {
				$kodeproyek = $baris["kode_proyek"];
				$nokegiatan = $baris["no_kegiatan"];	
				$personil 	= $baris["kode_pengguna"];
				$orangjam 	= $baris["orang_jam"]; 	
				hitung_totalorangjam_perbulan_dalamsetahun_tiappersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);		
}
mysql_free_result ($hasil);

//Cek unit yang dipilih.
if ($punitnav=="") {
   $punitnav = $unit_pengguna;
 	 $pabjad = "Semua";
	 $pseunit = "ya";	 
	 pemakaian_personil_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db);
} elseif ($pcari=="" and $punitnav<>"") {
	 pemakaian_personil_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db);
}


if ($pcari=="Cari!" and $pkatakunci<>"")  {
 	 $pabjad = "Semua";
	 pemakaian_personil_perunit($pseunit, $punitnav, $pabjad, $pkatakunci, $db);
}

mysql_close ($db);

echo "</body>\n";
echo "</html>\n";
?>
