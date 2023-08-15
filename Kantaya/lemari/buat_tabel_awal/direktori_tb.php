<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");

$result=mysql_query ("CREATE TABLE direktori 
  (kode_direktori int(10) NOT NULL DEFAULT '0' AUTO_INCREMENT, 
	nama_direktori varchar(30) NOT NULL, 
	direktori_induk int(10),
	keterangan varchar(120), 
	sharing_publik char(1) NOT NULL, 
	tanggal_dibuat date NOT NULL, 
	tanggal_diubah date,
	dibuat_oleh int(10) NOT NULL,
	diubah_oleh int(10),
    PRIMARY KEY (kode_direktori),
		FOREIGN KEY (direktori_induk) REFERENCES direktori ON DELETE cascade, 
	  FOREIGN KEY (pemilik) REFERENCES pengguna ON DELETE cascade)");

if (!$result) {
  die ("Pembuatan tabel gagal !");
	echo mysql_error();
	}

else { 
  echo "Pembuatan tabel sukses!";
	}
?>
