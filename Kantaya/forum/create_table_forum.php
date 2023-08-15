<html><body> 

<?php 

echo"Create Table Modul Forum";

$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 


// ----------------- Table forum ----------------------------
$hasil = mysql_query("CREATE TABLE forum (
			kode_forum	INTEGER		NOT NULL AUTO_INCREMENT PRIMARY KEY,
			nama_forum	VARCHAR(100)	NOT NULL,
			jenis_group	VARCHAR(1)		NOT NULL,
			kode_group	INTEGER		NOT NULL,
			moderator 	INTEGER		NOT NULL,
			dibuat_oleh	INTEGER,
			dibuat_tgl	DATETIME,
			diubah_oleh	INTEGER,
			diubah_tgl  DATETIME
			)
			", $db);
// -------------------------------------------------------------


// ------------------ Table Topik --------
$hasil = mysql_query("CREATE TABLE topik (
			kode_topik	INTEGER		NOT NULL AUTO_INCREMENT PRIMARY KEY,
			kode_forum	INTEGER		NOT NULL,
			judul		VARCHAR(100)	NOT NULL,
			isi_topik	VARCHAR(250),
			respon_thd	INTEGER,
			struktur	VARCHAR(30)		NOT NULL,
			dibuat_oleh	INTEGER,
			dibuat_tgl	DATETIME,
			diubah_oleh	INTEGER,
			diubah_tgl  DATETIME
			)
			", $db);
// -------------------------------------------------------------


/*
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0000000000', 'BPPT', '', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0100000000', 'TIEML', '0000000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0101000000', 'TIE', '0100000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0101010000', 'Bag. Sistem Informasi', '0101000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0101020000', 'Bag. Otomasi Industri', '0101000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0101030000', 'Bag. Telekomunikasi', '0101000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0101040000', 'Bag. Jaringan dan Multimedia', '0101000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0102000000', 'Lingkungan', '0100000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0600000000', 'Sekretaris Utama', '0000000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0601000000', 'Biro Perencanaan', '0600000000', now());
insert into unit_kerja(kode_unit, nama_unit, induk_unit, tanggal_dibuat) values('0601010000', 'Bag. Program', '0601000000', now());


insert into grup(nama_grup, sifat_grup, tanggal_dibuat) values('Grup ERP', 'x', now());
insert into grup(nama_grup, sifat_grup, tanggal_dibuat) values('Grup Bulutangkis TIE', 'x', now());
insert into grup(nama_grup, sifat_grup, tanggal_dibuat) values('Grup Science Fiction', 'x', now());


insert into pengguna(nama_pengguna, username, password, unit_kerja, email, tanggal_dibuat)
	values( 'Faisol', 'Fai', 'fai', '0101010000', 'faisol@bppt.go.id', now());
insert into pengguna(nama_pengguna, username, password, unit_kerja, email, tanggal_dibuat)
	values( 'Andre', 'Andre', 'andre', '0101010000', 'andre@bppt.go.id', now());
insert into pengguna(nama_pengguna, username, password, unit_kerja, email, tanggal_dibuat)
	values( 'Agoeng', 'Agoeng', 'agoeng', '0101010000', 'agoeng@bppt.go.id', now());
insert into pengguna(nama_pengguna, username, password, unit_kerja, email, tanggal_dibuat)
	values( 'Kelik', 'Kelik', 'kelik', '0101030000', 'kelik@inn.bppt.go.id', now());
insert into pengguna(nama_pengguna, username, password, unit_kerja, email, tanggal_dibuat)
	values( 'Purwoadi', 'purwoadi', 'pwd', '0101020000', 'purwadi@inn.bppt.go.id', now());
insert into pengguna(nama_pengguna, username, password, unit_kerja, email, tanggal_dibuat)
	values( 'Sulistyo', 'Sulis', 'sulis', '0101000000', 'agoeng@bppt.go.id', now());
insert into pengguna(nama_pengguna, username, password, unit_kerja, email, tanggal_dibuat)
	values( 'xxxxx', 'xxx', 'xxx', '0601000000', 'agoeng@bppt.go.id', now());


insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(1,1,now());
insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(1,3,now());
insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(6,1,now());
insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(2,5,now());
insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(2,6,now());
insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(2,4,now());
insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(2,1,now());
insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(3,2,now());
insert into grup_pengguna(kode_grup, kode_pengguna, tanggal_dibuat)
	values(3,1,now());
*/



echo"<br><br>Create Table selesai";

?> 

</body></html> 
