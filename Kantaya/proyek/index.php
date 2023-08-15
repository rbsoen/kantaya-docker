<?php
/******************************************
Nama File : index.php
Fungsi    : Mengatur frame utama modul
            Proyek.
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 5-11-2001
 Oleh     : AS
 Revisi   : Pengaturan frame otomatis
            sesuai layar.
******************************************/
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
 document.writeln("<title>Proyek</title>");    
 if (screen.width==800) {        
   document.writeln("<frameset rows='30%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
	 document.writeln("<frame src='../lib/kepala.php' name='judul' scrolling='No' noresize>");
   document.writeln("<frameset rows='13%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
   document.writeln("<frame src='frame_submenu.php' name='main' scrolling='No' noresize>");
   document.writeln("<frameset cols='30%,*' frameborder='1' border='1' framespacing='1'>");
	 document.writeln("<frame src='navigasi.php' name='navigasi' noresize>");
   document.writeln("<frame src='list_proyek.php' name='isi'>");
   document.writeln("</frameset>");
   document.writeln("</frameset>");
   document.writeln("</frameset>");
 } else {        
   document.writeln("<frameset rows='23%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
	 document.writeln("<frame src='../lib/kepala.php' name='judul' scrolling='No' noresize>");
   document.writeln("<frameset rows='10%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
   document.writeln("<frame src='frame_submenu.php' name='main' scrolling='No' noresize>");
   document.writeln("<frameset cols='30%,*' frameborder='1' border='1' framespacing='1'>");
	 document.writeln("<frame src='navigasi.php' name='navigasi' noresize>");
   document.writeln("<frame src='list_proyek.php' name='isi'>");
   document.writeln("</frameset>");
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