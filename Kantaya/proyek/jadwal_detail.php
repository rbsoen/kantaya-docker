<?php
/******************************************
Nama File : jadwal_detail.php
Fungsi    : 
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 21-11-2001
 Oleh     : AS
 Revisi   : css.
******************************************/
include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
include('../lib/akses_unit.php');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$proyek = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran, koordinator FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($proyek);

$sqltext = "select * from jadwal_proyek where kode_proyek = '$p1' and no_kegiatan = '$p2'";
$query = mysql_query($sqltext,$db);
$jdwlkgtn = mysql_fetch_array($query);

echo "<html>\n";
echo "<head>\n";
echo "<title>Detail Kegiatan Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";

echo "<script language='Javascript'>\n";
echo "function showUserList(pfld,pfltr) {\n";
echo "  if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {\n";
echo "    window.PsnList.close();\n";
echo "  }\n";
//echo " alert(navigator.appName)\n";
echo "  PsnList = window.open('../lib/list_pengguna.php?pfld='+pfld+'&pfltr='+pfltr, 'List', 'width=390,height=450,scrollbars=yes');\n";
echo "};\n";
echo "function showCldList(fld, dflt, range) {\n";
echo "  if (window.CldWin && window.CldWin.open && !window.CldWin.closed) {\n";
echo "    window.CldWin.close();\n";
echo "  }\n";
echo "  CldWin = window.open('../lib/kalender.php?pfld='+fld+'&pdflt='+dflt+'&prange='+range, 'List', 'width=300,height=200');\n";
echo "};\n";
echo "</script>\n";

echo "</head>\n";
echo "<body>\n";
echo "<table width='100%' border=0>\n";
if ($kode_pengguna == $proyek["koordinator"]){
echo "<tr>\n";
echo "<td colspan=2 class='judul1'>Detail Kegiatan Proyek</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2>&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td align=right><a href='ubah_jadwal.php?p1=$p1&p2=$p2'>Ubah Kegiatan Proyek</a></td>\n";
echo "</tr>\n";
} else {
echo "<tr>\n";
echo "<td class='judul1'>Detail Kegiatan Proyek</td>\n";
echo "</tr>\n";
}
echo "</table>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td width='20%'>Tahun Anggaran</td>\n";
echo "<td width='80%'>".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Proyek</td>\n";
echo "<td width='80%'><a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td colspan=4 class='judul2'>Data Kegiatan </td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>No Kegiatan</td>\n";
echo "<td width='30%'>".$jdwlkgtn["no_kegiatan"]."&nbsp;</td>\n";
echo "<td width='20%'>Bobot Kegiatan (%)</td>\n";
echo "<td width='30%'>".$jdwlkgtn["bobot"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Nama Kegiatan</td>\n";
echo "<td colspan=3>".$jdwlkgtn["nama_kegiatan"]."&nbsp;</td>\n";
echo "</tr>\n";
if ($jdwlkgtn["induk_kegiatan"] <> '') {
    $where = "kode_proyek = '$p1' and no_kegiatan = '".$jdwlkgtn["induk_kegiatan"]."'";
    $query = mysql_query("SELECT no_kegiatan, nama_kegiatan FROM jadwal_kegiatan WHERE $where", $db);
    $subkgtn = mysql_fetch_array($query);
    echo "<tr>\n";
    echo "<td width='20%'>Sub Kegiatan Dari</td>\n";
    echo "<td colspan=3><a href='jadwal_detail.php?p1=$p1&p2=".$subkgtn["no_kegiatan"]."'>".$subkgtn["nama_kegiatan"]."&nbsp;</td>\n";
    echo "</tr>\n";
}
echo "<tr>\n";
echo "<td width='20%'>Jenis Kegiatan</td>\n";
if ($jdwlkgtn["jenis_kegiatan"] == 'swa') {
    echo "<td colspan=3>Swakelola&nbsp;</td>\n";
} elseif ($jdwlkgtn["jenis_kegiatan"] == 'sub') {
    echo "<td width='30%'>Subkontrak&nbsp;</td>\n";
    echo "</td>\n";
    echo "<td width='20%'>Sub Kontraktor Mitra</td>\n";
    if ($jdwlkgtn["subkont_mitra"] == 0) {
       echo "<td width='30%'>&nbsp;</td>\n";
    } else {
       echo "<td width='30%'>".$jdwlkgtn["subkont_mitra"]."&nbsp;</td>\n";
    }
}

echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=4>Pelaksanaan Kegiatan</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Rencana</td>\n";
echo "<td width='30%'>".tanggal('S',$jdwlkgtn["rcn_tgl_mulai"])."&nbsp; s/d &nbsp;\n";
echo tanggal('S',$jdwlkgtn["rcn_tgl_selesai"])."&nbsp;</td> \n";
echo "<td width='20%'>Realisasi</td>\n";
echo "<td width='30%'>".tanggal('S',$jdwlkgtn["akt_tgl_selesai"])."&nbsp; s/d &nbsp;\n";
echo tanggal('S',$jdwlkgtn["akt_tgl_selesai"])."&nbsp;</td> \n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Status (%)</td>\n";
echo "<td colspan=3>".$jdwlkgtn["status"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=4>Keterangan</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>&nbsp;</td>\n";
echo "<td colspan=3>".$jdwlkgtn["keterangan"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "</table><p>\n";

$where = "a.kode_proyek = '$p1' and a.no_kegiatan = '$p2' and a.kode_pengguna = b.kode_pengguna";
$query = mysql_query("SELECT a.kode_pengguna, b.nama_pengguna, a.job, a.orang_jam FROM penugasan_personil a, pengguna b WHERE $where ORDER BY a.orang_jam", $db);
$ttlorgjam = mysql_query("select sum(orang_jam) from penugasan_personil where kode_proyek = '$p1' and no_kegiatan = '$p2'",$db);
$ttlorgjam = mysql_fetch_array($ttlorgjam);

echo "<table width='80%' border=0>\n";
echo "<tr>\n";
echo "<td colspan=5 class='judul2'>Data Penugasan Personil </td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='judul3' width='30%'>Nama Personil</td>\n";
echo "<td class='judul3' width='40%'>Job</td>\n";
echo "<td class='judul3' width='10%'>Org-Jam</td>\n";
echo "</tr>\n";
while ($row = mysql_fetch_array($query)) {
    $i++;
    echo "<tr>\n";
    echo "<td class='isi2' width='30%'>".$row["nama_pengguna"]."&nbsp;</td>\n";
    echo "<td  class='isi2' width='40%'>".$row["job"]."&nbsp;</td>\n";
    echo "<td  class='isi2' width='10%' align='center'>".$row["orang_jam"]."&nbsp;</td>\n";
    echo "</tr>\n";
}
echo "<tr>\n";
echo "<td class='judul3' colspan=2>Total Orang Jam</td>\n";
echo "<td class='judul3' width='10%' align='center'>$ttlorgjam[0]&nbsp;</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "</body>\n";
echo "</html>\n";



