<?php
/******************************************
Nama File : navigasi_dimana.php
Fungsi    : Navigasi untuk menampilkan 
            keberadaan pengguna per unit 
            kerja, menyimpan keberadaan
            terakhir dan mencari keberadaan
            pengguna.
Dibuat    :	
 Tgl.     : 02-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

include ('../lib/cek_sesi.inc');
include('../lib/akses_unit.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

$idpengguna = $kode_pengguna;
$unitpengguna = $unit_pengguna;
$idpengguna = 1;
$unitpengguna = '';
$levelpengguna = 1;
if ($levelpengguna == 1) {
    $admin = true;
} else {
    $admin = false;
}

list_akses_unit($db,$unitpengguna,&$aksesunit);
list_akses_grup($db,$idpengguna,$admin,&$aksesgrup);

echo "<html>\n";
echo "<head>\n";
echo "<title>Navigasi Dimana?</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<script language='Javascript' src='navigasi_dimana.js'></script>\n";
echo "<script language='Javascript'>\n";
echo "<!--\n";
inisialisasi_unit ($aksesunit,1);
inisialisasi_grup ($aksesgrup,1);

echo "var cssfile = '../css/$tampilan_css.css'\n";
if ($levelpengguna == 1) {
    echo "var admin = true\n";
} else {
    echo "var admin = false\n";
}

echo "// -->\n";
echo "</script>\n";
echo "</head>\n";
echo "<body>\n";
echo "<script language='Javascript'>printNavigasi()</script>\n";
echo "</body>\n";
echo "</html>\n";

function inisialisasi_unit($unit,$ini) {
    $ttlunit = count($unit);
    echo "var x = new Array($ttlunit);\n";
    echo "for (var i=0; i<$ttlunit; i++) {\n";
        echo "x[i] = new Array(4);\n";
    echo "}\n";
    for ($i=0; $i<$ttlunit; $i++) {
        for ($j=0; $j<3; $j++) {
            echo "x[$i][$j] = '".$unit[$i][$j]."';\n";
        }
        if ($ini > 0) {
            if ($unit[$i][2] <= $ini) {
                echo "x[$i][3] = '1';\n";
            } else {
                echo "x[$i][3] = '0';\n";
            }
        } else {
            echo "x[$i][3] = '0';\n";
        }
    }
}

function inisialisasi_grup($grup,$ini) {
    $ttlgrup = count($grup);
    echo "var g = new Array($ttlgrup);\n";
    echo "for (var i=0; i<$ttlgrup; i++) {\n";
        echo "g[i] = new Array(4);\n";
    echo "}\n";
    for ($i=0; $i<$ttlgrup; $i++) {
        for ($j=0; $j<3; $j++) {
            echo "g[$i][$j] = '".$grup[$i][$j]."';\n";
        }
        if ($ini > 0) {
            if ($grup[$i][2] <= $ini) {
                echo "g[$i][3] = '1';\n";
            } else {
                echo "g[$i][3] = '0';\n";
            }
        } else {
            echo "g[$i][3] = '0';\n";
        }
    }
}


?>


