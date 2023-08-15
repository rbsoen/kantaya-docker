<?php
/***********************************************
Nama File : fs_umum.php 
Fungsi    : Fungsi-fungsi untuk keperluan umum.
Dibuat    :	 
 Tgl.     : 23-10-2001 
 Oleh     : FB 
Revisi 1	:	 
 Tgl.     : 
 Oleh     : 
 Revisi   :
************************************************/

function ambil_data_pengguna($db, $idpengguna, &$pengguna) {
    $query = mysql_query("SELECT * FROM pengguna WHERE kode_pengguna='$idpengguna'", $db);
    $row = mysql_fetch_object($query);
    $pengguna["kode"] = $row->kode_pengguna;
    $pengguna["nama"] = $row->nama_pengguna;
    $pengguna["email"] = $row->email;
    $pengguna["nip"] = $row->nip;
    $pengguna["username"] = $row->username;

}

function tampilkan_error($errno, $errtext){
    echo "<table width= '75%'>\n";
    echo "<tr>\n";
    echo "<td class=judul1>Konfirmasi\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td>\n";
    if ($errno <> "") {
        echo "<font size=+1>".$errno." : </font><br>\n";
        echo "<font size=+1>".$errtext."</font>\n";
    } else {
        echo "<font size=+1>".$errtext."</font>\n";
    }
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    exit -1;
}

function check_mysql_error($errno, $errtext){
    if ($errno <> 0) {
        tampilkan_error($errno, $errtext);
        echo "$sqltext\n";
    }
}
?>