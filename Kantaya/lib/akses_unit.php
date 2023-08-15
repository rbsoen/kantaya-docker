<?php

function list_akses_unit($db, $punit, &$aksesunit) {
    list_akses_unit_atas($db, $punit, 0, 0, &$aksesunit1);
    list_akses_unit_bawah($db, $punit, 0, 0, &$aksesunit2);
    $k = 0;
    $plevel = 0;
    $flag = true;
    for ($i=count($aksesunit1)-1; $i>=0; $i--) {
        $aksesunit[$k][0] = $aksesunit1[$i][0];
        $aksesunit[$k][1] = $aksesunit1[$i][1];
        if ($flag) {
            $aksesunit[$k][2] = 1;
            $p0 = $aksesunit1[$i][2];
            $flag = false;
        } else {
            $aksesunit[$k][2] = 1 + ($p0-$aksesunit1[$i][2]);
        }
        $k++;
    }
    $plevel = $aksesunit[$k-1][2];
    for ($i=0; $i<count($aksesunit2); $i++) {
        for ($j=0;$j<3;$j++) {
            $aksesunit[$k][$j] = $aksesunit2[$i][$j];
            if ($j==2) $aksesunit[$k][$j] = $aksesunit[$k][$j]+$plevel;
        }
        $k++;
    }
}

function list_akses_unit_atas($db, $punit, $i, $plevel, &$aksesunit) {
    $sqltext = "SELECT * FROM unit_kerja WHERE kode_unit='$punit'";
    $query = mysql_query($sqltext, $db);
    $plevel++;
    while ($row = mysql_fetch_object($query)) {
        $aksesunit[$i][0] = $row->kode_unit;
        $aksesunit[$i][1] = $row->nama_unit;
        $aksesunit[$i][2] = $plevel;
        $i++;
        if ($row->induk_unit <> "") {
           list_akses_unit_atas($db, $row->induk_unit, $i, $plevel, &$aksesunit);
        }
    }
}

function list_akses_unit_bawah($db, $punit, $i, $plevel, &$aksesunit) {
    $query = mysql_query("SELECT * FROM unit_kerja WHERE induk_unit='$punit' order by kode_unit asc", $db);
    $plevel++;
    while ($row = mysql_fetch_object($query)) {
        $aksesunit[$i][0] = $row->kode_unit;
        $aksesunit[$i][1] = $row->nama_unit;
        $aksesunit[$i][2] = $plevel;
        $i++;
        list_akses_unit_bawah($db, $row->kode_unit, $i, $plevel, &$aksesunit);
        $i = count($aksesunit);
    }
}

function list_akses_grup ($db, $pidpengguna, $admin, &$aksesgrup) {
    if ($admin) {
        $sqltext = "SELECT a.kode_grup, a.nama_grup  FROM grup a order by a.nama_grup";
    } else {
        $sqlwhere= "WHERE a.status='1' and a.kode_grup = b.kode_grup and b.kode_pengguna = '$pidpengguna' ";
        $sqltext = "SELECT a.kode_grup, a.nama_grup FROM grup a, grup_pengguna b ".$sqlwhere." order by a.nama_grup";
    }
    $i = 1;
    $j = 0;
    $pj = -1;
    $delta = 5;
    $query = mysql_query($sqltext, $db);
    while ($row = mysql_fetch_object($query)) {
        while (1) {
            for ($k=0; $k<$delta; $k++) {
                $chr = 65+$k+($j*$delta);
                if (eregi("^".chr($chr),$row->nama_grup) || ($chr > 90)) {
                    break 2;
                }
            }
            $j++;
        }
        if (($chr > 90) && (($i > 1 && $pj == -1) || ($i == 1))) {
            $aksesgrup[$i-1][0] = $row->kode_grup;
            $aksesgrup[$i-1][1] = "Grup Lain-Lain";
            $aksesgrup[$i-1][2] = 1;
            $pj = -1;
            $j = 0;
            $i++;
        } elseif ($j <> $pj) {
            $aksesgrup[$i-1][0] = $row->kode_grup;
            if ($j == 5) {
                $aksesgrup[$i-1][1] = "Grup ".chr(65+($j*$delta));
            } else {
                $aksesgrup[$i-1][1] = "Grup ".chr(65+($j*$delta))." s/d ".chr(69+($j*$delta));
            }
            $aksesgrup[$i-1][2] = 1;
            $pj = $j;
            $i++;
        }
        $aksesgrup[$i-1][0] = $row->kode_grup;
        $aksesgrup[$i-1][1] = $row->nama_grup;
        $aksesgrup[$i-1][2] = 2;
        $i++;
    }
}


?>










