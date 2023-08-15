
<?php 

echo"Create Table Modul Mitra Proyek";

$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 

// ------------------ Table Kode Jenis Lembaga --------
$hasil = mysql_query("drop table kd_jns_lembaga", $db);
$hasil = mysql_query("create table kd_jns_lembaga (
	kode			varchar(10) 	not null,
	nama			varchar(60)	not null,
	singkatan		varchar(10),
	dibuat_oleh 		integer,
	tgl_dibuat  		datetime,
	diubah_oleh 		integer,
	tgl_diubah  		datetime,
	primary key (kode)
	)", $db);

if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
	exit -1;
}

// ------------------ Table Kode Jenis Kerjasama --------
$hasil = mysql_query("drop table kd_jns_kjsama", $db);
$hasil = mysql_query("create table kd_jns_kjsama (
	kode			varchar(10) 	not null,
	nama			varchar(60)	not null,
	singkatan		varchar(10),
	dibuat_oleh 		integer,
	tgl_dibuat  		datetime,
	diubah_oleh 		integer,
	tgl_diubah  		datetime,
	primary key (kode)
	)", $db);

if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
	exit -1;
}

// ------------------ Table Mitra Proyek --------
$hasil = mysql_query("drop table mitra_proyek", $db);
$hasil = mysql_query("create table mitra_proyek (
	kode_mitra		integer		not null 	auto_increment,
	kode_proyek 		integer		not null,
	nama_mitra		varchar(30)	not null,
	no_kerjasama		varchar(30),
	jenis_kerjasama		varchar(10)	not null,
	jenis_lembaga		varchar(10)	not null,
	kontak_person		varchar(60)	not null,
	email			varchar(30),
	web_kantor		varchar(60),
	telp_kantor		varchar(30)	not null,
	telp_hp			varchar(30),
	fax			varchar(30),
	alamat			varchar(100),
	kota			varchar(30),
	propinsi		varchar(30),
	negara			varchar(30),
	dibuat_oleh 		integer,
	tgl_dibuat  		datetime,
	diubah_oleh 		integer,
	tgl_diubah  		datetime,
	primary key (kode_mitra)
	)", $db);

if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
	exit -1;
}

// ------------------ Table Laporan Kemajuan Proyek --------
$hasil = mysql_query("drop table lap_kmjn_proyek", $db);
$hasil = mysql_query("create table lap_kmjn_proyek (
	kode_proyek 		integer		not null,
	no_termin		integer(3)	not null,
	no_urut			integer(2)	not null,
	hasil			varchar(250),
	masalah			varchar(250),
	pemecahan		varchar(250),
	dibuat_oleh 		integer,
	tgl_dibuat  		datetime,
	diubah_oleh 		integer,
	tgl_diubah  		datetime,
	primary key (kode_proyek,no_termin,no_urut)
	)", $db);

if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
	exit -1;
}


echo"<br><br>Create Table selesai";

?> 

</body></html> 
