<?
/** 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 

$WEBCHATPATH = '../';
require('../defines.php'); 
$q   = new DB_Chat;
$que = "delete from session where time<(".time()."-600)";
$q->query($que);
$que = "select * from session where uid=1 and skey='$client_key' and ip='$REMOTE_ADDR'";
$q->query($que);
if ($q->next_record()) {

  # update sesssion time
  $que = "update session set time = null where uid=1 and skey='$client_key' and ip='$REMOTE_ADDR'";
  $q->query($que);

  if ($action==MSG_108) {
    $que = "update room set name='$name', descript='$descript', typ='$typ' where rid=$rid";
    $q->query($que);
  } else if ($action==MSG_109) {
    $que = "select count(uid) as total_u from user where rid=$rid";
    $q->query($que);
    $q->next_record();
    if ($q->f("total_u") ==0) {
      $que = "delete from room where rid=$rid";
      $q->query($que);
    } else {
      $errormsg=MSG_113;	
    }
  } else if ($action==MSG_105) {
    $que = "insert into room values (null, '$name', '$descript', '$typ', 1)";
    $q->query($que);
  } else if ($action==MSG_114) {
    $que = "delete from session where uid='1' and skey='$client_key' and ip='$REMOTE_ADDR'";
    $q->query($que);
    setcookie("client_key","");
    Header("Location: ../");
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
<table cellspacing="1" cellpadding="5" border="0" bgcolor="#5566FF" width="95%">
<tr>
  <td bgcolor="#AABBFF" align="left" colspan="5">
  <br><img src="../img/logo.gif" align="left" border="0" hspace="20">
  <font face="Georgia,Helvetica,Arial" size="+3" color="#000000">
	<i><? echo MSG_101 ?></i>
  </font><br><br>
  </td>
</tr>

<tr>
  <td bgcolor="#FFFFFF" align="left" colspan="5">
  <font face="Helvetica,Arial" size="+1" color="#000000">
  <br><b><? echo MSG_104 ?></b>
  </font>
  </td>
</tr>

<tr>
  <td bgcolor="#5566BB" align="left" colspan="5" height="20">
  <font face="Helvetica,Arial" size="-1" color="#FFFFFF">
  <? echo $errormsg; ?>&nbsp;
  </font>
  </td>
</tr>

<?
 $que="select room.*, count(user.rid) as users from room
    left join user on user.rid=room.rid group by room.rid order by room.rid";
 $q->query($que);
 while ($q->next_record()) {
?>
<form name="frm_<? $q->p('rid') ?>" action="admin2.php" method="post">
<tr>
  <td bgcolor="#EEEEFF" align="left">
  <input type=hidden name="rid" value="<? $q->p('rid')?>">
  <input name="name" value="<? $q->p('name'); ?>" size="15"></td>
  <td bgcolor="#FFFFFF" align="left">
  <?$q->p('users'); ?> online</td>
  <td bgcolor="#FFFFFF" align="left">
  <input name="descript" value="<? $q->p('descript'); ?>" size="40"></td>
  <td bgcolor="#FFFFFF" align="left">
  <select name="typ" >
    <option value="N" <? if ($q->f('typ')=='N') echo 'selected'; ?>><? echo MSG_106; ?></option>
    <option value="P" <? if ($q->f('typ')=='P') echo 'selected'; ?>><? echo MSG_107; ?></option>
  </select></td>
  <td bgcolor="#FFFFFF" align="left">
    <input type="submit" name="action" value="<? echo MSG_108; ?>">
    <input type="submit" name="action" value="<? echo MSG_109; ?>"></td>
</tr>
</form>
<?
 }
?>

<form name="frm_add" action="admin2.php" method="post">
<tr>
  <td bgcolor="#EEEEFF" align="left">
  <input name="name" value="" size="15"></td>
  <td bgcolor="#FFFFFF" align="left">
   &nbsp;</td>
  <td bgcolor="#FFFFFF" align="left">
  <input name="descript" value="" size="40"></td>
  <td bgcolor="#FFFFFF" align="left">
  <select name="typ">
    <option value="N"><? echo MSG_106; ?></option>
    <option value="P"><? echo MSG_107; ?></option>
  </select></td>
  <td bgcolor="#FFFFFF" align="left">
  <input type="submit" name="action" value="<? echo MSG_105 ?>">
  </td>
</tr>
</form>

<form action="admin2.php" method="post">
<tr>
  <td bgcolor="#EEEEFF" align="left">
   &nbsp;</td>
  <td bgcolor="#FFFFFF" align="left">
   &nbsp;</td>
  <td bgcolor="#FFFFFF" align="left">
   &nbsp;</td>
  <td bgcolor="#FFFFFF" align="left">
   &nbsp;</td>
  <td bgcolor="#FFFFFF" align="left">
   <input type="submit" name="action" value="<? echo MSG_114; ?>">
  </td>
</tr>
</form>

<tr>
  <td bgcolor="#FFFFFF" align="left" colspan="5">
  &nbsp;<? echo MSG_200; ?>
  </td>
</tr>
</table>
</center>
</body>
</html>
<? 
} else {
  Header("Location: ./");
}
?>
