<?php
include ('../lib/cek_sesi.inc');
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>MEmbuat Direktori</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">URL Link</td>
   </tr>
</table><p>
<form method="post" action="direktori_baru2.php">
<table border="0" width="100%" cellpadding="2">    
  <tr>
    <td width="100%" valign="top">
      <div align="center">
        <center>
        <table border="0" cellpadding="2" width="500">
          <tr>
            <td class='judul2' colspan="2">Buat Direktori Baru</td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Nama direktori</font></td>
            <td valign="top" bgcolor="#EFEFEF">
                <input type="text" name="nama_direktori" size="30">
            </td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Direktori Induk</font></td>
            <td valign="top" bgcolor="#EFEFEF"><select name="direktori_induk">
                <?php
								if ($direktori){
								  $sql=mysql_query("SELECT kode_direktori, nama_direktori FROM direktori_url
									     WHERE kode_direktori='$direktori'");
									if ($data=mysql_fetch_row($sql)){
									  echo "<option value='$data[0]'>$data[1]</option>\n";
								    }
										
									else {
									  echo mysql_error();
										}
										
									}
									
								else {	
								  echo "<option value=''>Pilih Salah Satu</option><p>\n";																															
								  $sql=mysql_query("SELECT kode_direktori,
								             nama_direktori 
														 FROM direktori_url 
														 WHERE dibuat_oleh='$kode_pengguna' 
														 ORDER BY nama_direktori");
								
								  if ($data=mysql_fetch_array($sql)) {
									  do {
									    echo "<option value='$data[0]'>$data[1]</option>\n";
										  }								
								 	  while ($data=mysql_fetch_array($sql));
									  echo "<option value=''>Tidak Ada</option><p>\n";																	
									  }
								
								  else {								  
								    echo "<option value=''>Tidak Ada</option><p>\n";
									  echo mysql_error();
									  }
									
									}
									echo "</select>\n";
								?>								
            </td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Keterangan</font></td>
            <td valign="top" bgcolor="#EFEFEF">
                <textarea rows="2" name="keterangan" cols="30"></textarea>
            </td>
          </tr>

          <tr>
            <td bgcolor="#EFEFEF" align="center">
                &nbsp;
            </td>
            <td bgcolor="#EFEFEF">
                <input type="submit" value="Simpan" name="B3">
            </td>
          </tr>
        </table>
        </center>
      </div>
    </td>
  </tr>
</table>
</form>
<hr size="1">
</body>

</html>
