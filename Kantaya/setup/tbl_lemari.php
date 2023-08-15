<?php

function setup_table_lemari() {
    global $database, $link;
    mysql_select_db($database, $link);

    echo "<ul>\n";

    echo "create table direktori<br>\n";
    $sqltext = "create table direktori (
                       kode_direktori     int(10)         NOT NULL AUTO_INCREMENT,
                       nama_direktori     varchar(30)     NOT NULL,
                       direktori_induk    int(10),
                       keterangan         varchar(120),
                       sharing_publik     char(1)         NOT NULL,
                       tanggal_dibuat     date            NOT NULL,
                       tanggal_diubah     date,
                       dibuat_oleh        int(10)         NOT NULL,
                       pemilik        int(10)         NOT NULL,
                       diubah_oleh        int(10),
                       PRIMARY KEY (kode_direktori),
                       FOREIGN KEY (direktori_induk) REFERENCES direktori(kode_direktori) ON DELETE cascade,
                       FOREIGN KEY (pemilik) REFERENCES pengguna(kode_pengguna) ON DELETE cascade)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table file_tb<br>\n";
    $sqltext = "create table file_tb (
                       kode_file          int(10)         NOT NULL AUTO_INCREMENT,
                       nama_file          varchar(30)     NOT NULL,
                       ukuran_file        int(10)         NOT NULL,
                       kata_kunci         varchar(60),
                       ctt_perbaikan      varchar(120),
                       keterangan         varchar(120),
                       direktori          int(10)         NOT NULL,
                       tanggal_dibuat     date            NOT NULL,
                       tanggal_diubah     date,
                       dibuat_oleh        int(10)         NOT NULL,
                       diubah_oleh        int(10),
                       PRIMARY KEY (kode_file),
                       FOREIGN KEY (direktori) REFERENCES direktori(kode_direktori) ON DELETE cascade)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table sharing_dir_pengguna<br>\n";
    $sqltext = "create table sharing_dir_pengguna (
                       kode_direktori     int(10)         NOT NULL,
                       kode_pengguna      int(10)         NOT NULL,
                       PRIMARY KEY (kode_direktori, kode_pengguna),
                       FOREIGN KEY (kode_direktori) REFERENCES direktori(kode_direktori) ON DELETE cascade,
                       FOREIGN KEY (kode_pengguna) REFERENCES pengguna(kode_pengguna) ON DELETE cascade)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table sharing_dir_grup<br>\n";
    $sqltext = "create table sharing_dir_grup (
                       kode_direktori     int(10)         NOT NULL,
                       kode_grup          int(10)         NOT NULL,
                       PRIMARY KEY (kode_direktori, kode_grup),
                       FOREIGN KEY (kode_direktori) REFERENCES direktori(kode_direktori) ON DELETE cascade,
                       FOREIGN KEY (kode_grup) REFERENCES grup(kode_grup) ON DELETE cascade)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table sharing_dir_unit<br>\n";
    $sqltext = "create table sharing_dir_unit (
                       kode_direktori     int(10)         NOT NULL,
                       kode_unit          int(10)         NOT NULL,
                       PRIMARY KEY (kode_direktori, kode_unit),
                       FOREIGN KEY (kode_direktori) REFERENCES direktori(kode_direktori) ON DELETE cascade,
                       FOREIGN KEY (kode_unit) REFERENCES  unit_kerja(kode_unit) ON DELETE cascade)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "</ul>\n";

}

?>

