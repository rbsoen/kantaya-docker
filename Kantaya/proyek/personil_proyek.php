<?php
/*************************************************
Nama File : personil_proyek.php
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

$proyek = mysql_query("SELECT no_proyek, nama_proyek, singkatan, tahun_anggaran FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($proyek);
$singkatanproyek = $proyek["singkatan"];

$where = "a.kode_proyek = '$p1' and a.jabatan = b.kode and a.kode_pengguna = c.kode_pengguna";
$query = mysql_query("SELECT a.kode_pengguna, c.nama_pengguna, b.nama jabatan, a.kualifikasi FROM personil_proyek a, kd_jbtn_proyek b, pengguna c WHERE $where ORDER BY jabatan", $db);

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
echo "</script>\n";

echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1'>Personil Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<form name='psnlproyek' method='post' action='post_proyek.php' target='isi'>\n";
echo "<input type=hidden name='namaform' value='psnlproyek'>\n";
echo "<input type=hidden name='kode_proyek' value='$p1'>\n";
echo "<input type=hidden name=jnstransaksi value='hapus'>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td width='20%'>Tahun Anggaran</td>\n";
echo "<td width='80%'>: ".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Proyek</td>\n";
echo "<td width='80%'>: <a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<table width='100%' border=0>\n";
echo "<tr align=center>\n";
echo "<td class='judul2' width='5%'>Hapus</td>\n";
echo "<td class='judul2' width='5%'>Ubah</td>\n";
echo "<td class='judul2' width='40%'>Nama Personil</td>\n";
echo "<td class='judul2' width='25%'>Jabatan</td>\n";
echo "<td class='judul2' width='25%'>Kualifikasi</td>\n";
echo "</tr>\n";
$i = 0;
while ($row = mysql_fetch_array($query)) {
    $i++;
    echo "<tr align=center>\n";
    echo "<td class='isi2' width='5%'><input type='checkbox' name='cb_hapus[]' value=".$row["kode_pengguna"]."></td>\n";
    echo "<td class='isi2' width='5%'><a href='personil_proyek.php?p1=$p1&p2=".$row["kode_pengguna"]."#form'><img src='../gambar/pen.gif' width='17' height='17' border=0></a>&nbsp;</td>\n";
    echo "<td class='isi2' align=left width='40%'>".$row["nama_pengguna"]."</td>\n";
    echo "<td class='isi2' width='30%'>".$row["jabatan"]."</td>\n";
		if ($row["kualifikasi"]=="") { $row["kualifikasi"]="-"; }
    echo "<td class='isi2' width='30%'>".$row["kualifikasi"]."</td>\n";
    echo "</tr>\n";
}
if ($i==0) {
    echo "<tr>\n";
    echo "<td colspan=5>Belum ada Personil yang terdaftar</td>\n";
    echo "</tr>\n";
} else {
    echo "<tr>\n";
    echo "<input type=hidden name=singkatan value='$singkatanproyek'>\n";			
    echo "<td colspan=5 align='left'><input type=submit name=submit value='Hapus'></td>\n";
    echo "</tr>\n";
}
echo "<tr>\n";
echo "<td colspan=5>\n";
echo "</tr>\n";
echo "</table><p>\n";
echo "</form>\n";

$unit = $proyek["jenis_sharing"].";".$proyek["grup_sharing"];
if (empty($p2)) {
    pendaftaran_personil_proyek($db,$p1,$unit);
} else {
    edit_personil_proyek($db,$p1,$unit,$p2);
}


echo "</body>\n";
echo "</html>\n";


function pendaftaran_personil_proyek($db,$kode_proyek,$unit) {
    list($jns_sharing,$grup_sharing) = split(';',$unit);
		global $singkatanproyek;
    echo "<p id='form'>\n";
    echo "<form name='psnlproyek' method='post' action='post_proyek.php' target='isi'>\n";
    echo "<input type=hidden name='namaform' value='psnlproyek'>\n";
    echo "<input type=hidden name='kode_proyek' value='$kode_proyek'>\n";
    echo "<input type=hidden name=jnstransaksi value='tambah'>\n";
    echo "<input type=hidden name=singkatan value='$singkatanproyek'>\n";		
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul1' colspan=2>Pendaftaran Personil Proyek</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Nama Personil</td>\n";
    echo "<td width='80%'>: \n";
    echo "<input type=hidden name='personil' value=''>\n";
    echo "<input type=text name='nama_personil' size=30 value=''>\n";
    echo "<a href=\"javascript:showUserList('psnlproyek,personil,nama_personil','$grup_sharing')\"><img align=top border=0 height=21 src='../gambar/p108.gif'></a>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Jabatan</td>\n";
         echo "<td width='30%'>: <select name='jabatan'><option value='00' selected>Pilih jabatan proyek</option>\n";
         $query = mysql_query("SELECT * FROM kd_jbtn_proyek order by kode", $db);
         while ($row = mysql_fetch_array($query)) {
               echo "<option value='".$row["kode"]."'>".$row["nama"]."</option>\n";
         }
         echo "</select>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Kualifikasi</td>\n";
    echo "<td width='80%'>: <input type=text name=kualifikasi  size=30 value=''></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    if (is_null($personil)) {
        echo "<td colspan=2 align='center'><p><input type=submit name=submit value='Tambahkan'></td>\n";
    } else {
        echo "<td colspan=2 align='center'><p><input type=submit name=submit value='Ubah'></td>\n";
    }
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}

function edit_personil_proyek($db,$kode_proyek,$unit,$psnl) {
    list($jns_sharing,$grup_sharing) = split(';',$unit);
    $select = "SELECT a.kode_pengguna, c.nama_pengguna, a.jabatan kode_jabatan, b.nama jabatan, a.kualifikasi ";
    $from = "FROM personil_proyek a, kd_jbtn_proyek b, pengguna c ";
    $where = "WHERE a.kode_proyek = '$kode_proyek' and a.kode_pengguna = $psnl and a.jabatan = b.kode and a.kode_pengguna = c.kode_pengguna ";
    $orderby = "ORDER BY jabatan";
    $sqltext = "$select$from$where$orderby";
    $query = mysql_query($sqltext, $db);
    $editrow = mysql_fetch_array($query);
    echo "<p id='form'>\n";
    echo "<form name='psnlproyek' method='post' action='post_proyek.php' target='isi'>\n";
    echo "<input type=hidden name='namaform' value='psnlproyek'>\n";
    echo "<input type=hidden name='kode_proyek' value='$kode_proyek'>\n";
    echo "<input type=hidden name=jnstransaksi value='ubah'>\n";
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul1' colspan=2>Edit Personil Proyek</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Nama Personil</td>\n";
    echo "<td width='80%'>\n";
    echo "<input type=hidden name='personil' value=".$editrow["kode_pengguna"].">\n";
    echo "<font size=+1>".$editrow["nama_pengguna"]."</font>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Jabatan</td>\n";
         echo "<td width='30%'><select name='jabatan'>\n";
         $query = mysql_query("SELECT * FROM kd_jbtn_proyek order by kode", $db);
         while ($row = mysql_fetch_array($query)) {
             echo "<option value='".$row["kode"]."'>".$row["nama"]."</option>\n";
             if ($row["kode"]==$editrow["kode_jabatan"]){
                 echo "<option value='".$row["kode"]."' selected>".$row["nama"]."</option>\n";
             }
         }
         echo "</select>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Kualifikasi</td>\n";
    echo "<td width='80%'><input type=text name=kualifikasi  size=30 value='".$editrow["kualifikasi"]."'></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td colspan=2 align='center'><p><input type=submit name=submit value='Ubah'></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}


