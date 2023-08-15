<?php 
/******************************************
Nama File : forum.php
Fungsi    : Forum diskusi
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 20-11-2001
 Oleh     : AS
 Revisi   : css,
******************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../cfg/$cfgfile");
$css = "../css/$tampilan_css.css";
$ttlperhalaman = 20;

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

if ($jnskategori == "P") {
    $kategori = "Publik";
} elseif ($jnskategori == "U") {
    $query = mysql_query("SELECT * FROM unit_kerja WHERE kode_unit = $kdkategori", $db);
    $query = mysql_fetch_array($query);
    $kategori = $query["nama_unit"];
} elseif ($jnskategori == "G") {
    $query = mysql_query("SELECT * FROM grup WHERE kode_grup = $kdkategori", $db);
    $query = mysql_fetch_array($query);
    $kategori = $query["nama_grup"];
} else {
    $jnskategori == "P";
    $kategori = "Publik";
}
$group = $jnskategori.";".$kdkategori;
$where = "jenis_group='$jnskategori' and (('$jnskategori'!='P' and kode_group='$kdkategori') or ('$jnskategori'='P'))";
$jmldata = mysql_query("SELECT count(kode_forum) FROM forum WHERE $where", $db);
$jmldata = mysql_fetch_array($jmldata);
$forum = mysql_query("SELECT * FROM forum WHERE $where order by dibuat_tgl desc", $db);
$url_forum = "forum.php?jnskategori=$jnskategori&kdkategori=$kdkategori";

if ($halaman == "") $halaman = 1;

echo "<html>\n";
echo "<head>\n";
echo "<title>List Forum Diskusi</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'\n";
echo "</head>\n";
echo "<body>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1'>Forum Diskusi Ruang $kategori</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<br>Pilih salah satu forum dibawah ini dan anda dapat melihat serta
     memberikan tanggapan terhadap beberapa topik diskusi yang terdaftar, ataupun
     mendaftarkan forum dan topik bahasan yang baru. Jumlah total forum yang
     terdaftar dalam ruang ini adalah ".$jmldata[0]." forum. <p>\n";

navigasi_halaman($url_forum,$halaman,$ttlperhalaman,$jmldata[0]);

echo "<table width='100%' border=0>\n";
$i = 1;
while ($row = mysql_fetch_array($forum)) {
    ambil_data_pengguna($db, $row["dibuat_oleh"], $pengguna);
    if ($i > ($halaman-1)*$ttlperhalaman and $i <= ($halaman)*$ttlperhalaman) {
       $jmltopik = mysql_query("SELECT count(*) FROM topik WHERE kode_forum=".$row["kode_forum"]." and respon_thd = 0", $db) or db_die();
       $jmltopik = mysql_fetch_array($jmltopik);
       list($y,$m,$d)=split("-",$row["dibuat_tgl"]);
       echo "<tr>\n";
       echo "<td width='100%'>\n";
       echo "<img src='../gambar/folder.png' border=0> <a href='topik.php?pid=".$row["kode_forum"]."'>".$row["nama_forum"]."</a> (".$jmltopik[0]." topik)<br>\n";
       echo $row["keterangan"]." (didaftarkan oleh <a href=mailto:".$pengguna["email"].">".$pengguna["nama"]."</a>, ".tanggal('S',$row["dibuat_tgl"]).")\n";
       echo "<p></td>\n";
       echo "</tr>\n";
    }
    $i++;
}
echo "</table><p>\n";

navigasi_halaman($url_forum,$halaman,$ttlperhalaman,$jmldata[0]);

daftar_forum($group);

echo "</body>\n";
echo "</html>\n";

function navigasi_halaman($url_forum,$halaman,$ttlperhalaman,$jmldata) {
    $jmlhalaman = ceil($jmldata/$ttlperhalaman);
    if ($jmlhalaman == 0) $jmlhalaman = 1;
    if ($jmldata > $ttlperhalaman) {
       echo "<table width='100%' border=0>\n";
       echo "<tr>\n";
       echo "<td align='center'><h4>\n";
       if ($halaman > 1) {
          $hal_sblm = $halaman - 1;
          echo "<a href='".$url_forum."&halaman=".$hal_sblm."'> < </a> \n";
       } else {
          echo "<\n";
       }
       echo " Hal: ".$halaman." / ".$jmlhalaman. "\n";
       if ($halaman*$ttlperhalaman < $jmldata) {
          $hal_ssdh = $halaman + 1;
          echo "<a href='".$url_forum."&halaman=".$hal_ssdh."'> > </a> \n";
       } else {
          echo ">\n";
       }
       echo "</td>\n";
       echo "</tr>\n";
       echo "</table><p>\n";
    }
}

function daftar_forum($group) {
    echo "<form name='tambahforum' method='post' action='postforum.php' target='isi'>\n";
    echo "<input type=hidden name=namaform value='tambahforum'>\n";
    echo "<input type=hidden name=group value=$group>\n";
    echo "<input type=hidden name=halaman value='1'>\n";
    echo "<table width='100%' Border='0'>\n";
    echo "<tr>\n";
    echo "<td class='judul1' align='left' colspan=2><b>Penambahan Forum</b></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Nama Forum</td>\n";
    echo "<td width='80%'><input type=text name=namaforum size=35></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Keterangan</td>\n";
    echo "<td width='80%'><textarea rows=2 cols=35 name=keterangan></textarea></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td align='center' colspan=2>\n";
    echo "<input type=submit name=submit value='Tambahkan'></td>\n";
    echo "</tr>\n";
    echo "</table> \n";
    echo "</form>\n";
    echo "<p> \n";
}

?>


