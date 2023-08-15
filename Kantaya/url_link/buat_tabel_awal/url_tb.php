<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE url 
(kode_url int(10) NOT NULL DEFAULT '0' AUTO_INCREMENT,
 url varchar(120) NOT NULL,
 nama_url varchar(120) NOT NULL,
 keterangan varchar(120),
 direktori int(10) NOT NULL,
 tanggal_dibuat date NOT NULL,
 tanggal_diubah date, 
 PRIMARY KEY (kode_url),
 FOREIGN KEY (direktori) REFERENCES pengguna ON DELETE cascade) ");

if ($result=="") {
  echo "Pembuatan tabel gagal<p>\n";
	echo mysql_error();
	}

else { echo "Pembuatan tabel sukses!";}
?>
