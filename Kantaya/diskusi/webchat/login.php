<?
/* 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<? include "./defines.php"; ?>

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
<form action="verify.php" method="post">
<input type="hidden" name="rid" value="<? echo $rid; ?>">
<table summary="" border="0" bgcolor="#5566FF" cellspacing="1" width="500">
<tr><td align=center valign=middle bgcolor="#5566BB">
<?
	$q = new DB_Chat;
	$q->query("select * from room where rid='$rid'");
	if ($q->next_record()) { 
?>
	<font face="Verdana" size="-1" color="#FFFFFF">
	<br>
	<b><? echo MSG_003; ?> <? $q->p('name'); ?></b>
	<br><br>
	</font>
</td></tr>
<tr><td align=center valign=center bgcolor="#EEEEFF">

	<table summary="" border="0" cellspacing="1" cellpadding="4"  width="60%">
	<tr><td colspan=2>
   		<font face="Verdana" size="-1" color="#111111">
			<br>
			<b><? $q->p('descript'); ?></b>
			<br><br>
   		</font>
	</td></tr>
	<tr><td>
   		<font face="Verdana" size="-1" color="#111111">
    		<b><? echo MSG_004; ?></b>
   		</font>
	</td>
	<td>
   		<font face="Verdana" size="-0" color="white">
   		<input type="text" name="user">
   		</font>
	</td></tr>
	<? if ($q->f('typ')=='P')  {?>
	<tr><td>
   		<font face="Verdana" size="-1" color="#111111">
   		<b><? echo MSG_005; ?></b>
   		</font>
	</td>
	<td>
   		<font face="Verdana" size="-0" color="white">
   		<input type="password" name="pass">
   		</font>
	</td></tr>
	<tr><td>&nbsp;</td>
	<td>
   		<font face="Verdana" size="-1" color="#111111"><b>
   		<input type="checkbox" checked name="remember_pass"> <? echo MSG_006; ?>
			</b>
   		</font>
	</td></tr>
	<? } ?>
	<tr><td>&nbsp;</td>
	<td>
   		<font face="Verdana" size="-1" color="white">
   		<input type="submit" value="Chat !">
   		</font>
	</td></tr>
	<? if ($q->f('typ')=='P')  {?>
	<tr><td colspan=2>
   		<font face="Verdana" size="-1" color="white">
			<br><img src="img/point.gif" alt="">
			<a href="#">
   		<b><? echo MSG_007; ?></b>
			</a>
			<br>
   		</font>
	</td></tr>
	<? } ?>
	<tr><td colspan=2>
   		<font face="Verdana" size="-1" color="white">
			<br><img src="img/point.gif" alt="">
			<a href="#">
   		<b><? echo MSG_008; ?></b>
			</a>
   		</font>
	</td></tr>
	<tr><td colspan=2>
   		<font face="Verdana" size="-1" color="white">
			<br><img src="img/point.gif" alt="">
			<a href="choise.php">
   		<b><? echo MSG_009; ?></b>
			</a>
			<br><br><br>
   		</font>
	</td></tr>
	</table>
<? 	 } else {  ?>
   			<br><img src="img/point.gif" alt="">
			<a href="choise.php">
   		<font face="Verdana" size="-1" color="white">
		<b><? echo MSG_010; ?></b>
		</font>
			</a>
			<br><br><br>
   		
<? 	 }  ?> 
</td></tr>
</table>
</form>
<br>
<? copyright() ?>
</body>
</html>
