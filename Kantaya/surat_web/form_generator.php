<?
/*
This page generates the special forms requireds to login in UebiMiau
* Why I use it ?
	It's util if you can login from other places, like as non-php pages.
* How I use it ?
	Use as an JavaScript source file, like as:
	<script language="JavaScript" src="http://server/path-to-uebimiau/form_generator.php?type=all" type="text/javascript">

	in your page:
	<form name="form1" action="daftarsurat.php" method=post>
	<script language="JavaScript" src="http://server/path-to-uebimiau/form_generator.php?type=sid" type="text/javascript">
	</form>

* What's the parameters to this file?
	This file have three (optional) parameters:
	- form_generator.php?type=all    -> generate both forms (sid and server id)
	- form_generator.php?type=sid    -> generate only session id identifier
	- form_generator.php?type=server -> generate only server id identifier
*/

include("konfig_surat.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";


if($type == "") $type = "all";
if($type == "all" || $type == "server") {
	$aval_servers = count($pop3_servers);
	if($aval_servers != 0) {
		$correct = substr($tcontent,$startstat+31,$endstat-$startstat-60);
		if ($aval_servers == 1) {
			$result = "@".$pop3_servers[0]["domain"]." <input type=hidden name=six value=0>";
		} else {
			$result = "<select name=six>\\r";
			for($i=0;$i<$aval_servers;$i++)
				$result .= "<option value=$i>@".$pop3_servers[$i]["domain"]."\\r";
			$result .= "</select>\\r";
		}
	} else
		$result = "<h1>Anda harus mensetting satu atau lebih server</h1><br>\\r";
}
if($type == "all" || $type == "sid") {
	$result .= "<input type=hidden name=sid value=\"".strtoupper(md5(uniqid("")))."\">\\r";
}
$result .= 
"<META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"no-cache\">"
."<META HTTP-EQUIV=\"Expires\" CONTENT=\"-1\">"
."<META HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\">";
echo("
<!--
document.write('$result');
//-->
");
?>
