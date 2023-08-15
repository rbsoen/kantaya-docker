<?php
/******************************************
Nama File : cek_sesi.inc
Fungsi    : Mengecek sesi di tiap php-file.
Dibuat    :	
 Tgl.     : 16-10-2001
 Oleh     : KB
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

session_start();
if (!$kode_pengguna or !$nama_pengguna or !$level) {
  header ('Location: ../index.php');
  }
?>
