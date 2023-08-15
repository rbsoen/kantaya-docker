<?php

//Dibuat oleh: KB
//Fungsi: Menambah Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Tambah Pengguna</title>
</head>

<body>

<?php

//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");

//Cek apakah Nama, NIP, username, password, level, unit kerja sudah diisi
if (!$nama_pengguna OR !$nip OR !$username OR !$password OR !level OR !$unit_kerja) {
  echo "Anda harus mengisi Nama, NIP, <i>username, password</i>, level, dan Unit Kerja !";
  exit;
  }

//Cek apakah username sudah ada
$cek=mysql_query ("SELECT * FROM pengguna where username='$username'");
$hasil=mysql_fetch_row($cek);
if ($hasil) {
  echo "username <b>". $username. "</b> sudah ada !";
  exit;
  }

$tambah=mysql_query ("INSERT INTO pengguna 
  (nama_pengguna, nip, level, email, username, password, unit_kerja, telp_k, telp_r, hp, 
   fax, alamat_k_jalan, kota, kode_pos, propinsi, negara, keterangan, tanggal_dibuat, dibuat_oleh) 
   values 
  ('$nama', '$nip', '$level', '$email_p', '$username', '$password', '$unit_kerja', '$telp_k', '$telp_r', '$hp', 
   '$fax', '$alamat_k_jalan', '$kota', '$kode_pos', '$propinsi', '$negara', '$keterangan', now(), '$kode_pengguna')");

//Respon kepada penambah Pengguna
echo "Penambahan Pengguna sukses!<P>";
echo "Data yang Anda tambahkan adalah:<br>";
echo "<table>";
echo "<tr><td>Nama Pengguna</td><td>: $nama</td></tr>";
echo "<tr><td>Nomer Induk Pengguna</td><td>: $nip</td></tr>";
echo "<tr><td>Level</td><td>:";
if (level=="1") {
  echo " Administrator</td></tr>";}
else {
echo " Pengguna</td></tr>";}

echo "<tr><td>username</td><td>: $username</td></tr>";
echo "<tr><td>password</td><td>: $password</td></tr>";
echo "<tr><td>Email</td><td>: $email_p</td></tr>";

//Menampilkan Unit Kerja
        
  $sql=mysql_query("SELECT nama_unit from unit_kerja where kode_unit='$unit_kerja'");
  $data=mysql_fetch_row($sql);
  echo "<tr><td>Unit Kerja</td><td>: $data[0]</td></tr>";

echo "<tr><td>Telepon Kantor</td><td>: $telp_k</td></tr>";
echo "<tr><td>Telepon Rumah</td><td>: $telp_r</td></tr>";
echo "<tr><td>Handphone</td><td>: $hp</td></tr>";
echo "<tr><td>Fax</td><td>: $fax</td></tr>";
echo "<tr><td>Alamat Kantor</td><td>: $jalan $kota $kodepos, $propinsi, $negara</td></tr>";
echo "<tr><td>Keterangan</td><td>: $keterangan</td></tr>";

       
//Menampilkan pembuatnya

$sql=mysql_query("SELECT nama_pengguna 
     from pengguna 
     where kode_pengguna='$kode_pengguna'");
$data=mysql_fetch_row($sql);

echo "<tr><td>Pembuat</td><td>: $data[0]</td></tr>";
echo "</table>";
?>
</body>

</html>