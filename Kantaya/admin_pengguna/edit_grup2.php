<?php

//Dibuat oleh: KB
//Fungsi: Edit Grup

include ('../lib/cek_sesi.inc');
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);
$sql=mysql_query("SELECT * FROM grup WHERE kode_grup = '$kode_grup'");
$data=mysql_fetch_array($sql);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>
<div align="center">
  <center>
  <form method="post" action="edit_grup3.php">
  <table border="0" cellpadding="4" width="400" cellspacing="1">
    <tr>
      <td width="374" colspan="2" class="judul1"><font color="#FFFF00" size="3" face="Verdana"><b>Edit
        Grup</b></font></td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Nama Grup</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <?php echo $data[1]; ?>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Sifat Grup</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <select name="sifat_grup">
            <?php
              if ($data[2]=="Bebas") {
            ?>
                <option value="Bebas" selected>Bebas
                <option value="Eksklusif">Eksklusif 
            <?php   
             }
              else {
            ?>
                <option value="Bebas">Bebas
                <option value="Eksklusif" selected>Eksklusif 
            <?php   
             }
             ?>
          </select>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Status</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <select name="status_grup">
            <?php
              if ($data[9]=="1") {
            ?>
                <option value="1" selected>Aktif
                <option value="0">Non Aktif 
            <?php   
             }
              else {
            ?>
                <option value="1">Aktif
                <option value="0" selected>Non Aktif
            <?php   
             }
             ?>
          </select>
      </td>
    </tr>   
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Keterangan</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
        <textarea rows="3" name="keterangan" cols="30"><?php echo $data[8]; ?></textarea>
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
  <input type="hidden" name="nama_grup" value="<?php echo $data[1]; ?>">
  <input type="hidden" name="kode_grup" value="<?php echo $kode_grup; ?>">
  </form>
  </center>
</div>

</body>

</html>
