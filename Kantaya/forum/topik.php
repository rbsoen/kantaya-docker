<?php 
include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../cfg/$cfgfile");
$css = "../css/$tampilan_css.css";
$ttlperhalaman = 20;

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$jmldata = mysql_query("SELECT count(*) FROM topik WHERE kode_forum='$pid' and respon_thd = 0", $db) or db_die();
$jmldata = mysql_fetch_array($jmldata);

$forum = mysql_query("SELECT jenis_group, kode_group, nama_forum, moderator FROM forum WHERE kode_forum='$pid'", $db) or db_die();
$topik = mysql_query("SELECT * FROM topik WHERE kode_forum='$pid' and respon_thd = 0 order by dibuat_tgl desc", $db) or db_die();
$forum = mysql_fetch_array($forum);

$jnskategori = $forum["jenis_group"];
$kdkategori = $forum["kode_group"];
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
if ($halaman == "") $halaman = 1;

echo "<html>\n";
echo "<head>\n";
echo "<title>List Topik Diskusi</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'\n";
echo "</head>\n";
echo "<body>\n";
echo "<h2><b>Ruang $kategori</b></h2><p>\n";
echo "<h1><b>FORUM : </b>".$forum["nama_forum"]."</h1><br>\n";
echo "Pilih salah satu topik dibawah ini dan anda dapat melihat serta
     memberikan tanggapan terhadap topik-topik terkait.<p>\n";

navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$pid);

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
       list($y,$m,$d)=split("-",$row["dibuat_tgl"]);
       $jmltanggapan = mysql_query("SELECT count(*) FROM topik WHERE struktur like '".$row['struktur']."-%'", $db) or db_die();
       $jmltanggapan = mysql_fetch_array($jmltanggapan);
       echo "<tr>\n";
       echo "<td width='50%'><img src='../gambar/folder.png' border=0> <a href='topik_detail.php?idtopik=".$row["kode_topik"]."'>".$row["judul"]."</a>&nbsp;</td>\n";
       echo "<td width='20%'><a href=mailto:".$pengguna["email"].">".$pengguna["nama"]."</a>&nbsp;</td>\n";
       echo "<td width='15%' align='center'>$jmltanggapan[0]&nbsp;</td>\n";
       echo "<td width='15%'>".tanggal('S',$row["dibuat_tgl"])."&nbsp;</td>\n";
       echo "</tr>\n";
    }
    $i++;
}
echo "</table><p>\n";

navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$pid);

tambah_topik($pid);

echo "</body>\n";
echo "</html>\n";


function navigasi_halaman($halaman,$ttlperhalaman,$jmldata,$idforum) {
    $jmlhalaman = ceil($jmldata/$ttlperhalaman);
    if ($jmlhalaman == 0) $jmlhalaman = 1;
    if ($jmldata > $ttlperhalaman) {
       echo "<table width='100%' border=0>\n";
       echo "<tr>\n";
       echo "<td align='center'><h4>\n";
       if ($halaman > 1) {
          $hal_sblm = $halaman - 1;
          echo "<a href='topik.php?pid=$idforum&halaman=".$hal_sblm."'> < </a> \n";
       } else {
          echo "<\n";
       }
       echo " Hal: ".$halaman." / ".$jmlhalaman. "\n";
       if ($halaman*$ttlperhalaman < $jmldata) {
          $hal_ssdh = $halaman + 1;
          echo "<a href='topik.php?pid=$idforum&halaman=".$hal_ssdh."'> > </a> \n";
       } else {
          echo ">\n";
       }
       echo "</td>\n";
       echo "</tr>\n";
       echo "</table><p>\n";
    }
}

function tambah_topik($idforum) {
    echo "<p>\n";
    echo "<form name='tambahtopik' method='post' action='postforum.php' target='isi'>\n";
    echo "<input type=hidden name=namaform value='tambahtopik'>\n";
    echo "<input type=hidden name=halaman value=1>\n";
    echo "<input type=hidden name=idforum value='$idforum'>\n";
    echo "<input type=hidden name=respon value=''>\n";
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul1' colspan=2>Pendaftaran Topik Baru</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Judul</td>\n";
    echo "<td width='80%'><input type=text name=judultopik size=50></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>isi</td>\n";
    echo "<td width='80%'><textarea rows=10 cols=50 name=isitopik></textarea></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td colspan=2 align='center'><p><input type=submit name=submit value='Kirim Topik'></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}
?>
