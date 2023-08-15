<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");

$sql=mysql_query ("CREATE TABLE sharing_dir_pengguna 
  (kode_direktori int(10) NOT NULL, 
	kode_pengguna int(10) NOT NULL, 
    PRIMARY KEY (kode_direktori, kode_pengguna),
		FOREIGN KEY (kode_direktori) REFERENCES direktori ON DELETE cascade,
		FOREIGN KEY (kode_pengguna) REFERENCES pengguna ON DELETE cascade)"); 

if (!$sql) {
  die ("Pembuatan tabel gagal !");
	echo mysql_error();
	}

else { 
  echo "Pembuatan tabel sukses!";
	}
?>
