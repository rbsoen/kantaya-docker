<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE grup_pengguna (kode_pengguna
int(10) NOT
NULL, kode_grup int(10) NOT NULL, tanggal_dibuat date
NOT NULL, dibuat_oleh int(10), PRIMARY KEY (kode_pengguna, kode_grup),
FOREIGN KEY (kode_pengguna) REFERENCES pengguna, FOREIGN KEY
(kode_grup) REFERENCES grup, FOREIGN KEY
(dibuat_oleh) REFERENCES pengguna, FOREIGN KEY (diubah_oleh) REFERENCES
pengguna)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
