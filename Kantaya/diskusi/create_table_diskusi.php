<?php
/***********************************************************************
Nama File : create_table_diskusi.php
Fungsi    : Pembuatan table modul Diskusi
Dibuat    :
Tgl.      : 07-11-2001
Oleh      : FB

Revisi 1  :
Tgl.      :
Oleh      :
Revisi    :
***********************************************************************/
include('../lib/fs_umum.php');
require("../lib/kantaya_cfg.php");
$css = "../lib/kantaya.css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

echo "<html><body>\n";
echo "Create Table Modul Diskusi";

// ------------------ Table kamar_diskusi --------
$hasil = mysql_query("drop table kamar_diskusi", $db);
$hasil = mysql_query("create table kamar_diskusi (
			kode_kamar 	    integer		  not null 	  auto_increment,
			nama_kamar		varchar(60)	  not null,
            ktgr_ruang      varchar(1)    not null,
            nama_ruang      varchar(11),
			jenis_kamar	    varchar(1)    not null,
            sifat           varchar(1)    not null,
            tuan_rumah      varchar(30)   not null,
            undangan        varchar(100),
            kata_sambutan   varchar(250),
            dibuat_oleh 	integer,
            tgl_dibuat  	datetime,
            diubah_oleh 	integer,
            tgl_diubah  	datetime,
			primary key (kode_kamar),
            unique (nama_kamar,ktgr_ruang,nama_ruang)
			)", $db);

check_mysql_error(mysql_errno(),mysql_error());

// ------------------ Table pengunjung_kamar --------
$hasil = mysql_query("drop table pengunjung_kamar", $db);
$hasil = mysql_query("create table pengunjung_kamar (
			kode_kamar 	    integer		not null,
            kode_pengunjung integer		not null,
            tgl_login  	    datetime,
            tgl_respon_akhir datetime,
			primary key (kode_kamar, kode_pengunjung)
			)", $db);

check_mysql_error(mysql_errno(),mysql_error());

echo"<br><br>Create Table selesai";
echo "</body></html>\n";
?>


