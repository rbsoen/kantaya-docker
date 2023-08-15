<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE agenda (kode_agenda int(10) NOT NULL
AUTO_INCREMENT DEFAULT '0', pemilik int(10) NOT NULL, judul
varchar(80) NOT NULL, tipe varchar(15) NOT NULL, tgl_mulai date NOT
NULL,
waktu_mulai time NOT NULL, waktu_selesai time NOT NULL,
tgl_selesai date NOT NULL, deskripsi
varchar(120),
tgl_dibuat date NOT NULL, tgl_diubah date, sharing_publik char(1) NOT
NULL, sifat_sharing char(1), PRIMARY KEY (kode_agenda), FOREIGN KEY
(pemilik) REFERENCES pengguna)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
