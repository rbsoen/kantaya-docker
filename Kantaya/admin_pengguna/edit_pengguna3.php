<?php

//Dibuat oleh: KB
//Fungsi: Edit Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Edit Pengguna</td>
   </tr>
</table><p>
<?php

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//Cek apakah Nama, NIP, level, unit kerja sudah diisi
if (!$nama_pengguna OR !$nip OR !$level OR !$unit_kerja) {
  echo "Anda harus mengisi Nama, NIP, level, dan Unit Kerja !";
  exit;
  }

if ($password) {
  $ubah=mysql_query ("UPDATE pengguna set 
        nama_pengguna='$nama', nip='$nip', level='$level_p', email='$email_p', password='$password', unit_kerja='$unit_kerja', telp_k='$telp_k', telp_r='$telp_r', hp='$hp', fax='$fax', alamat_k_jalan='$jalan', kota='$kota', kode_pos='$kodepos', propinsi='$propinsi', negara='$negara', keterangan='$keterangan', tanggal_diubah=now(), diubah_oleh='$kode_pengguna' 
        where kode_pengguna='$kode_pengguna1'"); 
  }

else {
  $ubah=mysql_query ("UPDATE pengguna set 
        nama_pengguna='$nama', nip='$nip', level='$level_p', email='$email_p', unit_kerja='$unit_kerja', telp_k='$telp_k', telp_r='$telp_r', hp='$hp', fax='$fax', alamat_k_jalan='$jalan', kota='$kota', kode_pos='$kodepos', propinsi='$propinsi', negara='$negara', keterangan='$keterangan', tanggal_diubah=now(), diubah_oleh='$kode_pengguna' 
        where kode_pengguna='$kode_pengguna1'");
  }

//Respon kepada pengedit Pengguna
if ($ubah) {
  echo "<ul>\n";
  echo "Edit Data Pengguna sukses!<P>\n";
  echo "Data terbaru setelah Anda edit adalah:<br>\n";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "<table>\n";
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
  echo "<tr><td>password</td><td>:";
  if ($password){ echo $password; }
  echo "</td></tr>\n";
  echo "<tr><td>Email</td><td>: $email_p</td></tr>\n";

  //Menampilkan Unit Kerja
        
  $sql=mysql_query("SELECT nama_unit from unit_kerja where kode_unit='$unit_kerja'");
  $data=mysql_fetch_row($sql);
  echo "<tr><td>Unit Kerja</td><td>: $data[0]</td></tr>\n";
  echo "<tr><td>Telepon Kantor</td><td>: $telp_k</td></tr>\n";
  echo "<tr><td>Telepon Rumah</td><td>: $telp_r</td></tr>\n";
  echo "<tr><td>Handphone</td><td>: $hp</td></tr>\n";
  echo "<tr><td>Fax</td><td>: $fax</td></tr>\n";
  echo "<tr><td>Alamat Kantor</td><td>: $jalan  $kota $kodepos, $propinsi, $negara</td></tr>\n";
  echo "<tr><td>Keterangan</td><td>: $keterangan</td></tr>\n";
       
  //Menampilkan pembuatnya

  $sql=mysql_query("SELECT nama_pengguna 
     from pengguna 
     where kode_pengguna='$kode_pengguna'");
  $data=mysql_fetch_row($sql);

  echo "<tr><td>Diubah oleh</td><td>: $data[0]</td></tr>\n";
  echo "</table>\n";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "</ul>\n";
  }
  
else {
  echo "Edit data gagal !<P>\n";
  echo mysql_error;
  }
?>
</body>
</html>