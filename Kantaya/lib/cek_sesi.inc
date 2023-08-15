<?php
/******************************************
Nama File : cek_sesi.inc
Fungsi    : Mengecek sesi di tiap php-file.
Dibuat    :	
 Tgl.     : 16-10-2001
 Oleh     : KB
 
Revisi 1	:	
 Tgl.     : 17-08-2021
 Oleh     : rbsoen
 Revisi   : perbaikan sintax php

******************************************/

session_start();

# register variabel session
$kode_pengguna = $_SESSION['kode_pengguna'];
$nama_pengguna = $_SESSION['nama_pengguna'];
$level = $_SESSION['level'];
$email = $_SESSION['email'];
$unit_pengguna = $_SESSION['unit_pengguna'];
$tampilan_css = $_SESSION['tampilan_css'];
$cfgfile = $_SESSION['cfgfile'];

if (!$kode_pengguna or !$nama_pengguna or !$level) {
  header ('Location: ../index.php');
  }
?>
