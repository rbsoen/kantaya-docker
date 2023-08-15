<?
/** 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 

require './txt2html.php'; 

?>
<html>
<head>
  <title><? echo MSG_027 ?></title>
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
  <td bgcolor="#AABBFF" align="left" colspan="2">
  <br><img src="img/logo.gif" align="left" border="0" hspace="20">
  <font face="Georgia,Helvetica,Arial" size="+3" color="#000000">
	<i><? echo MSG_027 ?></i>
  </font><br>
  <font face="Helvetica,Arial" size="-1" color="#000000">
	<? include "./copyright.txt" ?>
  </font><br><br>
  </td>
</tr>

<tr>
  <td bgcolor="#FFFFFF" align="left" colspan="2">
  <font face="Helvetica,Arial" size="+1" color="#000000">
  <br><b><? echo MSG_017 ?></b>
  </font>
  </td>
</tr>

<tr>
  <td bgcolor="#5566BB" align="left">
  <font face="Helvetica,Arial" size="-1" color="#FFFFFF">
  <b><? echo MSG_018 ?></b>
  </font>
  </td>
  <td bgcolor="#5566BB" align="left">
  <font face="Helvetica,Arial" size="-1" color="#FFFFFF">
  <b><? echo MSG_019 ?></b>
  </font>
  </td>
</tr>

<tr>
  <td bgcolor="#EEEEFF" align="left">
  <b>/me</b> <? echo MSG_020 ?>
  </td>
  <td bgcolor="#FFFFFF" align="left">
  <? echo MSG_021 ?>
  </td>
</tr>

<tr>
  <td bgcolor="#EEEEFF" align="left">
  <b>/msg</b> <? echo MSG_022 ?>
  </td>
  <td bgcolor="#FFFFFF" align="left">
  <? echo MSG_023 ?>
  </td>
</tr>

<tr>
  <td bgcolor="#FFFFFF" align="left" colspan="2">
  <font face="Helvetica,Arial" size="+1" color="#000000">
  <br><b><? echo MSG_024 ?></b>
  </font>
  </td>
</tr>

<tr>
  <td bgcolor="#EEEEFF" align="left" colspan="2">
  <font face="Helvetica,Arial" size="-1" color="#000000">
  <?
    $readme = file("./readme.txt");
    $all_txt = implode($readme,"\n");
    echo txt2html($all_txt);
  ?>
  </font>
  </td>
</tr>

<tr>
  <td bgcolor="#FFFFFF" align="left" colspan="2">
  <font face="Helvetica,Arial" size="+1" color="#000000">
  <br><b><? echo MSG_025 ?></b>
  </font>
  </td>
</tr>

<tr>
  <td bgcolor="#EEEEFF" align="left" colspan="2">
  <font face="Helvetica,Arial" size="-1" color="#000000">
  GNU GENERAL PUBLIC LICENSE
  <br>
  <a href="license.txt"><i><? echo MSG_026 ?></i></a>
  </font>
  </td>
</tr>

</table>
</center>
</body>
</html>
