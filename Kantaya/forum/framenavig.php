<?php
//ini_alter("session.cookie_lifetime", "60");
session_start();
//if (!$kode_pengguna or !$nama_pengguna or !$level) {
//   echo "<center>Silakan login terlebih dahulu !<p><a href='/index.php'>Login sekarang ....</a></center>";
//   exit;
//}
include('akses_unit.php');
require("forum_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$css = "forum.css";
$idpengguna = $kode_pengguna;
$unitpengguna = $unit_pengguna;

echo "<html>\n";
echo "<head>\n";
echo "<title>Frame Navigasi Modul Forum</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";


echo "<table width='100%' Border='0'>\n";
echo "<tr class='judul'>\n";
echo "<td colspan=10 align='left'><b>List Kategori</b></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=10>&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=10><a href='forum.php?jnskategori=P' target='isi'>Publik</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=10>&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=10><b>Unit Struktural</b></td>\n";
echo "</tr>\n";

list_akses_unit($db,$unitpengguna, &$aksesunit);
for ($i=0;$i<count($aksesunit);$i++) {
    echo "<tr>\n";
    $unitlevel = $aksesunit[$i][2];
    for ($j=0;$j<$unitlevel;$j++) {
        echo "<td width='8%'>&nbsp;</td>\n";
    }
    echo "<td colspan=".(10-$unitlevel).">\n";
    echo "<a href='forum.php?jnskategori=U&kdkategori=".$aksesunit[$i][0]."' target='isi'>".$aksesunit[$i][1]."</a><br>\n";
    echo "</td>\n";
    echo "</tr>\n";
}
echo "<tr>\n";
echo "<td colspan=10>&nbsp;</td>\n";
echo "</tr>\n";
list_akses_grup($db,$idpengguna, &$aksesgrup);
if (count($aksesgrup) <> 0) {
   echo "<tr>\n";
   echo "<td colspan=10><b>Grup</b>\n";
   echo "</tr>\n";
   for ($i=0;$i<count($aksesgrup);$i++) {
       echo "<tr>\n";
       $gruplevel = $aksesgrup[$i][2];
       for ($j=0;$j<$gruplevel;$j++) {
           echo "<td width='8%'>&nbsp;</td>\n";
       }
       echo "<td colspan=".(10-$gruplevel).">\n";
       echo "<a href='forum.php?jnskategori=U&kdkategori=".$aksesgrup[$i][0]."' target='isi'>".$aksesgrup[$i][1]."</a>\n";
       echo "</td>\n";
       echo "</tr>\n";
   }
}
echo "</table>\n";
echo "<p>\n";

//echo "<form name='caritopik' method='post' action='postforum.php' target='isi'>\n";
echo "<form name='caritopik'>\n";
echo "<table width='100%' Border='0'>\n";
echo "<tr class='judul'>\n";
echo "<td align='left'><b>Pencarian Topik</b></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td align='center'><input type=text name=katakunci></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td align='center'><input type=button value='Cari!' onClick=window.open('cari_topik.php?ktkunci='+katakunci.value,'isi')></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</form>\n";
echo "<p>\n";

if ($level == 1) {
   echo "<form name='hapustopik' method='get' action='postforum.php' target='isi'>\n";
   echo "<table width='100%' Border='0'>\n";
   echo "<tr class='judul'>\n";
   echo "<td align='left'><b>Penghapusan Topik</b></td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td>Kriteria Penghapusan<br>\n";
   echo "<select name='jenis'>\n";
   echo "<option value='F'>Forum</option><option value='T'>Topik </option>\n";
   echo "</select>\n";
   echo "non aktif lebih dari \n";
   echo "<select name='nonaktif'>\n";
   for ($i=1;$i<=12;$i++) {
       echo "<option value=$i>$i</option>\n";
   }
   echo "</select>\n";
   echo "bulan\n";
   echo "</td>\n";
   echo "</tr>\n";
   echo "<tr>\n";
   echo "<td align='center'><input type=button value='Cari!' onClick=window.open('hapus_topik.php?p1='+jenis.options[jenis.selectedIndex].value+'&p2='+nonaktif.options[nonaktif.selectedIndex].value,'isi')></td>\n";
   echo "</tr>\n";
   echo "</table>\n";
   echo "</form>\n";
}
       
echo "<p>\n";

echo "</body>\n";
echo "</html>\n";
?>

