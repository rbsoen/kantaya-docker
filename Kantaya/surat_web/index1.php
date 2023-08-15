<?
error_reporting (E_ALL ^ E_NOTICE);
include("konfig_surat.php");
include("fungsi_utama.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";


$sid = md5(uniqid(""));
$tcontent = read_file($login_template);




$jssource = "


<script language=javascript>
function select_language(lid) {
	location = 'index.php?lid='+lid+'&f_user='+escape(document.forms[0].f_user.value)
}
function newmsg()  { alert('Anda harus Login terlebih dahulu') }
function refreshlist() { alert('Anda harus Login terlebih dahulu') }
function folderlist() { alert('Anda harus Login terlebih dahulu') }
function search()  { alert('Anda harus Login terlebih dahulu') }
function addresses()  { alert('Anda harus Login terlebih dahulu') }
function prefs()  { alert('Anda harus Login terlebih dahulu') }
function goend()   { alert('Anda harus Login terlebih dahulu') }
function goinbox() { alert('Anda harus Login terlebih dahulu') }
</script>
";


echo "<link rel=stylesheet type='text/css' href='$css'>\n";

$tcontent     = eregi_replace("<!--%UM_JS%-->",$jssource,$tcontent);
$tcontent     = eregi_replace("<!--%UM_SID%-->",strtoupper($sid),$tcontent);
$tcontent     = eregi_replace("<!--%UM_F_USER%-->",htmlspecialchars($f_user),$tcontent);

$startvar = strpos($tcontent,"<!--%UM_VARIABLE_SERVER_BEGIN%-->");
$endvar = strpos($tcontent,"<!--%UM_VARIABLE_SERVER_END%-->")+31;

$startstat = strpos($tcontent,"<!--%UM_STATIC_SERVER_BEGIN%-->");
$endstat = strpos($tcontent,"<!--%UM_STATIC_SERVER_END%-->")+29;

$aval_servers = count($pop3_servers);

if($aval_servers != 0) {
	// fixed server
	$correct = substr($tcontent,$startstat+31,$endstat-$startstat-60);
	if ($aval_servers == 1) {
		$tmp = "@".$pop3_servers[0]["domain"]." <input type=hidden name=six value=0>";
		$correct = eregi_replace("<!--%UM_SERVERS%-->",$tmp,$correct);
	} else {
		$tmp = "<select name=six>\r";
		for($i=0;$i<$aval_servers;$i++)
			$tmp .= "<option value=$i>@".$pop3_servers[$i]["domain"]."\r";
		$tmp .= "</select>\r";
		$correct = eregi_replace("<!--%UM_SERVERS%-->",$tmp,$correct);
	}
} else {
	$correct = substr($tcontent,$startvar+33,$endvar-$startvar-64);
	//variable server
}
$tcontent = substr($tcontent,0,$startvar).$correct.substr($tcontent,$endstat);


$avallangs = count($languages);
if($avallangs == 0) die("You must provide at least one language");

$startlng = strpos($tcontent,"<!--%UM_LANGUAGE_BEGIN%-->");
$endlng = strpos($tcontent,"<!--%UM_LANGUAGE_END%-->")+24;

if($allow_user_change) {
	$cleantext = substr($tcontent,$startlng+26,$endlng-$startlng-50);
	$langsel = "<select name=lng onChange=\"select_language(this.options[this.selectedIndex].value)\">\r";
	$def_lng = (is_numeric($lid))?$lid:$default_language;
	for($i=0;$i<$avallangs;$i++) {
		$selected = ($lid == $i)?" selected":"";
		$langsel .= "<option value=$i$selected>".$languages[$i]["name"]."\r";
	}
	$langsel .= "</select>\r";
	$cleantext = eregi_replace("<!--%UM_LANGUAGES%-->",$langsel,$cleantext);
	$tcontent = substr($tcontent,0,$startlng).$cleantext.substr($tcontent,$endlng);

} else 
	$tcontent = substr($tcontent,0,$startlng).substr($tcontent,$endlng);

echo($tcontent);
