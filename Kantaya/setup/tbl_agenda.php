<?php

function setup_table_agenda() {
    global $database, $link;
    mysql_select_db($database, $link);

    echo "<ul>\n";

    echo "create table agenda<br>\n";
    $sqltext = "create table agenda (
                       kode_agenda        int(10)         NOT NULL AUTO_INCREMENT DEFAULT '0',
                       pemilik            int(10)         NOT NULL,
                       judul              varchar(80)     NOT NULL,
                       tipe               varchar(15)     NOT NULL,
                       tgl_mulai          date            NOT NULL,
                       waktu_mulai        time            NOT NULL,
                       waktu_selesai      time            NOT NULL,
                       tgl_selesai        date            NOT NULL,
                       deskripsi          varchar(120),
                       tgl_dibuat         date            NOT NULL,
                       tgl_diubah         date,
                       sharing_publik     char(1)         NOT NULL,
                       sifat_sharing      char(1),
                       PRIMARY KEY (kode_agenda),
                       FOREIGN KEY (pemilik) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table pengulangan_agenda<br>\n";
    $sqltext = "create table pengulangan_agenda (
                       kode_agenda        int(10)         NOT NULL,
                       fase_ulang         varchar(10)     NOT NULL,
                       diulang_setiap     varchar(10),
                       sd_tgl             date,
                       tgl_dibuat         date            NOT NULL,
                       PRIMARY KEY (kode_agenda))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table segera_dikerjakan<br>\n";
    $sqltext = "create table segera_dikerjakan (
                       kode_agenda        int(10)         NOT NULL,
                       kode_dikerjakan    int(10)         NOT NULL AUTO_INCREMENT,
                       pemilik            int(10)         NOT NULL,
                       judul              varchar(80)     NOT NULL,
                       status             varchar(16)     NOT NULL,
                       tgl_berakhir       date,
                       deskripsi          varchar(120),
                       tgl_dibuat         date            NOT NULL,
                       tgl_diubah         date,
                       PRIMARY KEY (kode_dikerjakan),
                       FOREIGN KEY (pemilik) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table sharing_agenda_grup<br>\n";
    $sqltext = "create table sharing_agenda_grup (
                       kode_agenda        int(10)         NOT NULL,
                       kode_grup          int(10)         NOT NULL,
                       tgl_dibuat         date            NOT NULL,
                       PRIMARY KEY (kode_agenda, kode_grup),
                       FOREIGN KEY (kode_agenda) REFERENCES agenda,
                       FOREIGN KEY (kode_grup) REFERENCES grup)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table sharing_agenda_pengguna<br>\n";
    $sqltext = "create table sharing_agenda_pengguna (
                       kode_agenda        int(10)         NOT NULL,
                       kode_pengguna      int(10)         NOT NULL,
                       tgl_dibuat         date            NOT NULL,
                       PRIMARY KEY (kode_agenda, kode_pengguna),
                       FOREIGN KEY (kode_agenda) REFERENCES agenda,
                       FOREIGN KEY (kode_pengguna) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table sharing_agenda_unit<br>\n";
    $sqltext = "create table sharing_agenda_unit (
                       kode_agenda        int(10)         NOT NULL,
                       kode_unit int(10) NOT NULL,
                       tgl_dibuat date NOT NULL,
                       PRIMARY KEY (kode_agenda, kode_unit),
                       FOREIGN KEY (kode_agenda) REFERENCES agenda,
                       FOREIGN KEY (kode_unit) REFERENCES unit_kerja)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table undangan_grup<br>\n";
    $sqltext = "create table undangan_grup (
                       kode_agenda        int(10)         NOT NULL,
                       kode_grup          int(10)         NOT NULL,
                       tgl_dibuat         date            NOT NULL,
                       PRIMARY KEY (kode_agenda, kode_grup),
                       FOREIGN KEY (kode_agenda) REFERENCES agenda,
                       FOREIGN KEY (kode_grup) REFERENCES grup)";

    echo "create table undangan_pengguna<br>\n";
    $sqltext = "create table undangan_pengguna (
                       kode_agenda        int(10)         NOT NULL,
                       kode_pengguna      int(10)         NOT NULL,
                       konfirmasi         char(1),
                       alasan             varchar(120),
                       tgl_dibuat         date            NOT NULL,
                       PRIMARY KEY (kode_agenda, kode_pengguna),
                       FOREIGN KEY (kode_agenda) REFERENCES agenda,
                       FOREIGN KEY (kode_pengguna) REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table undangan_unit<br>\n";
    $sqltext = "create table undangan_unit (
                       kode_agenda        int(10)         NOT NULL,
                       kode_unit          int(10)         NOT NULL,
                       tgl_dibuat         date            NOT NULL,
                       PRIMARY KEY (kode_agenda, kode_unit),
                       FOREIGN KEY (kode_agenda) REFERENCES agenda,
                       FOREIGN KEY (kode_unit) REFERENCES unit_kerja)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "</ul>\n";

}

?>

