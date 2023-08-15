<html>
<body>
<?php

$kode_pengguna="1";

if ($nama_grup=="" || $kategori_grup=="" || $sifat_grup=="") {
echo "<h2>Tambah Grup</H2>";
echo "<form method='post' action='grup_baru.php'>";
echo "<table border='0'>";
echo "<tr><td>Nama grup:</td><td><input type='text' name='nama_grup'></td></tr>";
echo "<tr><td>Kategori grup:</td><td><select name='kategori_grup'>";
echo "<option value=''></option>";
echo "<option value='Struktural'>Struktural</option>";
echo "<option value='Fungsional'>Fungsional</option>";
echo "</select</td></tr>";
echo "<tr><td>Sifat Grup:</td><td><select name='sifat_grup'>";
echo "<option value=''></option>";
echo "<option value='Eksklusif'>Eksklusif</option>";
echo "<option value='Bebas'>Bebas</option>";
echo "</select></td></tr>";
echo "<tr><td>&nbsp;</td><td><input type='submit' value='Tambah Grup'></td></tr>";
echo "</table>";
echo "</form>";
} else

{
mysql_connect ('localhost', 'root');
mysql_select_db ('kantaya');

//Mengecek apakah nama grup sudah ada
$sql_cek=mysql_query ("SELECT * FROM grup WHERE nama_grup='$nama_grup'");
if ($row=mysql_fetch_array($sql_cek)) {
  print "Nama grup <b>$nama_grup</b> sudah ada !";}

else {

$sql_tambah_grup=mysql_query("INSERT INTO grup (nama_grup, kategori_grup,
sifat_grup, dibuat_tanggal, dibuat_oleh) values ('$nama_grup',
'$kategori_grup', '$sifat_grup', now(), $kode_pengguna)");

print "Penambahan Grup Sukses !<br>";
print "Nama Grup: $nama_grup<br>";
print "Kategori: $kategori_grup<br>";
print "Sifat: $sifat_grup<br>";
}

}

?>
</body>
</html>
