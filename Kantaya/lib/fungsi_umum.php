<?php
function ambil_data_pengguna($db, $idpengguna, &$pengguna) {
    $query = mysql_query("SELECT * FROM pengguna WHERE kode_pengguna='$idpengguna'", $db);
    $row = mysql_fetch_object($query);
    $pengguna["kode"] = $row->kode_pengguna;
    $pengguna["nama"] = $row->nama_pengguna;
    $pengguna["email"] = $row->email;
    $pengguna["nip"] = $row->nip;
}


?>
