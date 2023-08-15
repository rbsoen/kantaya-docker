<?
/* 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 
?>

<html>
<head>
<script>
<!--
<?
    require './defines.php';
    $RCPT_ID = 0;
    
    $txt = htmlspecialchars(rawurldecode($txt));
    if ((isset($txt)) && ($txt !='')) {

    if (preg_match("/^\/(\w+)\s+([^\s]+)\s+(.+)/i", $txt, $parts) ||
	preg_match("/^\/(\w+)\s+([^\s]+)/i", $txt, $parts)) {

      #----------------------------------------------------
      if( $parts[1] == 'me'){
	$txt = $parts[2].' '.$parts[3];
	$RCPT_ID = -1;
      }

      #----------------------------------------------------
      if( $parts[1] == 'msg'){
	$txt = $parts[3];
	$r   = new DB_Chat;
        $que = "select uid from user where name='$parts[2]'";
        $r->query($que);
	if ($r->next_record()) {
		#recepient found
		$RCPT_ID = $r->f("uid");
	} else {
		#recept. not found
		$RCPT_ID = $uid;
		$txt = 'Recepient not found';
	}
      }

      #----------------------------------------------------
    }

    $txt = rawurlencode(addslashes($txt));
    $q   = new DB_Chat;
    $que = "insert into chat.message values 
            (null, $rid, $uid, $RCPT_ID,'$txt')";
    $q->query($que);

    }
?>
//-->
</script>
</head>
<body bgcolor="#FFFFFF">
<form name="form2" method="post" action="send.php">
<input type="hidden" name="txt">
</form>
</body>
</html>
