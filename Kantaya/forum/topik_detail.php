<?php 
include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../cfg/$cfgfile");
$css = "../css/$tampilan_css.css";

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$topik = mysql_query("SELECT * FROM topik WHERE kode_topik='$idtopik'", $db);
$topik = mysql_fetch_array($topik);
$idforum = $topik["kode_forum"];
$forum = mysql_query("SELECT * FROM forum WHERE kode_forum='$idforum'", $db);
$forum = mysql_fetch_array($forum);
$respon = mysql_query("SELECT * FROM topik WHERE kode_topik=".$topik["respon_thd"], $db);
$respon = mysql_fetch_array($respon);

$isitopik = nl2br(ereg_replace("'","&#39;",htmlspecialchars($topik['isi_topik'])));
$isitopik = @eregi_replace("(((f|ht){1}tp://)[a-zA-Z0-9@:%_.~#-\?&]+[a-zA-Z0-9@:%_~#\?&])", "<a href=\"\\1\" target=\"_blank\">\\1</a>", $isitopik); //http
$isitopik = @eregi_replace("([[:space:]()[{}])(www.[a-zA-Z0-9@:%_.~#-\?&]+[a-zA-Z0-9@:%_~#\?&])", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $isitopik); // www.
$isitopik = @eregi_replace("([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})","<a href=\"mailto:\\1\">\\1</a>", $isitopik);

ambil_data_pengguna($db, $topik["dibuat_oleh"], $topik_oleh);

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

echo "<html>\n";
echo "<head>\n";
echo "<title>Detail Topik Diskusi</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'\n";
echo "</head>\n";
echo "<body>\n";

echo "<h2><b>Ruang $kategori</b></h2><p>\n";
echo "<h1><b>FORUM : </b>".$forum["nama_forum"]."</h1><p>\n";

echo "<h3>".$topik["judul"]." (oleh: <a href=mailto:".$topik_oleh["email"].">".$topik_oleh["nama"]."</a>, ".tanggal('S',$topik["dibuat_tgl"]).")</h3>\n";
echo "<table width='100%' border=0>\n";
if ($topik["respon_thd"] <> "0") {
    ambil_data_pengguna($db, $respon["dibuat_oleh"], $respon_oleh);
    echo "<tr >\n";
    echo "<td width='20%'>Respon Atas </td>\n";
    echo "<td width='80%'>: <a href='topik_detail.php?idtopik=".$topik["respon_thd"]."'>".$respon['judul']."</a> (oleh: <a href=mailto:".$respon_oleh["email"].">".$respon_oleh["nama"]."</a> Tanggal: ".tanggal('S',$respon["dibuat_tgl"]).")</td>\n";
    echo "</tr>\n";
}
echo "<tr>\n";
echo "<td class='judul1' colspan=2><b>Isi Topik</b></td>\n";
echo "</tr>\n";
echo "<tr >\n";
echo "<td colspan=2>".$isitopik."</td>\n";
echo "</tr>\n";
echo "</table><p>\n";

list_tanggapan($db, $topik["struktur"]);

$dflt_jdltopik = "Re: ".$topik["judul"];
kirim_tanggapan($idforum,$idtopik,$topik['struktur'],$dflt_jdltopik);

echo "</body>\n";
echo "</html>\n";


function list_tanggapan($db, $idstruktur) {
     $tanggapan = mysql_query("SELECT * FROM topik WHERE struktur like '".$idstruktur."-%' order by struktur", $db);
     echo "<table width='100%' border=0>\n";
     echo "<tr>\n";
     echo "<td class='judul1'><b>List Tanggapan</b></td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td>\n";
     $i = 0;
     $p0 = 0;
     while ($row = mysql_fetch_array($tanggapan)) {
         ambil_data_pengguna($db, $row["dibuat_oleh"], $tanggapan_oleh);
         $str = split("-",$row["struktur"]);
         if ($i == 0) $min = count($str)-1;
         $p1 = count($str)-$min;
         if ($p1-$p0 > 0) {
             echo str_repeat("<ol>",$p1-$p0)."\n";
         } elseif ($p1-$p0 < 0) {
             echo str_repeat("</ol>",$p0-$p1)."\n";
         } else {
             echo "<br>\n";
         }
         echo "<a href='topik_detail.php?idtopik=".$row["kode_topik"]."'>".$row["judul"]."</a> (oleh: <a href=mailto:".$tanggapan_oleh["email"].">".$tanggapan_oleh["nama"]."</a> tgl: ".tanggal('S',$row["dibuat_tgl"]).")\n";
         $p0 = $p1;
         $i++;
     }
     echo str_repeat("</ol>",$p0);
     echo "</td>\n";
     echo "</tr>\n";
     echo "</table>\n";
}

function kirim_tanggapan($idforum,$idtopik,$idstruktur,$dflt_jdltopik) {
     echo "<p>\n";
     echo "<form name='tambahtopik' method='post' action='postforum.php' target='isi'>\n";
     echo "<input type=hidden name=namaform value='tanggapantopik'>\n";
     echo "<input type=hidden name=idforum value='$idforum'>\n";
     echo "<input type=hidden name=idtopik value='$idtopik'>\n";
     echo "<input type=hidden name=respon value='$idtopik'>\n";
     echo "<input type=hidden name=struktur value='$idstruktur'>\n";
     echo "<table width='100%' border=0>\n";
     echo "<tr>\n";
     echo "<td class='judul1' colspan=2><b>Kirim Tanggapan Terhadap Topik Diatas</b></td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='20%'>Judul</td>\n";
     echo "<td width='80%'><input type=text name=judultopik value='$dflt_jdltopik'></td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='20%'>isi</td>\n";
     echo "<td width='80%'><textarea rows=10 cols=50 name=isitopik></textarea></td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td colspan=2 align='center'><p><input type=submit name=submit value='Kirim Tanggapan'></td>\n";
     echo "</tr>\n";
     echo "</table>\n";
     echo "</form>\n";
}
?>
