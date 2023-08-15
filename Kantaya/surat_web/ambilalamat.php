<?
include("pengaturan_session.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";

if(!isset($ix) || !isset($folder)) Header("Location: kesalahan.php?msg=".urlencode($error_other)."&sid=$sid&lid=$lid");
echo "<link rel=stylesheet type='text/css' href='$css'>\n";

$tcontent = read_file($catch_address_template);

$tcontent = eregi_replace("<!--%UM_LID%-->",$lid,$tcontent);
$tcontent = eregi_replace("<!--%UM_SID%-->",$sid,$tcontent);
$tcontent = eregi_replace("<!--%UM_FOLDER%-->",htmlspecialchars($folder),$tcontent);
$tcontent = eregi_replace("<!--%UM_IX%-->",$ix,$tcontent);

$filename = $userfolder."_infos/addressbook.ucf";
$myfile = read_file($filename);
$addressbook = Array();
if($myfile != "") 
	$addressbook = unserialize(~$myfile);

function email_exists($thismail) {
	global $addressbook,$f_email;
	for($i=0;$i<count($addressbook);$i++)
		if(trim($addressbook[$i]["email"]) == trim($thismail)) return 1;
	if(trim($f_email) == trim($thismail)) return 1;
	return 0;
}

$sessiontype = ($folder == "inbox")?"headers":"folderheaders";
$mail_info = $sess[$sessiontype][$ix];
$emails = Array();
$from = $mail_info["from"];
$to = $mail_info["to"];
$cc = $mail_info["cc"];


for($i=0;$i<count($from);$i++)
	$emails[] = $from[$i];
for($i=0;$i<count($to);$i++)
	$emails[] = $to[$i];
for($i=0;$i<count($cc);$i++)
	$emails[] = $cc[$i];

$aval = array();
for($i=0;$i<count($emails);$i++)
	if(!email_exists($emails[$i]["mail"])) $aval[] = $emails[$i];
	
$aval_count = count($aval);

if(isset($ckaval)) {
	for($i=0;$i<count($ckaval);$i++) {
		$idchecked = $ckaval[$i];
		$id = count($addressbook);
		$addressbook[$id]["name"] = $emails[$idchecked]["name"];
		$addressbook[$id]["email"] = $emails[$idchecked]["mail"];
	}
	$tmp = fopen($filename,"wb+"); 
	fwrite($tmp,~serialize($addressbook));
	fclose($tmp);
	echo("
	<script language=javascript>
		self.close();
	</script>
	");
	exit;
} else {

	if($aval_count > 0) {
	
		$tmp   = get_tags("<!--%UM_IF_HAVE_ADDRESS_AVAL_BEGIN%-->","<!--%UM_IF_HAVE_ADDRESS_AVAL_END%-->",$tcontent);
		$clean = $tmp["re-content"];
		$tmp2 = get_tags("<!--%UM_LOOP_BEGIN%-->","<!--%UM_LOOP_END%-->",$clean);
		$line = $tmp2["re-content"];
	
		for($i=0;$i<$aval_count;$i++) {
			$thisline = $line;
			$dspname = (strlen($aval[$i]["name"]) > 30)?substr($aval[$i]["name"],0,30)."...":$aval[$i]["name"];
			$dspname = "
			<input type=checkbox name=ckaval[] checked value=$i>
			".htmlspecialchars($dspname);
			$dspmail = htmlspecialchars($aval[$i]["mail"]);
			$thisline = eregi_replace("<!--%UM_NAME%-->",$dspname,$thisline);
			$thisline = eregi_replace("<!--%UM_MAIL%-->",$dspmail,$thisline);
			$result .= $thisline;
		}
		$clean    = substr($clean,0,$tmp2["ab-begin"]).$result.substr($clean,$tmp2["ab-end"]);
		$tcontent = substr($tcontent,0,$tmp["ab-begin"]).$clean.substr($tcontent,$tmp["ab-end"]);
		$tmp   = get_tags("<!--%UM_IF_NO_HAVE_ADDRESS_AVAL_BEGIN%-->","<!--%UM_IF_NO_HAVE_ADDRESS_AVAL_END%-->",$tcontent);
		$tcontent = substr($tcontent,0,$tmp["ab-begin"]).substr($tcontent,$tmp["ab-end"]);
	
	} else {
		$tmp   = get_tags("<!--%UM_IF_HAVE_ADDRESS_AVAL_BEGIN%-->","<!--%UM_IF_HAVE_ADDRESS_AVAL_END%-->",$tcontent);
		$tcontent = substr($tcontent,0,$tmp["ab-begin"]).substr($tcontent,$tmp["ab-end"]);
		$tmp   = get_tags("<!--%UM_IF_NO_HAVE_ADDRESS_AVAL_BEGIN%-->","<!--%UM_IF_NO_HAVE_ADDRESS_AVAL_END%-->",$tcontent);
		$tcontent = substr($tcontent,0,$tmp["ab-begin"]).$tmp["re-content"].substr($tcontent,$tmp["ab-end"]);
	}
	echo($tcontent);
}
?>
