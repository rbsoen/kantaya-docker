<?php
include ('../lib/cek_sesi.inc');

$css = "../css/" .$tampilan_css. ".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Hapus Direktori Anda</title>\n";
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
//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

  $sql=mysql_query("Delete FROM direktori_url WHERE kode_direktori='$kode_direktori'");										

  if ($sql) {
    echo "Direktori sudah dihapus !<p>\n";
		
		
		//Hapus database URL di dalam direktori ini
		$sql2=mysql_query("DELETE FROM url WHERE direktori='$kode_direktori'");
		if ($sql2) {
		  echo "Semua URL di dalam direktori ini juga sudah dihapus !<p>\n";
			}
		
		else {
		  echo mysql_error();
			}
		
		echo "Klik <a href='nav_url.php' target='navigasi'>di sini</a> untuk melihat susunan direktori terbaru !<p>\n";
			  
	  }

	else {
	  echo mysql_error();
		}

	//}

?>
<hr size="1">
</body>

</html>