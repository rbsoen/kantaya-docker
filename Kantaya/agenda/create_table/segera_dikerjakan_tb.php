<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE segera_dikerjakan (kode_dikerjakan int(10) NOT NULL AUTO_INCREMENT, pemilik int(10) NOT NULL, judul varchar(80) NOT NULL, status varchar(16) NOT NULL, tgl_berakhir date, deskripsi varchar(120), tgl_dibuat date NOT NULL, tgl_diubah date, PRIMARY KEY (kode_dikerjakan), FOREIGN KEY (pemilik) REFERENCES pengguna)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
