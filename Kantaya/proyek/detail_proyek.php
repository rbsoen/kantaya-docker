<?php
/******************************************
Nama File : detail_proyek.php
Fungsi    : Menampilkan detail proyek
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 6-11-2001
 Oleh     : AS
 Revisi   : Link kemajuan proyek, dokumentasi,
            forum diskusi
******************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
include('../lib/akses_unit.php');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);


$query = mysql_query("SELECT * FROM proyek WHERE kode_proyek=$p1", $db);
$proyek = mysql_fetch_array($query);

$tujuan = nl2br(ereg_replace("'","&#39;",htmlspecialchars($proyek['tujuan'])));
$tujuan = @eregi_replace("(((f|ht){1}tp://)[a-zA-Z0-9@:%_.~#-\?&]+[a-zA-Z0-9@:%_~#\?&])", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $tujuan); //http
$tujuan = @eregi_replace("([[:space:]()[{}])(www.[a-zA-Z0-9@:%_.~#-\?&]+[a-zA-Z0-9@:%_~#\?&])", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $tujuan); // www.
$tujuan = @eregi_replace("([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href=\"mailto:\\1\">\\1</a>", $tujuan);

$sasaran = nl2br(ereg_replace("'","&#39;",htmlspecialchars($proyek['sasaran'])));
$sasaran = @eregi_replace("(((f|ht){1}tp://)[a-zA-Z0-9@:%_.~#-\?&]+[a-zA-Z0-9@:%_~#\?&])", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $sasaran); //http
$sasaran = @eregi_replace("([[:space:]()[{}])(www.[a-zA-Z0-9@:%_.~#-\?&]+[a-zA-Z0-9@:%_~#\?&])", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $sasaran); // www.
$sasaran = @eregi_replace("([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href=\"mailto:\\1\">\\1</a>", $sasaran);

if ($proyek["jenis_sharing"] == "U") {
    $query = mysql_query("SELECT * FROM unit_kerja WHERE kode_unit = '".$proyek["grup_sharing"]."'", $db);
    $query = mysql_fetch_array($query);
    $unit_grup = $query["nama_unit"];
} elseif ($proyek["jenis_sharing"] == "G") {
    $query = mysql_query("SELECT * FROM grup WHERE kode_grup = '".$proyek["grup_sharing"]."'", $db);
    $query = mysql_fetch_array($query);
    $unit_grup = $query["nama_grup"];
}

echo "<html>\n";
echo "<head>\n";
echo "<title>List Proyek</title>\n";
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
?>


<script language="JavaScript">
<!--

function showAlertHapusProyek(kode) {
  window.open("alert_hapus_proyek.php?pkode="+kode, "List", "width=270,height=180");
};

// -->
</script>


<?php
echo "</head>\n";
echo "<body>\n";
echo "<table width='100%' border=0>\n";
/*
echo "<tr>\n";
if ($kode_pengguna == $proyek["koordinator"]){
    echo "<td class='judul1' width '90%'>Detail Data Proyek</td>\n";
    echo "<td class='judul3' width '10%'><a href='ubah_proyek.php?p1=".$proyek["kode_proyek"]."'>Ubah</a></td>\n";
} else {
    echo "<td class='judul1'>Detail Data Proyek</td>\n";
}
*/

if ($kode_pengguna == $proyek["koordinator"]) {
echo "<tr>\n";
echo "<td colspan=2 class='judul1'>Detail Data Proyek</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2>&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td align='right'>\n";
$kodeproyek = $proyek["kode_proyek"];
echo "<a href=\"javascript:showAlertHapusProyek('$kodeproyek')\">Hapus Proyek</a>&nbsp;&nbsp;&nbsp;\n";
echo "<a href='ubah_proyek.php?p1=".$proyek["kode_proyek"]."'>Ubah Data Proyek</a></td>\n";
echo "</tr>\n";
} else {
echo "<tr>\n";
echo "<td class='judul1'>Detail Data Proyek</td>\n";
echo "</tr>\n";
}

echo "</table>\n";

