<?php

include ('../lib/cek_sesi.inc');
require("../lib/kantaya_cfg.php");
$css = "../../../css/".$tampilan_css.".css";


?>
<html>

<head>
 <?php
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
 ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Baca Surat</title>
<base target="isi_surat">
</head>

<body bgcolor="#E6E6E6">
<table cellspacing=0 cellpadding=0 width="142" border=0 bgcolor=#CCCCCC>
  <tr>
    <td bgcolor="#006699" class="judul1" onclick="mClk(this);" width="142">
      <p align="center"><b><font color="#FFFFFF" size="2" face="Verdana">Menu
        Web Surat</font></b>
    </td>
  </tr>
  <tr> 
    <td bgcolor="#E6E6E6"  width="142"><font face="Verdana" size="2">&nbsp; <a href="javascript:parent.isi_surat.goinbox()">Baca 
      Surat</a></font></td>
  </tr>
  <tr> 
    <td bgcolor="#E6E6E6" onclick="mClk(this);" width="142"><font face="Verdana" size="2">&nbsp; 
      <a href="javascript:refreshlist()">Refresh</a></font></td>
  </tr>
  <tr> 
    <td bgcolor="#E6E6E6" onclick="mClk(this);" width="142"><font face="Verdana" size="2">&nbsp; 
      <a href="javascript:parent.isi_surat.newmsg()">Kirim Surat</a></font></td>
  </tr>
  <tr> 
    <td bgcolor="#E6E6E6" onclick="mClk(this);" width="142"><font face="Verdana" size="2">&nbsp; 
      <a href="javascript:parent.isi_surat.folderlist()">Almari Surat</a></font></td>
  </tr>
  <tr> 
    <td bgcolor="#E6E6E6" onclick="mClk(this);" width="142"><font face="Verdana" size="2">&nbsp; 
      <a href="javascript:parent.isi_surat.search()">Pencarian</a></font></td>
  </tr>
  <tr> 
    <td bgcolor="#E6E6E6" onclick="mClk(this);" width="142"><font face="Verdana" size="2">&nbsp; 
      <a href="javascript:parent.isi_surat.addresses()">Alamat</a></font></td>
  </tr>
  <tr>
    <td bgcolor="#E6E6E6" width="142"><font face="Verdana" size="2">&nbsp;
      <a href="javascript:parent.isi_surat.prefs()">Konfigurasi</a></font></td>
  </tr>
  <tr> 
    <td bgcolor="#E6E6E6" width="142"><font face="Verdana" size="2">&nbsp;
      <a href="javascript:parent.isi_surat.goend()">Keluar</a></font></td>
  </tr>
</table>		
</body>

</html>
