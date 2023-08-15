<?php
include ('../lib/cek_sesi.inc');

echo "<html>\n";
echo "<head>\n";
echo "<title>Hapus Direktori</title>\n";
$css = "../css/" .$tampilan_css. ".css";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
?>
<center>
<table border="0" cellpadding="2" width="100%" cellspacing="2">
   <tr>
      <td width="49%" class="judul1">Lemari</td>
      <td width="10%" align="center" class="judul1"><a href="cari_file.php?kata_kunci=">Cari</a></td>
      <td width="10%" bgcolor="#000080" align="center" class="judul1">Direktori</td>
      <td width="10%" align="center" class="judul1"><a href="upload.php">Upload</a></td>
   </tr>
</table>
<P>
<?php

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

  //Cek apakah mempunyai sub-direktori
	$cek=mysql_query("SELECT * FROM direktori WHERE direktori_induk='$kode_direktori'");
	if ($hasil_cek=mysql_fetch_row($cek)){
	  echo "<p>Di dalam direktori ini, masih ada <b>sub-direktori</b> !<p>\n";
		echo "Silakan dihapus dulu !<p>\n";
		}
	
	else {
	  
		//Cek apakah direktori masih punya file
		
		$file=mysql_query("SELECT * FROM file_tb WHERE direktori='$kode_direktori'");
		if ($hasil_file=mysql_fetch_row($file)){
		  echo "<p>Di dalam direktori ini masih terdapat <b>FILE</b> !<p>\n";
			echo "Silakan <a href='isi_direktori.php?pdirektorinav=$kode_direktori'>dihapus</a> dahulu !<p>\n";
			}
		
		else {
	
      $nama=mysql_query("SELECT nama_direktori FROM direktori WHERE kode_direktori='$kode_direktori'");
      $hasil=mysql_fetch_row($nama);										
 
      if ($hasil) {
        echo "<p>Anda yakin akan menghapus Direktori <b>$hasil[0]</b> ?<p>\n";
		    //echo "Jika Anda meng-klik 'Ya', maka semua direktori dan file di bawah direktori <u>$hasil[0]</u> akan terhapus !<p>\n";
	      echo "<b><a href='hapus_dir2.php?kode_direktori=$kode_direktori'>YA !</a> | 
				<a href='javascript:history.go(-1)'>TIDAK !</a></b><p>\n";
	      }

	    else {
	      echo mysql_error();
		    }
			
			echo mysql_error();
			}
 
    echo mysql_error();
	  }

?>
</center>
</body>
</html>