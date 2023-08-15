<?
// load the configurations
include("konfig_surat.php");
include("fungsi_utama.php");
error_reporting (E_ALL ^ E_NOTICE); 
// load the specified file
$tcontent = read_file($bad_login_template);
$tcontent = ereg_replace("<!--%UM_LID%-->",$lid,$tcontent);
// show it :)
echo($tcontent);
?>
