<?php

//Dibuat oleh: KB
//Fungsi: Edit Pengguna

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

$sql="SELECT 
      kode_pengguna, nip, nama_pengguna, email 
      FROM pengguna
      WHERE nama_pengguna LIKE '$huruf%'
      ORDER BY nama_pengguna";

$result = mysql_query($sql);

if ($row=mysql_fetch_array($result)) {
  echo "<center>\n";
  echo "<table border='1'>\n";
  echo "<tr bgcolor='#CFCFCF'><td class='judul1'><font color='#0000ff' size='5'><b>$huruf</b></font></td><td class='judul1'>Nomer Induk</td><td class='judul1'>Nama Pengguna</td><td class='judul1'>Email</td></tr>\n";

  do {
    echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td>$row[1]</td>\n";
    echo "<td><a href='edit_pengguna2.php?kode_pengguna1=$row[0]'>$row[2]</a></td>\n";
    echo "<td><a href='mailto:$row[3]'>$row[3]</a></td></tr>\n";
    } 
 
  while ($row=mysql_fetch_array($result));
    echo "</table><p>\n";
    echo "</center>\n";
  } 
        
else {
  print "<p><b>Tidak ada pengguna dengan nama berawalan '$huruf' .... !</b><p>\n";
  } 

//Membuat alpabet

echo "<p><center><hr size='1'>\n";
echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'>\n";
for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='edit_pengguna.php?huruf=$i'>$i</a> - \n";
  }
echo "<A href='edit_pengguna.php?huruf='>Semua</A>";
echo "</font>\n";
echo "<hr size='1'></center>\n";
?>

</body>
</html>