<?php

function setup_table_dimana() {
    global $database, $link;
    mysql_select_db($database, $link);

    echo "<ul>\n";

    echo "create table dimana<br>\n";
    $sqltext = "create table dimana (
                       kode_pengguna      INT(10)         NOT NULL,
                       keberadaan         CHAR(1)         NOT NULL,
                       keterangan         VARCHAR(250),
                       tanggal_dibuat     DATETIME,
                       tanggal_diubah     DATETIME,
                       dibuat_oleh	      INT(10),
                       diubah_oleh        INT(10),
                       PRIMARY KEY	(kode_pengguna),
                       FOREIGN KEY	(dibuat_oleh)	REFERENCES pengguna,
                       FOREIGN KEY	(diubah_oleh)	REFERENCES pengguna)";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "</ul>\n";

}

?>

