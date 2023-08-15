<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE grup (kode_grup int(10) NOT NULL
DEFAULT '0' AUTO_INCREMENT, nama_grup varchar(50) NOT NULL, sifat_grup varchar(9) NOT NULL, pimpinan_grup
int(10), tanggal_dibuat date NOT NULL, tanggal_diubah date, dibuat_oleh
int(10), diubah_oleh int(10), keterangan varchar(255), status char(1), PRIMARY KEY
(kode_grup), FOREIGN KEY (pimpinan_grup) REFERENCES pengguna, FOREIGN KEY
(dibuat_oleh) REFERENCES pengguna, FOREIGN KEY (diubah_oleh) REFERENCES
pengguna)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
