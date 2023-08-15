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
<title>Tambah Grup</title>

<script language="JavaScript">

function BukaJendelaBaru(kode_pengguna1){
window.open('profile_pengguna.php?kode_pengguna1='+kode_pengguna1,'Profile_Pengguna','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=350,top=100,left=100')
}

</script>
</head>

<body>

<?php

//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");

//Cek apakah Nama Grup dan sifat Grup sudah diisi
if (!$nama_grup OR !($sifat_grup)) {
  echo "Anda harus mengisi Nama Grup dan memilih Sifat Grup !";
  exit;
  }

//Cek apakah Nama Grup sudah ada
$cek=mysql_query ("SELECT * FROM grup where nama_grup='$nama_grup'");
$hasil=mysql_fetch_row($cek);
if ($hasil) {
  echo "Nama Grup <b>". $nama_grup. "</b> sudah ada !";
  exit;
  }

$tambah=mysql_query ("INSERT INTO grup 
  (nama_grup, sifat_grup, keterangan, pimpinan_grup, tanggal_dibuat,
dibuat_oleh, status) 
   values 
  ('$nama_grup', '$sifat_grup','$keterangan', '$kode_pengguna', now(),
'$kode_pengguna', '1')");

//Respon kepada penambah Unit Kerja
echo "Penambahan Grup sukses!<P>";
echo "Data yang Anda tambahkan adalah:<br>";
echo "<table>";
echo "<tr><td>Nama Grup</td><td>: $nama_grup</td></tr>";
echo "<tr><td>Sifat Grup</td><td>: $sifat_grup</td></tr>";

        
//Menampilkan tanggal dibuat dan pembuatnya

$sql=mysql_query("SELECT grup.tanggal_dibuat, nama_pengguna 
     from grup, pengguna 
     where nama_grup='$nama_grup' AND kode_pengguna=grup.dibuat_oleh");
$data=mysql_fetch_row($sql);

echo "<tr><td>Tanggal dibuat</td><td>: $data[0]</td></tr>"; 
echo "<tr><td>Pembuat</td><td>: $data[1]</td></tr>";
echo "</table>";

if ($sifat_grup=="Eksklusif"){

//Mengambil nilai kode_grup yang baru didapat

$sql=mysql_query ("select kode_grup from grup where nama_grup='$nama_grup'");
$grup=mysql_fetch_array($sql);

//Membuat alpabet
echo "<hr size='1'>";
for ($i=A, $k=1; $k<=26; $i++, $k++) {
  echo "<b><a href='lihat_calon_anggota.php?huruf=$i&kode_grup=$grup[0]'>$i</a></b> - ";
}
echo "<A href='lihat_calon_anggota.php?kode_grup=$grup[0]'>Semua</A>";
echo "<hr size='1'>";

echo "Klik di depan nama pengguna, untuk memilih anggota Grup !<p>";
$sql=mysql_query ("SELECT kode_pengguna, nama_pengguna from pengguna where nama_pengguna like 'A%' order by nama_pengguna");

if ($row=mysql_fetch_array($sql)) {

echo "<form method='post' action='tambah_anggota_grup.php'>";
echo "<table border='1'>";
echo "<tr bgcolor='#CFCFCF'><td><h2><font color='#0000ff'>A</font></h2></td><td>Pilih</td><td>Nama Pengguna</td></tr>";

  do {
     echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td><input type='checkbox' name='pilihan[]' value='$row[kode_pengguna]'></td>";
     
     echo "<td><a
href='javascript:BukaJendelaBaru($row[kode_pengguna])'>$row[nama_pengguna]</a></td></tr>";

     } 
 
  while ($row=mysql_fetch_array($sql));
    echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td colspan='2'><input type='submit' value='Simpan Menjadi Anggota Grup'>";
    echo "</table>";


  echo "<input type='hidden' name='kode_grup' value='$grup[0]'>";
  

    echo "</form>";

  } 
        
        else 
           {
             print "Tidak ada pengguna dengan nama $huruf .... !";
           } 
//Membuat alpabet
echo "<hr size='1'>";
for ($i=A, $k=1; $k<=26; $i++, $k++) {
  echo "<b><a href='lihat_calon_anggota.php?huruf=$i&kode_grup=$grup[0]'>$i</a></b> - ";
}
echo "<A href='lihat_calon_anggota.php?kode_grup=$grup[0]'>Semua</A>";
echo "<hr size='1'>";
}



?>

</body>

</html>
