<?php

//Dibuat oleh: KB
//Fungsi: Edit Grup

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Grup</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Edit Grup</td>
   </tr>
</table><br>
<?php
//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$ubah=mysql_query ("update grup set 
  sifat_grup='$sifat_grup', keterangan='$keterangan', tanggal_diubah=now(), diubah_oleh='$kode_pengguna', status='$status_grup' where kode_grup='$kode_grup'"); 

if ($ubah) {
  //Respon kepada penambah Grup
  echo "Edit Grup sukses!<P>\n";
  echo "Data terbaru yang Anda edit adalah:<br>\n";
  echo "<table>\n";
  echo "<tr><td>Nama Grup</td><td>: $nama_grup</td></tr>\n";
  echo "<tr><td>Sifat Grup</td><td>: $sifat_grup (";
  if ($status_grup=="1"){
    echo "<i>Aktif</i>)\n";
    }
  else {
    echo "<i>Non Aktif</i>)\n";
    }

  echo "</td></tr>\n";

        
  //Menampilkan tanggal diubah dan pembuatnya
  
  $sql=mysql_query("SELECT grup.tanggal_diubah, nama_pengguna 
     from grup, pengguna 
     where nama_grup='$nama_grup' AND kode_pengguna=grup.diubah_oleh");
  $data=mysql_fetch_row($sql);

  echo "<tr><td>Tanggal diubah</td><td>: $data[0]</td></tr>\n"; 
  echo "<tr><td>Diubah oleh</td><td>: $data[1]</td></tr>\n";
  echo "</table>";

  }

else {
  echo "Edit data gagal !<p>\n";
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