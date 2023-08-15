<?php

//Dibuat oleh: KB
//Fungsi: Menampilkan URL

//Cek keberadaan sesi (session)
//include ("../lib/cek_sesi.inc");
session_start();
if (!$kode_pengguna or !$nama_pengguna or !$level) {
  header('Location: ../index.php');
  }
	
//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");
?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>List URL</title>
</head>

<body>
<?php

$sql="SELECT url, nama_url, keterangan from url where dibuat_oleh='$kode_pengguna' AND nama_url LIKE '$huruf%' order by nama_url";
	
$result = mysql_query($sql);

if ($row=mysql_fetch_array($result)) {

	echo "<center>\n";
  echo "<table border='1'>\n";
  echo "<tr bgcolor='#CFCFCF'>";
	echo "<td><font color='#0000ff' size='5'><b>$huruf</b></font></td>";
	echo "<td>URL</td><td>Nama URL</td>";
	echo "<td>Keterangan</td>";
	echo "</tr>\n";

  do {
    echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td>$row[0]</td>\n";
    echo "<td><a href='$row[0]'>$row[1]</a></td>\n";
    echo "<td>$row[1]</td></tr>\n";
    } 
 
  while ($row=mysql_fetch_array($result));
    echo "</table><p>\n";
    echo "</center>\n";
  } 
        
else {
  print "<p><b>Tidak ada Nama URL yang berawalan '$huruf' .... !</b><p>\n";
  } 

//Membuat alpabet

echo "<p><center><hr size='1'>\n";
echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'>\n";
for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='isi_url.php?huruf=$i'>$i</a> - \n";
  }
echo "<A href='isi_url.php?huruf='>Semua</A>";
echo "</font>\n";
echo "<hr size='1'></center>\n";
?>

</body>
</html>