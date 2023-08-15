<?php
session_start();
include ('../lib/cek_sesi.inc');
?>
<html> 
<head> 
<title></title> 
<script language='Javascript'> 
function settingframe() {       
document.open("text/html","index");       
document.writeln("<html>");       
document.writeln("<head> ");       
document.writeln("<title>Kantaya - Agenda</title>");       
if (screen.width==800) {               
 document.writeln("<frameset rows='25%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>"); 
        document.writeln("<frame src='../lib/kepala.php' name='kepala' MARGINWIDTH=0  MARGINHEIGHT=0 >"); 
        document.writeln("<frameset cols='30%,*' frameborder='1' border='1' framespacing='0'>"); 
        document.writeln("<frame src='navigasi_agenda.php' name='navigasi' MARGINWIDTH=0  MARGINHEIGHT=0 noresize>"); 
        document.writeln("<frame src='agenda.php' name='isi' MARGINWIDTH=0  MARGINHEIGHT=0 >"); 
        document.writeln("</frameset>"); 
        document.writeln("</frameset>"); 
} else {               
 document.writeln("<frameset rows='20%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>"); 
        document.writeln("<frame src='../lib/kepala.php' name='kepala' MARGINWIDTH=0  MARGINHEIGHT=0 >");               
        document.writeln("<frameset cols='24%,*' frameborder='1' border='1' framespacing='0'>");               
        document.writeln("<frame src='navigasi_agenda.php' name='navigasi' MARGINWIDTH=0  MARGINHEIGHT=0 noresize>");               
        document.writeln("<frame src='agenda.php' name='isi' MARGINWIDTH=0  MARGINHEIGHT=0 >");               
        document.writeln("</frameset>");               
        document.writeln("</frameset>");       
}          
document.writeln("</html>");       
document.writeln("</head> ");       
document.close();}; 
</script> 
</head> 

<body onLoad=settingframe()> 
</body> 
</html> 

