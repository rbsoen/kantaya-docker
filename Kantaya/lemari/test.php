<?php

require("lemari_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

$pidpengguna='5';
$punit='69';

function list_akses_unit($db, $pidpengguna, $punit, &$aksesunit) {


    list_akses_unit_atas($db, $pidpengguna, $punit, 0, 0, &$aksesunit1);
    list_akses_unit_bawah($db, $pidpengguna, $punit, 0, 0, &$aksesunit2);
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

function list_akses_unit_atas($db, $pidpengguna, $punit, $i, $plevel, &$aksesunit) {
    $sqltext = "SELECT * FROM direktori WHERE kode_direktori='$punit' AND dibuat_oleh='$pidpengguna'";
    $query = mysql_query($sqltext, $db);
    $plevel++;
    while ($row = mysql_fetch_object($query)) {
        $aksesunit[$i][0] = $row->kode_direktori;
        $aksesunit[$i][1] = $row->nama_direktori;
        $aksesunit[$i][2] = $plevel;
        $i++;
        if ($row->direktori_induk <> "") {
           list_akses_unit_atas($db, $pidpengguna, $row->direktori_induk, $i, $plevel, &$aksesunit);
        }
    return ($aksesunit[$i][0]);
		echo "haha";
		
		}
}

function list_akses_unit_bawah($db, $pidpengguna, $punit, $i, $plevel, &$aksesunit) {
    $query = mysql_query("SELECT * FROM direktori WHERE direktori_induk='$punit' AND dibuat_oleh='$pidpengguna' order by kode_direktori asc", $db);
    $plevel++;
    while ($row = mysql_fetch_object($query)) {
        $aksesunit[$i][0] = $row->kode_direktori;
        $aksesunit[$i][1] = $row->nama_direktori;
        $aksesunit[$i][2] = $plevel;
        $i++;
        list_akses_unit_bawah($db, $pidpengguna, $row->kode_direktori, $i, $plevel, &$aksesunit);
        $i = count($aksesunit);
   	return ($aksesunit[$i][0]);
		echo "haha";
	  }
	
}


echo $pidpengguna;
echo $punit;
?>
khkjhkjhkjk