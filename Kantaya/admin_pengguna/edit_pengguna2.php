<?php

//Dibuat oleh: KB
//Fungsi: Edit Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$sql=mysql_query("SELECT * 
     from pengguna 
     where kode_pengguna='$kode_pengguna1'");
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
<?php
if ($data) {
?>

  <center>
  <form method="post" action="edit_pengguna3.php">
  <table border="0" cellpadding="4" width="458" cellspacing="1">
    <tr>
      <td width="374" colspan="2" class="judul1"><font color="#FFFF00" size="3" face="Verdana"><b>Edit
        Pengguna</b></font></td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Nama
        Pengguna</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="nama" size="25" value='<?php echo $data[2]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Nomer
        Induk Pengguna</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="nip" size="15" value='<?php echo $data[1]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font><i>username</i></font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <?php echo $data[4]; ?>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font><i>password</i></font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="password" name="password" size="10"><br>
          <font size="-1">(biarkan kosong untuk password sama dengan yang lama)</font>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana"><font color="#ff0000">*</font>Level</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <select size="1" name="level_p">
           <?php
            if ($data[3]=="1"){
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
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Email</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="email_p" size="25" value='<?php echo $data[6]; ?>'>
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
        <?php

        if ($row=mysql_fetch_array($result)) {

           do {

             if ($row[0]==$data[7]){
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
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Telepon
        Kantor</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="telp_k" size="15" value='<?php echo $data[8]; ?>'
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Telepon
        Rumah</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="telp_r" size="15" value='<?php echo $data[9]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Handphone</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="hp" size="15" value='<?php echo $data[10]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Fax</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="fax" size="15" value='<?php echo $data[11]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="432" bgcolor="#EFEFEF" valign="top" colspan="2"><font size="2" face="Verdana">Alamat
        Kantor</font></td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Jalan</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="jalan" size="25" value='<?php echo $data[12]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Kota</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="kota" size="20" value='<?php echo $data[13]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Kode
        Pos</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="kodepos" size="5" value='<?php echo $data[14]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Propinsi</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="propinsi" size="25" value='<?php echo $data[15]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Negara</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
          <input type="text" name="negara" size="15" value='<?php echo $data[16]; ?>'>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF" valign="top"><font size="2" face="Verdana">Keterangan</font></td>
      <td width="274" bgcolor="#EFEFEF" valign="top">
        <textarea rows="3" name="keterangan" cols="30"><?php echo $data[21]; ?></textarea>
        <br>
        <font size="1" face="Verdana" color="#000000">(maksimum 120 karakter)</font>
      </td>
    </tr>
    <tr>
      <td width="158" bgcolor="#EFEFEF">&nbsp;</td>
      <td width="274" bgcolor="#EFEFEF">
        <input type="submit" value="Simpan" name="B1">
      </td>
    </tr>
  </table>
  <input type="hidden" name="kode_pengguna1" value="<?php echo $data[0] ?>">
  <input type="hidden" name="username" value="<?php echo $data[4] ?>">
  </form>
  </center>

<?php  
}

else {
  echo "Ada kesalahan pengambilan data di MySQL !<p>";
  echo mysql_error();
  }

?>
</div>

</body>

</html>
