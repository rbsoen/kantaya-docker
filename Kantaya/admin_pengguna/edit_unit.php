<?php

//////////////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Menampilkan Unit Kerja untuk diedit
//////////////////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Unit Kerja</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

$sql="SELECT 
      kode_unit, nama_unit, singkatan_unit 
      FROM unit_kerja
      WHERE nama_unit LIKE '$huruf%'
      ORDER BY nama_unit";

$result = mysql_query($sql);

if ($row=mysql_fetch_array($result)) {
  echo "<center>\n";
  echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='3'>\n";
  echo "<b>UNIT KERJA</b>\n";
  echo "</font><p>\n";
  echo "<table border='1' cellpadding='4' cellspacing='0'>\n";
  echo "<tr bgcolor='#CFCFCF'><td class='judul1'><font size='5' color='#0000ff'><b>$huruf</b></font></td><td class='judul1'>Kode</td><td class='judul1'>Nama</td><td class='judul1'>Singkatan</td></tr>\n";

  do {
    echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td>$row[0]</td>\n";
    echo "<td><a href='edit_unit2.php?kode_unit=$row[0]'>$row[1]</a></td>\n";
    echo "<td>$row[2]</td></tr>\n";
    } 
 
  while ($row=mysql_fetch_array($result));
  echo "</table>\n";
  echo "</center>\n";
  } 
        
else {
  echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='2'>\n";
  echo "<p><center><b>Tidak ada Unit Kerja berawalan <font color='#ff0000' size='4'>'$huruf'</font> .... !</b></center><p>\n";
  echo "</font>\n";
  } 

//Membuat alpabet
echo "<p><center><hr size='1'>\n";
echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'>\n";
for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='edit_unit.php?huruf=$i'>$i</a> -\n ";
  }
echo "<A href='edit_unit.php?huruf='>Semua</A>\n";
echo "</font>\n";
echo "<hr size='1'></center>\n";

?>
</body>
</html>