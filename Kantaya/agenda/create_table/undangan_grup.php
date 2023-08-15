<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE undangan_grup (kode_agenda int(10) NOT NULL, kode_grup int(10) NOT NULL, tgl_dibuat date NOT NULL, PRIMARY KEY (kode_agenda, kode_grup), FOREIGN KEY (kode_agenda) REFERENCES agenda, FOREIGN KEY (kode_grup) REFERENCES grup)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
