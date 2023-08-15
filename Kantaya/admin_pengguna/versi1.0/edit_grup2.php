<?php
include ('../lib/cek_sesi.inc');

mysql_connect (localhost, root);
mysql_select_db (kantaya);
$sql=mysql_query("SELECT * FROM grup WHERE kode_grup = '$kode_grup'");
$data=mysql_fetch_array($sql);
?>
<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Tambah Grup</title>
</head>

<body>
<div align="center">
  <center>
  <form method="post" action="edit_grup3.php">
  <table border="0" cellpadding="4" width="400" cellspacing="1">
    <tr>
      <td width="374" colspan="2" bgcolor="#000080"><font color="#FFFF00" size="3" face="Verdana"><b>Tambah
        Grup</b></font></td>
    </tr>
    <tr>
      <td width="120" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Nama Grup</font></td>
      <td width="254" bgcolor="#C0C0C0" valign="top">
          <?php echo $data[nama_grup] ?>
      </td>
    </tr>
    <tr>
      <td width="120" bgcolor="#C0C0C0" valign="top"><font size="2" face="Verdana">Sifat Grup</font></td>
      <td width="254" bgcolor="#C0C0C0" valign="top">
          <select name="sifat_grup">
            <?php
              if ($data[sifat_grup]=="Bebas") {
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
  <input type="hidden" name="nama_grup" value="<?php echo $data[nama_grup]; ?>">
  <input type="hidden" name="kode_grup" value="<?php echo $kode_grup; ?>">
  </form>
  </center>
</div>

</body>

</html>
