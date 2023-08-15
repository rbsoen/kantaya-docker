<?php
include ('../lib/cek_sesi.inc');

mysql_connect (localhost, root);
mysql_select_db (kantaya);

$sql=mysql_query("SELECT * 
     from unit_kerja
     where kode_unit='$kode_unit'");
$data=mysql_fetch_array($sql);
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Tambah Unit Kerja</title>
</head>

<body>
<div align="center">
  <center>
  <form method="post" action="edit_unit3.php">
  <table border="0" cellpadding="4" width="400" cellspacing="1">
    <tr>
      <td width="374" colspan="2" bgcolor="#000080"><font color="#FFFF00" size="3" face="Verdana"><b>Tambah
        Unit Kerja</b></font></td>
    </tr>
    <tr>
      <td width="120" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Kode Unit Kerja</font></td>
      <td width="254" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[kode_unit] ?>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Nama Unit Kerja</font></td>
      <td width="254" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="nama_unit" size="35" value="<?php echo $data[nama_unit] ?>">
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Singkatan</font></td>
      <td width="254" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="singkatan" size="15" value="<?php echo $data[singkatan_unit] ?>">
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Unit Kerja Induk</font></td>
      <td width="254" bgcolor="#C0C0C0" valign="top">
        <?php
        $sql="SELECT 
              kode_unit, 
              nama_unit 
              FROM unit_kerja 
              ORDER BY nama_unit";
         $result = mysql_query($sql);
         ?>

        <select size="1" name="induk_unit">
        <?php

        if ($row=mysql_fetch_array($result)) {
           do {

if ($row[0]==$data[induk_unit]) {
            print "<option value=";
	     print $row[0];
	     print " selected>";
	     print $row[1];
	     print "</option>\n";}

else {
	     print "<option value=";
	     print $row[0];
	     print ">";
	     print $row[1];
	     print "</option>\n";}
	    } 
 
           while ($row=mysql_fetch_array($result));
	     
          print "<option value=''>Tidak ada Induknya</option>\n";
	   } 
        
        else 
           {
             print "Belum ada data Unit Kerja !";
           } 

        ?>
        </select>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Keterangan</font></td>
      <td width="254" bgcolor="#C0C0C0" valign="top">
        <textarea rows="3" name="keterangan" cols="30"><?php echo $data[keterangan] ?></textarea>
        <br>
        <font size="1" face="Verdana" color="#000000">(maksimum 255 karakter)</font>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#C0C0C0"></td>
      <td width="254" bgcolor="#C0C0C0">
        <input type="submit" value="Simpan" name="B1">
      </td>
    </tr>
  </table>
  <input type="hidden" name="kode_unit" value="<?php echo $data[kode_unit] ?>">
  </form>
  </center>
</div>

</body>

</html>
