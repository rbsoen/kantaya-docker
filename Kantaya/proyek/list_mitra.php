<?php
/*************************************************
Nama File : list_mitra.php
Fungsi    : 
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 13-11-2001
 Oleh     : AS
 Revisi   : css,
**************************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../lib/kantaya_cfg.php");
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$proyek = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran, tgl_mulai, tgl_selesai, (to_days(tgl_selesai)-to_days(tgl_mulai)) ttlhari FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($proyek);

$sqltext = "select * from mitra_proyek where kode_proyek = $p1 order by nama_mitra";
$query = mysql_query($sqltext, $db);

list($y1,$m1,$d1)=split("-",$proyek["tgl_mulai"]);
list($y2,$m2,$d2)=split("-",$proyek["tgl_selesai"]);

echo "<html>\n";
echo "<head>\n";
echo "<title>List Mitra Kegiatan Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1' width='80%'>List Mitra Kegiatan Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td width='20%'>Tahun Anggaran</td>\n";
echo "<td width='80%'>: ".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Proyek</td>\n";
echo "<td width='80%'>: <a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Periode</td>\n";
echo "<td width='80%'>: ".tanggal('S',$proyek["tgl_mulai"])." s/d ".tanggal('S',$proyek["tgl_selesai"])."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2 align='right'><a href='input_mitra.php?p1=$p1'>Pendaftaran Mitra Kegiatan</a></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "<p>\n";

echo "<table width='100%' border=0>\n";
echo "<tr align='center'> \n";
echo "<td class='judul2' width='25%'>Nama Mitra</td>\n";
echo "<td class='judul2' align='center' width='15%'>No Kerjasama</td>\n";
echo "<td class='judul2' align='center' width='15%'>Jenis Kerjasama</td>\n";
echo "<td class='judul2' align='center' width='15%'>Jenis Lembaga</td>\n";
echo "<td class='judul2' align='center' width='15%'>Kontak Personil</td>\n";
echo "<td class='judul2' align='center' width='15%'>Telp</td>\n";
echo "</tr>\n";

$i = 0;
while ($row = mysql_fetch_array($query)) {
    $qry = mysql_query("SELECT a.nama jenis_kerjasama, b.nama jenis_lembaga FROM kd_jns_kjsama a, kd_jns_lembaga b WHERE a.kode='".$row["jenis_kerjasama"]."' and b.kode='".$row["jenis_lembaga"]."'", $db);
    $kode = mysql_fetch_array($qry);
    echo "<tr>\n";
    echo "<td class='isi2' width='25%'><a href='mitra_detail.php?p1=".$row["kode_proyek"]."&p2=".$row["kode_mitra"]."'>".$row["nama_mitra"]."</a>&nbsp;</td>\n";
    echo "<td class='isi2' width='15%'>".$row["no_kerjasama"]."&nbsp;</td>\n";
    echo "<td class='isi2' width='15%'>".$kode["jenis_kerjasama"]."&nbsp;</td>\n";
    echo "<td class='isi2' width='15%'>".$kode["jenis_lembaga"]."&nbsp;</td>\n";
    echo "<td class='isi2' width='15%'>".$row["kontak_person"]."&nbsp;</td>\n";
    echo "<td class='isi2' width='15%'>".$row["telp_kantor"]."&nbsp;</td>\n";
    echo "</tr>\n";
    $i++;
}
if ($i==0) {
    echo "<tr>\n";
    echo "<td colspan=6>Belum ada Mitra yang terdaftar</td>\n";
    echo "</tr>\n";
}
echo "</table><p>\n";

echo "</body>\n";
echo "</html>\n";




