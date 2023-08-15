<? 
/* 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 

    include "./defines.php"; 
    $q = new DB_Chat;

    # some cleaning in old users ..
    # delete users without password and with timestamp < now-120
    $tstamp= doubleval(date("YmdHis"));
    $tstamp-=120;
    $q->query("delete from user where (pass is null or pass='') and last<".$tstamp);

    $q->query("select uid,name,last from user where rid=".$rid." and last>".$tstamp);
?>
    

<html>
<head>
  <title>Users</title>
  <link rel="stylesheet" href="main.css">
<SCRIPT LANGUAGE="JavaScript">
<!--

function newImage(arg) {
	if (document.images) {
		rslt = new Image();
		rslt.src = arg;
		return rslt;
	}
}

function changeImages() {
	if (document.images && (preloadFlag == true)) {
		for (var i=0; i<changeImages.arguments.length; i+=2) {
			document[changeImages.arguments[i]].src = changeImages.arguments[i+1];
		}
	}
}

var preloadFlag = false;
function preloadImages() {
	if (document.images) {
        user1 = newImage("img/u1.gif");
        user2 = newImage("img/u2.gif");
		preloadFlag = true;
	}
}

function setFocus() {
  if (document.all) {
    top.wIn.document.all['form1'].txt.focus(); 
  } else {
    top.wIn.document.form1.txt.focus();
  }
}

function sendMessage(name) {
  if (document.all) {
    top.wIn.document.all['form1'].txt.value="/msg "+name+' '; 
  } else {
    top.wIn.document.form1.txt.value="/msg "+name+' ';
  }
  setFocus();
}

// -->
</SCRIPT>

</head>
<body bgcolor=#EEEEEE marginwidth="0" marginheight="0" leftmargin="0" topmargin="0" background="img/bg.gif" onLoad="preloadImages()">
<font face="Verdana,sans-serif" size="-1" color="darkblue">
<a href="users.php">
 <img src="img/users.gif" border="0"></a><br>
<small><nobr>
<?
    while( $q->next_record() ) {
        $name=$q->f("name");
        ?> 
        <a href="javascript:sendMessage('<? $q->p("name") ?>')" 
		    onMouseOver="document.images['im<? $q->p("uid") ?>'].src='img/u2.gif'"
                    onMouseOut ="document.images['im<? $q->p("uid") ?>'].src='img/u1.gif'">
        <img src='img/u1.gif' alt='<? echo $name ?>' name='im<? $q->p("uid") ?>' border='0'><?
        if ( strlen($name) > 12 )
            $name=substr($name,0,11)."..";
        echo $name."</a><br>";
    }
?>
        
</nobr></small>
</font>
</body>
</html>
