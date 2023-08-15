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


$ubah=mysql_query ("UPDATE unit_kerja set
  nama_unit='$nama_unit', singkatan_unit='$singkatan', induk_unit='$induk_unit', tanggal_diubah=now(), diubah_oleh='$kode_pengguna', keterangan='$keterangan' where kode_unit='$kode_unit'"); 

//Respon kepada penambah Unit Kerja
echo "Edit Unit Kerja sukses!<P>";
echo "Data terbaru yang Anda edit adalah:<br>";
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
        
//Menampilkan keterangan, tanggal dibuat dan pembuatnya

$sql=mysql_query("SELECT unit_kerja.tanggal_diubah, nama_pengguna 
     from unit_kerja, pengguna 
     where kode_unit='$kode_unit' AND kode_pengguna=unit_kerja.diubah_oleh");
$data=mysql_fetch_row($sql);

echo "<tr><td>Tanggal diedit</td><td>: $data[0]</td></tr>"; 
echo "<tr><td>Pengedit</td><td>: $data[1]</td></tr>";
echo "</table>";
?>
</body>

</html>