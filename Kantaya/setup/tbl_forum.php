<?php

function setup_table_forum() {
    global $database, $link;
    mysql_select_db($database, $link);

    echo "<ul>\n";

    echo "create table forum<br>\n";
    $sqltext = "create table forum (
                       kode_forum         INTEGER		NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       nama_forum         VARCHAR(100)	NOT NULL,
                       jenis_group        VARCHAR(1)	NOT NULL,
                       kode_group         INTEGER		NOT NULL,
                       moderator          INTEGER		NOT NULL,
                       dibuat_oleh        INTEGER,
                       dibuat_tgl         DATETIME,
                       diubah_oleh        INTEGER,
                       diubah_tgl         DATETIME)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table topik<br>\n";
    $sqltext = "create table topik (
                       kode_topik	      INTEGER		NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       kode_forum         INTEGER		NOT NULL,
                       judul		      VARCHAR(100)	NOT NULL,
                       isi_topik          VARCHAR(250),
                       respon_thd         INTEGER,
                       struktur	          VARCHAR(30)  NOT NULL,
                       dibuat_oleh        INTEGER,
                       dibuat_tgl         DATETIME,
                       diubah_oleh        INTEGER,
                       diubah_tgl         DATETIME)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "</ul>\n";

}

?>

   
   

