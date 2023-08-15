<?php

//Dibuat oleh: KB
//Fungsi: Pilih Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
?>

<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Pilih Pengguna</title>
<script language="JavaScript">

function BukaJendelaBaru(kode_pengguna1){
reWin=window.open('profile_pengguna.php?kode_pengguna1='+kode_pengguna1,'Profile_Pengguna','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=350,top=100,left=100')
}

</script>
</head>

<body>

<?php

//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");

//////////////////Masih salah

echo "<h1>Masih salah, lho !!!! </h1>";
//////////////////////

//Membuat alpabet
echo "<hr size='1'>";
for ($i=A, $k=1; $k<=26; $i++, $k++) {
  echo "<b><a href='anggota_grup.php?huruf=$i&kode_grup=$kode_grup'>$i</a></b> - ";
}
echo "<A href='anggota_grup.php?kode_grup=$kode_grup'>Semua</A>";
echo "<hr size='1'>";

echo "Klik di depan nama pengguna, untuk memilih anggota Grup !<p>";
$sql=mysql_query ("SELECT grup.nama_grup, grup_pengguna.kode_pengguna, pengguna.nama_pengguna from pengguna, grup, grup_pengguna where pengguna.nama_pengguna like '$huruf%' and grup.kode_grup=grup_pengguna.kode_grup and grup_pengguna.kode_pengguna=pengguna.kode_pengguna order by nama_pengguna");

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
    echo "<input type='hidden' name='kode_grup' value='$kode_grup'>";
    echo "</form>";

  } 
        
        else 
           {
             print "Tidak ada pengguna dengan nama $huruf .... !";
           } 


//Membuat alpabet
echo "<hr size='1'>";
for ($i=A, $k=1; $k<=26; $i++, $k++) {
  echo "<b><a href='anggota_grup.php?huruf=$i&kode_grup=$kode_grup'>$i</a></b> - ";
}
echo "<A href='anggota_grup.php?kode_grup=$kode_grup'>Semua</A>";
echo "<hr size='1'>";

?>

</body>

</html>
