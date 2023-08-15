<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("INSERT INTO grup (kode_grup, nama_grup,
sifat_grup, tanggal_dibuat) values (0, 'Grup Sementara',
'Eksklusif', now())");

if ($result=="") {
  die ("Penambahan data gagal");}

else { echo "Penambahan data sukses!";}
?>
