<?php

//////////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Proses Tambah Unit Kerja
//////////////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Tambah Unit Kerja</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>

<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Administrasi Pengguna</td>
   </tr>
</table><p>

<?php

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);
//Cek apakah Kode Unit Kerja dan Nama Unit Kerja sudah diisi
if (!$kode_unit OR !$nama_unit) {
  echo "<center>\n";
  echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>\n";
  echo "Anda harus mengisi Kode Unit Kerja dan Nama Unit Kerja !<p>\n";
  echo "</font>\n";
  echo "<form><input type='button' value='Ulangi !' onClick='javascript:history.go(-1)'></form>\n";
  echo "</center>\n";
  exit;
  }

//Cek apakah Kode Unit Kerja sudah ada (untuk menghindari tampilan error dari MySQL)
$cek=mysql_query ("SELECT * FROM unit_kerja where kode_unit='$kode_unit'");
$hasil=mysql_fetch_row($cek);
if ($hasil) {
  echo "<center>\n";
  echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>\n";
  echo "Kode Unit Kerja <b>". $kode_unit. "</b> sudah ada !\n";
  echo "</font>";
  echo "<form><input type='button' value='Ulangi !' onClick='javascript:history.go(-1)'></form>\n";
  echo "</center>\n";
  exit;
  }

//Cek apakah Nama Unit Kerja sudah ada
$cek=mysql_query ("SELECT * FROM unit_kerja where nama_unit='$nama_unit'");
$hasil=mysql_fetch_row($cek);
if ($hasil) {
  echo "<center>\n";
  echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>\n";
  echo "Nama Unit Kerja <b>". $nama_unit. "</b> sudah ada !\n";
  echo "</font>";
  echo "<form><input type='button' value='Ulangi !' onClick='javascript:history.go(-1)'></form>\n";
  echo "</center>\n";
  exit;
  }

//Tambah data ke tabel unit_kerja
$tambah=mysql_query ("INSERT INTO unit_kerja 
  (kode_unit, nama_unit, singkatan_unit, induk_unit, tanggal_dibuat, dibuat_oleh, keterangan) 
   values 
  ('$kode_unit', '$nama_unit', '$singkatan', '$induk_unit', now(), '$kode_pengguna','$keterangan')");

//Respon kepada penambah Unit Kerja

if ($tambah) {
  echo "<ul>\n";
  echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>\n";
  echo "Penambahan Unit Kerja sukses!<p>\n";
  echo "Data yang Anda tambahkan adalah:<p>\n";
  echo "<hr size='1' width='350' align='left'>\n";
  echo "</font>\n";
  echo "<table>\n";
  echo "<tr><td>Kode Unit Kerja</td><td>: $kode_unit</td></tr>\n";
  echo "<tr><td>Nama Unit Kerja</td><td>: $nama_unit</td></tr>\n";
  echo "<tr><td>Singkatan</td><td>: $singkatan</td></tr>\n";

  //Menampilkan Induk Unit Kerja jika Induk tidak kosong
        
  if ($induk_unit) {
    $sql=mysql_query("SELECT nama_unit from unit_kerja where kode_unit='$induk_unit'");
    $induk=mysql_fetch_row($sql);
    echo "<tr><td>Induk Unit Kerja</td><td>: $induk[0]</td></tr>\n";
    }

  echo "<tr><td>Keterangan</td><td>: $keterangan</td></tr>\n";
        
  //Menampilkan tanggal dibuat dan pembuatnya

  $sql=mysql_query("SELECT unit_kerja.tanggal_dibuat, nama_pengguna 
       from unit_kerja, pengguna 
       where kode_unit='$kode_unit' AND kode_pengguna=unit_kerja.dibuat_oleh");
  $dibuat=mysql_fetch_row($sql);

  echo "<tr><td>Tanggal dibuat</td><td>: $dibuat[0]</td></tr>\n"; 
  echo "<tr><td>Pembuat</td><td>: $dibuat[1]</td></tr>\n";
  echo "</table>\n";
  echo "<hr size='1' width='350' align='left'>\n";
  echo "</ul>\n";
  }
  
else {
  echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>\n";
  echo "Penambahan data Unit Kerja gagal !<p>\n";
  echo mysql_error();
  echo "</font>\n";
  }
?>
</body>

</html>