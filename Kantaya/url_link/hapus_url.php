<?php
include ('../lib/cek_sesi.inc');

$css = "../css/" .$tampilan_css. ".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Hapus Url Anda</title>\n";
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

  $nama=mysql_query("SELECT nama_url FROM url WHERE kode_url='$kode_url'");
  $hasil=mysql_fetch_row($nama);										

  if ($hasil) {
	  echo "<center>\n";
    echo "Anda yakin akan menghapus URL: <b>$hasil[0]</b> ?<p>\n";		
	  echo "<b><a href='hapus_url2.php?kode_url=$kode_url'>YA !</a> | 
		<a href='javascript:history.go(-1)'>TIDAK !</a></b><p>\n";
	  echo "</center>\n";
	  }

	else {
	  echo mysql_error();
		}

	//}

?>
<hr size="1">
</body>

</html>