<?php
/***********************************************************************
Nama File : post_diskusi.php
Fungsi    : Proses penyimpanan dan pengubahan data pada modul diskusi
Dibuat    :
Tgl.      : 07-11-2001
Oleh      : FB

Revisi 1  :
Tgl.      :
Oleh      :
Revisi    :
***********************************************************************/
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
require("../lib/fs_umum.php");
$css = "../lib/kantaya.css";

$js = "<script language='JavaScript'>" ;
$endjs = "</script>\n";

$dibuat_oleh = $kode_pengguna;
$tgljam = date("Y-n-j H:i:s");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

echo "<html>\n";
echo "<head><title>Pendaftaran Kamar Diskusi</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

switch ($namaform) {
    case "buatkamar":
         if (is_null($ktgr_ruang)) {
             $errtext = "Field Jenis Kategori Ruang Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if (is_null($nama_kamar) or is_null($jenis_kamar) or is_null($sifat)) {
             $errtext = "Field Nama Kamar, Jenis Kamar dan Sifat Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if (is_null($tuan_rumah)) {
             $errtext = "Field Tuan Rumah Harus Diisi";
             tampilkan_error('',$errtext);
         }
         $sqlinsert = "insert into kamar_diskusi(nama_kamar, ktgr_ruang, nama_ruang, tuan_rumah, jenis_kamar, sifat, undangan, kata_sambutan, dibuat_oleh, tgl_dibuat)";
         $sqlinsert .= " values ('$nama_kamar', '$ktgr_ruang', '$nama_ruang', '$tuan_rumah', '$jenis_kamar', '$sifat', '$undangan', '$kata_sambutan', $kode_pengguna, '$tgljam')";
         $hasil = mysql_query($sqlinsert, $db);
         $kode_ruang = mysql_insert_id($db);
//         echo "$sqlinsert<br>\n";
         check_mysql_error(mysql_errno(),mysql_error());
         echo $js." window.open('list_kamar.php?p1=$ktgr_ruang&p2=$nama_ruang','isi') ".$endjs;
    break;



}

echo "</body>\n";
echo "</html>\n";


