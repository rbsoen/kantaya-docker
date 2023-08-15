<?
include("pengaturan_session.php");

include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";

echo($nocache);
if($tipo == "send") {
	$tcontent = read_file($newmsg_result_template);
	include("class_smtp.php");

	$md = new mime_decode();
	
	$ARTo = $md->get_names(stripslashes($to));
	$ARCc = $md->get_names(stripslashes($cc));
	$ARBcc = $md->get_names(stripslashes($bcc));

	if((count($ARTo)+count($ARCc)+count($ARBcc)) > 0) {
		$mail = new phpmailer;
		// for password authenticated servers

		if($use_password_for_smtp) {
			$user = ($use_email_as_user_smtp)?$sess["email"]:$sess["user"];
			$mail->UseAuthLogin($user,$sess["pass"]);
		}
		// if using the advanced editor

		if($is_html == "true")  {
			$mail->IsHTML(1);
			if($footer != "") {
				$footer = ereg_replace("\n","",$footer); $footer = ereg_replace("\r","<br>\r\n",$footer);
				$body .= $footer;
			}
		} elseif ($footer != "") $body .= $footer;

		$mail->From = $sess["email"];
		$mail->FromName = $md->mime_encode_headers($real_name);
		$mail->AddReplyTo($reply_to, $md->mime_encode_headers($real_name));
		$mail->Host = $smtp_server;
		$mail->WordWrap = 76;

		if(count($ARTo) != 0) {
			for($i=0;$i<count($ARTo);$i++) {
				$name = $ARTo[$i]["name"];
				$email = $ARTo[$i]["mail"];
				if($name != $email)
					$mail->AddAddress($email,$md->mime_encode_headers($name));
				else
					$mail->AddAddress($email);
			}
		}

		if(count($ARCc) != 0) {
			for($i=0;$i<count($ARCc);$i++) {
				$name = $ARCc[$i]["name"];
				$email = $ARCc[$i]["mail"];
				if($name != $email)
					$mail->AddCC($email,$md->mime_encode_headers($name));
				else
					$mail->AddCC($email);
			}
		}

		if(count($ARBcc) != 0) {
			for($i=0;$i<count($ARBcc);$i++) {
				$name = $ARBcc[$i]["name"];
				$email = $ARBcc[$i]["mail"];
				if($name != $email)
					$mail->AddBCC($email,$md->mime_encode_headers($name));
				else
					$mail->AddBCC($email);
			}
		}

		if(is_array($attachs = $sess["attachments"])) {
			for($i=0;$i<count($attachs);$i++) {
				if(file_exists($attachs[$i]["localname"])) {
					$mail->AddAttachment($attachs[$i]["localname"], $attachs[$i]["name"], $attachs[$i]["type"]);
				}
			}
		}

		$mail->Subject = $md->mime_encode_headers(stripslashes($subject));
		$mail->Body = stripslashes($body);

		$sucstartpos = strpos($tcontent,"<!--%UM_SUCESS_BEGIN%-->");
		$sucendpos = strpos($tcontent,"<!--%UM_SUCESS_END%-->")+22;

		$failstartpos = strpos($tcontent,"<!--%UM_FAIL_BEGIN%-->");
		$failendpos = strpos($tcontent,"<!--%UM_FAIL_END%-->")+20;


		if(($resultmail = $mail->Send()) === false) {

			$err = $mail->ErrorAlerts[count($mail->ErrorAlerts)-1];
			$tcontent = substr($tcontent,0,$sucstartpos).substr($tcontent,$failstartpos+22,$failendpos-$failstartpos-42).substr($tcontent,$failendpos);
			$tcontent = eregi_replace("<!--%UM_ERR%-->",$err,$tcontent);

		} else {
			if(is_array($attachs = $sess["attachments"])) {
				for($i=0;$i<count($attachs);$i++) {
					if(file_exists($attachs[$i]["localname"])) {
						@unlink($attachs[$i]["localname"]);
					}
				}
				
				unset($sess["attachments"]);
				reset($sess);
				save_session($sess);
			}
			$tcontent = substr($tcontent,0,$sucstartpos).substr($tcontent,$sucstartpos+24,$sucendpos-$sucstartpos-46).substr($tcontent,$failendpos);

			if($save_to_sent) {
				$struc = $md->fetch_structure($resultmail);
				$header = $struc["header"];
				$mail_info = $md->get_mail_info($header);
				$flocalname = $userfolder."sent/".md5($mail_info["subject"].$mail_info["message-id"].$mail_info["date"]).".eml";
				$myfile = fopen($flocalname,"wb+");
				fwrite($myfile,$resultmail);
				fclose($myfile);
			}

		}

	} else die("<script language=\"javascript\">location = 'kesalahan.php?msg=".urlencode($error_no_recipients)."&sid=$sid&lid=$lid';</script>");

	$jssource = "
	<script language=\"javascript\">
	function newmsg() { location = 'kirimsurat.php?pag=$pag&folder=".urlencode($folder)."&sid=$sid&lid=$lid'; }
	function folderlist() { location = 'almarisurat.php?folder=".urlencode($folder)."&sid=$sid&lid=$lid'}
	function goend() { location = 'logout.php?sid=$sid&lid=$lid'; }
	function goinbox() { location = 'daftarsurat.php?folder=inbox&sid=$sid&lid=$lid'; }
	function emptytrash() {	location = 'almarisurat.php?empty=trash&folder=".urlencode($folder)."&goback=true&sid=$sid&lid=$lid';}
	function search() {	location = 'pencarian.php?folder=".urlencode($folder)."&sid=$sid&lid=$lid';}
	function addresses() { location = 'bukualamat.php?sid=$sid&lid=$lid'; }
	function prefs() { location = 'konfigurasi.php?sid=$sid&lid=$lid'; }
	</script>
	";
    echo "<link rel=stylesheet type='text/css' href='$css'>\n";
    
	$tcontent = eregi_replace("<!--%UM_SID%-->",$sid,$tcontent);
	$tcontent = eregi_replace("<!--%UM_LID%-->",$lid,$tcontent);
	$tcontent = eregi_replace("<!--%UM_JS%-->",$jssource,$tcontent);
	echo($tcontent);

}else {
	$uagent = $HTTP_SERVER_VARS["HTTP_USER_AGENT"];
	$uagent = explode("; ",$uagent);
	$uagent = explode(" ",$uagent[1]);
	$bname = strtoupper($uagent[0]);
	$bvers = $uagent[1];
	$show_advanced = (($bname == "MSIE") && (intval($bvers) >= 5) && (!$textmode) )?1:0;
	//$show_advanced = 0;
	$js_advanced = ($show_advanced)?"true":"false";

	if($show_advanced) $signature = nl2br($signature);

	$tcontent = read_file($newmsg_template);

	$tcontent = eregi_replace("<!--%UM_IS_HTML%-->",$js_advanced,$tcontent);
	$tcontent = eregi_replace("<!--%UM_TEXTMODE%-->",$textmode,$tcontent);

	$jssource = "
	<script language=\"javascript\">
	bIs_html = $js_advanced;
	function addsig() {
		with(document.composeForm) {
			if(cksig.checked) {
				if(bIs_html) {
					cur = GetHtml()
					SetHtml(cur+'<br><br>--<br>'+sig.value);
				} else
					body.value += '\\r\\n\\r\\n--\\r\\n'+sig.value;
			}
		}
	}

	function upwin(rem) { 
		mywin = 'upload.php';
		if (rem != null) mywin += '?rem='+rem+'&sid=$sid';
		else mywin += '?sid=$sid&lid=$lid';
		window.open(mywin,'Upload','width=300,height=50,scrollbars=0,menubar=0,status=0'); 
	}

	function doupload() {
		if(bIs_html) document.composeForm.body.value = GetHtml();
		document.composeForm.tipo.value = 'edit';
		document.composeForm.submit();
	}
	function textmode() {
		with(document.composeForm) {
			if(bIs_html) body.value = GetText();
			textmode.value = 1;
			tipo.value = 'edit';
			submit();
		}
	}

	function enviar() {
		error_msg = new Array();
		frm = document.composeForm;
		check_mail(frm.to.value);
		check_mail(frm.cc.value);
		check_mail(frm.bcc.value);
		errors = error_msg.length;

		if(frm.to.value == '' && frm.cc.value == '' && frm.bcc.value == '')
			alert('$error_no_recipients');

		else if (errors > 0) {

			if (errors == 1) errmsg = '$error_compose_invalid_mail1_s\\r\\r';
			else  errmsg = '$error_compose_invalid_mail1_p\\r\\r';

			for(i=0;i<errors;i++)
				errmsg += error_msg[i]+'\\r';

			if (errors == 1) errmsg += '\\r$error_compose_invalid_mail2_s';
			else  errmsg += '\\r$error_compose_invalid_mail2_p';

			alert(errmsg)
	
		} else {
			if(bIs_html) frm.body.value = GetHtml();
			frm.tipo.value = 'send';
			frm.submit();
		}
	}
	
	function newmsg() { location = 'kirimsurat.php?pag=$pag&folder=".urlencode($folder)."&sid=$sid&lid=$lid'; }
	function folderlist() { location = 'almarisurat.php?folder=".urlencode($folder)."&sid=$sid&lid=$lid'}
	function goend() { location = 'logout.php?sid=$sid&lid=$lid'; }
	function goinbox() { location = 'daftarsurat.php?folder=inbox&sid=$sid&lid=$lid'; }
	function emptytrash() {	location = 'almarisurat.php?empty=trash&folder=".urlencode($folder)."&goback=true&sid=$sid&lid=$lid';}
	function search() {	location = 'pencarian.php?folder=".urlencode($folder)."&sid=$sid&lid=$lid';}
	function addrpopup() {	mywin = window.open('quick_address.php?sid=$sid&lid=$lid','AddressBook','width=480,height=220,top=200,left=200'); }
	function addresses() { location = 'bukualamat.php?sid=$sid&lid=$lid'; }
	function prefs() { location = 'konfigurasi.php?sid=$sid&lid=$lid'; }
	function AddAddress(strType,strAddress) {
		obj = eval('document.composeForm.'+strType);
		if(obj.value == '') obj.value = strAddress
		else  obj.value = obj.value + ', ' + strAddress
	}
	
	function check_mail(strmail) {
		if(strmail == '') return;
		chartosplit = ',;';
		protectchar = '\"';
		temp = '';
		armail = new Array();
		inthechar = false; 
		lt = '<';
		gt = '>'; 
		isclosed = true;
	
		for(i=0;i<strmail.length;i++) {
			thischar = strmail.charAt(i);
			if(thischar == lt && isclosed) isclosed = false;
			if(thischar == gt && !isclosed) isclosed = true;
			if(thischar == protectchar) inthechar = (inthechar)?0:1;
			if(chartosplit.indexOf(thischar) != -1 && !inthechar && isclosed) {
				armail[armail.length] = temp; temp = '';
			} else temp += thischar;
		}
	
		armail[armail.length] = temp; 
	
		for(i=0;i<armail.length;i++) {
			thismail = armail[i]; strPat = /(.*)<(.*)>/;
			matchArray = thismail.match(strPat); 
			if (matchArray != null) strEmail = matchArray[2];
			else {
				strPat = /([-a-z0-9_$+.]+@[-a-z0-9_.]+[-a-z0-9_]+)((.*))/; matchArray = thismail.match(strPat); 
				if (matchArray != null) strEmail = matchArray[1];
				else strEmail = thismail;
			}
			if(strEmail.charAt(0) == '\"' && strEmail.charAt(strEmail.length-1) == '\"') strEmail = strEmail.substring(1,strEmail.length-1)
			if(strEmail.charAt(0) == '<' && strEmail.charAt(strEmail.length-1) == '>') strEmail = strEmail.substring(1,strEmail.length-1)
	
			strPat = /([-a-z0-9_$+.]+@[-a-z0-9_.]+[-a-z0-9_]+)((.*))/;
			matchArray = strEmail.match(strPat); 
			if(matchArray == null)
				error_msg[error_msg.length] = strEmail;
		}
	}
	
	
	</script>
	";
	echo "<link rel=stylesheet type='text/css' href='$css'>\n";
 
	$tcontent = eregi_replace("<!--%UM_JS%-->",$jssource,$tcontent);
	$tcontent = eregi_replace("<!--%UM_SID%-->",$sid,$tcontent);
	$tcontent = eregi_replace("<!--%UM_LID%-->",$lid,$tcontent);
	$body = stripslashes($body);
	switch($rtype) {
	case "reply":
		$to = $toreply;
		if($show_advanced) $body = nl2br($body);
		if($add_sig) 
			if($show_advanced) $body = "<br><br>--<br>$signature<br><br>$body";
			else $body = "\r\n\r\n--\r\n$signature\r\n\r\n$body";
		break;
	case "replyall":
		$to = $toallreply;
		$cc = $ccaalreply;
		if($show_advanced) $body = nl2br($body);
		if($add_sig) 
			if($show_advanced) $body = "<br><br>--<br>$signature<br><br>$body";
			else $body = "\r\n\r\n--\r\n$signature\r\n\r\n$body";
		break;
	case "forward":
		$sessiontype = ($folder == "inbox")?"headers":"folderheaders";
		$mail_info = $sess[$sessiontype][$ix];
		$localname = $mail_info["localname"];
		if(file_exists($localname)) {

			if(!is_array($sess["attachments"])) $ind = 0;
			else $ind = count($sess["attachments"]);

			$filename = $userfolder."_attachments/".basename($localname);
		    copy($localname, $filename);

			$sess["attachments"][$ind]["localname"] = $filename;
			$sess["attachments"][$ind]["name"] = substr(ereg_replace("[^A-Za-z0-9]","_",$mail_info["subject"]),0,20).".eml";
			$sess["attachments"][$ind]["type"] = "message/rfc822";
			$sess["attachments"][$ind]["size"] = filesize($filename);
			save_session($sess);

		}
		if($show_advanced) $body = nl2br($body);
		if($add_sig) 
			if($show_advanced) $body = "<br><br>--<br>$signature<br><br>$body";
			else $body = "\r\n\r\n--\r\n$signature\r\n\r\n$body";
		break;
	default:
		if($add_sig && $body == "") 
			if($show_advanced) $body = "<br><br>--<br>$signature";
			else $body = "\r\n\r\n--\r\n$signature";
		break;
	}

	$nameto = htmlspecialchars($nameto);
	$mailto = htmlspecialchars($mailto);
	
	$strto = (isset($nameto) && eregi("([-a-z0-9_$+.]+@[-a-z0-9_.]+[-a-z0-9_])",$mailto))?
	"<input class=formfield type=text size=35 name=to value=\"".htmlspecialchars(stripslashes($nameto))." <".htmlspecialchars(stripslashes($mailto)).">\">
	":"<input class=formfield type=text size=35 name=to value=\"".htmlspecialchars(stripslashes($to))."\">";
	
	$strcc = "<input class=formfield type=text size=35 name=cc value=\"".htmlspecialchars(stripslashes($cc))."\">";
	$strbcc = "<input class=formfield type=text size=35 name=bcc value=\"".htmlspecialchars(stripslashes($bcc))."\">";
	$strsubject = "<input class=formfield type=text size=35 name=subject value=\"".htmlspecialchars(stripslashes($subject))."\">";
	
	$attbegin = strpos($tcontent,"<!--%UM_ATTACH_BEGIN%-->");
	$attend = strpos($tcontent,"<!--%UM_ATTACH_END%-->")+22;
	
	$noattbegin = strpos($tcontent,"<!--%UM_NO_ATTACH_BEGIN%-->");
	$noattend = strpos($tcontent,"<!--%UM_NO_ATTACH_END%-->")+25;
	
	
	if(is_array($attachs = $sess["attachments"]) && count($sess["attachments"]) != 0) {
		$cleantext = substr($tcontent,$attbegin+24,$attend-$attbegin-46);
	
		$loopbegin = strpos($cleantext,"<!--%UM_AT_LOOP_BEGIN%-->");
		$loopend = strpos($cleantext,"<!--%UM_AT_LOOP_END%-->")+23;
		
		$cleanline = substr($cleantext,$loopbegin+25,$loopend-$loopbegin-48);

		for($i=0;$i<count($attachs);$i++) {
			$thisline = $cleanline;
			$thisline = eregi_replace("<!--%UM_AT_NAME%-->",htmlspecialchars($attachs[$i]["name"]),$thisline);
			$thisline = eregi_replace("<!--%UM_AT_SIZE%-->",ceil($attachs[$i]["size"]/1024)."Kb",$thisline);
			$thisline = eregi_replace("<!--%UM_AT_TYPE%-->",$attachs[$i]["type"],$thisline);
			$thisline = eregi_replace("<!--%UM_AT_DEL%-->","javascript:upwin($i)",$thisline);
			$loopresult .= $thisline;
		}
		
		$result = substr($cleantext,0,$loopbegin).$loopresult.substr($cleantext,$loopend);
		$tcontent = substr($tcontent,0,$attbegin).$result.substr($tcontent,$noattend);
	} else { 
		$cleantext = substr($tcontent,$noattbegin+27,$noattend-$noattbegin-52);
		$tcontent = substr($tcontent,0,$attbegin).$cleantext.substr($tcontent,$noattend);
	}
	if($show_advanced) {
		$editor = read_file($adv_editor_template);
		$txtarea = $editor."\r<input type=hidden name=body>";

	echo("<div id=\"hiddenCompose\" style=\"position: absolute; left: 3; top: -100; visibility: visible; z-index: 3\">	      
		<form name=\"hiddencomposeForm\">
		<textarea name=\"hiddencomposeFormTextArea\">$body</textarea>
		</form>
		</div>");

	} else {
		$txtarea = "<textarea cols=50 rows=15 name=body>".htmlspecialchars(stripslashes($body))."</textarea>";
	}
	
	$tcontent = eregi_replace("<!--%UM_SIG%-->",$signature,$tcontent);
	$tcontent = eregi_replace("<!--%UM_TO%-->",$strto,$tcontent);
	$tcontent = eregi_replace("<!--%UM_CC%-->",$strcc,$tcontent);
	$tcontent = eregi_replace("<!--%UM_BCC%-->",$strbcc,$tcontent);
	$tcontent = eregi_replace("<!--%UM_SUBJECT%-->",$strsubject,$tcontent);
	$tcontent = eregi_replace("<!--%UM_TEXT_EDITOR%-->",$txtarea,$tcontent);
	$tcontent = eregi_replace("<!--%UM_CURRENT_FOLDER%-->",htmlspecialchars($folder),$tcontent);

	echo($tcontent);

}

?>

