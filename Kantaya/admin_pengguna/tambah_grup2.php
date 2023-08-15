<?php

////////////////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Menambah Grup (Proses Input ke Tabel)
////////////////////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
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
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//Cek apakah Nama Grup dan sifat Grup sudah diisi
if (!$nama_grup OR !($sifat_grup)) {
  echo "Anda harus mengisi Nama Grup dan memilih Sifat Grup !\n";
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
  (nama_grup, sifat_grup, keterangan, pimpinan_grup, tanggal_dibuat, dibuat_oleh, status) 
   values 
  ('$nama_grup', '$sifat_grup','$keterangan', '$kode_pengguna', now(), '$kode_pengguna', '1')");

//Respon kepada penambah Unit Kerja

if ($tambah) {
  echo "Penambahan Grup sukses!<P>";
  echo "Data yang Anda tambahkan adalah:<br>";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "<table>";
  echo "<tr><td>Nama Grup</td><td>: $nama_grup</td></tr>";
  echo "<tr><td>Sifat Grup</td><td>: $sifat_grup</td></tr>";
        
  //Menampilkan tanggal dibuat dan pembuatnya

  $sql=mysql_query("SELECT grup.tanggal_dibuat, nama_pengguna, kode_grup 
     from grup, pengguna 
     where nama_grup='$nama_grup' AND kode_pengguna=grup.dibuat_oleh");
  $data=mysql_fetch_row($sql);

  echo "<tr><td>Tanggal dibuat</td><td>: $data[0]</td></tr>"; 
  echo "<tr><td>Pembuat</td><td>: $data[1]</td></tr>";
  echo "</table>";
  echo "<hr size='1' width='400' align='left'>\n";

	//Keanggotaan otomatis bagi pembuat grup
	
	$anggota=mysql_query("INSERT INTO grup_pengguna 
	  (kode_pengguna, kode_grup, tanggal_dibuat, dibuat_oleh) 
		values 
		($kode_pengguna, $data[2], now(), $kode_pengguna)") or die ("gagal");
	
	
  if ($sifat_grup=="Eksklusif"){

    //Mengambil nilai kode_grup yang baru didapat

    //$sql=mysql_query ("select kode_grup from grup where nama_grup='$nama_grup'");
    //$grup=mysql_fetch_array($sql);

    echo "Klik di depan nama pengguna, untuk memilih anggota Grup !<p>\n";
    $sql=mysql_query ("SELECT kode_pengguna, nama_pengguna from pengguna where nama_pengguna like 'A%' AND kode_pengguna<>'$kode_pengguna' order by nama_pengguna");

    if ($row=mysql_fetch_array($sql)) {

      echo "<form method='post' action='tambah_anggota_grup.php'>\n";
      echo "<table border='1'>\n";
      echo  "<tr bgcolor='#CFCFCF'><td><b><font color='#0000ff' size='5'>A</font></b></td><td>Pilih</td><td>Nama Pengguna</td></tr>\n";

      do {
        echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td><input type='checkbox' name='pilihan[]' value='$row[0]'></td>";
     
       echo "<td><a
href='javascript:BukaJendelaBaru($row[0])'>$row[1]</a></td></tr>\n";
       } 
 
      while ($row=mysql_fetch_array($sql));
      echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td colspan='2'><input type='submit' value='Simpan Menjadi Anggota Grup'>\n";
      echo "</table>";

      echo "<input type='hidden' name='kode_grup' value='$data[2]'>\n";
      echo "</form>";
      } 
       
    else {
      echo "Tidak ada pengguna dengan nama $huruf .... !\n";
      } 

    //Membuat alpabet
    echo "<p><center><hr size='1'>\n";
    echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'>\n";
    for ($i='A', $k=1; $k<=26; $i++, $k++) {
      echo "<a href='lihat_calon_anggota.php?huruf=$i&kode_grup=$data[2]'>$i</a> - \n";
      }
    echo "<A href='lihat_calon_anggota.php?huruf=&kode_grup=$data[2]'>Semua</A>\n";
    echo "<hr size='1'>";
    }

  }
  
else {
  echo "Penambahan data Grup gagal !<p>\n";
  echo mysql_error();
  }

?>

</body>
</html>