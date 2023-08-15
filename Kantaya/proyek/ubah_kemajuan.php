<?php
/*************************************************
Nama File : ubah_kemajuan.php
Fungsi    : Mengubah pelaporan kemajuan proyek
Dibuat    :	
 Tgl.     : 23-11-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   :
**************************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
include('../lib/akses_unit.php');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$query = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran, tgl_mulai, tgl_selesai FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($query);

list($y1,$m1,$d1)=split("-",$proyek["tgl_mulai"]);
list($y2,$m2,$d2)=split("-",$proyek["tgl_selesai"]);

$jenis_pelaporan = $pjenislap;
$thbl1 = $y1.$m1;
$thbl2 = $y2.$m2;

$query = mysql_query("SELECT (period_diff('$thbl2','$thbl1')) selisihbulan, koordinator FROM proyek WHERE kode_proyek='$p1'", $db);
$ttlbulan = (mysql_result($query,0,"selisihbulan")+1);
$koordproyek = mysql_result($query,0,"koordinator");

if ($terminke=="") {
    $terminke = 1;
}

if ($jenis_pelaporan == "T") {
    $jmltermin = ceil($ttlbulan/3);
} else {
    $jmltermin = $ttlbulan;
}

list($jns_sharing,$grup_sharing) = split(';',$p1);
if ($jns_sharing == "U") {
    $query = mysql_query("SELECT * FROM unit_kerja WHERE kode_unit = '$grup_sharing'", $db);
    $query = mysql_fetch_array($query);
    $unit_grup = $query["nama_unit"];
} elseif ($jns_sharing == "G") {
    $query = mysql_query("SELECT * FROM grup WHERE kode_grup = '$grup_sharing'", $db);
    $query = mysql_fetch_array($query);
    $unit_grup = $query["nama_grup"];
}
$grup = $jnskategori.";".$kdkategori;
$where = "jenis_sharing='$jns_sharing' and grup_sharing='$grup_sharing' and tahun_anggaran='$tahun' and jenis_proyek like '$p3%'";
$query = mysql_query("SELECT count('x') FROM proyek WHERE $where", $db);
$jmldata = mysql_fetch_array($query);
$purl = "list_proyek.php?p1=$p1&p2=$p2&p3=$p3";

echo "<html>\n";
echo "<head>\n";
echo "<title>Mengubah Data Kemajuan Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1'>Ubah Detail Kemajuan Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<form name='kemajuanproyek' method='post' action='post_kemajuanproyek.php' target='isi'>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td>Nama Proyek</td>\n";
echo "<td> : </td>\n";
echo "<td><a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Periode</td>\n";
echo "<td> : </td>\n";
echo "<td>".tanggal('S',$proyek["tgl_mulai"])." s/d ".tanggal('S',$proyek["tgl_selesai"])."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Tahun Anggaran</td>\n";
echo "<td> : </td>\n";
echo "<td>".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";

if ($p3=="T") {
  echo "<td>Termin Triwulan ke </td>\n";
} else {
  echo "<td>Termin Bulan ke </td>\n";
}
echo "<td> : </td>\n";
echo "<td>".$p2."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>&nbsp;</td>\n";
echo "</tr>\n";

$where = "kode_proyek='$p1' AND no_termin='$p2'";
$query = mysql_query("SELECT * FROM kemajuan_proyek WHERE $where", $db);
$row = mysql_fetch_array($query);
$proyek_termin_tbl = $row["kode_proyek"].$row["no_termin"];
$proyek_termin_frm = $p1.$terminke;
$kemajuankeg = $row["kemajuan_kegiatan"];

echo "<tr>\n";
echo "<td>Kemajuan</td><td> : </td><td><textarea name=kemajuan  rows=3 cols=25>".$row["kemajuan_kegiatan"]."</textarea></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Masalah</td><td> : </td><td><textarea name=masalah rows=3 cols=25>".$row["masalah"]."</textarea></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Pemecahan</td><td> : </td><td><textarea name=pemecahan rows=3 cols=25>".$row["pemecahan"]."</textarea></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Status Kemajuan</td><td> : </td><td><input name=statuskemajuan size=5 value=".$row["status_kemajuan"].">  %</input></td>\n";
echo "</tr>\n";


echo "<input type='hidden' name='kodeproyek' value='$p1'>\n";
echo "<input type='hidden' name='p1' value='$p1'>\n";
echo "<input type='hidden' name='p2' value='$p2'>\n";
$p3 = $row["tgl_dibuat"];
echo "<input type='hidden' name='p3' value='$p3'>\n";
echo "<input type='hidden' name='jnstransaksi' value='ubah kemajuan'>\n";

echo "<tr>\n";
echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;<input type=submit name=psubmit value='Simpan'></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "</body>\n";
echo "</html>\n";



