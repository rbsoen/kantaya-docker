<?
include("pengaturan_session.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";


echo($nocache);
if (isset($rem) && $rem != "") {
	$attchs = $sess["attachments"];

	//echo("<pre>".print_r($attchs)."</pre>");

	@unlink($attchs[$rem]["localname"]);
	unset($attchs[$rem]);
	shuffle($attchs);

	//echo("<pre>".print_r($attchs)."</pre>");

	$sess["attachments"] = $attchs;
	save_session($sess);

	echo("
	<script language=javascript>\n
		if(window.opener) window.opener.doupload();\n
		setTimeout('self.close()',500);\n
	</script>\n
	");
    echo "<link rel=stylesheet type='text/css' href='$css'>\n";
} elseif (isset($userfile) && $userfile != "") {

	if(!is_array($sess["attachments"])) $ind = 0;
	else $ind = count($sess["attachments"]);
	$filename = $userfolder."_attachments/".md5(uniqid("")).$userfile_name;
    copy($userfile, $filename); unlink($userfile);

	$sess["attachments"][$ind]["localname"] = $filename;
	$sess["attachments"][$ind]["name"] = $userfile_name;
	$sess["attachments"][$ind]["type"] = $userfile_type;
	$sess["attachments"][$ind]["size"] = $userfile_size;

	save_session($sess);

	echo("
	<script language=javascript>\n
		if(window.opener) window.opener.doupload();\n
		setTimeout('self.close()',500);\n
	</script>\n
	");
    echo "<link rel=stylesheet type='text/css' href='$css'>\n";
} else {

	$tcontent = read_file($attach_window_template);
	$tcontent = eregi_replace("<!--%UM_SID%-->",$sid,$tcontent);
	echo($tcontent);

}
?>
