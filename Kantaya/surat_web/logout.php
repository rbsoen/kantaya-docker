<?
$ignoresession = true;
include("pengaturan_session.php");
if(is_array($sess["headers"]) && file_exists($userfolder)) {

	$inboxdir = $userfolder."inbox/";

	if(is_array($attachs = $sess["attachments"])) {
		for($i=0;$i<count($attachs);$i++) {
			if(file_exists($attachs[$i]["localname"])) @unlink($attachs[$i]["localname"]);
		}
	}
	$filelist = Array();
	if(is_array($headers = $sess["headers"])) {
		for($i=0;$i<count($headers);$i++) {
			$filelist[] = $headers[$i]["localname"];
		}
	}

	$d = dir("$inboxdir");

	while($entry=$d->read()) {
		if(!in_array($inboxdir.$entry,$filelist))
			@unlink($inboxdir.$entry);
	}

	$d->close();
	$att = $userfolder."_attachments/";
	$d = dir($att);
	while($entry=$d->read())
		@unlink($att.$entry);
	$d->close();
	if($empty_trash) {
		$trsh = $userfolder."trash/";
		$d = dir($trsh);
		while($entry=$d->read())
			@unlink($trsh.$entry);
		$d->close();
	}
}
delete_session();

header("Location: ./index1.php\r\n");
?> 
