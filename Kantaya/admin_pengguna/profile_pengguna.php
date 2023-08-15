<?php

//Dibuat oleh: KB
//Fungsi: Edit Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);
?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Profile Pengguna</title>
</head>

<body>
<?php

$sql="SELECT * FROM pengguna WHERE kode_pengguna = '$kode_pengguna1'";
$result = mysql_query($sql);
if ($data=mysql_fetch_array($result)) {
?>

<table border="0" cellpadding="4" width="458" cellspacing="1">
    <tr>
      <td width="374" colspan="2" bgcolor="#000080"><font color="#FFFF00" size="3" face="Verdana"><b>Profile 
        Pengguna</b></font></td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Nama
        Pengguna</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[2]; ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Nomer
        Induk Pengguna</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[1]; ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Email</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[6]; ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Unit
        Kerja</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
        <?php
        $sql="SELECT nama_unit 
              from pengguna, unit_kerja 
              where pengguna.kode_pengguna='$kode_pengguna1' and pengguna.unit_kerja=unit_kerja.kode_unit";
        $result = mysql_query($sql);
        if ($unit=mysql_fetch_array($result)) {     
          echo $unit[0];
          }
        ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Telepon
        Kantor</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[8]; ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Telepon
        Rumah</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[9]; ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Handphone</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[10]; ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Fax</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[11]; ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Alamat
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php 
            echo "$data[12] ";
            echo "$data[13] ";
            echo "$data[14], ";
            echo "$data[15], ";
            echo "$data[16]";
          ?>
      </td>
    </tr>
  </table>
<p>
<center>
<input type="button" value="Tutup" onClick="javascript:window.close()">
</center>
<?php
}
?>

</html>