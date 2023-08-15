<?php

///////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Mengedit Anggota Grup
//////////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Anggota Grup</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
?>

<body>

<?php

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//Menambah anggota grup sebanyak checkbox yang di-klik

$count=count($pilihan);
for ($i=0; $i<$count; $i++) {
  $hapus=mysql_query ("DELETE from grup_pengguna where kode_grup='$kode_grup' and kode_pengguna='$pilihan[$i]'");
  }

if ($hapus) {

  //Respon kepada penambah Pengguna
  //Mengambil anggota grup setelah diedit

  $sql_grup=mysql_query ("SELECT pengguna.kode_pengguna, pengguna.nama_pengguna, grup.nama_grup FROM pengguna, grup, grup_pengguna where grup.kode_grup = grup_pengguna.kode_grup and pengguna.kode_pengguna = grup_pengguna.kode_pengguna and grup.kode_grup ='$kode_grup'");

  if ($grup=mysql_fetch_array($sql_grup)) {
    echo "Pencabutan Anggota Grup sukses!<P>\n";
    echo "Data terakhir setelah Anda edit adalah:<p>\n";
    echo "Nama Grup: <b>$grup[2]</b><p>\n";
    echo "Nama-nama anggota:<br>\n";
    echo "<table border='1'>\n";

    do {
      $sql=mysql_query ("SELECT nama_pengguna from pengguna where kode_pengguna='$grup[0]'");
      $anggota=mysql_fetch_array($sql);

      echo "<tr><td><img src='/ikon/kotak-merah.gif' alt='Kotak Kecil'></td><td>".$anggota[0]. "</td></tr>\n";
      }
  
    while ($grup=mysql_fetch_array($sql_grup));
  
    echo "</table><p>\n";
    }

  else {
    echo "Grup Anda tidak punya anggota lagi !\n";
    }

  }

else {
  echo "<center>\n";
	echo "Edit grup gagal !\n";
  echo "<form><input type='button' value='Ulangi' onClick='javascript:history.go(-1)'></form>\n";   
	echo mysql_error();
	echo "</center>\n";
  }

echo "<center>\n";
echo "<form><input type='button' value='Tutup' onClick='javascript:window.close()'></form>\n";   
echo "</center>\n";
?>
</body>

</html>