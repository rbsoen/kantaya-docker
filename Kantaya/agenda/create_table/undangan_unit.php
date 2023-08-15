<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE undangan_unit (kode_agenda int(10) NOT NULL, kode_unit int(10) NOT NULL, tgl_dibuat date NOT NULL, PRIMARY KEY (kode_agenda, kode_unit), FOREIGN KEY (kode_agenda) REFERENCES agenda, FOREIGN KEY (kode_unit) REFERENCES unit_kerja)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
