<?
// get a list of messages in a especified folder (file.eml)
if(strlen($f_user) > 0 && strlen($f_pass) > 0) {
	if($allow_user_change) {
		if($lng != "") $lid = $lng;
		else { $lid = $default_language; }
	} else
		$lid = $default_language;
}

function build_local_list($folder) {
	$md = new mime_decode();
	$i = 0;
	$msglist = Array();
	$d = dir($folder);
	$dirsize = 0;
	while($entry=$d->read()) {
		$fullpath = "$folder/$entry";
		if(	is_file($fullpath)) {
			$thisheader = get_headers_from_file($fullpath);
			$mail_info = $md->get_mail_info($thisheader);
			$decoded_headers = $md->decode_header($thisheader);
			$msglist[$i]["id"] = $i+1;
			$msglist[$i]["msg"] = $i;
			$msglist[$i]["size"] = filesize($fullpath);
			$msglist[$i]["date"] = $mail_info["date"];
			$msglist[$i]["subject"] = $mail_info["subject"];
			$msglist[$i]["message-id"] = $mail_info["message-id"];
			$msglist[$i]["from"] = $mail_info["from"];
			$msglist[$i]["to"] = $mail_info["to"];
			$msglist[$i]["cc"] = $mail_info["cc"];
			$msglist[$i]["headers"] = $header;
			$msglist[$i]["attach"] = (eregi("(multipart/mixed|multipart/related|application)",$mail_info["content-type"]))?1:0;
			$msglist[$i]["localname"] = $fullpath;
			$msglist[$i]["read"] = ($decoded_headers["status"] == "N")?0:1;
			$i++;
		}
	}
	$d->close();

	return $msglist;
}

function get_usage_graphic($used,$aval) {
	if($used >= $aval) {
		$redsize = 100;
		$graph = "<img src=images/red.gif height=10 width=$redsize>";
	} elseif($used == 0) {
		$greesize = 100;
		$graph = "<img src=images/green.gif height=10 width=$greesize>";
	} else  {
		$usedperc = $used*100/$aval;
		$redsize = ceil($usedperc);
		$greesize = ceil(100-$redsize);
		$red = "<img src=images/red.gif height=10 width=$redsize>";
		$green = "<img src=images/green.gif height=10 width=$greesize>";
		$graph = $red.$green;
	}
	return $graph;
}


function get_total_used_size() {
	global $userfolder;
	$d = dir($userfolder);
	$totalused = 0;
	while($entry=$d->read()) {
		$this = $userfolder.$entry;
		if(is_dir($this) && 
			$entry != ".." && 
			substr($entry,0,1) != "_" && 
			$entry != ".") {
			$totalused += get_folder_size($entry);
		}
	}
	return $totalused;
}


function get_folder_size($folder) {
	global $sess,$userfolder;
	$dirsize = 0;
	if ($folder == "inbox") {
		$thisbox = $sess["headers"];
		for($i=0;$i<count($thisbox);$i++)
			$dirsize += $thisbox[$i]["size"];
	} else { 
		$dir = $userfolder.$folder;
		$d = dir($dir);
		while($entry=$d->read()) {
			$fullpath = "$dir/$entry";
			if(	is_file($fullpath))
				$dirsize += filesize($fullpath);
		}
		$d->close();
		unset($d);
	}
	//echo($folder . " " . $dirsize."<br>");
	return $dirsize;
}

// remove dirs recursivelly
function RmdirR($location) { 
	if (substr($location,-1) <> "/") $location = $location."/";
	$all=opendir($location); 
	while ($file=readdir($all)) { 
		if (is_dir($location.$file) && $file <> ".." && $file <> ".") { 
			RmdirR($location.$file); 
			unset($file); 
		} elseif (!is_dir($location.$file)) { 
			unlink($location.$file); 
			unset($file); 
		}
	}
	closedir($all); 
	unset($all);
	rmdir($location); 
}


// sort an multidimension array
function array_qsort2 (&$array, $column=0, $order="ASC", $first=0, $last= -2) { 
	if($last == -2) $last = count($array) - 1; 
	if($last > $first) { 
		$alpha = $first; 
		$omega = $last; 
		$guess = $array[$alpha][$column]; 
		while($omega >= $alpha) { 
			if($order == "ASC") { 
				while(strtolower($array[$alpha][$column]) < strtolower($guess)) $alpha++; 
				while(strtolower($array[$omega][$column]) > strtolower($guess)) $omega--; 
			} else {
				while(strtolower($array[$alpha][$column]) > strtolower($guess)) $alpha++; 
				while(strtolower($array[$omega][$column]) < strtolower($guess)) $omega--; 
			} 
			if(strtolower($alpha) > strtolower($omega)) break; 
			$temporary = $array[$alpha]; 
			$array[$alpha++] = $array[$omega]; 
			$array[$omega--] = $temporary; 
		} 
		array_qsort2 ($array, $column, $order, $first, $omega); 
		array_qsort2 ($array, $column, $order, $alpha, $last); 
	} 
} 

// load session info
function load_session() {
	global $temporary_directory,$sid;
	$sessionfile = $temporary_directory."_sessions/$sid.usf";
	$result      = Array();
	if(file_exists($sessionfile)) {
		$result = file($sessionfile);
		$result = join("",$result);
		$result = unserialize(~$result);
	}
	return $result;
}

