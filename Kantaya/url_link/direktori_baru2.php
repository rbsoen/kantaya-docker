<?php
include ('../lib/cek_sesi.inc');

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
<?php
if (!$nama_direktori) {
  echo "<center>";
	echo "Anda harus menuliskan Nama Direktori !<p>\n";
  echo "<a href='javascript:history.go(-1)'>Ulangi Lagi !</a><p>\n";
  echo "<hr size='1'>";
	echo "</center>";
	exit;
	}
	
else {
  echo mysql_error();
	}

require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//if ($direktori_induk!="") {
  $nama=mysql_query("SELECT nama_direktori 
	      FROM direktori_url 
	      WHERE nama_direktori='$nama_direktori' 
				AND dibuat_oleh='$kode_pengguna'");
  $hasil_nama=mysql_fetch_row($nama);										

  if ($hasil_nama) {
    echo "<p>Anda sudah mempunyai direktori <b>$nama_direktori</b> !<p>\n";
		echo "Dalam sistem ini tidak diperbolehkan membuat dua direktori dengan nama sama, walaupun induk direktorinya berbeda !<p>\n";
	  echo "<a href='javascript:history.go(-1)'>Ulangi Lagi !</a><p>\n";
    exit;
	  }

  $data=mysql_query("INSERT INTO direktori_url 
	                 (nama_direktori, direktori_induk, keterangan, tanggal_dibuat, dibuat_oleh)
									 VALUES
									 ('$nama_direktori', '$direktori_induk', '$keterangan', now(), '$kode_pengguna')");
	if ($data) {
  echo "<center>";
	echo "Penambahan direktori <b>SUKSES</b> !<p>\n";
	echo "Klik <a href='nav_url.php?pdirektorinav=' target='navigasi'>di sini untuk melihatnya !<p>\n";
	echo "</center>";
		}

	else {
	  echo "Penambahan direktori GAGAL !<p>\n";
		echo mysql_error();
		}
	
?>
<hr size="1">
</body>
</html>
