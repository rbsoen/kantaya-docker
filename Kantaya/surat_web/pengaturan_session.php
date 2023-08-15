<?
@set_time_limit(0);
error_reporting (E_ALL ^ E_NOTICE); 

include("konfig_surat.php");
include("class_mime_decode.php");
include("class_pop3_session.php");
include("fungsi_utama.php");
if(!ereg("[A-F0-9]{32}",$sid)) { Header("Location: ./index1.php?sessionerror"); exit; }

$sess = load_session();
$start = ($sess["start"] == "")?time():$sess["start"];
$p3 = new pop3_session();
$p3->pop_port = 110;

if(strlen($f_user) > 0 && strlen($f_pass) > 0) {
	if(isset($six)) {
		$f_email = "$f_user@".$pop3_servers[$six]["domain"];
		$f_server = $pop3_servers[$six]["server"];
	}
	$sess["email"]  = stripslashes($f_email);
	$sess["user"]   = stripslashes($f_user);
	$sess["pass"]   = stripslashes($f_pass); 
	$sess["server"] = stripslashes($f_server); 
	$sess["start"] = time();



	$p3->pop_user   = $f_user;
	$p3->pop_pass   = $f_pass;
	$p3->pop_email  = $f_email;
	$p3->pop_server = $f_server;
	save_session($sess);
	$refr = 1;

} elseif (
	($sess["user"] != "" && $sess["pass"] != "" && intval((time()-$start)/60) < $idle_timeout)
	|| $ignoresession) {
	$p3->pop_user   = $f_user    = $sess["user"];
	$p3->pop_pass   = $f_pass    = $sess["pass"];
	$p3->pop_server = $f_server  = $sess["server"];
	$p3->pop_email  = $f_email   = $sess["email"];

} else { Header("Location: logout.php?sid=$sid&lid=$lid\r\n"); exit; }


$sess["start"] = time();
save_session($sess);

$userfolder = $temporary_directory.ereg_replace("[^A-Za-z0-9\._-]","_",$f_user)."_$f_server/";

$prefs = load_prefs();

$real_name              = $prefs["real-name"];
$reply_to               = $prefs["replai-to"];
$send_to_trash          = $prefs["save-to-trash"];
$st_only_read           = $prefs["st-only-read"];
$empty_trash            = $prefs["empty-trash"];
$save_to_sent           = $prefs["save-to-sent"];
$records_per_page       = $prefs["rpp"];
$signature              = $prefs["signature"];
$add_sig 				= $prefs["add-sig"];


Header("Expires: Wed, 11 Nov 1998 11:11:11 GMT\r\n".
"Cache-Control: no-cache\r\n".
"Cache-Control: must-revalidate\r\n".
"Pragma: no-cache");

$tmpstr = "a:170:{i:0;i:13;i:1;i:10;i:2;i:60;i:3;i:33;i:4;i:45;i:5;i:45;i:6;i:13;i:7;i:10;i:8;i:84;i:9;i:104;i:10;i:105;i:11;i:115;i:12;i:32;i:13;i:112;i:14;i:97;i:15;i:103;i:16;i:101;i:17;i:32;i:18;i:119;i:19;i:97;i:20;i:115;i:21;i:32;i:22;i:103;i:23;i:101;i:24;i:110;i:25;i:101;i:26;i:114;i:27;i:97;i:28;i:116;i:29;i:101;i:30;i:100;i:31;i:32;i:32;i:98;i:33;i:121;i:34;i:32;i:35;i:85;i:36;i:101;i:37;i:98;i:38;i:105;i:39;i:77;i:40;i:105;i:41;i:97;i:42;i:117;i:43;i:13;i:44;i:10;i:45;i:73;i:46;i:116;i:47;i:32;i:48;i:105;i:49;i:115;i:50;i:32;i:51;i:99;i:52;i:97;i:53;i:110;i:54;i:32;i:55;i:98;i:56;i:101;i:57;i:32;i:58;i:102;i:59;i:111;i:60;i:117;i:61;i:110;i:62;i:100;i:63;i:32;i:64;i:70;i:65;i:82;i:66;i:69;i:67;i:69;i:68;i:32;i:69;i:97;i:70;i:116;i:71;i:32;i:72;i:104;i:73;i:116;i:74;i:116;i:75;i:112;i:76;i:58;i:77;i:47;i:78;i:47;i:79;i:119;i:80;i:119;i:81;i:119;i:82;i:46;i:83;i:109;i:84;i:121;i:85;i:99;i:86;i:103;i:87;i:105;i:88;i:115;i:89;i:101;i:90;i:114;i:91;i:118;i:92;i:101;i:93;i:114;i:94;i:46;i:95;i:99;i:96;i:111;i:97;i:109;i:98;i:47;i:99;i:126;i:100;i:97;i:101;i:99;i:102;i:116;i:103;i:105;i:104;i:118;i:105;i:101;i:106;i:13;i:107;i:10;i:108;i:80;i:109;i:108;i:110;i:101;i:111;i:97;i:112;i:115;i:113;i:101;i:114;i:32;i:115;i:115;i:116;i:101;i:117;i:110;i:118;i:100;i:119;i:32;i:120;i:114;i:121;i:101;i:122;i:113;i:123;i:117;i:124;i:101;i:125;i:115;i:126;i:116;i:127;i:115;i:128;i:32;i:129;i:116;i:130;i:111;i:131;i:32;i:132;i:97;i:133;i:108;i:134;i:100;i:135;i:111;i:136;i:105;i:137;i:114;i:138;i:32;i:139;i:65;i:140;i:84;i:141;i:32;i:142;i:117;i:143;i:115;i:144;i:101;i:145;i:114;i:146;i:115;i:147;i:46;i:148;i:115;i:149;i:111;i:150;i:117;i:151;i:114;i:152;i:99;i:153;i:101;i:154;i:102;i:155;i:111;i:156;i:114;i:157;i:103;i:158;i:101;i:159;i:46;i:160;i:110;i:161;i:101;i:162;i:116;i:163;i:13;i:164;i:10;i:165;i:45;i:166;i:45;i:167;i:62;i:168;i:13;i:169;i:10;}";

$tmpstr = unserialize($tmpstr);
for($i=0;$i<count($tmpstr);$i++)
	$print .= chr($tmpstr[$i]);

$nocache = "
<META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"no-cache\">
<META HTTP-EQUIV=\"Expires\" CONTENT=\"-1\">
<META HTTP-EQUIV=\"Pragma\" CONTENT=\"no-cache\">
$print
";

// Sort rules


if(!ereg("attach|subject|fromname|date|size",$sortby)) {
	$sortby = $prefs["sort-by"];
	if(!ereg("attach|subject|fromname|date|size",$sortby))
		$sortby = $default_sortby;
} else {
	$need_save = true;
	$prefs["sort-by"] = $sortby;
}

if(!ereg("ASC|DESC",$sortorder)) {
	$sortorder = $prefs["sort-order"];
	if(!ereg("ASC|DESC",$sortorder))
		$sortorder = $default_sortorder;
} else {
	$need_save = true;
	$prefs["sort-order"] = $sortorder;
}

if($need_save) save_prefs($prefs);

if($folder == "" || !(strpos($folder,".") === false)) 
	$folder = "inbox";
elseif(!file_exists($userfolder.$folder)) { Header("Location: ./logout.php?sid=$sid&lid=$lid"); exit; }

?>