echo "<table width='100%' border=0>\n";
echo "<form name='detailproyek' method=post action=''>\n";
echo "<tr>\n";
echo "<td class='judul2' colspan=4>\n";
     if ($proyek["jenis_sharing"] == "U") {
         echo "Unit : $unit_grup\n";
     } elseif ($proyek["jenis_sharing"] == "G") {
         echo "Grup : $unit_grup\n";
     }
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>No Proyek</td>\n";
echo "<td width='30%'>: ".$proyek["no_proyek"]."&nbsp;</td>\n";
echo "<td width='20%'>Tahun Anggaran</td>\n";
echo "<td width='30%'>: ".$proyek["tahun_anggaran"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Nama Proyek</td>\n";
echo "<td colspan=3>: ".$proyek["nama_proyek"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Singkatan</td>\n";
echo "<td width='30%'>: ".$proyek["singkatan"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Proyek</td>\n";
echo "<td colspan=3 width='30%'>\n";
     $qry = mysql_query("SELECT * FROM kd_jns_proyek WHERE kode='".$proyek["jenis_proyek"]."'", $db);
     $row = mysql_fetch_array($qry);
     echo ": ".$row["nama"]."&nbsp;\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Unit Pengelola</td>\n";
echo "<td colspan=3>\n";
     $qry = mysql_query("SELECT * FROM unit_kerja WHERE kode_unit='".$proyek["unit_pengelola"]."'", $db);
     $row = mysql_fetch_array($qry);
     echo ": ".$row["nama_unit"]."&nbsp;\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Koordinator</td>\n";
echo "<td colspan=3>\n";
     ambil_data_pengguna($db, $proyek["koordinator"], $koordinator);
     echo ": <a href=mailto:".$koordinator["email"].">".$koordinator["nama"]."</a>&nbsp;\n";
echo "</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td width='20%'>Status</td>\n";
echo "<td colspan=3>\n";
     if ($proyek["status"]==1){
         echo ": Aktif&nbsp;\n";
     } else {
         echo ": Selesai&nbsp;\n";
     }
echo "</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td width='20%'>Jenis Pelaporan</td>\n";
echo "<td colspan=3>\n";
     if ($proyek["jenis_pelaporan"]=="T"){
         echo ": Triwulanan&nbsp;\n";
     } else {
         echo ": Bulanan&nbsp;\n";
     }
echo "</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td width='20%'>Tgl Mulai</td>\n";
echo "<td colspan=3>: ".tanggal('S',$proyek["tgl_mulai"])."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Tgl Selesai</td>\n";
echo "<td colspan=3>: ".tanggal('S',$proyek["tgl_selesai"])."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Lokasi</td>\n";
echo "<td colspan=3>: ".$proyek["lokasi"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kata Kunci</td>\n";
echo "<td colspan=3>: ".$proyek["kata_kunci"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%' valign='top'>Tujuan</td>\n";
echo "<td colspan=3 valign='top'>: ".$tujuan."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%' valign='top'>Sasaran</td>\n";
echo "<td colspan=3 valign='top'>: ".$sasaran."&nbsp;</td>\n";
echo "</tr>\n";
echo "</form>\n";
echo "</table>\n";
echo "<p>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1'>Link Detail</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='judul3'><ul><a href='list_mitra.php?p1=$p1'>Mitra</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='judul3'><ul><a href='personil_proyek.php?p1=$p1'>Personil Proyek</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='judul3'><ul><a href='list_jadwal_b.php?p1=$p1'>Jadwal Proyek</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
$koord = $proyek["koordinator"];
$jenislap = $proyek["jenis_pelaporan"];
echo "<td class='judul3'><ul><a href='list_kemajuan.php?p1=$p1&pkoord=$koord&pjenislap=$jenislap'>Laporan Kemajuan</a></td>\n";
echo "</tr>\n";
$query = mysql_query("SELECT kode_direktori FROM direktori WHERE nama_direktori = '".$proyek["singkatan"]."'", $db);
$query = mysql_fetch_array($query);
$kodedir = $query["kode_direktori"];
echo "<tr>\n";
echo "<td class='judul3'><ul><a href='../lemari/isi_direktori.php?pdirektorinav=$kodedir'>Dokumentasi</a></td>\n";
echo "</tr>\n";
$query = mysql_query("SELECT kode_grup FROM grup WHERE nama_grup = '".$proyek["singkatan"]."'", $db);
$query = mysql_fetch_array($query);
$kodegrup = $query["kode_grup"];
echo "<tr>\n";
echo "<td class='judul3'><ul><a href='../forum/forum.php?jnskategori=G&kdkategori=$kodegrup'>Forum Diskusi</a></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "</body>\n";
echo "</html>\n";

