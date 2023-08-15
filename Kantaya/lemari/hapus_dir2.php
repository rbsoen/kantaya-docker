<?php
include ("../lib/cek_sesi.inc");
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Hapus Direktori</title>\n";
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
<p>	
<?php

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

  $sql=mysql_query("Delete FROM direktori WHERE kode_direktori='$kode_direktori'");										

  if ($sql) {
    echo "Direktori sudah dihapus !<p>\n";
		echo "Klik <a href='nav_direktori.php' target='navigasi'>di sini</a> untuk melihat susunan direktori terbaru !<p>\n";
		
		//Hapus database file
		//$sql2=mysql_query("DELETE FROM file_tb WHERE direktori='$kode_direktori'");
					  
	  }

	else {
	  echo mysql_error();
		}

	//}

?>
</center>
</body>

</html>