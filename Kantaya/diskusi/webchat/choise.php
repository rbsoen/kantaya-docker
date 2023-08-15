<?
/** 
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
<img src="img/choise.gif" alt="">
<br><br><br>
<form action="#" method="post">
<table  cellspacing="1" cellpadding="5" border="0" bgcolor="#5566FF" summary="" width="500">
<tr><td align=center valign=center bgcolor="#AABBFF"><br><br>
<?
    $q = new DB_Chat;
    # some cleaning in old users ..
    # delete users without password and with timestamp < now-120
    $tstamp-=120;
    $que="delete from user where (pass is null or pass='') and last<".$tstamp."";
    $q->query($que);

    #todo select only ACTIVE users, not all registred (timestamp > now+120)
    $q->query("select room.*, count(user.rid) as users from room
    left join user on user.rid=room.rid group by room.rid order by room.rid");
                if($q->nf()==0) {
    				?> <font face="Verdana" size="-1" color="white"><b>
<? echo MSG_001; ?><br>
                    </b></font> <?
                } else {
				    while($q->next_record()) {
?>
				<table summary="" border="0" bgcolor="#5566FF" cellspacing="1" cellpadding="0"  width="320">
				<tr><td bgcolor="#5566FF">
				<table summary="" border="0" cellspacing="0" cellpadding="4"  width="320">
				<tr><td bgcolor="#5566BB" colspan=2>
    				<font face="Verdana" size="-1" color="white">
						<b><? $q->p('name'); ?></b>
    				</font>
				</td></tr>
				<tr>
				<td bgcolor="#EEEEFF" width=40>
				<? if ($q->f('typ')=='P')  {?>
						<img src="img/pass.gif" alt=""><br>
				<? } ?>
				&nbsp;		
				</td><td bgcolor="white" width="280">
    				<font face="Verdana" size="-1" color="#5566ff">
						<? $q->p('descript'); ?><br>
						Users: <? $q->p('users'); ?>
    				</font>
				</td></tr>
				<tr><td bgcolor="#EEEEFF" width="40">&nbsp;</td><td bgcolor="white" align="right" width="280">
    				<font face="Verdana" size="-1" color="#5566ff">
						<a href="login.php?rid=<? $q->p('rid'); ?>"><? echo MSG_002; ?></a>
    				</font>
				</td></tr></table>
				</td></tr></table>
				<br>
<? } } ?> 
				<br><br>
</td></tr>
</table>
</form>
<br>
<? copyright() ?>
</body>
</html>

