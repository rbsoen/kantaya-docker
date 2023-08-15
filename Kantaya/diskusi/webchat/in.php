<?
/* 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 
?>

<html>
<head>
<title>In</title>
<style>
<!--
INPUT {
  border : #EEEEEE;	
  border-style : solid;	
  border-width : thin; 
  background-color: #FFFFFF; 
  color : #777777;	
  font : bolder;
}
-->
</style>
<script>
function doSubmit() {
  if (document.all) {
    top.wSend.document.all['form2'].txt.value=escape(document.all['form1'].txt.value);
    top.wSend.document.all['form2'].submit();
    document.all['form1'].txt.value='';
  } else {
    top.wSend.document.form2.txt.value=escape(document.form1.txt.value);
    top.wSend.document.form2.submit();
    document.form1.txt.value='';
  }

  return false;
}

function setFocus() {
  if (document.all) {
    document.all['form1'].txt.focus(); 
  } else {
    document.form1.txt.focus();
  }
}

</script>
</head>
<body bgcolor="#FFFFFF" onLoad="setFocus()">
<form action="#" name="form1" method=get onSubmit="return doSubmit();">
<input type="text" size="47" name="txt" >
<a href="javascript:void(doSubmit())"
	onMouseover="document.images['send'].src='img/send2.gif'"
	onMouseout ="document.images['send'].src='img/send1.gif'">
  <img src="img/send1.gif" name="send" border=0 align="top"></a>
</form>
</body>
</html>
