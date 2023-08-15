<?php

//Dibuat oleh: KB
//Fungsi: Proses Menambah Pengguna

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
//Cek kelengkapan form

if ($direktori=="" OR $url=="" or $nama_url=="") {
  echo "<p><center>Anda harus memilih direktori, mengisi Alamat URL dan Nama URL !<p>\n";
	echo "<a href='javascript:history.go(-1)'>Ulangi Langi !</a></center><p>\n";
	exit;
	}

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$cek=mysql_query("SELECT * FROM url WHERE url='$url'");
if ($hasil_cek=mysql_fetch_row($cek)){
  echo "URL <b>$url</b> sudah ada !";
	exit;
	}

$cek=mysql_query("SELECT * FROM url WHERE nama_url='$nama_url'");
if ($hasil_cek=mysql_fetch_row($cek)){
  echo "Nama URL <b>$nama_url</b> sudah ada !";
	exit;
	}
	
$tambah=mysql_query ("INSERT INTO url 
  (url, nama_url, keterangan, direktori, tanggal_dibuat) 
   values 
  ('$url', '$nama_url', '$keterangan', '$direktori', now())");

//Respon kepada penambah Pengguna

if ($tambah) {
  echo "<ul>\n";
  echo "Penambahan URL sukses!<P>\n";
  echo "Data yang Anda tambahkan adalah:<br>\n";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "<table>";
  echo "<tr><td>URL</td><td>: <a href='$url' target='_new'>$url</a></td></tr>\n";
  echo "<tr><td>Nama URL</td><td>: $nama_url</td></tr>\n";
  echo "<tr><td>Keterangan</td><td>: $keterangan</td></tr>\n";
       
  //Menampilkan direktori & pembuatnya

	$dir=mysql_query("SELECT nama_direktori FROM direktori_url WHERE kode_direktori='$direktori'");
	$data_dir=mysql_fetch_row($dir);
	if ($data_dir){
	  echo "<tr><td>Direktori</td><td>: <a href='isi_direktori.php?pdirektorinav=$direktori'>$data_dir[0]</a></td></tr>\n";
		}
	
  $sql=mysql_query("SELECT nama_pengguna 
     from pengguna 
     where kode_pengguna='$kode_pengguna'");
  $data=mysql_fetch_row($sql);
  if ($data) {
    echo "<tr><td>Pembuat</td><td>: $data[0]</td></tr>\n";
		}
  echo "</table>\n";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "</ul>\n";
  }

else {
  echo "Penambahan data Pengguna gagal !<p>\n";
  echo mysql_error();
  }

?>
<hr size="1">
</body>

</html>