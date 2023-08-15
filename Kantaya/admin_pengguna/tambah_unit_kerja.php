<?php

//////////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Form Tambah Unit Kerja
//////////////////////////////////////////////

include ('../lib/cek_sesi.inc');
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Tambah Unit Kerja</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>

<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Administrasi Pengguna</td>
   </tr>
</table><p>
  <center>
  <form method="post" action="tambah_unit_kerja2.php">
  <table border="0" cellpadding="4" width="450" cellspacing="1">
    <tr>
      <td width="374" colspan="2" class="judul2">Tambah Unit Kerja</td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Kode Unit Kerja</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="kode_unit" size="10" maxlength="10">
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Nama Unit Kerja</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="nama_unit" size="35">
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Singkatan</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="singkatan" size="15">
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Unit Kerja Induk</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
        <?php
        $sql="SELECT 
              kode_unit, 
              nama_unit 
              FROM unit_kerja 
              ORDER BY nama_unit";
         $result = mysql_query($sql);
         ?>

        <select size="1" name="induk_unit">
        <option value="" selected>Pilih Satu</option>
        <?php

        if ($row=mysql_fetch_array($result)) {
          do {
	        echo "<option value=";
	        echo $row[0];
	        echo ">";
	        echo $row[1];
	        echo "</option>\n";
	        } 
 
          while ($row=mysql_fetch_array($result));
	      echo "\n</select>";
	      } 
        
        else {            
          echo "Belum ada data Unit Kerja !";
          } 
        ?>
        </select>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Keterangan</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
        <textarea rows="3" name="keterangan" cols="30"></textarea>
        <br>
        <font size="1" face="Verdana" color="#000000">(maksimum 255 karakter)</font>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF">&nbsp;</td>
      <td width="254" bgcolor="#EFEFEF">
        <input type="submit" value="Simpan" name="B1">
      </td>
    </tr>
  </table>
  </form>
  </center>
<hr size="1">
</body>
</html>