<?
/** 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 

$WEBCHATPATH = '../';
require('../defines.php'); 
$q   = new DB_Chat;
$que = "delete from session where time<(".time()."-600)"; #session expires afret 10 min
$q->query($que);

$errormsg='';
if (isset($username) && isset($password)) {
  if (!isset($client_key)) {
     $errormsg = MSG_110;
  } else {
     $que = "select * from user where uid=1 and name='$username' and pass=password('$password')";
     $q->query($que);
     if (!$q->next_record()) {
        $errormsg = MSG_111;
     } else {
        $que = "select * from session where uid=1 and skey='$client_key' and ip='$REMOTE_ADDR'";
        $q->query($que);
        if ($q->next_record()) {
          include('admin1.php');
          exit;
        } else {
          $errormsg = MSG_112." $client_key";
        }
    }
  }
} else {
  if (!isset($client_key) || $client_key=='') {
    $server_key = md5($REMOTE_ADDR.time().rand());
    $que = "insert into session (uid,skey,ip) values (1,'$server_key','$REMOTE_ADDR')";
    $q->query($que);
    setcookie("client_key", $server_key);
  } 
}
?>

<html>
<head>
  <title>
	<? echo MSG_100 ?>
  </title>
  <script>
  <!--
  if (document.all) {
	document.write('<link rel="stylesheet" href="main.css">');
  }
  //-->
  </script>
</head>
<body bgcolor="#EEEEEE">
<center>
<form action="./" method="post">
<table cellspacing="1" cellpadding="5" border="0" bgcolor="#5566FF" width="95%">
<tr>
  <td bgcolor="#AABBFF" align="left" colspan="2">
  <br><img src="../img/logo.gif" align="left" border="0" hspace="20">
  <font face="Georgia,Helvetica,Arial" size="+3" color="#000000">
	<i><? echo MSG_101 ?></i>
  </font><br><br>
  </td>
</tr>

<tr>
  <td bgcolor="#FFFFFF" align="left" colspan="2">
  <font face="Helvetica,Arial" size="+1" color="#000000">
  <br><b><? echo MSG_102 ?></b>
  </font>
  </td>
</tr>

<tr>
  <td bgcolor="#5566BB" align="left" colspan="2" height="20">
  <font face="Helvetica,Arial" size="-1" color="#FFFFFF">
  <? echo $errormsg; ?>&nbsp;
  </font>
  </td>
</tr>

<tr>
  <td bgcolor="#EEEEFF" align="left">
  <b><? echo MSG_004 ?></b> 
  </td>
  <td bgcolor="#FFFFFF" align="left">
  <input type="text" name="username" value="<? echo $username; ?>">
  </td>
</tr>

<tr>
  <td bgcolor="#EEEEFF" align="left">
  <b><? echo MSG_005 ?></b> 
  </td>
  <td bgcolor="#FFFFFF" align="left">
  <input type="password" name="password">
  </td>
</tr>

<tr>
  <td bgcolor="#EEEEFF" align="left">
  &nbsp;
  </td>
  <td bgcolor="#FFFFFF" align="left">
  <input type="submit" value="<? echo MSG_102 ?>">
  </td>
</tr>

<tr>
  <td bgcolor="#FFFFFF" align="left" colspan="2">
  &nbsp;
  </td>
</tr>
</table>
</form>
</center>
</body>
</html>
