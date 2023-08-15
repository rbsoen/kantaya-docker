<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("INSERT INTO pengguna (kode_pengguna, nip,
nama_pengguna, level, username, password, tanggal_dibuat) values (0,
'0000000000', 'Administrator', '1', 'root', 'root', now())");

if ($result=="") {
  die ("Penambahan data gagal");}

else { echo "Penambahan data sukses!";}
?>
