<?php

//Dibuat oleh: KB
//Fungsi: Menambah Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Tambah Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>

<div align="center">
  <center>
  <form method="post" action="tambah_pengguna2.php">
  <table border="0" cellpadding="4" width="458" cellspacing="1">
    <tr>
      <td width="374" colspan="2" class="judul1">Tambah Pengguna</td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Nama
        Pengguna</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="nama" size="25">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Nomer
        Induk Pengguna</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="nip" size="15">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font><i>username</i></font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="username" size="10">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font><i>password</i></font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="password" name="password" size="10">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Level</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <select size="1" name="level_p">
        <option value="1">Administrator</option>
            <option selected value="2">Pengguna</option>
        &nbsp; </select>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Email</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="email_p" size="25">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Unit
        Kerja</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
        <?php
        $sql="SELECT 
              kode_unit, 
              nama_unit 
              FROM unit_kerja 
              ORDER BY nama_unit";
         $result = mysql_query($sql);
         ?>

        <select size="1" name="unit_kerja">
        <option value="" selected>Pilih Satu</option>
        <?php

        if ($row=mysql_fetch_array($result)) {
           do {
	     print "<option value=";
	     print $row[0];
	     print ">";
	     print $row[1];
	     print "</option>\n";
	    } 
 
           while ($row=mysql_fetch_array($result));
	     print "\n</select>";
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
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Telepon
        Kantor</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="telp_k" size="15">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Telepon
        Rumah</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="telp_r" size="15">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Handphone</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="hp" size="15">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Fax</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="fax" size="15">
      </td>
    </tr>
    <tr>
      <td width="432" bgcolor="#EFEFEF" valign="top" colspan="2"><font size="2" face="Verdana">Alamat
        Kantor</font></td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Jalan</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="jalan" size="25">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Kota</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="kota" size="20">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Kode
        Pos</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="kodepos" size="5">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Propinsi</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="propinsi" size="25">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Negara</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="negara" size="15" value="Indonesia">
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Keterangan</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
        <textarea rows="3" name="keterangan" cols="30"></textarea>
        <br>
        <font size="1" face="Verdana" color="#000000">(maksimum 255 karakter)</font>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF">&nbsp;</td>
      <td width="274" bgcolor="#EFEFEF">
        <input type="submit" value="Simpan" name="B1">
      </td>
    </tr>
  </table>
  </form>
  </center>
</div>

</body>

</html>