// save session info
function save_session($array2save) {
	global $temporary_directory,$sid;
	$content = ~serialize($array2save);
	if(!is_writable($temporary_directory)) die("<h3>The folder \"$temporary_directory\" do not exists or the webserver don't have permissions to write</h3>");
	$sessiondir = $temporary_directory."_sessions/";
	if(!file_exists($sessiondir)) mkdir($sessiondir,0777);
	$f = fopen("$sessiondir$sid.usf","wb+") or die("<h3>Could not open session file</h3>");
	fwrite($f,$content);
	fclose($f);
	return 1;
}

function get_tags($begin,$end,$template) {
	$beglen = strlen($begin);
	$endlen = strlen($end);
	$beginpos = strpos($template,$begin);
	$endpos = strpos($template,$end);
	$result["ab-begin"] = $beginpos;
	$result["ab-end"]   = $endpos+$endlen;
	$result["re-begin"] = $beginpos+$beglen;
	$result["re-end"]   = $endpos;
	$result["ab-content"] = substr($template,$beginpos,($endpos+$endlen)-$beginpos);
	$result["re-content"] = substr($template,$beginpos+$beglen,$endpos-$beginpos-$beglen);
	unset($beglen,$endlen,$beginpos,$endpos,$begin,$end,$template);
	return $result;
}


// delete an session (logout)
function delete_session() {
	global $temporary_directory,$sid;
	$sessionfile = $temporary_directory."_sessions/$sid.usf";
	return @unlink($sessionfile);
}

// load settings
function load_prefs() {
	global $userfolder,$sess,$send_to_trash_default,$st_only_ready_default,
	$empty_trash_default,$save_to_sent_default,$sortby_default,$sortorder_default,
	$rpp_default,$add_signature_default,$signature_default;

	$pref_file = $userfolder."_infos/prefs.upf";
	if(!file_exists($pref_file)) {
		$prefs["real-name"]     = UCFirst(substr($sess["email"],0,strpos($sess["email"],"@")));
		$prefs["reply-to"]      = $sess["email"];
		$prefs["save-to-trash"] = $send_to_trash_default;
		$prefs["st-only-read"]  = $st_only_ready_default;
		$prefs["empty-trash"]   = $empty_trash_default;
		$prefs["save-to-sent"]  = $save_to_sent_default;
		$prefs["sort-by"]       = $sortby_default;
		$prefs["sort-order"]    = $sortorder_default;
		$prefs["rpp"]           = $rpp_default;
		$prefs["add-sig"]       = $add_signature_default;
		$prefs["signature"]     = $signature_default;
	} else {
		$prefs = file($pref_file);
		$prefs = join("",$prefs);
		$prefs = unserialize(~$prefs);
	}
	return $prefs;
}

//save preferences
function save_prefs($prefarray) {
	global $userfolder;
	$pref_file = $userfolder."_infos/prefs.upf";
	$f = fopen($pref_file,"wb+");
	fwrite($f,~serialize($prefarray));
	fclose($f);
}

//read an especified file
function read_file($strfile) {
	if($strfile == "" || !file_exists($strfile)) return;
	$thisfile = file($strfile);
	while(list($line,$value) = each($thisfile)) {
		$value = ereg_replace("(\r|\n)","",$value);
		$result .= "$value\r\n";
	}
	return $result;
}

//get only headers from a file
function get_headers_from_file($strfile) {
	if(!file_exists($strfile)) return;
	$f = fopen($strfile,"r");
	while(!feof($f)) {
		$result .= ereg_replace("\n","",fread($f,100));
		$pos = strpos($result,"\r\r");
		if(!($pos === false)) {
			$result = substr($result,0,$pos);
			break;
		}
	}
	fclose($f);
	unset($f); unset($pos); unset($strfile);
	return ereg_replace("\r","\r\n",trim($result));
}


function save_file($fname,$fcontent) {
	if($fname == "") return;
	$tmpfile = fopen($fname,"wb+");
	fwrite($tmpfile,$fcontent);
	fclose($tmpfile);
	unset($tmpfile,$fname,$fcontent);
}


if(!is_numeric($lid) || $lid >= count($languages)) $lid = $default_language;

$lngpath = $languages[$lid]["path"];

/********************************************************
System messages
********************************************************/
$language_file = "$lngpath/language.txt";

/********************************************************
Templates
********************************************************/
$message_list_template     = "$lngpath/daftarsurat.htm";
$read_message_template     = "$lngpath/bacasurat.htm";
$folder_list_template      = "$lngpath/almarisurat.htm";
$search_template           = "$lngpath/search.htm";
$login_template            = "$lngpath/login.htm";
$bad_login_template        = "$lngpath/salahlogin.htm";
$error_template            = "$lngpath/kesalahan.htm";
$newmsg_template           = "$lngpath/kirimsurat.htm";
$newmsg_result_template    = "$lngpath/hasilkirim.htm";
$attach_window_template    = "$lngpath/upload-attach.htm";
$quick_address_template    = "$lngpath/alamatsingkat.htm";
$address_form_template     = "$lngpath/formalamat.htm";
$address_display_template  = "$lngpath/tampilalamat.htm";
$address_list_template     = "$lngpath/daftaralamat.htm";
$address_results_template  = "$lngpath/hasilalamat.htm";
$headers_window_template   = "$lngpath/kepalajendela.htm";
$preferences_template      = "$lngpath/konfigurasi.htm";
$adv_editor_template       = "$lngpath/advanced-editor.htm";
$catch_address_template    = "$lngpath/ambilalamat.htm";

$lg = file($language_file);
while(list($line,$value) = each($lg)) {
	if(strpos(";#",$value[0]) === false && ($pos = strpos($value,"=")) != 0 && trim($value) != "") {
		$varname  = trim(substr($value,0,$pos));
		$varvalue = trim(substr($value,$pos+1));
		${$varname} = $varvalue;
	}
}


?>
