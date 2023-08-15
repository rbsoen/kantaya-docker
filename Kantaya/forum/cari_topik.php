<?php
include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../cfg/$cfgfile");
$css = "../css/$tampilan_css.css";
$ttlperhalaman = 20;

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

echo "<html>\n";
echo "<head>\n";
echo "<title>Hasil Pencarian Topik Diskusi</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'\n";
echo "</head>\n";
echo "<body>\n";

echo "<h1><b>FORUM DISKUSI</h1><br>\n";
echo "<h2><b>Hasil Pencarian Topik</b></h2><p>\n";
echo "Hasil pencarian untuk topik '$ktkunci', ditemukan sejumlah $jmldata[0]
     topik sebagai berikut:<p>\n";

if ($ktkunci == "") {
     echo "<h1> Error </h1><br>\n";
     echo "Pastikan anda telah mengisikan kata kunci pencarian<br>";
     exit -1;
}
$jmldata = mysql_query("SELECT count(*) FROM topik WHERE judul like '%$ktkunci%' or isi_topik like '%$ktkunci%'", $db);
$jmldata = mysql_fetch_array($jmldata);
$jmlhalaman = ceil($jmldata[0]/$ttlperhalaman);
if ($halaman == "") $halaman = 1;

$topik = mysql_query("SELECT * FROM topik WHERE judul like '%$ktkunci%' or isi_topik like '%$ktkunci%'", $db);

navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$ktkunci);

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul3' width='50%'>Topik</td>\n";
echo "<td class='judul3' width='20%'>Dikirimkan Oleh</td>\n";
echo "<td class='judul3' width='15%'>Jml Tanggapan</td>\n";
echo "<td class='judul3' width='15%'>Tgl Pengiriman</td>\n";
echo "</tr>\n";

$i = 1;

while ($row = mysql_fetch_array($topik)) {
    ambil_data_pengguna($db, $row["dibuat_oleh"], $pengguna);
    if ($i > ($halaman-1)*$ttlperhalaman and $i <= ($halaman)*$ttlperhalaman) {
       $jmltanggapan = mysql_query("SELECT count(*) FROM topik WHERE struktur like '".$row['struktur']."-%'", $db) or db_die();
       $jmltanggapan = mysql_fetch_array($jmltanggapan);
       echo "<tr>\n";
       echo "<td width='50%'><a href='topik_detail.php?idforum=".$row["kode_forum"]."&idtopik=".$row["kode_topik"]."'>".$row["judul"]."</a>&nbsp;</td>\n";
       echo "<td width='20%'><a href=mailto:".$pengguna["email"].">".$pengguna["nama"]."</a>&nbsp;</td>\n";
       echo "<td width='15%' align='center'>$jmltanggapan[0]&nbsp;</td>\n";
       echo "<td width='15%'>".tanggal('S',$row["dibuat_tgl"])."&nbsp;</td>\n";
       echo "</tr>\n";
    }
    $i++;
}
echo "</table>\n";

navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$ktkunci);

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
