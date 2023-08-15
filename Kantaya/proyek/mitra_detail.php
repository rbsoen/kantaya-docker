<?php
/*************************************************
Nama File : mitra_detail.php
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

$proyek = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran, koordinator FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($proyek);
$query = mysql_query("SELECT * FROM mitra_proyek WHERE kode_proyek=$p1 and kode_mitra=$p2", $db);
$mitra = mysql_fetch_array($query);

echo "<html>\n";
echo "<head>\n";
echo "<title>List Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "</head>\n";

echo "<body>\n";
echo "<table width='100%' border=0>\n";
if ($kode_pengguna == $proyek["koordinator"]){
    echo "<tr>\n";
    echo "<td colspan=2 class='judul1'>Detail Mitra Proyek</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td colspan=2>&nbsp;</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td align='right'><a href='ubah_mitra.php?p1=$p1&p2=$p2'>Ubah Data Mitra</a></td>\n";
		echo "</tr>\n";
} else {
    echo "<tr>\n";
    echo "<td class='judul1'>Detail Mitra Proyek</td>\n";
		echo "</tr>\n";
}
echo "</table>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td width='20%'>Tahun Anggaran</td>\n";
echo "<td width='80%'>: ".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Proyek</td>\n";
echo "<td width='80%': ><a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td colspan=4 class='judul2'>Data Mitra </td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>No Kerjasama</td>\n";
echo "<td width='30%'>: ".$mitra["no_kerjasama"]."&nbsp;</td>\n";
echo "<td width='20%'>Jenis Kerjasama</td>\n";
echo "<td width='30%'>: \n";
     $qry = mysql_query("SELECT * FROM kd_jns_kjsama WHERE kode='".$mitra["jenis_kerjasama"]."'", $db);
     $row = mysql_fetch_array($qry);
     echo $row["nama"]."&nbsp;\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Nama Mitra</td>\n";
echo "<td colspan=3>: ".$mitra["nama_mitra"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Lembaga</td>\n";
echo "<td width='30%'>: \n";
     $qry = mysql_query("SELECT * FROM kd_jns_lembaga WHERE kode='".$mitra["jenis_lembaga"]."'", $db);
     $row = mysql_fetch_array($qry);
     echo $row["nama"]."&nbsp;\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kontak Person</td>\n";
echo "<td colspan=3>: ".$mitra["kontak_person"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Telp.</td>\n";
echo "<td width='30%'>: ".$mitra["telp_kantor"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>HP</td>\n";
echo "<td width='30%'>: ".$mitra["telp_hp"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Fax</td>\n";
echo "<td width='30%'>: ".$mitra["fax"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Email</td>\n";
echo "<td width='30%'>: ".$mitra["email"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Alamat</td>\n";
echo "<td colspan=3>: ".$mitra["alamat"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Kota</td>\n";
echo "<td width='30%'>: ".$mitra["kota"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Propinsi</td>\n";
echo "<td width='30%'>: ".$mitra["propinsi"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Negara</td>\n";
echo "<td colspan=3>: ".$mitra["negara"]."&nbsp;</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "</body>\n";
echo "</html>\n";


