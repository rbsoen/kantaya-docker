<?php

//Dibuat oleh: KB
//Fungsi: Menambah Anggota Grup

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Tambah Anggota Grup</title>
</head>

<body>

<?php

//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");

//Menambah anggota grup sebanyak checkbox yang di-klik
$count=count($pilihan);
for ($i=0; $i<$count; $i++) {

  $tambah=mysql_query ("INSERT INTO grup_pengguna 
   (kode_pengguna, kode_grup, tanggal_dibuat, dibuat_oleh) 
    values 
    ('$pilihan[$i]', '$kode_grup', now(), '$kode_pengguna')");
  }


//Respon kepada penambah Pengguna

//Mengambil nama grup
$sql_grup=mysql_query ("select nama_grup from grup where kode_grup='$kode_grup'");
$grup=mysql_fetch_array($sql_grup);

echo "Penambahan Anggota Grup sukses!<P>";
echo "Data yang Anda tambahkan adalah:<br>";

echo "<table border='1'><tr bgcolor='#cfcfcf'><td>Nama Pengguna</td><td>Nama Grup</td></tr>";

$count=count($pilihan);
for ($i=0; $i<$count; $i++)
{

$sql=mysql_query ("SELECT nama_pengguna from pengguna where kode_pengguna='$pilihan[$i]'");
$anggota=mysql_fetch_array($sql);

echo "<tr><td>".$anggota[nama_pengguna]. "</td><td>" .$grup[nama_grup]. "</td></tr>";
}

echo "</table>";

?>
</body>

</html>