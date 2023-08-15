<?php

///////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Menambah Grup (Form Input)
//////////////////////////////////////////

include ("../lib/cek_sesi.inc");
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Tambah Grup</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>
<div align="center">
  <center>
  <form method="post" action="tambah_grup2.php">
  <table border="0" cellpadding="4" width="400" cellspacing="1">
    <tr>
      <td width="374" colspan="2" class="judul1">Tambah Grup</td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Nama Grup</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="nama_grup" size="35">
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Sifat Grup</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <select name="sifat_grup">
            <option value="">Pilih satu
            <option value="Bebas">Bebas
            <option value="Eksklusif">Eksklusif
          </select>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Keterangan</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
        <textarea rows="3" name="keterangan" cols="30"></textarea>
        <br>
        <font size="1" face="Verdana" color="#000000">(maksimum 120 karakter)</font>
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
</div>

</body>

</html>
