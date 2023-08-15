<?php
/******************************************
Nama File : kd_jnskjsama.php
Fungsi    : Setup kode jenis kerjasama proyek
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
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$sqltext = "select * from kd_jns_kjsama order by kode";
$query = mysql_query($sqltext, $db);

echo "<html>\n";
echo "<head>\n";
echo "<title>Kode Jenis Kerjasama Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td colspan=2 class='judul1'>Kode Jenis Kerjasama Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

//echo "<h2><b>Kode Jenis Kerjasama Proyek</b></h2><p>\n";

echo "<table width='100%' border=0>\n";
echo "<tr align=center>\n";
echo "<td class='judul2' width='5%'>Hapus</td>\n";
echo "<td class='judul2' width='5%'>Ubah</td>\n";
echo "<td class='judul2' width='20%'>Kode</td>\n";
echo "<td class='judul2' width='50%'>Nama</td>\n";
echo "<td class='judul2' width='20%'>Singkatan</td>\n";
echo "</tr>\n";

$i = 0;
echo "<form name='hapus_kjsama' method='post' action='post_kdproyek.php' target='isi'>\n";
while ($row = mysql_fetch_array($query)) {
    $i++;
    echo "<tr>\n";
    echo "<td class='isi2' width='5%'><input type='checkbox' name='cb_hapus[]' value=".$row["kode"]."></td>\n";
    echo "<td class='isi2' width='5%'><a href='kd_jnskjsama.php?pid=".$row["kode"]."#form'><img src='../gambar/pen.gif' width='17' height='17' border=0></a>&nbsp;</td>\n";
    echo "<td class='isi2' width='20%'>".$row["kode"]."&nbsp;</td>\n";
    echo "<td class='isi2' width='50%'>".$row["nama"]."&nbsp;</td>\n";
    echo "<td class='isi2' width='20%'>".$row["singkatan"]."&nbsp;</td>\n";
    echo "</tr>\n";
    if ($row["kode"] == $pid) {
        $r1 = $row["kode"];
        $r2 = $row["nama"];
        $r3 = $row["singkatan"];
    }
}
if ($i==0) {
    echo "<tr>\n";
    echo "<td colspan=3>Belum ada kode yang terdaftar</td>\n";
    echo "</tr>\n";
} else {
    echo "<input type=hidden name=namaform value='hapuskjsama'>\n";
    echo "<tr>\n";
    echo "<td colspan=5 align='left'><input type=submit name=submit value='Hapus'></td>\n";
    echo "</tr>\n";
}
echo "</table><p>\n";
echo "</form>\n";

form_edit_kode($r1,$r2,$r3);

echo "</body>\n";
echo "</html>\n";


function form_edit_kode($kode,$nama,$singk) {
    echo "<p id='form'>\n";
    echo "<form name='jns_kjsama' method='post' action='post_kdproyek.php' target='isi'>\n";
    echo "<input type=hidden name=namaform value='jnskjsama'>\n";
    if (is_null($kode)) {
        echo "<input type=hidden name=jnstransaksi value='tambah'>\n";
    } else {
        echo "<input type=hidden name=jnstransaksi value='ubah'>\n";
    }
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul1' colspan=2>Penambahan / Ubah Kode Jenis Kerjasama </td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>kode</td>\n";
    echo "<td width='80%'><input type=text name=kode size=20 value=$kode></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Nama</td>\n";
    echo "<td width='80%'><input type=text name=nama size=30 value=$nama></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Singkatan</td>\n";
    echo "<td width='80%'><input type=text name=singkatan size=20 value=$singk></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    if (is_null($kode)) {
        echo "<td colspan=2 align='center'><p><input type=submit name=submit value='Tambahkan'></td>\n";
    } else {
        echo "<td colspan=2 align='center'><p><input type=submit name=submit value='Ubah'></td>\n";
    }
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}
?>

