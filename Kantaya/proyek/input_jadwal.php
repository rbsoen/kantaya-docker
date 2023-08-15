<?php
/*************************************************
Nama File : input_jadwal.php
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
include('../lib/akses_unit.php');
require("../lib/kantaya_cfg.php");
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$proyek = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($proyek);

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
echo "<title>List Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";

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
echo "function cek_jnskgtn(fld) {\n";
echo "  if (fld.name == 'jenis_kegiatan') {\n";
echo "    obj = document.jdwlproyek.subkont_mitra;\n";
echo "    if (fld.value == 'swa') {\n";
echo "        obj.selectedIndex = 0;\n";
echo "    }\n";
echo "  }\n";
echo "  if (fld.name == 'subkont_mitra') {\n";
echo "    obj = document.jdwlproyek.jenis_kegiatan; \n";
echo "    if (fld.value != '') {\n";
echo "        obj.selectedIndex = 1; \n";
echo "    }\n";
echo "  }\n";
echo "};\n";

echo "</script>\n";

echo "</head>\n";
echo "<body>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1'>Detail Kegiatan Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td width='20%'>Th. Anggaran</td>\n";
echo "<td width='80%'>: ".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Proyek</td>\n";
echo "<td width='80%'>: <a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<form name='jdwlproyek' method='post' action='post_jdwlproyek.php' target='isi'>\n";
echo "<input type=hidden name='jnstransaksi' value='input'>\n";
echo "<input type=hidden name='kode_proyek' value='$p1'>\n";
echo "<input type=hidden name='jenis_sharing' value=$jns_sharing>\n";
echo "<input type=hidden name='grup_sharing' value=$grup_sharing>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td colspan=4 class='judul2'>Data Kegiatan </td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>No Kegiatan <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: <input type=text name='no_kegiatan' size=20></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Bobot Kegiatan (%)<font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='bobot'>\n";
     $i = 0;
     while ($i<=100) {
         echo "<option value='$i'>$i</option>\n";
         $i = $i + 5;
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Nama Kegiatan<font size=2 color=red>*</font></td>\n";
echo "<td colspan=3>: <input type=text name='nama_kegiatan' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Sub Kegiatan Dari</td>\n";
echo "<td colspan=3>: \n";
     echo "<select name='induk_kegiatan'>\n";
     echo "<option value='' selected>Pilih Induk Kegiatan</option>\n";
     $query = mysql_query("SELECT * FROM jadwal_proyek where kode_proyek='$p1' order by no_kegiatan ", $db);
     while ($row = mysql_fetch_array($query)) {
         echo "<option value='".$row["no_kegiatan"]."'>".$row["nama_kegiatan"]."</option>\n";
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Kegiatan</td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='jenis_kegiatan' onChange=cek_jnskgtn(this)>\n";
     echo "<option value='swa' selected>Swakelola</option>\n";
     echo "<option value='sub'>Sub Kontrak</option>\n";
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Sub Kontraktor Mitra</td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='subkont_mitra' onChange=cek_jnskgtn(this)>\n";
     echo "<option value='' selected>Pilih Sub Kontraktor Mitra</option>\n";
     $query = mysql_query("SELECT * FROM mitra_proyek where kode_proyek='$p1' order by nama_mitra ", $db);
     while ($row = mysql_fetch_array($query)) {
         echo "<option value='".$row["kode_mitra"]."'>".$row["nama_mitra"]."</option>\n";
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=4>Rencana</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Tgl Mulai</td>\n";
echo "<td colspan=3>: \n";
     echo "<input type=hidden name='rcn_tgl_mulai'>\n";
     echo "<select name='rcntglmulai'>\n";
     for ($i=1; $i<=31; $i++){
         echo "<option value=$i> $i</option>\n";
     }
     echo "</select>\n";
     echo "<select name='rcnblnmulai'>\n";
     for ($i=1; $i<=12; $i++){
         if ($i == date("m")) {
             echo "<option value=$i selected> ".namabulan("P",$i)."</option>\n";
         } else {
             echo "<option value=$i> ".namabulan("P",$i)."</option>\n";
         }
     }
     echo "</select>\n";
     echo "<select name='rcnthnmulai'>\n";
     for ($i=0; $i<=2; $i++){
         if (date("Y")-1+$i == date("Y")) {
             echo "<option value=".(date("Y")-1+$i)." selected>".(date("Y")-1+$i)."</option>\n";
         } else {
             echo "<option value=".(date("Y")-1+$i).">".(date("Y")-1+$i)."</option>\n";
         }
         if ($i==0) {
             $range = (date("Y")-1+$i);
         } else {
             $range = $range.",".(date("Y")-1+$i);
         }
     }
     echo "</select>\n";
     $fld = 'jdwlproyek,rcntglmulai,rcnblnmulai,rcnthnmulai';
     $dflt = '';
     echo "<a href=\"javascript:showCldList('$fld', '$dflt', '$range')\"><img align=top border=0 height=21 src='../gambar/cld.gif'></a>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Tgl Selesai</td>\n";
echo "<td colspan=3>: \n";
     echo "<input type=hidden name='rcn_tgl_selesai'>\n";
     echo "<select name='rcntglselesai'>\n";
     for ($i=1; $i<=31; $i++){
         echo "<option value=$i> $i</option>\n";
     }
     echo "</select>\n";
     echo "<select name='rcnblnselesai'>\n";
     for ($i=1; $i<=12; $i++){
         if ($i == date("m")) {
             echo "<option value=$i selected> ".namabulan("P",$i)."</option>\n";
         } else {
             echo "<option value=$i> ".namabulan("P",$i)."</option>\n";
         }
     }
     echo "</select>\n";
     echo "<select name='rcnthnselesai'>\n";
     for ($i=0; $i<=2; $i++){
         if (date("Y")-1+$i == date("Y")) {
             echo "<option value=".(date("Y")-1+$i)." selected>".(date("Y")-1+$i)."</option>\n";
         } else {
             echo "<option value=".(date("Y")-1+$i).">".(date("Y")-1+$i)."</option>\n";
         }
         if ($i==0) {
             $range = (date("Y")-1+$i);
         } else {
             $range = $range.",".(date("Y")-1+$i);
         }
     }
     echo "</select>\n";
     $fld = 'jdwlproyek,rcntglselesai,rcnblnselesai,rcnthnselesai';
     $dflt = '';
     echo "</select>\n";
     echo "<a href=\"javascript:showCldList('$fld', '$dflt', '$range')\"><img align=top border=0 height=21 src='../gambar/cld.gif'></a>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=4>Realisasi</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Tgl Mulai</td>\n";
echo "<td colspan=3>: \n";
     echo "<input type=hidden name='akt_tgl_mulai'>\n";
     echo "<select name='akttglmulai'><option value=''></option>\n";
     for ($i=1; $i<=31; $i++){
         echo "<option value=$i> $i</option>\n";
     }
     echo "</select>\n";
     echo "<select name='aktblnmulai'><option value=''></option>\n";
     for ($i=1; $i<=12; $i++){
         echo "<option value=$i> ".namabulan("P",$i)."</option>\n";
     }
     echo "</select>\n";
     echo "<select name='aktthnmulai'><option value=''></option>\n";
     for ($i=0; $i<=2; $i++){
         echo "<option value=".(date("Y")-1+$i).">".(date("Y")-1+$i)."</option>\n";
         if ($i==0) {
             $range = (date("Y")-1+$i);
         } else {
             $range = $range.",".(date("Y")-1+$i);
         }
     }
     echo "</select>\n";
     $fld = 'jdwlproyek,akttglmulai,aktblnmulai,aktthnmulai';
     $dflt = '';
     echo "<a href=\"javascript:showCldList('$fld', '$dflt', '$range')\"><img align=top border=0 height=21 src='../gambar/cld.gif'></a>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Tgl Selesai</td>\n";
echo "<td colspan=3>: \n";
     echo "<input type=hidden name='akt_tgl_selesai'>\n";
     echo "<select name='akttglselesai'><option value=''></option>\n";
     for ($i=1; $i<=31; $i++){
         echo "<option value=$i> $i</option>\n";
     }
     echo "</select>\n";
     echo "<select name='aktblnselesai'><option value=''></option>\n";
     for ($i=1; $i<=12; $i++){
         echo "<option value=$i> ".namabulan("P",$i)."</option>\n";
     }
     echo "</select>\n";
     echo "<select name='aktthnselesai'><option value=''></option>\n";
     for ($i=0; $i<=2; $i++){
         echo "<option value=".(date("Y")-1+$i).">".(date("Y")-1+$i)."</option>\n";
         if ($i==0) {
             $range = (date("Y")-1+$i);
         } else {
             $range = $range.",".(date("Y")-1+$i);
         }
     }
     echo "</select>\n";
     $fld = 'jdwlproyek,akttglselesai,aktblnselesai,aktthnselesai';
     $dflt = '';
     echo "</select>\n";
     echo "<a href=\"javascript:showCldList('$fld', '$dflt', '$range')\"><img align=top border=0 height=21 src='../gambar/cld.gif'></a>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Status (%)</td>\n";
echo "<td colspan=3>: \n";
     echo "<select name='status'>\n";
     $i = 0;
     while ($i<=100) {
         echo "<option value='$i'>$i</option>\n";
         $i = $i + 5;
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Keterangan </td>\n";
echo "<td>:</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>&nbsp;</td>\n";
echo "<td colspan=3 valign='top'><textarea rows=5 cols=30 name='keterangan'></textarea></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=3>";
echo "<font size=2>Ket. :</font><font size=2 color=red> * </font><font size=2>= Wajib diisi/dipilih.</font>";
echo "</td>";
echo "</tr>\n";
echo "</table><p>\n";

$where = "a.kode_proyek = '$p1' and a.jabatan = b.kode and a.kode_pengguna = c.kode_pengguna";
$query = mysql_query("SELECT a.kode_pengguna, c.nama_pengguna, b.nama jabatan, a.kualifikasi FROM personil_proyek a, kd_jbtn_proyek b, pengguna c WHERE $where ORDER BY jabatan", $db);
echo "<table width='100%' border=1>\n";
echo "<tr>\n";
echo "<td colspan=5 class='judul2'>Data Penugasan Personil </td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='judul3' width='5%'>&nbsp;</td>\n";
echo "<td class='judul3' width='30%'>Nama Personil</td>\n";
echo "<td class='judul3' width='15%'>Jabatan</td>\n";
echo "<td class='judul3' width='40%'>Job</td>\n";
echo "<td class='judul3' width='10%'>Org-Jam</td>\n";
echo "</tr>\n";
while ($row = mysql_fetch_array($query)) {
    $i++;
    echo "<tr>\n";
    echo "<td width='5%'><input type='checkbox' name='personil[]' value=".$row["kode_pengguna"]."></td>\n";
    echo "<td width='30%'>".$row["nama_pengguna"]."</td>\n";
    echo "<td width='15%'>".$row["jabatan"]."</td>\n";
    echo "<td width='40%'><input type=text name='job[]' size=25></td>\n";
    echo "<td width='10%'><input type=text name='org_jam[]' size=5></td>\n";
    echo "</tr>\n";
}
echo "</table>\n";

echo "<p>\n";
echo "<input type=submit name=submit value='Simpan'>\n";
echo "<input type=submit name=submit value='Simpan dan Tambah'>\n";
echo "<input type=submit name=submit value='Batal' onClick='history.go(-1)'>\n";

echo "</form>\n";
echo "</body>\n";
echo "</html>\n";



