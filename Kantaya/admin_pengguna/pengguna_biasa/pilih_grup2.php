<?php

//Dibuat oleh: KB
//Fungsi: Menambah Anggota Grup

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
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Pilih Grup</td>
   </tr>
</table><p>
<?php
//Koneksi ke database
require("../../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//Menambah anggota grup sebanyak checkbox yang di-klik
$count=count($pilihan);
for ($i=0; $i<$count; $i++) {

  $tambah=mysql_query ("INSERT INTO grup_pengguna 
   (kode_grup, kode_pengguna, tanggal_dibuat, dibuat_oleh) 
    values 
    ('$pilihan[$i]', '$kode_pengguna', now(), '$kode_pengguna')");
  }

if ($tambah) {

//Respon kepada penambah Pengguna

//Mengambil nama grup
$sql_grup=mysql_query ("select nama_grup from grup, grup_pengguna where kode_pengguna='$kode_pengguna' and grup.kode_grup=grup_pengguna.kode_grup");
if ($grup=mysql_fetch_array($sql_grup)) {

echo "Penambahan menjadi Anggota Grup sukses!<P>";
echo "Anda sekarang mempunyai grup sebagai berikut:<p>";
echo "<ul>";
do {
  echo "<li> $grup[0]</li>";
  }
while ($grup=mysql_fetch_array($sql_grup));
echo "</ul>";
}
}

else {
  echo "Pemilihan menjadi Anggota Grup gagal!<p>\n";
  echo mysql_error();
  }


?>
<hr size="1">
</center>
</body>

</html>