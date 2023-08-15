<?php

function setup_table_fasilitas() {
    global $database, $link;
    mysql_select_db($database, $link);

    echo "<ul>\n";

    echo "create table fasilitas<br>\n";
    $sqltext = "create table fasilitas (
                       kode_pengguna      INT(10)         NOT NULL,
                       kode_fas           INT(10)         NOT NULL AUTO_INCREMENT,
                       nama_fas           VARCHAR(100)    NOT NULL,
                       unit               VARCHAR(10)     NOT NULL,
                       wewenang           VARCHAR(30)     NOT NULL,
                       lokasi             VARCHAR(20)     NOT NULL,
                       status             VARCHAR(1)      NOT NULL,
                       keterangan         VARCHAR(250),
                       tanggal_dibuat     DATETIME,
                       tanggal_diubah     DATETIME,
                       dibuat_oleh        INT(10),
                       diubah_oleh        INT(10),
                       PRIMARY KEY	(kode_fas),
                       FOREIGN KEY	(dibuat_oleh)	REFERENCES pengguna(kode_pengguna),
                       FOREIGN KEY	(diubah_oleh)	REFERENCES pengguna(kode_pengguna))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "create table pemesanan<br>\n";
    $sqltext = "create table pemesanan (
                       kode_pengguna      INT(10)         NOT NULL,
                       kode_pesan         INT(10)	      NOT NULL AUTO_INCREMENT,
                       fasilitas          INT(10)	      NOT NULL,
                       pemesan            INT(10)	      NOT NULL,
                       kode_agenda        INT(10),
                       keperluan          VARCHAR(250),
                       untuk_tgl          DATE NOT NULL,
                       jam_mulai          TIME NOT NULL,
                       jam_akhir          TIME,
                       keterangan         VARCHAR(250),
                       tanggal_dibuat     DATETIME,
                       tanggal_diubah     DATETIME,
                       dibuat_oleh        INT(10),
                       diubah_oleh        INT(10),
                       PRIMARY KEY	(kode_pesan),
                       FOREIGN KEY	(fasilitas)	  REFERENCES fasilitas(kode_fas),
                       FOREIGN KEY	(pemesan)     REFERENCES pengguna(kode_pengguna),
                       FOREIGN KEY	(kode_agenda) REFERENCES agenda(kode_agenda),
                       FOREIGN KEY	(dibuat_oleh) REFERENCES pengguna(kode_pengguna),
                       FOREIGN KEY	(diubah_oleh) REFERENCES pengguna(kode_pengguna))";
    $table = mysql_query($sqltext,$link);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "</ul>\n";

}

?>
