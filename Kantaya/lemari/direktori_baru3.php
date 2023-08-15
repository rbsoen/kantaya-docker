<?php
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Direktori Baru</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
?>
<table border="0" cellpadding="2" width="100%" cellspacing="0">
   <tr>
      <td width="49%" class="judul1">Lemari</td>
      <td width="10%" align="center" class="judul1"><a href="cari_file.php?kata_kunci=">Cari</a></td>
      <td width="10%" bgcolor="#000080" align="center" class="judul1">Direktori</td>
      <td width="10%" align="center" class="judul1"><a href="upload.php">Upload</a></td>
   </tr>
</table>
<?php

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//Cek Nama Direktori milik sendiri

//if ($direktori_induk!="") {
  $nama=mysql_query("SELECT nama_direktori FROM direktori WHERE nama_direktori='$nama_direktori' AND direktori_induk='$direktori_induk'");
  $hasil_nama=mysql_fetch_row($nama);										

  if ($hasil_nama) {
    echo "<p>Direktori <b>$nama_direktori</b> sudah ada !<p>\n";
	  echo "<a href='javascript:history.go(-2)'><< Ulangi Lagi !</a><p>\n";
    exit;
	  }
	//}


//Menambah anggota grup sebanyak checkbox yang di-klik

$direktori=mysql_query("INSERT INTO direktori 
          (nama_direktori, direktori_induk, keterangan, sharing_publik, tanggal_dibuat, dibuat_oleh)
					VALUES
					('$nama_direktori', '$direktori_induk', '$keterangan', '0' , now(), '$kode_pengguna')");

$kode_dir=mysql_query("SELECT kode_direktori from direktori 
          WHERE nama_direktori='$nama_direktori' 
					AND direktori_induk='$direktori_induk'
					AND keterangan='$keterangan'
					AND sharing_publik='0'
					AND tanggal_dibuat=now()
					AND dibuat_oleh='$kode_pengguna'");
$hasil_dir=mysql_fetch_row($kode_dir);										

if ($hasil_dir) {
					
  if ($sharing=="Unit") {
    $count=count($unit);
    for ($i=0; $i<$count; $i++) {
      $tambah=mysql_query ("INSERT INTO sharing_dir_unit
		          VALUES ('$hasil_dir[0]','$unit[$i]')");
      }
	  }
		
	if ($sharing=="Grup") {
    $count=count($grup);
    for ($i=0; $i<$count; $i++) {
      $tambah=mysql_query ("INSERT INTO sharing_dir_grup
		          VALUES ('$hasil_dir[0]','$grup[$i]')");
      }
	  }
		
	if ($sharing=="Pengguna") {
		$count=count($pengguna);
    for ($i=0; $i<$count; $i++) {
      $tambah=mysql_query ("INSERT INTO sharing_dir_pengguna
		          VALUES ('$hasil_dir[0]','$pengguna[$i]')");
      }
	  }

  echo "<center>";
	echo "<p>Penambahan direktori <b>SUKSES</b> !<p>\n";
	echo "Klik <a href='nav_direktori.php?pdirektorinav=' target='navigasi'>di sini untuk melihatnya !<p>\n";
	echo "</center>";
		
	}

else {
  echo "Penambahan direktori GAGAL !<p>\n";
  echo mysql_error();
	}
?>
</body>

</html>