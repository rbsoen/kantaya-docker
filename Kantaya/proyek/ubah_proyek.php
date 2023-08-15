<?php
/******************************************
Nama File : ubah_proyek.php
Fungsi    : Mengubah data proyek
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 20-11-2001
 Oleh     : AS
 Revisi   : css
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
echo "<title>Edit Data Proyek</title>\n";
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
echo "<td class='judul1'>Edit Data Proyek</td>\n";
echo "</tr>\n";
//echo "<tr>\n";
//echo "<td>&nbsp;</td>\n";
//echo "</tr>\n";
echo "</table>\n";

echo "<form name='daftarproyek' method='post' action='post_proyek.php' target='isi'>\n";
echo "<input type=hidden name='namaform' value='editproyek'>\n";
echo "<input type=hidden name='kode_proyek' value='$p1'>\n";
echo "<input type=hidden name='jenis_sharing' value=".$proyek["jenis_sharing"].">\n";
echo "<input type=hidden name='grup_sharing' value=".$proyek["grup_sharing"].">\n";
echo "<table width='100%' border=0>\n";
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
echo "<td width='20%'>No. Proyek <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: <input type=text name='no_proyek' size=10 value='".$proyek["no_proyek"]."'></td>\n";
echo "<td width='20%'>Th. Anggaran</td>\n";
echo "<td width='30%'>: <select name='tahun_anggaran'>\n";
     for ($i=0; $i<3; $i++) {
         if (date("Y")-1+$i == $proyek["tahun_anggaran"]) {
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
echo "<td colspan=3>: <input type=text name='nama_proyek' size=30 value='".$proyek["nama_proyek"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Singkatan <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: <input type=text name='singkatan' size=10 value='".$proyek["singkatan"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Proyek <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='jenis_proyek'>\n";
     $query = mysql_query("SELECT * FROM kd_jns_proyek order by nama", $db);
     while ($row = mysql_fetch_array($query)) {
         if ($row["kode"] == $proyek["jenis_proyek"]) {
             echo "<option value='".$row["kode"]."' selected>".$row["nama"]."</option>\n";
         } else {
             echo "<option value='".$row["kode"]."'>".$row["nama"]."</option>\n";
         }
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
             if ($proyek["unit_pengelola"] == $aksesunit[$i][0]) {
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
         ambil_data_pengguna($db, $proyek["koordinator"], $koord);
         echo "<input type=hidden name='koordinator' value='".$proyek["koordinator"]."'>\n";
         echo "<input type=text name='nama_koordinator' value='".$koord["nama"]."' size=30>\n";
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
     if ($proyek["status"] == '0') {
         echo "<option value='0' selected> Selesai</option>\n";
         echo "<option value='1'> Aktif</option>\n";
     } else {
         echo "<option value='0'> Selesai</option>\n";
         echo "<option value='1' selected> Aktif</option>\n";
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";

$jnsplp = $proyek["jenis_pelaporan"];
if ($jnsplp=="T") {
  $jnsplptxt = "Triwulanan";
} else {
  $jnsplptxt = "Bulanan";
}
	
echo "<tr>\n";
echo "<td width='20%'>Jenis Pelaporan</td>\n";
echo "<td colspan=3>: <select name='jenispelaporan'>\n";
     echo "<option value='".$jnsplp."' selected> ".$jnsplptxt."</option>\n";
		 if ($jnsplp <> "B") {
        echo "<option value='B'> Bulanan</option>\n";
		 }
		 if ($jnsplp <> "T") {		 
        echo "<option value='T'> Triwulanan</option>\n";
		 }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td width='20%'>Tgl Mulai</td>\n";
echo "<td colspan=3>: \n";
     list($y,$m,$d)=split("-",$proyek["tgl_mulai"]);
     echo "<input type=hidden name='tgl_mulai'>\n";
     echo "<select name='tglmulai'>\n";
     for ($i=1; $i<=31; $i++){
         if ($i == $d) {
             echo "<option value=$i selected> $i</option>\n";
         } else {
             echo "<option value=$i> $i</option>\n";
         }
     }
     echo "</select>\n";
     echo "<select name='blnmulai'>\n";
     for ($i=1; $i<=12; $i++){
         if ($i == $m) {
             echo "<option value=$i selected> ".namabulan("P",$i)."</option>\n";
         } else {
             echo "<option value=$i> ".namabulan("P",$i)."</option>\n";
         }
     }
     echo "</select>\n";
     echo "<select name='thnmulai'>\n";
     for ($i=0; $i<=2; $i++){
         if (date("Y")-1+$i == $y) {
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
     list($y,$m,$d)=split("-",$proyek["tgl_selesai"]);
     echo "<input type=hidden name='tgl_selesai'>\n";
     echo "<select name='tglselesai'>\n";
     for ($i=1; $i<=31; $i++){
         if ($i == $d) {
             echo "<option value=$i selected> $i</option>\n";
         } else {
             echo "<option value=$i> $i</option>\n";
         }
     }
     echo "</select>\n";
     echo "<select name='blnselesai'>\n";
     for ($i=1; $i<=12; $i++){
         if ($i == $m) {
             echo "<option value=$i selected> ".namabulan("P",$i)."</option>\n";
         } else {
             echo "<option value=$i> ".namabulan("P",$i)."</option>\n";
         }
     }
     echo "</select>\n";
     echo "<select name='thnselesai'>\n";
     for ($i=0; $i<=2; $i++){
         if (date("Y")-1+$i == $y) {
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
echo "<td colspan=3>: <input type=text name='lokasi' size=30 value='".$proyek["lokasi"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kata Kunci</td>\n";
echo "<td colspan=3>: <input type=text name='kata_kunci' size=30 value='".$proyek["kata_kunci"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%' valign='top'>Tujuan</td>\n";
echo "<td colspan=3 valign='top'>: <textarea rows=5 cols=30 name='tujuan'>".$proyek['tujuan']."</textarea></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%' valign='top'>Sasaran</td>\n";
echo "<td colspan=3 valign='top'>: <textarea rows=5 cols=30 name='sasaran'>".$proyek['sasaran']."</textarea>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2 align='right'><p><input type=submit name=submit value='Simpan'></td>\n";
echo "<td colspan=2 align='left'><p><input type=submit name=submit value='Batal' onClick='history.go(-1)'></td>\n";
echo "</tr>\n";


echo "</table>\n";


echo "</form>\n";
echo "</body>\n";
echo "</html>\n";

