<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");

$sql=mysql_query ("CREATE TABLE sharing_dir_grup 
  (kode_direktori int(10) NOT NULL, 
	kode_grup int(10) NOT NULL, 
    PRIMARY KEY (kode_direktori, kode_grup),
		FOREIGN KEY (kode_direktori) REFERENCES direktori ON DELETE cascade,
		FOREIGN KEY (kode_grup) REFERENCES grup ON DELETE cascade)"); 

if (!$sql) {
  die ("Pembuatan tabel gagal !");
	echo mysql_error();
	}

else { 
  echo "Pembuatan tabel sukses!";
	}
?>
