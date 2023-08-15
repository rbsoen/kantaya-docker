<?php
/*************************************************
Nama File : ubah_mitra.php
Fungsi    : 
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 27-11-2001
 Oleh     : AS
 Revisi   : link ubah ke buku alamat.
**************************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
include('../lib/akses_unit.php');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$proyek = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($proyek);
$query = mysql_query("SELECT * FROM mitra_proyek WHERE kode_proyek=$p1 and kode_mitra=$p2", $db);
$mitra = mysql_fetch_array($query);
$kontakperson = $mitra["kontak_person"];
echo $kontakperson;

//tambahan untuk mencari kontak_id di bku alamat(AS)
$query = mysql_query("SELECT kontak_id FROM buku_alamat WHERE nama='$kontakperson'", $db);
$kontakid = mysql_result($query,0,"kontak_id");

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
echo "<input type=hidden name='jnstransaksi' value='ubah'>\n";
echo "<input type=hidden name='kode_proyek' value='$p1'>\n";
echo "<input type=hidden name='kode_mitra' value='$p2'>\n";
echo "<input type=hidden name='kontakid' value='$kontakid'>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td colspan=4 class='judul2'>Data Mitra </td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>No Kerjasama</td>\n";
echo "<td width='30%'>: <input type=text name='no_kerjasama' size=20 value='".$mitra["no_kerjasama"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Kerjasama</td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='jenis_kerjasama'>\n";
     $query = mysql_query("SELECT * FROM kd_jns_kjsama order by nama ", $db);
     while ($row = mysql_fetch_array($query)) {
         if ($row["kode"] == $mitra["jenis_kerjasama"]) {
             echo "<option value='".$row["kode"]."' selected>".$row["nama"]."</option>\n";
         } else {
             echo "<option value='".$row["kode"]."'>".$row["nama"]."</option>\n";
         }
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Nama Mitra</td>\n";
echo "<td colspan=3>: <input type=text name='nama_mitra' size=40 value='".$mitra["nama_mitra"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Lembaga</td>\n";
echo "<td width='30%'>: \n";
     echo "<select name='jenis_lembaga'>\n";
     echo "<option value='' selected>Pilih Jenis Lembaga</option>\n";
     $query = mysql_query("SELECT * FROM kd_jns_lembaga order by nama ", $db);
     while ($row = mysql_fetch_array($query)) {
         if ($row["kode"] == $mitra["jenis_lembaga"]) {
             echo "<option value='".$row["kode"]."' selected>".$row["nama"]."</option>\n";
         } else {
             echo "<option value='".$row["kode"]."'>".$row["nama"]."</option>\n";
         }     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kontak Person</td>\n";
echo "<td colspan=3>: <input type=text name='kontak_person' size=40 value='".$mitra["kontak_person"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Telp.</td>\n";
echo "<td width='30%'>: <input type=text name='telp_kantor' size=20 value='".$mitra["telp_kantor"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>HP</td>\n";
echo "<td width='30%'>: <input type=text name='telp_hp' size=20 value='".$mitra["telp_hp"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Fax</td>\n";
echo "<td width='30%'>: <input type=text name='fax' size=20 value='".$mitra["fax"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Email</td>\n";
echo "<td width='30%'>: <input type=text name='emailmitra' size=20 value='".$mitra["email"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Web</td>\n";
echo "<td width='30%'>: <input type=text name='web_kantor' size=30></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Alamat</td>\n";
echo "<td colspan=3>: <input type=text name='alamat' size=40 value='".$mitra["alamat"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kota</td>\n";
echo "<td width='30%'>: <input type=text name='kota' size=20 value='".$mitra["kota"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Propinsi</td>\n";
echo "<td width='30%'>: <input type=text name='propinsi' size=20 value='".$mitra["propinsi"]."'></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Negara</td>\n";
echo "<td colspan=3>: <input type=text name='negara' size=20 value='".$mitra["negara"]."'></td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<p>\n";
echo "<input type=submit name=submit value='Simpan'>\n";
echo "<input type=submit name=submit value='Batal' onClick='history.go(-1)'>\n";

echo "</form>\n";
echo "</body>\n";
echo "</html>\n";


