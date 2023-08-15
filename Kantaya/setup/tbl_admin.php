<?php

function setup_table_admin() {
    global $database, $link;
    mysql_select_db($database, $link);
    
    echo "<ul>\n";

    echo "create table profile_perusahaan<br>\n";
    $sqltext = "create table profile_perusahaan (
                       nama_perusahaan    varchar(100)    NOT NULL,
                       alamat             varchar(250)    NOT NULL,
                       telp               varchar(30)     NOT NULL,
                       fax                varchar(30)     NOT NULL,
                       email              varchar(30)     NOT NULL,
                       url                varchar(60)     NOT NULL,
                       logo               varchar(30)     NOT NULL,
                       tanggal_dibuat     date            NOT NULL,
                       tanggal_diubah     date,
                       dibuat_oleh        int(10),
                       diubah_oleh        int(10))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());
                       
    echo "create table pengguna<br>\n";
    $sqltext = "create table pengguna (
                       kode_pengguna    int(10)         NOT NULL DEFAULT '0' AUTO_INCREMENT,
                       nip              varchar(25),
                       nama_pengguna    varchar(100)    NOT NULL,
                       level            char(1)         NOT NULL,
                       username         varchar(15)     NOT NULL,
                       password         varchar(15)     NOT NULL,
                       email            varchar(100),
                       unit_kerja       varchar(10),
                       telp_k           varchar(15),
                       telp_r           varchar(15),
                       hp               varchar(15),
                       fax              varchar(15),
                       alamat_k_jalan   varchar(100),
                       kota             varchar(100),
                       kode_pos         char(5),
                       propinsi         varchar(100),
                       negara           varchar(100),
                       tanggal_dibuat   date NOT NULL,
                       tampilan_css     varchar(30),
                       tanggal_diubah   date,
                       dibuat_oleh      int(10),
                       diubah_oleh      int(10),
                       keterangan       varchar(120),
                       PRIMARY KEY (kode_pengguna),
                       FOREIGN KEY (dibuat_oleh) REFERENCES pengguna,
                       FOREIGN KEY (diubah_oleh) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table unit_kerja<br>\n";
    $sqltext = "create table unit_kerja (
                       kode_unit        varchar(10)     NOT NULL,
                       nama_unit        varchar(100)    NOT NULL,
                       singkatan_unit   varchar(10),
                       induk_unit       varchar(10),
                       tanggal_dibuat   date            NOT NULL,
                       tanggal_diubah   date,
                       dibuat_oleh      int(10),
                       diubah_oleh      int(10),
                       keterangan       varchar(120),
                       PRIMARY KEY (kode_unit),
                       FOREIGN KEY (dibuat_oleh) REFERENCES pengguna,
                       FOREIGN KEY (diubah_oleh) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table grup<br>\n";
    $sqltext = "create table grup (
                       kode_grup        int(10)         NOT NULL DEFAULT '0' AUTO_INCREMENT,
                       nama_grup        varchar(50)     NOT NULL,
                       sifat_grup       varchar(9)      NOT NULL,
                       pimpinan_grup    int(10),
                       tanggal_dibuat   date            NOT NULL,
                       tanggal_diubah   date,
                       dibuat_oleh      int(10),
                       diubah_oleh      int(10),
                       keterangan       varchar(120),
                       status           char(1),
                       PRIMARY KEY (kode_grup),
                       FOREIGN KEY (pimpinan_grup) REFERENCES pengguna,
                       FOREIGN KEY (dibuat_oleh) REFERENCES pengguna,
                       FOREIGN KEY (diubah_oleh) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table grup_pengguna<br>\n";
    $sqltext = "create table grup_pengguna (
                       kode_pengguna    int(10)         NOT NULL,
                       kode_grup        int(10)         NOT NULL,
                       tanggal_dibuat   date            NOT NULL,
                       dibuat_oleh      int(10),
                       PRIMARY KEY (kode_pengguna, kode_grup),
                       FOREIGN KEY (kode_pengguna) REFERENCES pengguna,
                       FOREIGN KEY (kode_grup) REFERENCES grup,
                       FOREIGN KEY (dibuat_oleh) REFERENCES pengguna,
                       FOREIGN KEY (diubah_oleh) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "</ul>\n";

}

?>

