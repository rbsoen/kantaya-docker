<?php

//////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Proses Edit Unit Kerja
//////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Unit Kerja</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Edit Unit Kerja</td>
   </tr>
</table><p>
<?php
//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//Cek apakah Kode Unit Kerja dan Nama Unit Kerja sudah diisi
if (!$kode_unit OR !$nama_unit) {
  echo "Anda harus mengisi Kode Unit Kerja dan Nama Unit Kerja !\n";
  exit;
  }

$ubah=mysql_query ("UPDATE unit_kerja set
  nama_unit='$nama_unit', singkatan_unit='$singkatan', induk_unit='$induk_unit', tanggal_diubah=now(), diubah_oleh='$kode_pengguna', keterangan='$keterangan' where kode_unit='$kode_unit'"); 

//Respon kepada penambah Unit Kerja

if ($ubah) {
  echo "<ul>\n";
  echo "Edit Unit Kerja sukses!<P>\n";
  echo "Data terbaru setelah Anda edit adalah:<br>\n";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "<table>";
  echo "<tr><td>Kode Unit Kerja</td><td>: $kode_unit</td></tr>\n";
  echo "<tr><td>Nama Unit Kerja</td><td>: $nama_unit</td></tr>\n";
  echo "<tr><td>Singkatan</td><td>: $singkatan</td></tr>\n";

  //Menampilkan Induk Unit Kerja jika Induk tidak kosong
        
  if ($induk_unit) {
    $sql=mysql_query("SELECT nama_unit from unit_kerja where kode_unit='$induk_unit'");
    $data=mysql_fetch_row($sql);
    echo "<tr><td>Induk Unit Kerja</td><td>: $data[0]</td></tr>\n";
    }

  echo "<tr><td>Keterangan</td><td>: $keterangan</td></tr>\n";
        
  //Menampilkan keterangan, tanggal dibuat dan pembuatnya

  $sql=mysql_query("SELECT unit_kerja.tanggal_diubah, nama_pengguna 
     from unit_kerja, pengguna 
     where kode_unit='$kode_unit' AND kode_pengguna=unit_kerja.diubah_oleh");
  $data=mysql_fetch_row($sql);

  echo "<tr><td>Tanggal diedit</td><td>: $data[0]</td></tr>\n"; 
  echo "<tr><td>Pengedit</td><td>: $data[1]</td></tr>\n";
  echo "</table>\n";
  echo "<hr size='1' width='400' align='left'>\n";
  echo "</ul>\n";
  }

else {
  echo "Edit Unit Kerja gagal !<p>\n";
  echo mysql_error();
  }

?>
</body>

</html>