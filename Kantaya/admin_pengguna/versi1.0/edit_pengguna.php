<?php

//Dibuat oleh: KB
//Fungsi: Edit Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");
?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Edit Pengguna</title>
</head>

<body>
<?php

//Membuat alpabet
for ($i=A, $k=1; $k<=26; $i++, $k++) {
  echo "<b><a href='edit_pengguna.php?huruf=$i'>$i</a></b> - ";
}

echo "<A href='edit_pengguna.php'>Semua</A><p>";


$sql="SELECT 
      kode_pengguna, nip, nama_pengguna, email 
      FROM pengguna
      WHERE nama_pengguna LIKE '$huruf%'
      ORDER BY nama_pengguna";

$result = mysql_query($sql);


if ($row=mysql_fetch_array($result)) {

echo "<table border='1'>";
echo "<tr bgcolor='#CFCFCF'><td><h2><font color='#0000ff'>$huruf</font></h2></td><td>Nomer Induk</td><td>Nama Pengguna</td><td>Email</td></tr>";

  do {
     echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td>$row[nip]</td>";
     echo "<td><a href='edit_pengguna2.php?kode_pengguna1=$row[kode_pengguna]'>$row[nama_pengguna]</a></td>";
     echo "<td><a href='mailto:$row[email]'>$row[email]</a></td></tr>";
     } 
 
  while ($row=mysql_fetch_array($result));
    echo "</table><p>";
  } 
        
else {
  print "<p><b>Tidak ada pengguna dengan nama berawalan '$huruf' .... !</b><p>";
  } 

//Membuat alpabet
for ($i=A, $k=1; $k<=26; $i++, $k++) {
  echo "</b><a href='edit_pengguna.php?huruf=$i'>$i</a></b> - ";
}

echo "<A href='edit_pengguna.php'>Semua</A>";


?>

</body>

</html>