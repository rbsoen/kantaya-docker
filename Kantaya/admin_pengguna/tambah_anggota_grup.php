<?php

/////////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Menambah Anggota Grup
/////////////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Tambah Anggota Grup</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//Mengambil nama grup
$sql_grup=mysql_query ("select nama_grup from grup where kode_grup='$kode_grup'");
$grup=mysql_fetch_array($sql_grup);
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Tambah Anggota Grup '<?php echo $grup[0]; ?>'</td>
   </tr>
</table>
<?php

//Menambah anggota grup sebanyak checkbox yang di-klik
$count=count($pilihan);
for ($i=0; $i<$count; $i++) {

  $tambah=mysql_query ("INSERT INTO grup_pengguna 
   (kode_pengguna, kode_grup, tanggal_dibuat, dibuat_oleh) 
    values 
    ('$pilihan[$i]', '$kode_grup', now(), '$kode_pengguna')");
  }


//Respon kepada penambah Pengguna

if ($tambah) {



  echo "Penambahan Anggota Grup sukses!<br>\n";
  echo "Data yang Anda tambahkan adalah:<br>\n";
  echo "Nama-nama anggota:<br>\n";
  echo "<table border='1'>\n";

  $count=count($pilihan);
  for ($i=0; $i<$count; $i++) {

    $sql=mysql_query ("SELECT nama_pengguna from pengguna where kode_pengguna='$pilihan[$i]'");
    $anggota=mysql_fetch_array($sql);

    echo "<tr><td><img src='/ikon/kotak-merah.gif'></td><td>".$anggota[0]. "</td></tr>\n";
    }

  echo "</table>\n";
  }

else {
  echo "Penambahan anggota gagal !<p>\n";
  echo mysql_error();
  }

?>
<hr size="1">
<center>
<form>
<input type="button" value="Tutup" onClick="javascript:window.close()">
</form>
</center>
</body>

</html>