<?
include("pengaturan_session.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";


echo "<link rel=stylesheet type='text/css' href='$css'>\n";

$tcontent = read_file($headers_window_template);
$tcontent = eregi_replace("<!--%UM_TITLE%-->",$appname." ".$appversion." - ".htmlspecialchars($subject),$tcontent);

$start = strpos($tcontent,"<!--%UM_LOOP_BEGIN%-->");
$end = strpos($tcontent,"<!--%UM_LOOP_END%-->")+20;

$line = substr($tcontent,$start+22,$end-$start-42);

$md = new mime_decode();
$headers = $md->decode_header($headers);

while(list($key,$val) = each($headers)) {
	$thisline = $line;
	$thisline = eregi_replace("<!--%UM_KEY%-->",UCFirst($key),$thisline);
	$thisline = eregi_replace("<!--%UM_VALUE%-->",htmlspecialchars(stripslashes($val)),$thisline);
	$result .= $thisline;
}

$tcontent = substr($tcontent,0,$start).$result.substr($tcontent,$end);

echo($tcontent);

?>
