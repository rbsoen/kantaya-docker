<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("INSERT INTO unit_kerja (kode_unit, nama_unit,
tanggal_dibuat) values ('UKS', 'Unit Kerja Sementara', now())");

if ($result=="") {
  die ("Penambahan data gagal");}

else { echo "Penambahan data sukses!";}
?>
