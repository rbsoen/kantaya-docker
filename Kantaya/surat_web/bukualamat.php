<?
// load session management
include("pengaturan_session.php");
include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";

// keep cache clean
echo($nocache);

// use the char 149 as columm separator
$sp = chr(149);

$filename = $userfolder."_infos/addressbook.ucf";
$myfile = read_file($filename);
if($myfile != "") 
	$addressbook = unserialize(~$myfile);
array_qsort2($addressbook,"name");

switch($opt) {
	// save an edited contact
	case "save":

		$addressbook[$id]["name"] = $name;
		$addressbook[$id]["email"] = $email;
		$addressbook[$id]["street"] = $street;
		$addressbook[$id]["city"] = $city;
		$addressbook[$id]["state"] = $state;
		$addressbook[$id]["work"] = $work;

		$tmp = fopen($filename,"wb+"); 
		fwrite($tmp,~serialize($addressbook));
		fclose($tmp);

		$tcontent = read_file($address_results_template);

		$tcontent = eregi_replace("<!--%UM_GOBACK%-->","bukualamat.php?sid=$sid&lid=$lid",$tcontent);
		$tcontent = eregi_replace("<!--%UM_MESSAGE%-->",sprintf($addr_saved,$email),$tcontent);
		break;

	// add a new contact
	case "add":
		$id = count($addressbook);
		$addressbook[$id]["name"] = $name;
		$addressbook[$id]["email"] = $email;
		$addressbook[$id]["street"] = $street;
		$addressbook[$id]["city"] = $city;
		$addressbook[$id]["state"] = $state;
		$addressbook[$id]["work"] = $work;

		$tmp = fopen($filename,"wb+"); 
		fwrite($tmp,~serialize($addressbook));
		fclose($tmp);

		$tcontent = read_file($address_results_template);


		$tcontent = eregi_replace("<!--%UM_GOBACK%-->","bukualamat.php?sid=$sid&lid=$lid",$tcontent);
		$tcontent = eregi_replace("<!--%UM_MESSAGE%-->",sprintf($addr_added,$email),$tcontent);

		break;
		
	//delete an existing contact
	case "dele":
		unset($addressbook[$id]);
		$newaddr = Array();
		while(list($l,$value) = each($addressbook))
			$newaddr[] = $value;
		$addressbook = $newaddr;
		$tmp = fopen($filename,"wb+"); 
		fwrite($tmp,~serialize($addressbook));
		fclose($tmp);
		$tcontent = read_file($address_results_template);
		$tcontent = eregi_replace("<!--%UM_GOBACK%-->","bukualamat.php?sid=$sid&lid=$lid",$tcontent);
		$tcontent = eregi_replace("<!--%UM_MESSAGE%-->",$addr_deleted,$tcontent);
		break;

	// show the form to edit
	case "edit":
		$tcontent = read_file($address_form_template);

		$tcontent = eregi_replace("<!--%UM_SID%-->",$sid,$tcontent);
		$tcontent = eregi_replace("<!--%UM_GOBACK%-->","bukualamat.php?sid=$sid&lid=$lid",$tcontent);

		$tcontent = eregi_replace("<!--%UM_OPT%-->","save",$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_ID%-->",$id,$tcontent);

		$tcontent = eregi_replace("<!--%UM_ADDR_NAME%-->",htmlspecialchars($addressbook[$id]["name"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_EMAIL%-->",htmlspecialchars($addressbook[$id]["email"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_STREET%-->",htmlspecialchars($addressbook[$id]["street"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_CITY%-->",htmlspecialchars($addressbook[$id]["city"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_STATE%-->",htmlspecialchars($addressbook[$id]["state"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_WORK%-->",htmlspecialchars($addressbook[$id]["work"]),$tcontent);

		break;

	// display the details for an especified contact
	case "display":
		$tcontent = read_file($address_display_template);

		$tcontent = eregi_replace("<!--%UM_GOBACK%-->","bukualamat.php?sid=$sid&lid=$lid",$tcontent);

		$tcontent = eregi_replace("<!--%UM_ADDR_ID%-->",$id,$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_NAME%-->",htmlspecialchars($addressbook[$id]["name"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_EMAIL%-->",htmlspecialchars($addressbook[$id]["email"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_STREET%-->",htmlspecialchars($addressbook[$id]["street"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_CITY%-->",htmlspecialchars($addressbook[$id]["city"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_STATE%-->",htmlspecialchars($addressbook[$id]["state"]),$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_WORK%-->",htmlspecialchars($addressbook[$id]["work"]),$tcontent);

		break;

	// show the form to a new contact
	case "new":

		$tcontent = read_file($address_form_template);

		$tcontent = eregi_replace("<!--%UM_GOBACK%-->","bukualamat.php?sid=$sid&lid=$lid",$tcontent);

		$tcontent = eregi_replace("<!--%UM_SID%-->",$sid,$tcontent);
		$tcontent = eregi_replace("<!--%UM_OPT%-->","add",$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_ID%-->","N",$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_NAME%-->","",$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_EMAIL%-->","",$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_STREET%-->","",$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_CITY%-->","",$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_STATE%-->","",$tcontent);
		$tcontent = eregi_replace("<!--%UM_ADDR_WORK%-->","",$tcontent);

		break;
		
	// default is list
	default:

		$tcontent = read_file($address_list_template);

		$tcontent = eregi_replace("<!--%UM_NEW_CONT%-->","bukualamat.php?opt=new&sid=$sid&lid=$lid",$tcontent);
		$startpos = strpos($tcontent,"<!--%UM_LOOP_BEGIN%-->");
		$endpos = strpos($tcontent,"<!--%UM_LOOP_END%-->")+21;
		$cleanline = substr($tcontent,$startpos+22,$endpos-$startpos-43);

		for($i=0;$i<count($addressbook);$i++) {
			$thisline = $cleanline;
			$thisline = eregi_replace("<!--%UM_VIEW_LINK%-->","bukualamat.php?opt=display&id=$i&sid=$sid&lid=$lid",$thisline);
			$thisline = eregi_replace("<!--%UM_NOME%-->",htmlspecialchars($addressbook[$i]["name"]),$thisline);
			$thisline = eregi_replace("<!--%UM_COMPOSE_LINK%-->","kirimsurat.php?nameto=".htmlspecialchars($addressbook[$i]["name"])."&mailto=".htmlspecialchars($addressbook[$i]["email"])."&sid=$sid&lid=$lid",$thisline);
			$thisline = eregi_replace("<!--%UM_EMAIL%-->",htmlspecialchars($addressbook[$i]["email"]),$thisline);
			$thisline = eregi_replace("<!--%UM_EDIT_LINK%-->","bukualamat.php?opt=edit&id=$i&sid=$sid&lid=$lid",$thisline);
			$thisline = eregi_replace("<!--%UM_DEL_LINK%-->","bukualamat.php?opt=dele&id=$i&sid=$sid&lid=$lid",$thisline);
			$buffer .= $thisline;
		}

		$tcontent = substr($tcontent,0,$startpos).$buffer.substr($tcontent,$endpos);

}
$jssource = "
<script language=\"JavaScript\">
function goinbox() { location = 'daftarsurat.php?folder=inbox&sid=$sid&lid=$lid'; }
function newmsg() { location = 'kirimsurat.php?pag=$pag&folder=".urlencode($folder)."&sid=$sid&lid=$lid'; }
function refreshlist() { location = 'bukualamat.php?sid=$sid&lid=$lid' }
function folderlist() { location = 'almarisurat.php?folder=".urlencode($folder)."&sid=$sid&lid=$lid'}
function search() { location = 'pencarian.php?sid=$sid&lid=$lid'; }
function addresses() { location = 'bukualamat.php?sid=$sid&lid=$lid'; }
function emptytrash() {	location = 'almarisurat.php?empty=trash&folder=".urlencode($folder)."&goback=true&sid=$sid&lid=$lid';}
function goend() { location = 'logout.php?sid=$sid&lid=$lid'; }
function prefs() { location = 'konfigurasi.php?sid=$sid&lid=$lid'; }
</script>
";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";


$tcontent = eregi_replace("<!--%UM_LID%-->",$lid,$tcontent);
$tcontent = eregi_replace("<!--%UM_JS%-->",$jssource,$tcontent);
echo($tcontent);
?>
