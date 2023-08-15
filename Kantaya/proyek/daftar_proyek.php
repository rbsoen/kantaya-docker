<?php
/******************************************
Nama File : daftar_proyek.php
Fungsi    : Mendaftarkan proyek baru
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 8-11-2001
 Oleh     : AS
 Revisi   : Jenis Pelaporan.
******************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
include('../lib/akses_unit.php');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

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
if ($halaman == "") $halaman = 1;

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
echo "</script>\n";

echo "</head>\n";
echo "<body>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1'>Pendaftaran Proyek</td>\n";
echo "</tr>\n";
//echo "<tr>\n";
//echo "<td>&nbsp;</td>\n";
//echo "</tr>\n";
echo "</table>\n";

echo "<form name='daftarproyek' method='post' action='post_proyek.php' target='isi'>\n";
echo "<input type=hidden name='namaform' value='daftarproyek'>\n";
echo "<input type=hidden name='jenis_sharing' value=$jns_sharing>\n";
echo "<input type=hidden name='grup_sharing' value=$grup_sharing>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul2' colspan=4>\n";
     if ($jns_sharing == "U") {
         echo "Unit : $unit_grup\n";
     } elseif ($jns_sharing == "G") {
         echo "Grup : $unit_grup\n";
     }
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>No. Proyek <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: <input type=text name='no_proyek' size=15></td>\n";
echo "<td width='20%'>Th. Anggaran</td>\n";
echo "<td width='30%'>: <select name='tahun_anggaran'>\n";
     for ($i=0; $i<3; $i++) {
         if (date("Y")-1+$i == date("Y")) {
             echo "<option value=".(date("Y")-1+$i)." selected>".(date("Y")-1+$i)."</option>\n";
         } else {
             echo "<option value=".(date("Y")-1+$i).">".(date("Y")-1+$i)."</option>\n";
         }
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Nama Proyek <font size=2 color=red>*</font></td>\n";
echo "<td colspan=3>: <input type=text name='nama_proyek' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Singkatan <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: <input type=text name='singkatan' size=10></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Proyek <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='jenis_proyek'><option value='' selected>Pilih jenis proyek</option>\n";
     $query = mysql_query("SELECT * FROM kd_jns_proyek order by nama", $db);
     while ($row = mysql_fetch_array($query)) {
         echo "<option value='".$row["kode"]."'>".$row["nama"]."</option>\n";
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Unit Pengelola</td>\n";
echo "<td colspan=3>: \n";
     if ($level == 1) {
         list_akses_unit($db,'',&$aksesunit);
         echo "<select name='unit_pengelola'>\n";
         for ($i=0; $i<count($aksesunit); $i++) {
             if ($unit_pengguna == $aksesunit[$i][0]) {
                 echo "<option value=".$aksesunit[$i][0]." selected>".$aksesunit[$i][1]."</option>\n";
             } else {
                 echo "<option value=".$aksesunit[$i][0].">".$aksesunit[$i][1]."</option>\n";
             }
         }
         echo "</select>\n";
     } else {
         $query = mysql_query("SELECT * FROM unit_kerja WHERE kode_unit='$unit_pengguna'", $db);
         $row = mysql_fetch_array($query);
         echo "<input type=hidden name='unit_pengelola' value='$unit_pengguna'>\n";
         echo "<font size=+1>".$row["nama_unit"]."</font>\n";
     }
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Koordinator <font size=2 color=red>*</font></td>\n";
echo "<td colspan=3>: \n";
     if ($level == 1) {
         echo "<input type=hidden name='koordinator' value='$kode_pengguna'>\n";
         echo "<input type=text name='nama_koordinator' value='' size=30>\n";
         echo "<a href=\"javascript:showUserList('daftarproyek,koordinator,nama_koordinator',document.daftarproyek.unit_pengelola.options[document.daftarproyek.unit_pengelola.selectedIndex].value)\"><img align=top border=0 height=21 src='../gambar/p108.gif'></a>\n";
     } else {
         echo "<input type=hidden name='koordinator' value='$kode_pengguna'>\n";
         echo "<font size=+1>$nama_pengguna</font>\n";
     }
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Status</td>\n";
echo "<td colspan=3>: <select name='status'>\n";
     echo "<option value='0'> Selesai</option>\n";
     echo "<option value='1' selected> Aktif</option>\n";
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td width='20%'>Jenis Pelaporan</td>\n";
echo "<td colspan=3>: <select name='jenispelaporan'>\n";
     echo "<option value='B'> Bulanan</option>\n";
     echo "<option value='T' selected> Triwulanan</option>\n";
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td width='20%'>Tgl Mulai</td>\n";
echo "<td colspan=3>: \n";
     echo "<input type=hidden name='tgl_mulai'>\n";
     echo "<select name='tglmulai'>\n";
     for ($i=1; $i<=31; $i++){
         echo "<option value=$i> $i</option>\n";
     }
     echo "</select>\n";
     echo "<select name='blnmulai'>\n";
     for ($i=1; $i<=12; $i++){
         echo "<option value=$i> ".namabulan("P",$i)."</option>\n";
     }
     echo "</select>\n";
     echo "<select name='thnmulai'>\n";
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
     $fld = 'daftarproyek,tglmulai,blnmulai,thnmulai';
     $dflt = '';
     echo "<a href=\"javascript:showCldList('$fld', '$dflt', '$range')\"><img align=top border=0 height=21 src='../gambar/cld.gif'></a>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Tgl Selesai</td>\n";
echo "<td colspan=3>: \n";
     echo "<input type=hidden name='tgl_selesai'>\n";
     echo "<select name='tglselesai'>\n";
     for ($i=1; $i<=31; $i++){
         echo "<option value=$i> $i</option>\n";
     }
     echo "</select>\n";
     echo "<select name='blnselesai'>\n";
     for ($i=1; $i<=12; $i++){
         echo "<option value=$i> ".namabulan("P",$i)."</option>\n";
     }
     echo "</select>\n";
     echo "<select name='thnselesai'>\n";
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
     $fld = 'daftarproyek,tglselesai,blnselesai,thnselesai';
     $dflt = '';
     echo "</select>\n";
     echo "<a href=\"javascript:showCldList('$fld', '$dflt', '$range')\"><img align=top border=0 height=21 src='../gambar/cld.gif'></a>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Lokasi</td>\n";
echo "<td colspan=3>: <input type=text name='lokasi' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kata Kunci</td>\n";
echo "<td colspan=3>: <input type=text name='kata_kunci' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%' valign='top'>Tujuan</td>\n";
echo "<td colspan=3 valign='top'>: <textarea rows=5 cols=30 name='tujuan'></textarea></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%' valign='top'>Sasaran</td>\n";
echo "<td colspan=3 valign='top'>: <textarea rows=5 cols=30 name='sasaran'></textarea>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2 align='right'><p><input type=submit name=submit value='Simpan'></td>\n";
echo "<td colspan=2 align='left'><p><input type=submit name=submit value='Batal' onClick='javascript:history.go(-1)'></td>\n";
echo "</tr>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=3>";
echo "<font size=2>Ket. :</font><font size=2 color=red> * </font><font size=2>= Wajib diisi/dipilih.</font>";
echo "</td>";
echo "</tr>\n";
echo "</table>\n";


echo "</form>\n";
echo "</body>\n";
echo "</html>\n";

