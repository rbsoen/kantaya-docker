<html><body> 

<?php 

echo"Create Table Modul Proyek";

$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 


// ------------------ Table Kode Jenis Proyek --------
$hasil = mysql_query("drop table kd_jns_proyek", $db);
$hasil = mysql_query("create table kd_jns_proyek (
			kode			varchar(10) 	not null,
			nama			varchar(60)	not null,
			singkatan		varchar(10),
            dibuat_oleh 	integer,
            tgl_dibuat  	datetime,
            diubah_oleh 	integer,
            tgl_diubah  	datetime,
			primary key (kode)
			)", $db);

	echo mysql_errno().": ".mysql_error()."<br>";
if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
//	echo "$sqltext\n";
	exit -1;
}

// ------------------ Table Kode Jabatan Proyek --------
$hasil = mysql_query("drop table kd_jbtn_proyek", $db);
$hasil = mysql_query("create table kd_jbtn_proyek (
			kode			varchar(10) 	not null,
			nama			varchar(60)	not null,
			singkatan		varchar(10),
            dibuat_oleh 	integer,
            tgl_dibuat  	datetime,
            diubah_oleh 	integer,
            tgl_diubah  	datetime,
			primary key (kode)
			)", $db);

	echo mysql_errno().": ".mysql_error()."<br>";
if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
//	echo "$sqltext\n";
	exit -1;
}

// ----------------- Table forum ----------------------------
$hasil = mysql_query("drop table proyek", $db);
$hasil = mysql_query("create table proyek (
			kode_proyek 		integer		not null 	auto_increment,
			no_proyek 		varchar(30)	not null 	unique,
			nama_proyek 		varchar(100)	not null,
			jenis_proyek 		varchar(10)	not null,
			singkatan		varchar(10),
			koordinator 		integer		not null,
			unit_pengelola 		varchar(10)	not null,
            jenis_sharing           varchar(1)    not null,
            grup_sharing            varchar(11)   not null,
            kode_grup               integer,
			tahun_anggaran		varchar(4)	not null,
			status			varchar(1)	not null,
			tgl_mulai 		date		not null,
			tgl_selesai 		date		not null,
			lokasi			varchar(60),
			kata_kunci		varchar(60),
			tujuan   		varchar(250),
            		sasaran   		varchar(250),
            		dibuat_oleh 		integer,
            		tgl_dibuat  		datetime,
            		diubah_oleh 		integer,
            		tgl_diubah  		datetime,
            		primary key (kode_proyek),
			index proyek_idx (unit_pengelola, tahun_anggaran)
			)", $db);
	echo mysql_errno().": ".mysql_error()."<br>";

if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
//	echo "$sqltext\n";
	exit -1;
}

// ------------------ Table Personil Proyek --------
$hasil = mysql_query("drop table personil_proyek", $db);
$hasil = mysql_query("create table personil_proyek (
			kode_proyek 		integer		not null,
			kode_pengguna		integer		not null,
			jabatan			varchar(10),
            kualifikasi     varchar(30),
            dibuat_oleh 	integer,
            tgl_dibuat  	datetime,
            diubah_oleh 	integer,
            tgl_diubah  	datetime,
			primary key (kode_proyek, kode_pengguna)
			)", $db);

	echo mysql_errno().": ".mysql_error()."<br>";
if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
//	echo "$sqltext\n";
	exit -1;
}


// ------------------ Table Jadwal Proyek --------
$hasil = mysql_query("drop table jadwal_proyek", $db);
$hasil = mysql_query("create table jadwal_proyek (
	kode_proyek 		integer		not null,
	no_kegiatan		varchar(10)	not null,
	nama_kegiatan		varchar(60)	not null,
	jenis_kegiatan		varchar(3)	not null,
	bobot			integer(3)	not null,
	rcn_tgl_mulai	     	date 		not null,
	rcn_tgl_selesai	     	date 		not null,
	akt_tgl_mulai	     	date,
	akt_tgl_selesai	     	date,
	Status			integer(3),
	induk_kegiatan		varchar(10),
	subkont_mitra		integer,
	keterangan		varchar(250),
	dibuat_oleh 		integer,
	tgl_dibuat  		datetime,
	diubah_oleh 		integer,
	tgl_diubah  		datetime,
	primary key (kode_proyek, no_kegiatan)
	)", $db);

if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
//	echo "$sqltext\n";
	exit -1;
}

// ------------------ Table Jadwal Proyek --------
$hasil = mysql_query("drop table penugasan_personil", $db);
$hasil = mysql_query("create table penugasan_personil (
	kode_proyek 		integer		not null,
	no_kegiatan		varchar(10)	not null,
	kode_pengguna		integer		not null,
	job			varchar(60),
	orang_jam		integer(4)	not null,
	dibuat_oleh 		integer,
	tgl_dibuat  		datetime,
	diubah_oleh 		integer,
	tgl_diubah  		datetime,
	primary key (kode_proyek, no_kegiatan,kode_pengguna)
	)", $db);

if (mysql_errno() <> 0) {
	echo "<h1> Error </h1><br>\n";
	echo mysql_errno().": ".mysql_error()."<br>";
//	echo "$sqltext\n";
	exit -1;
}


echo"<br><br>Create Table selesai";

?> 

</body></html> 
