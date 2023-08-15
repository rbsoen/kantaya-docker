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

  $nama=mysql_query("SELECT * FROM direktori_url WHERE direktori_induk='$kode_direktori'");
  $hasil=mysql_fetch_row($nama);										

  if ($hasil) {
   echo "Anda masih mempunyai sub-direktori di dalam direktori ini !<p>\n";
	 echo "Silakan dihapus dahulu !<p>\n";
	
	  }

	else {
    $dir=mysql_query("SELECT nama_direktori FROM direktori_url WHERE kode_direktori='$kode_direktori'");
		if ($hasil_dir=mysql_fetch_row($dir)){	 
      echo "Anda yakin akan menghapus Direktori <b>$hasil_dir[0]</b> ?<p>\n";
		  echo "Jika Anda meng-klik <b>Ya</b>, semua URL di dalam direktori ini akan ikut terhapus !<p>\n";
	    echo "<b><a href='hapus_dir2.php?kode_direktori=$kode_direktori'>YA !</a> | 
			<a href='javascript:history.go(-1)'>TIDAK !</a></b><p>\n";
	    }
		
		else {
		  echo mysql_error();
			}
		
		echo mysql_error();
		}

	//}

?>
<hr size="1">
</body>

</html>