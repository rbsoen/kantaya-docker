<?
include("pengaturan_session.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";


$tcontent = read_file($preferences_template);

if(isset($f_real_name)) {
	$myprefs["real-name"]     = $f_real_name;
	$myprefs["reply-to"]      = $f_reply_to;
	$myprefs["save-to-trash"] = $f_save_trash;
	$myprefs["st-only-read"]  = $f_st_only_read;
	$myprefs["empty-trash"]   = $f_empty_on_exit;
	$myprefs["save-to-sent"]  = $f_save_sent;
	$myprefs["rpp"]           = $f_rpp;
	$myprefs["add-sig"]       = $f_add_sig;
	$myprefs["signature"]     = $f_sig;
	save_prefs($myprefs); unset($myprefs);
}

$prefs = load_prefs();
$real_name              = $prefs["real-name"];
$reply_to               = $prefs["reply-to"];
$send_to_trash          = $prefs["save-to-trash"];
$st_only_read           = $prefs["st-only-read"];
$empty_trash            = $prefs["empty-trash"];
$save_to_sent           = $prefs["save-to-sent"];
$records_per_page       = $prefs["rpp"];
$add_signature          = $prefs["add-sig"];
$signature              = $prefs["signature"];

$jssource = "

<script language=\"JavaScript\">
disbl = false;
function newmsg() { location = 'kirimsurat.php?pag=$pag&folder=".urlencode($folder)."&sid=$sid&lid=$lid'; }
function folderlist() { location = 'almarisurat.php?folder=".urlencode($folder)."&sid=$sid&lid=$lid'}
function goend() { location = 'logout.php?sid=$sid&lid=$lid'; }
function goinbox() { location = 'daftarsurat.php?folder=inbox&sid=$sid&lid=$lid'; }
function search() { location = 'pencarian.php?sid=$sid&lid=$lid'; }
function emptytrash() {	location = 'almarisurat.php?empty=trash&folder=".urlencode($folder)."&goback=true&sid=$sid&lid=$lid';}
function addresses() { location = 'bukualamat.php?sid=$sid&lid=$lid'; }
function dis() { 
	with(document.forms[0]) { 
		f_st_only_read.disabled = !f_save_trash.checked; 
		if(f_st_only_read.checked) f_st_only_read.checked = f_save_trash.checked; 
		disbl = !f_save_trash.checked
	} 
}
function checkDis() { if (disbl) return false; }
</script>

";

 echo "<link rel=stylesheet type='text/css' href='$css'>\n";
 
$aval_rpp = Array(10,20,30,40,50);
$sel_rpp = "<select name=f_rpp>\r";
for($i=0;$i<count($aval_rpp);$i++) {
	$selected = ($records_per_page == $aval_rpp[$i])?" selected":"";
	$sel_rpp .= "<option value=".$aval_rpp[$i].$selected.">".$aval_rpp[$i]."\r";
}
$sel_rpp .= "</select>";

$txtsignature = "<textarea cols=\"40\" rows=\"3\" name=\"f_sig\" class=\"textarea\">".htmlspecialchars($signature)."</textarea>";

$tcontent = eregi_replace("<!--%UM_JS%-->",$jssource,$tcontent);
$tcontent = eregi_replace("<!--%UM_SID%-->",$sid,$tcontent);
$tcontent = eregi_replace("<!--%UM_LID%-->",$lid,$tcontent);
$tcontent = eregi_replace("<!--%UM_REAL_NAME%-->",htmlspecialchars($real_name),$tcontent);
$tcontent = eregi_replace("<!--%UM_REPLY_TO%-->",htmlspecialchars($reply_to),$tcontent);
$status = ($send_to_trash)?" checked":"";
$tcontent = eregi_replace("<!--%UM_SAVE_TRASH%-->",$status,$tcontent);
$status = ($st_only_read)?" checked":"";
$tcontent = eregi_replace("<!--%UM_ST_ONLY_READ%-->",$status,$tcontent);
$status = ($empty_trash)?" checked":"";
$tcontent = eregi_replace("<!--%UM_EMPTY_ON_EXIT%-->",$status,$tcontent);
$status = ($save_to_sent)?" checked":"";
$tcontent = eregi_replace("<!--%UM_SAVE_SENT%-->",$status,$tcontent);
$status = ($add_signature)?" checked":"";
$tcontent = eregi_replace("<!--%UM_ADD_SIGNATURE%-->",$status,$tcontent);

$tcontent = eregi_replace("<!--%UM_RECORDS_PP%-->",$sel_rpp,$tcontent);
$tcontent = eregi_replace("<!--%UM_SIGNATURE%-->",$txtsignature,$tcontent);

echo($tcontent);
?>
