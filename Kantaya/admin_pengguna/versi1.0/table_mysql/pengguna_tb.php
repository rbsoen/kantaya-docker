<?php
mysql_connect ("localhost","root");
mysql_select_db ("kantaya");
$result=mysql_query ("CREATE TABLE pengguna (kode_pengguna int(10) NOT
NULL DEFAULT '0' AUTO_INCREMENT, nip varchar(25), nama_pengguna
varchar(100) NOT NULL, level char(1) NOT NULL, username varchar(15) NOT
NULL, password varchar(15) NOT NULL, email varchar(100), unit_kerja
varchar(10), telp_k varchar(15), telp_r varchar(15), hp varchar(15), fax
varchar(15), alamat_k_jalan varchar(100), kota varchar(100), kode_pos
char(5), propinsi varchar(100), negara varchar(100), tanggal_dibuat date
NOT NULL, tanggal_diubah date, dibuat_oleh int(10), diubah_oleh int(10),
keterangan varchar(255), PRIMARY KEY (kode_pengguna), FOREIGN KEY
(dibuat_oleh) REFERENCES pengguna, FOREIGN KEY (diubah_oleh) REFERENCES
pengguna, FOREIGN KEY (unit_kerja) REFERENCES unit_kerja)");

if ($result=="") {
  die ("Pembuatan tabel gagal");}

else { echo "Pembuatan tabel sukses!";}
?>
