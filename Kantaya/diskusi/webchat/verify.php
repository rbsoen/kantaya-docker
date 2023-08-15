<?
/** 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 

include "./defines.php"; 

$tstamp= doubleval(date("YmdHis"));
$q = new DB_Chat;
    if (!isset($user) || $user=='')				
        $err_message=MSG_011;
    else {
        $user = stripslashes($user);
	$user = eregi_replace(' ','_',$user);
        $err_message="";
        $q->query("select * from room where rid='$rid'");
        if ($q->next_record()) {
            $room_type = $q->f('typ'); 
            if ($room_type == 'P' && ( !isset($pass) || $pass=='' ))
                $err_message=MSG_012;
        }
        if ( isset($pass) ) {
            $que = sprintf("select * from user where user.name='%s' and user.pass=PASSWORD('%s')",
                            $user,
                            $pass);
            $q->query($que);
            $q->next_record();
            $lstamp = doubleval($q->f('last'));
            if ($q->nf()==0)
                $err_message=MSG_013;
			else if ( ($tstamp - $q->f('last')) < 120 )
                $err_message=MSG_014;
        } else {
            $que = sprintf("select * from user where user.name='%s' and user.rid='%s'",
                            $user,
                            $rid);
            $q->query($que);
            $q->next_record();
            $lstamp = doubleval($q->f('last'));
            if ( ($tstamp - $lstamp) < 120 )
                $err_message=MSG_014;
        }
    }

    # some cleaning in old users ..
    # delete users without password and with timestamp < now-120
    $tstamp-=120;
    $que="delete from user where (pass is null or pass='') and (last < $tstamp)";
    $q->query($que);

    if ( $err_message=='' ) {
        #if no error found, redirect to chat
        if ($room_type == 'P')
            $q->query("update user set last=null where rid='$rid' and name='$user'");
        else 
            $q->query("insert into user values (null,'$user',null,$rid,'')");
        
        $q->query("select uid from user where name='$user'");
        $q->next_record();
        setCookie("rid",$rid);
        setCookie("uid",$q->f('uid'));
	echo "<script>window.open('chat.php','','width=550,height=350');</script>";
        include('welcome.php');
    } else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
  <title>WebChat</title>
  <script>
  <!--
  if (document.all) {
	document.write('<link rel="stylesheet" href="main.css">');
  }
  //-->
  </script>
</head>
<body bgcolor="#EEEEEE" text="#000000" link="#5566ff" vlink="#5566ff">
<center>
<br>
<img src="img/login.gif" alt="">
<br><br><br>
<table summary="" border="0" bgcolor="#5566FF" cellspacing="1" width="500">
<tr><td align=center valign=center bgcolor="#5566BB">
        <font face="Verdana" size="-1" color="white">
        <br><b><? echo MSG_015; ?></b><br><br>
        </font>
</td></tr>
<tr><td align=center valign=center bgcolor="#EEEEFF">
    <table summary="" border="0" bgcolor="#EEEEFF" cellspacing="0" cellpadding="4"  width="60%">
    <tr><td colspan=2>
        <font face="Verdana" size="-1" color="white">
        <br><img src="img/point.gif" alt="">
        <a href="login.php?rid=<? echo $rid;  ?>">
        <b>
        <? echo $err_message; ?><br><br>
        <? echo MSG_016; ?>
        </b></a><br><br>
        </font>
    </td></tr>
    </table>
</td></tr>
</table>
<br>
<?  }  ?> 
<? copyright() ?>
</body>
</html>

