<?php

function setup_table_diskusi() {
    global $database, $link;
    mysql_select_db($database, $link);

    echo "<ul>\n";

    echo "create table kamar_diskusi<br>\n";
    $sqltext = "create table kamar_diskusi (
                       kode_kamar         integer       not null    auto_increment,
                       nama_kamar         varchar(60)   not null    unique,
                       ktgr_ruang         varchar(1)    not null,
                       nama_ruang         varchar(11),
                       jenis_kamar	      varchar(1)    not null,
                       sifat              varchar(1)    not null,
                       tuan_rumah         varchar(30)   not null,
                       undangan           varchar(100),
                       kata_sambutan      varchar(250),
                       dibuat_oleh 	      integer,
                       tgl_dibuat  	      datetime,
                       diubah_oleh 	      integer,
                       tgl_diubah  	      datetime,
                       primary key (kode_kamar))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table pengunjung_kamar<br>\n";
    $sqltext = "create table pengunjung_kamar (
                       kode_kamar         integer       not null,
                       kode_pengunjung    integer		not null,
                       tgl_login          datetime,
                       tgl_respon_akhir   datetime,
                       primary key (kode_kamar, kode_pengunjung))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "</ul>\n";

}

?>
