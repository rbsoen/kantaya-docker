<?php
/******************************************
Nama File : koneksi_db.inc
Fungsi    : Konfigurasi koneksi ke database.
Dibuat    :	20-10-2001
 Tgl.     : 
 Oleh     : KB
 
Revisi 1	:	
 Tgl.     : 17-08-2021
 Oleh     : rbsoen
 Revisi   : gunakan konfigurasi dalam cfg/kantaya.cfg

******************************************/

require("../cfg/kantaya.cfg");

if (!$dbh=mysql_connect($db_host, $db_user, $db_pswd))
  {
    echo mysql_error();
  }

mysql_select_db($db_database, $dbh);
?>
