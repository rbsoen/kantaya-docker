<?php

//Dibuat oleh: KB
//Fungsi: Tambah URL

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

$css = "../css/" .$tampilan_css. ".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Url Anda</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$sql1=mysql_query("SELECT url, nama_url, url.keterangan, direktori, nama_direktori from url, direktori_url
      where kode_url='$kode_url' AND url.direktori=direktori_url.kode_direktori");

if ($data1=mysql_fetch_row($sql1)) {
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">URL Link</td>
   </tr>
</table><p>
<center>
<form method="post" action="edit_url2.php">
<table border="0" cellpadding="2" width="428">
  <tr>
    <td class='judul1' width="410" colspan="2">Edit
      <i>Uniform Resources Locators</i> (URL)</td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF">Direktori</td>
    <td width="303" bgcolor="#EFEFEF"><select name="direktori">
      <?php	
			echo "<option value='$data1[3]' selected>$data1[4]</option>";
										
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
						echo "</select>\n";
		    
		
			?>								
    </td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF" valign="top">URL</td>
    <td width="303" bgcolor="#EFEFEF">
<input type="text" name="url" size="30" value="<?php echo $data1[0]; ?>">
<br>
<font size="-2">Contoh: http://www.nama-perusahaan.com/</font>
</td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF" valign="top">Nama URL</td>
    <td width="303" bgcolor="#EFEFEF"><input type="text" name="nama_url" size="30" value="<?php echo $data1[1]; ?>"><br>
      <font size="-2">Contoh: Perusahaan ABC</font></td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF">Keterangan</td>
    <td width="303" bgcolor="#EFEFEF">
      <textarea rows="2" name="keterangan" cols="30"><?php echo $data1[2]; ?></textarea>
      </td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF">&nbsp;</td>
    <td width="303" bgcolor="#EFEFEF">
      <input type="submit" value="Simpan" name="B3">
    </td>
  </tr>
</table>
<input type="hidden" name="kode_url" value="<?php echo $kode_url; ?>">
</form>
</center>
<?php
}
			
			else {
			  echo mysql_error();
				}
?>
<hr size="1">
</body>

</html>
