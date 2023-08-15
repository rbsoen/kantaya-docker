<?php
/******************************************
Nama File : nav_direktori.php
Fungsi    : Navigasi untuk menampilkan 
            direktori (lemari) pengguna
Dibuat    :	
 Tgl.     : 28-11-2001
 Oleh     : KB
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

include ('../lib/cek_sesi.inc');
include('../lib/akses_direktori.php');
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);
			
$css = "../css/".$tampilan_css.".css";

$idpengguna = $kode_pengguna;
$unitpengguna = $unit_pengguna;

$unitpengguna = '';

list_akses_unit($db,$idpengguna, $unitpengguna,&$aksesunit);

echo "<html>\n";
echo "<head>\n";
echo "<title>Navigasi Lemari</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<script language='Javascript' src='nav_direktori.js'></script>\n";
echo "<script language='Javascript'>\n";
echo "<!--\n";

inisialisasi_unit ($aksesunit,1);

echo "var cssfile = '../css/$tampilan_css.css'\n";
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

?>
