<?php
include ("../lib/cek_sesi.inc");
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

echo "<html>\n";
echo "<head>\n";
echo "<title>Upload Direktori Sharing</title>\n";
$css = "../css/" .$tampilan_css. ".css";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="49%" class="judul1">Lemari</td>
      <td width="10%" align="center" class="judul1"><a href="cari_file.php?kata_kunci=">Cari</a></td>
      <td width="10%" bgcolor="#000080" align="center" class="judul1"><a href="isi_direktori.php">Direktori</A></td>
      <td width="10%" align="center" class="judul1">Upload</td>
   </tr>
</table><p>

<table border="0" width="100%" cellpadding="2">
	<form enctype="multipart/form-data" method="post" action="upload2.php">
  <tr>
    <td width="100%" valign="top">
      <div align="center">
        <center>
        <table border="0" cellpadding="2" width="500">
          <tr>
            <td colspan="2" bgcolor="#000080" class="judul2">Upload File</td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Nama
              file &amp; lokasinya</font></td>
            <td valign="top" bgcolor="#EFEFEF">
                <input type="file" name="img1" size="30">
            </td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Letakkan
              di direktori</font></td>
            <td valign="top" bgcolor="#EFEFEF">
						    <select size="1" name="direktori">
								
								<?php
								$sql=mysql_query("SELECT kode_direktori, nama_direktori 
								     FROM direktori WHERE kode_direktori='$direktori'");
								
								if ($data=mysql_fetch_row($sql)) {
									  echo "<option value='$data[0]'>$data[1]</option>\n";
										}								
								
								else {								  
									echo mysql_error();
									}
															
								echo "</select>\n";
							
								?>	
              </td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Kata
              Kunci</font></td>
            <td valign="top" bgcolor="#EFEFEF">
                <input type="text" name="kata_kunci" size="30">
            </td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Catatan
              Perbaikan</font></td>
            <td valign="top" bgcolor="#EFEFEF">
                <input type="text" name="ctt_perbaikan" size="30">
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
                <input type="hidden" name="jenis" value="sharing">  
								<input type="hidden" name="pemilik" value="<?php echo $pemilik; ?>">
								          </td>
            <td bgcolor="#EFEFEF">
                <input type="submit" value="Upload !" name="B3">
            </td>
          </tr>
        </table>
        </center>
      </div>
      </form>
      <div align="center">
        <div align="left">
      <hr size="1">
      </div>
    </td>
  </tr>
</table>

</body>

</html>
