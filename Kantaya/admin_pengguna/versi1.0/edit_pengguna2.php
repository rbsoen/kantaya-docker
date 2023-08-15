<?php

//Dibuat oleh: KB
//Fungsi: Edit Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");

$sql=mysql_query("SELECT * 
     from pengguna 
     where kode_pengguna='$kode_pengguna1'");
$data=mysql_fetch_array($sql);
?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Tambah Pengguna</title>
</head>

<body>

<div align="center">
  <center>
  <form method="post" action="edit_pengguna3.php">
  <table border="0" cellpadding="4" width="458" cellspacing="1">
    <tr>
      <td width="374" colspan="2" bgcolor="#000080"><font color="#FFFF00" size="3" face="Verdana"><b>Edit
        Pengguna</b></font></td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Nama
        Pengguna</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="nama" size="25" value='<?php echo "$data[nama_pengguna]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Nomer
        Induk Pengguna</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="nip" size="15" value='<?php echo "$data[nip]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font><i>username</i></font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <?php echo "$data[username]" ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font><i>password</i></font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="password" name="password" size="10"><br>
          <font size="-1">(biarkan kosong untuk password sama dengan yang lama)</font>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Level</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <select size="1" name="level">
           <?php
            if ($data[level]=="1"){
              echo "<option value='1' selected>Administrator</option>";
              echo "<option value='2'>Pengguna</option>"; }
            else {
              echo "<option value='1'>Administrator</option>";
              echo "<option value='2' selected>Pengguna</option>"; }
           ?>

        &nbsp; </select>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Email</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="email_p" size="25" value='<?php echo "$data[email]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Unit
        Kerja</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">



        <?php

        $sql="SELECT 
              kode_unit, 
              nama_unit 
              FROM unit_kerja 
              ORDER BY nama_unit";
         $result = mysql_query($sql);
        ?>

        <select size="1" name="unit_kerja">
        <?php

        if ($row=mysql_fetch_array($result)) {

           do {

             if ($row[0]==$data[unit_kerja]){
             print "<option value=";
	     print $row[0];
	     print " selected>";
	     print $row[1];
	     print "</option>\n"; }	     

             else {

             print "<option value=";
	     print $row[0];
	     print ">";
	     print $row[1];
	     print "</option>\n"; }
	    } 
 
           while ($row=mysql_fetch_array($result));
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
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Telepon
        Kantor</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="telp_k" size="15" value='<?php echo "$data[telp_k]" ?>'
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Telepon
        Rumah</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="telp_r" size="15" value='<?php echo "$data[telp_r]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Handphone</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="hp" size="15" value='<?php echo "$data[hp]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Fax</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="fax" size="15" value='<?php echo "$data[fax]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="432" bgcolor="#C0C0C0" valign="top" colspan="2"><font size="2" face="Verdana">Alamat
        Kantor</font></td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Jalan</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="jalan" size="25" value='<?php echo "$data[alamat_k_jalan]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Kota</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="kota" size="20" value='<?php echo "$data[kota]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Kode
        Pos</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="kodepos" size="5" value='<?php echo "$data[kode_pos]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Propinsi</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="propinsi" size="25" value='<?php echo "$data[propinsi]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Negara</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
          <input type="text" name="negara" size="15" value='<?php echo "$data[negara]" ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Keterangan</font></td>
      <td width="274" bgcolor="#C0C0C0" valign="top">
        <textarea rows="3" name="keterangan" cols="30"><?php echo "$data[keterangan]" ?></textarea>
        <br>
        <font size="1" face="Verdana" color="#000000">(maksimum 255 karakter)</font>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#C0C0C0"></td>
      <td width="274" bgcolor="#C0C0C0">
        <input type="submit" value="Simpan" name="B1">
      </td>
    </tr>
  </table>
  <input type="hidden" name="kode_pengguna1" value="<?php echo $data[kode_pengguna] ?>">
  <input type="hidden" name="username" value="<?php echo $data[username] ?>">
  </form>
  </center>
</div>

</body>

</html>
