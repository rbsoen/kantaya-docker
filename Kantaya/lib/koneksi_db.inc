<?php
/******************************************
Nama File : koneksi_db.inc
Fungsi    : Konfigurasi koneksi ke database.
Dibuat    :	20-10-2001
 Tgl.     : 
 Oleh     : KB
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

$db="kantaya";
$host="localhost";
$username="root";
$password="";

if (!$dbh=mysql_connect($host, $username, $password))
  {
    echo mysql_error();
  }

mysql_select_db($db, $dbh);
?>
