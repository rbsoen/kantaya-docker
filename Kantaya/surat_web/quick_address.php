<?
include("pengaturan_session.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";


$filename = $userfolder."_infos/addressbook.ucf";
$myfile = read_file($filename);
if($myfile != "") 
	$addressbook = unserialize(~$myfile);
array_qsort2($addressbook,"name");
$listbox = "<select name=contacts size=10>\r\n";
for($i=0;$i<count($addressbook);$i++) {
	$line = $addressbook[$i];
	$name = htmlspecialchars(trim($line["name"]));;
	$email = htmlspecialchars(trim($line["email"]));
	$listbox .= "<option value=\"&quot;$name&quot; &lt;$email&gt;\"> &quot;$name&quot; &lt;$email&gt;";
}
$listbox .= "</select>";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";

$tcontent = read_file($quick_address_template);

$tcontent = eregi_replace("<!--%UM_CONTACTS%-->",$listbox,$tcontent);
echo($tcontent);

?>
