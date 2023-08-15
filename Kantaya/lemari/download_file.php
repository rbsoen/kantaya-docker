<?php
include ("../lib/cek_sesi.inc");
require ("../lib/induk_dir.php");
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$total="file_upload/".$direktori."/".$file;

Header("Content-Type:application/zip");
Header("Content-Length:".filesize($total));
Header("Content-Disposition: attachment; filename=$file");
readfile($total);


//echo $total;
?>
