<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");

$sql=mysql_query ("CREATE TABLE file_tb 
  (kode_file int(10) NOT NULL DEFAULT '0' AUTO_INCREMENT, 
	nama_file varchar(30) NOT NULL, 
	ukuran_file int(10) NOT NULL,
	kata_kunci varchar(60),
	ctt_perbaikan varchar(120), 
	keterangan varchar(120), 
	direktori int(10) NOT NULL,
	tanggal_dibuat date NOT NULL, 
	tanggal_diubah date,
	dibuat_oleh int(10) NOT NULL,
	diubah_oleh int(10),
    PRIMARY KEY (kode_file),
		FOREIGN KEY (direktori) REFERENCES direktori ON DELETE cascade)"); 

if (!$sql) {
  die ("Pembuatan tabel gagal !");
	echo mysql_error();
	}

else { 
  echo "Pembuatan tabel sukses!";
	}
?>
