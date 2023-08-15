<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("INSERT INTO grup_pengguna (kode_pengguna,
kode_grup, tanggal_dibuat) values (1, 1, now())");

if ($result=="") {
  die ("Penambahan data gagal");}

else { echo "Penambahan data sukses!";}
?>
