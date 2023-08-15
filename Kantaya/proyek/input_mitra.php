<?php
/*************************************************
Nama File : input_mitra.php
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

$query = mysql_query("SELECT no_proyek, singkatan, nama_proyek, tahun_anggaran FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($query);
$singkatan = $proyek["singkatan"];

$query = mysql_query("SELECT kode_grup FROM grup WHERE nama_grup='$singkatan'", $db);
$kodegrup = mysql_result($query,0,"kode_grup");


echo "<html>\n";
echo "<head>\n";
echo "<title>List Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";

echo "</head>\n";
echo "<body>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1'>Input Mitra Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

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

echo "<form name='mitraproyek' method='post' action='post_mitra.php' target='isi'>\n";
echo "<input type=hidden name='jnstransaksi' value='input'>\n";
echo "<input type=hidden name='kode_proyek' value='$p1'>\n";
echo "<input type=hidden name='kode_grup' value='$kodegrup'>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td colspan=4 class='judul2'>Data Mitra </td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>No Kerjasama</td>\n";
echo "<td width='30%'>: <input type=text name='no_kerjasama' size=20></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Kerjasama <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='jenis_kerjasama'>\n";
     echo "<option value='' selected>Pilih Jenis Kerjasama</option>\n";
     $query = mysql_query("SELECT * FROM kd_jns_kjsama order by nama ", $db);
     while ($row = mysql_fetch_array($query)) {
         echo "<option value='".$row["kode"]."'>".$row["nama"]."</option>\n";
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Nama Mitra <font size=2 color=red>*</font></td>\n";
echo "<td colspan=3>: <input type=text name='nama_mitra' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Lembaga <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='jenis_lembaga'>\n";
     echo "<option value='' selected>Pilih Jenis Lembaga</option>\n";
     $query = mysql_query("SELECT * FROM kd_jns_lembaga order by nama ", $db);
     while ($row = mysql_fetch_array($query)) {
         echo "<option value='".$row["kode"]."'>".$row["nama"]."</option>\n";
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kontak Person <font size=2 color=red>*</font></td>\n";
echo "<td colspan=3>: <input type=text name='kontak_person' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Telp. <font size=2 color=red>*</font></td>\n";
echo "<td width='30%'>: <input type=text name='telp_kantor' size=10></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>HP</td>\n";
echo "<td width='30%'>: <input type=text name='telp_hp' size=10></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Fax</td>\n";
echo "<td width='30%'>: <input type=text name='fax' size=10></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Email</td>\n";
echo "<td width='30%'>: <input type=text name='emailmitra' size=10></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Web</td>\n";
echo "<td width='30%'>: <input type=text name='web_kantor' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Alamat</td>\n";
echo "<td colspan=3>: <input type=text name='alamat' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kota</td>\n";
echo "<td width='30%'>: <input type=text name='kota' size=20></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Propinsi</td>\n";
echo "<td width='30%'>: <input type=text name='propinsi' size=20></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Negara</td>\n";
echo "<td colspan=3>: <input type=text name='negara' size=30 value='Indonesia'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=3>";
echo "<font size=2>Ket. :</font><font size=2 color=red> * </font><font size=2>= Wajib diisi/dipilih.</font>";
echo "</td>";
echo "</tr>\n";
echo "</table>\n";

echo "<p>\n";
echo "<input type=submit name=submit value='Simpan'>\n";
echo "<input type=submit name=submit value='Simpan dan Tambah'>\n";
echo "<input type=submit name=submit value='Batal' onClick='history.go(-1)'>\n";

echo "</form>\n";
echo "</body>\n";
echo "</html>\n";


