<?php

//Dibuat oleh: KB
//Fungsi: Tambah URL

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Tambah Url Anda</title>\n";
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
<?php
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$sql=mysql_query("SELECT kode_direktori,
		                     nama_direktori 
												   FROM direktori_url 
												     WHERE dibuat_oleh='$kode_pengguna' 
														   ORDER BY nama_direktori");
					
if ($data=mysql_fetch_array($sql)) {
?>
<center>
<form method="post" action="tambah_url2.php">
<table border="0" cellpadding="2" width="428">
  <tr>
    <td class='judul2' width="410" colspan="2">Tambah
      <i>Uniform Resources Locators</i> (URL)</td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF">Direktori</td>
    <td width="303" bgcolor="#EFEFEF"><select name="direktori">
      <?php
			if ($direktori) {
			  $sql1=mysql_query("SELECT kode_direktori, nama_direktori FROM direktori_url WHERE kode_direktori='$direktori'");
				if ($data_sql1=mysql_fetch_row($sql1)) {
				  echo "<option value='$data_sql1[0]'>$data_sql1[1]</option>\n";
					}
					
				else {
				  echo mysql_error();
					}
				
				}
				
			else {
						
        echo "<option value=''>Pilih Salah Satu</option><p>\n";
			  do {
			    echo "<option value='$data[0]'>$data[1]</option>\n";
				  }								
			
			  while ($data=mysql_fetch_array($sql));
			  echo "<option value=''>Tidak Ada</option><p>\n";																						
			  }
			echo "</select>\n";
			?>								
    </td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF" valign="top">URL</td>
    <td width="303" bgcolor="#EFEFEF">
      <input type="text" name="url" size="30"><br>
      <font size="-2">Contoh: <font color="ff0000">http://www.nama-perusahaan.com/</font></font>
    </td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF" valign="top">Nama URL</td>
    <td width="303" bgcolor="#EFEFEF"><input type="text" name="nama_url" size="30"><br>
      <font size="-2">Contoh: <font color="ff0000">Perusahaan ABC</font></font></td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF">Keterangan</td>
    <td width="303" bgcolor="#EFEFEF">
      <textarea rows="2" name="keterangan" cols="30"></textarea>
      </td>
  </tr>
  <tr>
    <td width="107" bgcolor="#EFEFEF">&nbsp;</td>
    <td width="303" bgcolor="#EFEFEF">
      <input type="submit" value="Simpan" name="B3">
    </td>
  </tr>
</table>
</form>
</center>
<?php
}
else {								  
  echo "<center>\n";
	echo "Anda belum punya direktori SAMA SEKALI !<p>\n";
	echo "Silakan <a href='direktori_baru.php'>membuat Direktori</a> terlebih dahulu !<p>\n";
	echo "</center>\n";
	echo mysql_error();
	}
?>
<hr size="1">
</body>

</html>
