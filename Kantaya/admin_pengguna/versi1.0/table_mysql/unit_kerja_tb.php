<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE unit_kerja (kode_unit
varchar(10) NOT NULL, nama_unit varchar(100) NOT NULL,
singkatan_unit varchar(10), induk_unit varchar(10), tanggal_dibuat date
NOT NULL, tanggal_diubah date, dibuat_oleh int(10), diubah_oleh int(10),
keterangan varchar(255), PRIMARY KEY (kode_unit), FOREIGN KEY
(dibuat_oleh)
REFERENCES pengguna, FOREIGN KEY (diubah_oleh) REFERENCES pengguna)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
