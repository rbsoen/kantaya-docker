<?php

function setup_table_proyek() {
    global $database, $link;
    mysql_select_db($database, $link);

    echo "<ul>\n";

    echo "create table kd_jns_proyek<br>\n";
    $sqltext = "create table kd_jns_proyek (
                       kode			      varchar(10)     not null,
                       nama			      varchar(60)     not null,
                       singkatan		  varchar(10),
                       dibuat_oleh 	      integer,
                       tgl_dibuat         datetime,
                       diubah_oleh        integer,
                       tgl_diubah         datetime,
                       primary key (kode))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table kd_jbtn_proyek<br>\n";
    $sqltext = "create table kd_jbtn_proyek (
                       kode               varchar(10) 	  not null,
                       nama               varchar(60)	  not null,
                       singkatan          varchar(10),
                       dibuat_oleh 	      integer,
                       tgl_dibuat  	      datetime,
                       diubah_oleh 	      integer,
                       tgl_diubah  	      datetime,
                       primary key (kode))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table proyek<br>\n";
    $sqltext = "create table proyek (
                       kode_proyek        integer         not null auto_increment,
                       no_proyek          varchar(30)     not null unique,
                       nama_proyek        varchar(100)    not null,
                       jenis_proyek       varchar(10)     not null,
                       singkatan          varchar(10)     not null,
                       nama_grup          integer         not null,
                       koordinator        integer         not null,
                       unit_pengelola     varchar(10)     not null,
                       jenis_sharing      varchar(1)      not null,
                       grup_sharing       varchar(11)     not null,
                       kode_grup          integer,
                       tahun_anggaran     varchar(4)      not null,
                       status             varchar(1)      not null,
                       tgl_mulai          date            not null,
                       tgl_selesai        date            not null,
                       lokasi             varchar(60),
                       kata_kunci         varchar(60),
                       tujuan             varchar(250),
                       sasaran            varchar(250),
                       dibuat_oleh        integer,
                       tgl_dibuat         datetime,
                       diubah_oleh        integer,
                       tgl_diubah         datetime,
                       primary key (kode_proyek),
                       index proyek_idx (unit_pengelola, tahun_anggaran))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table personil_proyek<br>\n";
    $sqltext = "create table personil_proyek (
                       kode_proyek         integer         not null,
                       kode_pengguna       integer         not null,
                       jabatan             varchar(10),
                       kualifikasi         varchar(30),
                       dibuat_oleh 	       integer,
                       tgl_dibuat  	       datetime,
                       diubah_oleh 	       integer,
                       tgl_diubah  	       datetime,
                       primary key (kode_proyek, kode_pengguna))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table jadwal_proyek<br>\n";
    $sqltext = "create table jadwal_proyek (
                       kode_proyek         integer         not null,
                       no_kegiatan         varchar(10)     not null,
                       nama_kegiatan       varchar(60)     not null,
                       jenis_kegiatan      varchar(3)      not null,
                       bobot               integer(3)      not null,
                       rcn_tgl_mulai       date            not null,
                       rcn_tgl_selesai     date            not null,
                       akt_tgl_mulai       date,
                       akt_tgl_selesai     date,
                       Status              integer(3),
                       induk_kegiatan      varchar(10),
                       subkont_mitra       integer,
                       keterangan          varchar(250),
                       dibuat_oleh         integer,
                       tgl_dibuat          datetime,
                       diubah_oleh         integer,
                       tgl_diubah          datetime,
                       primary key (kode_proyek, no_kegiatan))";

    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table penugasan_personil<br>\n";
    $sqltext = "create table penugasan_personil (
                       kode_proyek         integer         not null,
                       no_kegiatan         varchar(10)     not null,
                       kode_pengguna       integer         not null,
                       job                 varchar(60),
                       orang_jam           integer(4)      not null,
                       dibuat_oleh         integer,
                       tgl_dibuat          datetime,
                       diubah_oleh         integer,
                       tgl_diubah          datetime,
                       primary key (kode_proyek, no_kegiatan, kode_pengguna))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table kd_jns_lembaga<br>\n";
    $sqltext = "create table kd_jns_lembaga (
                       kode               varchar(10) 	  not null,
                       nama               varchar(60)	  not null,
                       singkatan          varchar(10),
                       dibuat_oleh 	      integer,
                       tgl_dibuat  	      datetime,
                       diubah_oleh 	      integer,
                       tgl_diubah  	      datetime,
                       primary key (kode))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table kd_jns_kjsama<br>\n";
    $sqltext = "create table kd_jns_kjsama (
                       kode               varchar(10) 	  not null,
                       nama               varchar(60)	  not null,
                       singkatan          varchar(10),
                       dibuat_oleh 	      integer,
                       tgl_dibuat  	      datetime,
                       diubah_oleh 	      integer,
                       tgl_diubah  	      datetime,
                       primary key (kode))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table mitra_proyek<br>\n";
    $sqltext = "create table mitra_proyek (
                       kode_mitra         integer		  not null 	auto_increment,
                       kode_proyek        integer		  not null,
                       nama_mitra         varchar(30)	  not null,
                       no_kerjasama       varchar(30),
                       jenis_kerjasama    varchar(10)	  not null,
                       jenis_lembaga      varchar(10)	  not null,
                       kontak_person      varchar(60)	  not null,
                       email              varchar(30),
                       web_kantor         varchar(60),
                       telp_kantor        varchar(30)	  not null,
                       telp_hp            varchar(30),
                       fax                varchar(30),
                       alamat             varchar(100),
                       kota               varchar(30),
                       propinsi           varchar(30),
                       negara             varchar(30),
                       dibuat_oleh        integer,
                       tgl_dibuat         datetime,
                       diubah_oleh        integer,
                       tgl_diubah         datetime,
                       primary key (kode_mitra))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table lap_kmjn_proyek <br>\n";
    $sqltext = "create table lap_kmjn_proyek  (
                       kode_proyek        integer         not null,
                       no_termin          integer(3)      not null,
                       no_urut            integer(2)      not null,
                       hasil              varchar(250),
                       masalah            varchar(250),
                       pemecahan          varchar(250),
                       dibuat_oleh        integer,
                       tgl_dibuat         datetime,
                       diubah_oleh        integer,
                       tgl_diubah         datetime,
                       primary key (kode_proyek,no_termin,no_urut))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table timesheet_proyek <br>\n";
    $sqltext = "create table timesheet_proyek  (
                       kode_proyek        INT(10)         NOT NULL,
                       no_kegiatan        VARCHAR(10)     NOT NULL,
                       tgl_kegiatan       DATE            NOT NULL,
                       kode_personil      INT(10)         NOT NULL,
                       total_jam          INT(10)         NOT NULL,
                       tgl_dibuat         DATETIME,
                       tgl_diubah         DATETIME,
                       dibuat_oleh        INT(10),
                       diubah_oleh        INT(10),
                       PRIMARY KEY (kode_proyek,no_kegiatan,tgl_kegiatan,kode_personil),
                       FOREIGN KEY (kode_proyek) REFERENCES proyek,
                       FOREIGN KEY (kode_personil) REFERENCES pengguna,
                       FOREIGN KEY (no_kegiatan) REFERENCES jadwal_proyek,
                       FOREIGN KEY (dibuat_oleh) REFERENCES pengguna,
                       FOREIGN KEY (diubah_oleh) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "</ul>\n";

}

?>







