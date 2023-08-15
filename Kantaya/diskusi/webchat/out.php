<?
/* 
 * @author  Daniel Toma <dt@dnt.ro>
 * @version $Id$ 
 */ 
?>

<html>
<style>
<!--
BODY {
  font-family: Verdana, sans-serif;
  color: #000055;
  font-size: 12px;
  font-weight: normal;
}
-->
</style>
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
        smile  = newImage("img/smile.gif");
        normal = newImage("img/normal.gif");
        sad    = newImage("img/sad.gif");
		preloadFlag = true;
	}
}
</script>
<body bgcolor="#FFFFFF" onLoad="preloadImages()">
