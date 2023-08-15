<?php

//Dibuat oleh: KB
//Fungsi: Proses Menambah Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
//require ("../lib/induk_dir.php");
?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Tambah Pengguna</title>
</head>

<body>

<?php

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//Cek apakah Nama, NIP, username, password, level, unit kerja sudah diisi
if (!$nama_pengguna OR !$nip OR !$username OR !$password OR !$level OR !$unit_kerja) {
  echo "Anda harus mengisi Nama, NIP, <i>username, password</i>, level, dan Unit Kerja !\n";
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
  ('$nama', '$nip', '$level_p', '$email_p', '$username', '$password', '$unit_kerja', '$telp_k', '$telp_r', '$hp', 
   '$fax', '$jalan', '$kota', '$kodepos', '$propinsi', '$negara', '$keterangan', now(), '$kode_pengguna')");

//Mencari kode_pengguna - untuk membuat direktori uplaod_file

$kodep=mysql_query ("SELECT kode_pengguna FROM pengguna WHERE username='$username'");
$hasil_kodep=mysql_fetch_row($kodep);

	 
//Respon kepada penambah Pengguna

if ($tambah) {
  echo "<ul>\n";
  echo "Penambahan Pengguna sukses!<P>\n";
  echo "Data yang Anda tambahkan adalah:<br>\n";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "<table>";
  echo "<tr><td>Nama Pengguna</td><td>: $nama</td></tr>\n";
  echo "<tr><td>Nomer Induk Pengguna</td><td>: $nip</td></tr>\n";
  echo "<tr><td>Level</td><td>:";
  if ($level_p=="1") {
    echo " Administrator</td></tr>\n";
    }
  else {
    echo " Pengguna</td></tr>\n";
    }

  echo "<tr><td>username</td><td>: $username</td></tr>\n";
  echo "<tr><td>password</td><td>: $password</td></tr>\n";
  echo "<tr><td>Email</td><td>: $email_p</td></tr>\n";

  //Menampilkan Unit Kerja
        
  $sql=mysql_query("SELECT nama_unit from unit_kerja where kode_unit='$unit_kerja'");
  $data=mysql_fetch_row($sql);
  echo "<tr><td>Unit Kerja</td><td>: $data[0]</td></tr>\n";

  echo "<tr><td>Telepon Kantor</td><td>: $telp_k</td></tr>\n";
  echo "<tr><td>Telepon Rumah</td><td>: $telp_r</td></tr>\n";
  echo "<tr><td>Handphone</td><td>: $hp</td></tr>\n";
  echo "<tr><td>Fax</td><td>: $fax</td></tr>\n";
  echo "<tr><td>Alamat Kantor</td><td>: $jalan $kota $kodepos, $propinsi, $negara</td></tr>\n";
  echo "<tr><td>Keterangan</td><td>: $keterangan</td></tr>\n";

       
  //Menampilkan pembuatnya

  $sql=mysql_query("SELECT nama_pengguna 
     from pengguna 
     where kode_pengguna='$kode_pengguna'");
  $data=mysql_fetch_row($sql);

  echo "<tr><td>Pembuat</td><td>: $data[0]</td></tr>\n";
  echo "</table>\n";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "</ul>\n";
  
	//Membuat direktori untuk dia - upload file
	//Sesuaikan dengan home direktori Web-nya !
	
	//mkdir ("/home/www/lemari/file_upload/$hasil_kodep[0]",0744);
	mkdir ("../lemari/file_upload/".$hasil_kodep[0],0744);
	
	}

else {
  echo "Penambahan data Pengguna gagal !<p>\n";
  echo mysql_error();
  }

?>
</body>

</html>