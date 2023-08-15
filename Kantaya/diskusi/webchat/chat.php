<?
/** 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 
?>

<html>
<head>
<title>WebChat</title>
</head>

<frameset cols="100,*" border="0">
	<frame name="wUsers" src="users.php" frameborder=0 scrolling="no">
	<frameset rows="100,*,50" border="0"> 
		<frameset cols="*,*" border="0">
			<frame name="wReceive" src="receive.php" frameborder=0>
			<frame name="wSend" src="send.php" frameborder=0>
		</frameset>
		<frame name="wOut" src="out.php" frameborder=0>
		<frame name="wIn" src="in.php" frameborder=0 scrolling="no">
	</frameset>
</frameset>
</html>
