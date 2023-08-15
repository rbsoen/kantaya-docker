<?php
/******************************************
Nama File : cari_proyek.php
Fungsi    : Mencari proyek
Dibuat    :	
 Tgl.     : 
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   : 
******************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

echo "<html>\n";
echo "<head>\n";
echo "<title>Hasil Pencarian Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td colspan=2 class='judul1'>List Hasil Pencarian Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

//echo "<h1><b>LIST PROYEK</h1><br>\n";
if ($ktkunci == "") {
     echo "<h1> Error </h1><br>\n";
     echo "Pastikan anda telah mengisikan kata kunci pencarian<br>";
     exit -1;
}
$jmldata = mysql_query("SELECT count(*) FROM proyek WHERE nama_proyek like '%$ktkunci%'", $db);
$jmldata = mysql_fetch_array($jmldata);
$jmlhalaman = ceil($jmldata[0]/$ttlperhalaman);
if ($halaman == "") $halaman = 1;

$query = mysql_query("SELECT * FROM proyek WHERE nama_proyek like '%$ktkunci%' order by tgl_mulai desc", $db);

//echo "<h2><b>Hasil Pencarian Proyek</b></h2><p>\n";
echo "<br>Hasil pencarian untuk proyek <b>$ktkunci</b>, ditemukan sejumlah <b>$jmldata[0]</b> proyek sebagai berikut:<p>\n";

//navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$ktkunci);

echo "<table width='100%' border=0>\n";
echo "<tr align=center>\n";
echo "<td class='judul2' width='10%'>No Proyek</td>\n";
echo "<td class='judul2' width='30%'>Nama Proyek</td>\n";
echo "<td class='judul2' width='20%'>Koordinator</td>\n";
echo "<td class='judul2' width='15%'>Tgl Mulai</td>\n";
echo "<td class='judul2' width='15%'>Tgl Selesai</td>\n";
echo "<td class='judul2' align='center' width='10%'>Unit Pengelola</td>\n";
echo "</tr>\n";

$i = 1;

while ($row = mysql_fetch_array($query)) {
   ambil_data_pengguna($db, $row["koordinator"], $koordinator);
    //if ($i > ($halaman-1)*$ttlperhalaman and $i <= ($halaman)*$ttlperhalaman) {
       echo "<tr>\n";
       echo "<td class='isi2' width='10%'>".$row["no_proyek"]."&nbsp;</td>\n";
       echo "<td class='isi2' width='30%'><a href='detail_proyek.php?p1=".$row["kode_proyek"]."'>".$row["nama_proyek"]."</a>&nbsp;</td>\n";
       echo "<td class='isi2' width='20%'><a href=mailto:".$koordinator["email"].">".$koordinator["nama"]."</a>&nbsp;</td>\n";
       echo "<td class='isi2' width='15%'>".tanggal('S',$row["tgl_mulai"])."&nbsp;</td>\n";
       echo "<td class='isi2' width='15%'>".tanggal('S',$row["tgl_selesai"])."&nbsp;</td>\n";
		   $kodeunit = $row["unit_pengelola"];
			 $query = mysql_query("SELECT nama_unit, singkatan_unit FROM unit_kerja WHERE kode_unit='$kodeunit'", $db);
			 $unitpengelola = mysql_result($query,0,"nama_unit");
     	 echo "<td class='isi2' width='10%' align='center'>".$unitpengelola."&nbsp;</td>\n";			 
       echo "</tr>\n";
   // }
   // $i++;
}
echo "</table>\n";

//navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$purl);

echo "</body>\n";
echo "</html>\n";

function navigasi_halaman($halaman,$ttlperhalaman,$jmldata,$kunci) {
    $jmlhalaman = ceil($jmldata/$ttlperhalaman);
    if ($jmlhalaman == 0) $jmlhalaman = 1;
    if ($jmldata > $ttlperhalaman) {
       echo "<table width='100%' border=0>\n";
       echo "<tr>\n";
       echo "<td align='center'><h4>\n";
       if ($halaman > 1) {
          $hal_sblm = $halaman - 1;
          echo "<a href='cari_topik.php?ktkunci=$kunci&halaman=".$hal_sblm."'> < </a> \n";
       } else {
          echo "<\n";
       }
       echo " Hal: ".$halaman." / ".$jmlhalaman. "\n";
       if ($halaman*$ttlperhalaman < $jmldata) {
          $hal_ssdh = $halaman + 1;
          echo "<a href='cari_topik.php?ktkunci=$kunci&halaman=".$hal_ssdh."'> > </a> \n";
       } else {
          echo ">\n";
       }
       echo "</td>\n";
       echo "</tr>\n";
       echo "</table><p>\n";
    }
}
?>
