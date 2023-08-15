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
<title>Tambah Pengguna</title>
</head>

<body>
<?php

//Membuat alpabet
echo "<hr size='1'>";
for ($i=A, $k=1; $k<=26; $i++, $k++) {
  echo "<b><a href='edit_unit.php?huruf=$i'>$i</a></b> - ";
}

echo "<A href='edit_unit.php'>Semua</A>";
echo "<hr size='1'>";

$sql="SELECT 
      kode_unit, nama_unit, singkatan_unit 
      FROM unit_kerja
      WHERE nama_unit LIKE '$huruf%'
      ORDER BY nama_unit";

$result = mysql_query($sql);



if ($row=mysql_fetch_array($result)) {

echo "<table border='1'>";
echo "<tr bgcolor='#CFCFCF'><td><h2><font color='#0000ff'>$huruf</font></h2></td><td>Kode Unit Kerja</td><td>Nama Unit Kerja</td><td>Singkatan</td></tr>";

  do {
     echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td>$row[kode_unit]</td>";
     echo "<td><a href='edit_unit2.php?kode_unit=$row[kode_unit]'>$row[nama_unit]</a></td>";
     echo "<td>$row[singkatan_unit]</td></tr>";
     } 
 
  while ($row=mysql_fetch_array($result));
    echo "</table>";

  } 
        
        else 
           {
             print "<p><b>Tidak ada Unit Kerja dengan nama berawalan '$huruf' .... !</b><p>";
           } 
//Membuat alpabet
echo "<hr size='1'>";
for ($i=A, $k=1; $k<=26; $i++, $k++) {
  echo "<b><a href='edit_unit.php?huruf=$i'>$i</a></b> - ";
}

echo "<A href='edit_unit.php'>Semua</A>";
echo "<hr size='1'>";

?>
</body>

</html>