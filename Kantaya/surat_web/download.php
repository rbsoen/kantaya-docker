<?
// load session management
include("pengaturan_session.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";


// check for all parameters
if(	!isset($bound)|| 
	!isset($part) || 
	!isset($ix)) die("<script language=\"javascript\">location = 'kesalahan.php?msg=".urlencode($error_other)."&sid=$sid&lid=$lid';</script>");

// choose correct session
$sessiontype = ($folder == "inbox")?"headers":"folderheaders";
$mail_info = $sess[$sessiontype][$ix];
$localname = $mail_info["localname"];
// check if the file exists, otherwise, do a error
if (!file_exists($localname)) die("<script language=\"javascript\">location = 'kesalahan.php?msg=".urlencode($error_other)."&sid=$sid&lid=$lid';</script>");
// read the email
$email = read_file($localname);
// start a new mime decode class
$md = new mime_decode();
// split the mail, body and headers
$email = $md->fetch_structure($email);
$header = $email["header"];
$body = $email["body"];
// split the parsts of email if it have more than one parts
if($bound != "") {
	$parts = $md->split_parts(base64_decode($bound),$body);
	// split the especified part of mail, body and headers
	$email = $md->fetch_structure($parts[$part]);
	$header = $email["header"];
	$body = $email["body"];
}
// check if file will be downloaded
$isdown = (isset($down))?1:0;
// get the attachment
$md->download_attach($header,$body,$isdown);
unset($md);
?>
