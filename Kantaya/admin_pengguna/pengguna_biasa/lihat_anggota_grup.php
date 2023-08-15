<?php

//Dibuat oleh: KB
//Fungsi: Pilih Pengguna

//Cek keberadaan sesi (session)
include ('../../lib/cek_sesi.inc');
$css = "../../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";


//Koneksi ke database
require("../../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$sql=mysql_query ("SELECT pengguna.kode_pengguna, pengguna.nama_pengguna, grup.nama_grup FROM pengguna, grup, grup_pengguna where grup.kode_grup = grup_pengguna.kode_grup and pengguna.kode_pengguna = grup_pengguna.kode_pengguna and grup.kode_grup ='$kode_grup' and nama_pengguna like '$huruf%'");


if ($row=mysql_fetch_array($sql)) {

echo "<center><table border='1'>";
echo "<tr bgcolor='#CFCFCF'><td>Nama Anggota</td></tr>\n";


  do {

     echo "<tr><td>$row[1]</td></tr>\n";

     } 
 
  while ($row=mysql_fetch_array($sql));

    echo "</table></center>\n";
 
  } 
        
        else 
           {
             print "Tidak ada pengguna dengan nama $huruf .... !\n";
           } 

//Membuat alpabet
echo "<p><center><hr size='1'>\n";
echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'>\n";
for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='lihat_anggota_grup.php?huruf=$i&kode_grup=$kode_grup'>$i</a> -\n ";
}
echo "<A href='lihat_anggota_grup.php?huruf=&kode_grup=$kode_grup'>Semua</A>\n";
echo "<hr size='1'>\n";
echo "<center><form><input type='button' value='Tutup' onClick='javascript:window.close()'></form></center>";
?>

</body>

</html>
