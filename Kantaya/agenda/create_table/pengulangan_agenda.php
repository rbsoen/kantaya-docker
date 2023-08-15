<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE pengulangan_agenda_unit (kode_agenda int(10) NOT NULL, fase_ulang varchar(10) NOT NULL, diulang_setiap varchar(10), sd_tgl date, tgl_dibuat date NOT NULL, PRIMARY KEY (kode_agenda))");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
