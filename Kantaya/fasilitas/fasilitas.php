<?php
/******************************************
Nama File : fasilitas.php
Fungsi    : Mengatur frame utama modul
            Pemesanan Fasilitas.
Dibuat    :	
 Tgl.     : 17-09-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/
?>


<html>
<head>
<title></title>
<script language='Javascript'>
function settingframe() {    
 document.open("text/html","index");    
 document.writeln("<html>");    
 document.writeln("<head> ");    
 document.writeln("<title>Pemesanan Fasilitas</title>");    
 if (screen.width==800) {        
  document.writeln("<frameset rows='33%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
	document.writeln("<frame src='../lib/kepala.php' name='judul' >");
	document.writeln("<frameset cols='30%,*' frameborder='1' border='1' framespacing='1'>");
	document.writeln("<frame src='navigasi_harian.php' name='navigasi' noresize>");
	document.writeln("<frame src='detail_hari_ini.php' name='isi'>");
	document.writeln("</frameset>");
	document.writeln("</frameset>");
 } else {        
  document.writeln("<frameset rows='23%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
	document.writeln("<frame src='../lib/kepala.php' name='judul' >");        
	document.writeln("<frameset cols='30%,*' frameborder='1' border='1' framespacing='1'>");        
	document.writeln("<frame src='navigasi_harian.php' name='navigasi' noresize>");        
	document.writeln("<frame src='detail_hari_ini.php' name='isi'>");        
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