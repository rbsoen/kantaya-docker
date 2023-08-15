<?php
include ('../lib/cek_sesi.inc');
?>
<html>
<head>
<script language='Javascript'>
function settingframe() {    
 document.open("text/html","index");       
 document.writeln("<title>Lemari - Folder</title>");    
 if (screen.width==800) {        
  document.writeln("<frameset rows='35%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
	document.writeln("<frame src='../lib/kepala.php' name='judul' >");
	document.writeln("<frameset cols='25%,*' frameborder='1' border='1' framespacing='1'>");
	document.writeln("<frame src='navigasi_ap.php' name='navigasi' noresize>");
	document.writeln("<frame src='isi_awal.php' name='isi'>");
	document.writeln("</frameset>");
	document.writeln("</frameset>");
 } else {        
  document.writeln("<frameset rows='25%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
	document.writeln("<frame src='../lib/kepala.php' name='judul' >");
	document.writeln("<frameset cols='25%,*' frameborder='1' border='1' framespacing='1'>");
	document.writeln("<frame src='navigasi_ap.php' name='navigasi' noresize>");
	document.writeln("<frame src='isi_awal.php' name='isi'>");
	document.writeln("</frameset>");
	document.writeln("</frameset>");
 }	    
 document.writeln("</head> ");    
 document.close();};
</script>
</head>

<body onLoad=settingframe()>
<b>Browser Anda harus mampu menampilkan FRAME !</b>
</body>
</html>