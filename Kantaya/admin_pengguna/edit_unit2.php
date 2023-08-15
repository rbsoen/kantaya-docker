<?php

////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Form Edit Unit Kerja
////////////////////////////////////

include ("../lib/cek_sesi.inc");
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$sql=mysql_query("SELECT * 
     from unit_kerja
     where kode_unit='$kode_unit'");
$data=mysql_fetch_array($sql);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Unit Kerja</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>
<div align="center">
  <center>
  <form method="post" action="edit_unit3.php">
  <table border="0" cellpadding="4" width="450" cellspacing="1">
    <tr>
      <td width="374" colspan="2" class="judul1"><font color="#FFFF00" size="3" face="Verdana"><b>Edit Unit Kerja</b></font></td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Kode Unit Kerja</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <?php echo $data['0'] ?>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Nama Unit Kerja</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="nama_unit" size="35" value="<?php echo $data[1]; ?>">
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Singkatan</font></td>
      <td width="254" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="singkatan" size="15" value="<?php echo $data[2]; ?>">
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
        <?php

        if ($row=mysql_fetch_array($result)) {
          do {
            if ($row[0]==$data[3]) {
              echo "<option value=";
	          echo $row[0];
	          echo " selected>";
	          echo $row[1];
	          echo "</option>\n";
	          }

            else {
   	          echo "<option value=";
	          echo $row[0];
	          echo ">";
	          echo $row[1];
	          echo "</option>\n";}
	          } 
 
          while ($row=mysql_fetch_array($result));
	      echo "<option value=''>Tidak ada Induknya</option>\n";
	      } 
        
        else {
          echo "Belum ada data Unit Kerja !\n";
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
  <input type="hidden" name="kode_unit" value="<?php echo $data[0]; ?>">
  </form>
  </center>
</div>
</body>
</html>