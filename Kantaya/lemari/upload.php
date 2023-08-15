<?php
include ("../lib/cek_sesi.inc");
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Upload File</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";

//Cek jika pengguna belum punya direktori

$sql_cek=mysql_query("SELECT kode_direktori
														 FROM direktori 
														 WHERE dibuat_oleh='$kode_pengguna'
														 ");
								
if (!$data_cek=mysql_fetch_array($sql_cek)) {
  echo "<p>&nbsp;<br><center>";
	echo "Anda harus membuat DIREKTORI terlebih dahulu, karena Anda belum punya Direktori satupun !<p>\n";
	echo "Klik <a href='direktori_baru.php'>di sini</a> untuk membuat Direktori baru! <b>ATAU</b><br>Anda bisa meng-upload file ke direktori-direktori yang di-share ke Anda, sbb:</center>\n";
	echo mysql_error();
	
	//Cek direktori yang di-share ke Publik
	$sql_sharing=mysql_query("SELECT kode_direktori, nama_direktori FROM direktori where sharing_publik='1'");
	if ($data_sql_sharing=mysql_fetch_row($sql_sharing)){
	  echo "<ul>\n";
	  do {
			echo "<li><a href='upload_sharing.php?direktori_induk=$data_sql_sharing[0]'>$data_sql_sharing[1]</a>\n";
			}								
		while ($data_sql_sharing=mysql_fetch_array($sql_sharing));
			echo "</ul>\n";									
		  }
	
	else {
		  echo mysql_error();
			}

	//Cek direktori yang dishare ke Pengguna ybs
  $sql_sharing=mysql_query("SELECT sharing_dir_pengguna.kode_direktori, nama_direktori FROM sharing_dir_pengguna, direktori 
	             where kode_pengguna='$kode_pengguna' AND sharing_dir_pengguna.kode_direktori=direktori.kode_direktori");
	if ($data_sql_sharing=mysql_fetch_array($sql_sharing)){
	  echo "<ul>\n";
	  do {
			echo "<li><a href='upload_sharing.php?direktori=$data_sql_sharing[0]'>$data_sql_sharing[1]</a>\n";
			}								
		while ($data_sql_sharing=mysql_fetch_array($sql_sharing));
			echo "</ul>\n";									
		  }
	
	else {
		  echo mysql_error();
			}
	//Cek direktori yang dishare ke Grup ybs
	
	//Cek grup yang dimiliki pengguna ybs.
	
	$grup=mysql_query("SELECT kode_grup FROM grup_pengguna WHERE kode_pengguna='$kode_pengguna'");
	
	if ($data_grup=mysql_fetch_array($grup)){
	  do { 
	    // Cek direktori yang di-share ke grup ybs
	    $sql_sharing2=mysql_query("SELECT sharing_dir_grup.kode_direktori, nama_direktori FROM sharing_dir_grup, direktori 
	             where kode_grup='$data_grup[0]' AND sharing_dir_grup.kode_direktori=direktori.kode_direktori");
	
	    if ($data_sql_sharing2=mysql_fetch_array($sql_sharing2)){
	      echo "<ul>\n";
	      do {
			    echo "<li><a href='upload_sharing.php?direktori_induk=$data_sql_sharing2[0]'>$data_sql_sharing2[1]</a>\n";
			    }								
		    while ($data_sql_sharing2=mysql_fetch_array($sql_sharing2));
			    echo "</ul>\n";									
		      }
		
		  else {
		    echo mysql_error();
			  }
		  
			}
		
		while ($data_grup=mysql_fetch_array($grup));
			  echo mysql_error();								
		    }
	
	else {
		  echo mysql_error();
			}
	
	exit;
  }
?>

<center>
<table border="0" cellpadding="2" width="100%" cellspacing="0">
   <tr>
      <td width="49%" class="judul1">Lemari</td>
      <td width="10%" align="center" class="judul1"><a href="cari_file.php?kata_kunci=">Cari</a></td>
      <td width="10%" bgcolor="#000080" align="center" class="judul1"><a href='isi_direktori.php'>Direktori</a></td>
      <td width="10%" align="center" class="judul1">Upload</td>
   </tr>
</table>
<p>
<form enctype="multipart/form-data" method="post" action="upload2.php">
<table border="0" cellpadding="2" width="100%" cellspacing="0">
  <tr>
    <td width="100%" valign="top">
      <div align="center">
        <center>
        <table border="0" cellpadding="2" width="500">
          <tr>
            <td colspan="2" class="judul2">Upload File</td>
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
								
								if ($letak_direktori) {
								  $sql=mysql_query("SELECT kode_direktori, nama_direktori FROM direktori WHERE kode_direktori='$letak_direktori'");
									if ($data=mysql_fetch_row($sql)){
									  echo "<option value='$data[0]'>$data[1]</option>\n";
										}
									
									else {
									  echo myslq_error();
										}
								
								  }
								
								else {
								  echo "<option value=''>Pilih Salah Satu</option><p>\n";
								  $sql=mysql_query("SELECT kode_direktori,
								             nama_direktori 
														 FROM direktori 
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
                &nbsp;
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