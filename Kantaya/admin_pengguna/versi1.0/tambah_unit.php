<?php

//Dibuat oleh: KB
//Fungsi: Menambah Unit Kerja

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Tambah Unit Kerja</title>
</head>

<body>

<?php

//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");

//Cek apakah Kode Unit Kerja dan Nama Unit Kerja sudah diisi
if (!$kode_unit OR !$nama_unit) {
  echo "Anda harus mengisi Kode Unit Kerja dan Nama Unit Kerja !";
  exit;
  }

//Cek apakah Kode Unit Kerja sudah ada (untuk menghindari tampilan error dari MySQL)
$cek=mysql_query ("SELECT * FROM unit_kerja where kode_unit='$kode_unit'");
$hasil=mysql_fetch_row($cek);
if ($hasil) {
  echo "Kode Unit Kerja <b>". $kode_unit. "</b> sudah ada !";
  exit;
  }

//Cek apakah Nama Unit Kerja sudah ada
$cek=mysql_query ("SELECT * FROM unit_kerja where nama_unit='$nama_unit'");
$hasil=mysql_fetch_row($cek);
if ($hasil) {
  echo "Nama Unit Kerja <b>". $nama_unit. "</b> sudah ada !";
  exit;
  }

$tambah=mysql_query ("INSERT INTO unit_kerja 
  (kode_unit, nama_unit, singkatan_unit, induk_unit, tanggal_dibuat, dibuat_oleh, keterangan) 
   values 
  ('$kode_unit', '$nama_unit', '$singkatan', '$induk_unit', now(), '$kode_pengguna','$keterangan')");

//Respon kepada penambah Unit Kerja
echo "Penambahan Unit Kerja sukses!<P>";
echo "Data yang Anda tambahkan adalah:<br>";
echo "<table>";
echo "<tr><td>Kode Unit Kerja</td><td>: $kode_unit</td></tr>";
echo "<tr><td>Nama Unit Kerja</td><td>: $nama_unit</td></tr>";
echo "<tr><td>Singkatan</td><td>: $singkatan</td></tr>";

//Menampilkan Induk Unit Kerja jika Induk tidak kosong
        
if ($induk_unit) {
  $sql=mysql_query("SELECT nama_unit from unit_kerja where kode_unit='$induk_unit'");
  $data=mysql_fetch_row($sql);
  echo "<tr><td>Induk Unit Kerja</td><td>: $data[0]</td></tr>";
  }


echo "<tr><td>Keterangan</td><td>: $keterangan</td></tr>";
        
//Menampilkan tanggal dibuat dan pembuatnya

$sql=mysql_query("SELECT unit_kerja.tanggal_dibuat, nama_pengguna 
     from unit_kerja, pengguna 
     where kode_unit='$kode_unit' AND kode_pengguna=unit_kerja.dibuat_oleh");
$data=mysql_fetch_row($sql);

echo "<tr><td>Tanggal dibuat</td><td>: $data[0]</td></tr>"; 
echo "<tr><td>Pembuat</td><td>: $data[1]</td></tr>";
echo "</table>";
?>
</body>

</html>