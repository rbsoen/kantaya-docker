<?
// load configs
include("konfig_surat.php");
include("fungsi_utama.php");
error_reporting (E_ALL ^ E_NOTICE); 

// load template
$tcontent = read_file($error_template);
// replace the vars in template
$tcontent = eregi_replace("<!--%UM_SID%-->",$sid,$tcontent);
$tcontent = eregi_replace("<!--%UM_LID%-->",$lid,$tcontent);
$tcontent = eregi_replace("<!--%UM_ERROR%-->",$msg,$tcontent);
// show result
echo($tcontent);
?>
