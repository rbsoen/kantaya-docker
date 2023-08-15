<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE sharing_agenda_pengguna (kode_agenda int(10) NOT NULL, kode_pengguna int(10) NOT NULL, tgl_dibuat date NOT NULL, PRIMARY KEY (kode_agenda, kode_pengguna), FOREIGN KEY (kode_agenda) REFERENCES agenda, FOREIGN KEY (kode_pengguna) REFERENCES pengguna)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
