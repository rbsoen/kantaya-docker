<?php
include ('../lib/cek_sesi.inc');
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

echo "<html>\n";
echo "<head>\n";
echo "<title>Direktori Sharing</title>\n";
$css = "../css/" .$tampilan_css. ".css";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";

sharing_publik($publik);
sharing_pengguna($kode_pengguna);
sharing_unit($kode_pengguna);
sharing_grup($kode_pengguna);

//Sharing Publik
function sharing_publik($publik) {
  $publik=1;
  $spublik=mysql_query("SELECT direktori.kode_direktori, nama_direktori, dibuat_oleh 
	         FROM direktori
           WHERE sharing_publik='1'");
  if ($sharing_publik=mysql_fetch_array($spublik)){
    echo "<p>";
	  echo "<table width='100%'>";
    echo "<tr><td class='judul2'>";
    echo "Sharing untuk semua pengguna:\n";
	  echo "</td></tr></table>\n";
	  do {
	    echo "&nbsp;&nbsp;<img src='/ikon/kotak-merah.gif'>";
		  echo " <a href='isi_direktori_sharing.php?pdirektorinav=$sharing_publik[0]&pemilik=$sharing_publik[2]'";
		  echo " target='isi_dir'>$sharing_publik[1]</a><br>\n";
		  }
	
  	while ($sharing_publik=mysql_fetch_array($spublik));
	  }

  else {
    echo "<img src='../ikon/kotak-merah.gif'>Tidak ada sharing untuk semua pengguna!<br>\n";
    echo mysql_error();
	  }
  }

//Sharing Pengguna
function sharing_pengguna($kode_pengguna) {
  $spengguna=mysql_query("SELECT direktori.kode_direktori, nama_direktori, dibuat_oleh 
             FROM direktori, sharing_dir_pengguna 
             WHERE kode_pengguna='$kode_pengguna' 
					         AND direktori.kode_direktori=sharing_dir_pengguna.kode_direktori");
  if ($sharing_pengguna=mysql_fetch_array($spengguna)){
    echo "<p>";
	  echo "<table width='100%'>";
    echo "<tr><td class='judul2'>";
    echo "Sharing khusus untuk Anda:\n";
	  echo "</td></tr></table>\n";
	  do {
	    echo "&nbsp;&nbsp;<img src='../ikon/kotak-merah.gif'>"; 
		  echo " <a href='isi_direktori_sharing.php?pdirektorinav=$sharing_pengguna[0]&pemilik=$sharing_pengguna[2]'";
		  echo " target='isi_dir'>$sharing_pengguna[1]</a><br>";
		  }
	
	  while ($sharing_pengguna=mysql_fetch_array($spengguna));
	  }
  }
	
//Sharing Unit Kerja
function sharing_unit($kode_pengguna) {
  $sunit=mysql_query("SELECT direktori.kode_direktori, direktori.nama_direktori, direktori.dibuat_oleh 
         FROM pengguna, unit_kerja, sharing_dir_unit, direktori 
         WHERE pengguna.kode_pengguna='$kode_pengguna' 
					     AND unit_kerja.kode_unit=pengguna.unit_kerja
					     AND sharing_dir_unit.kode_unit=unit_kerja.kode_unit
					     AND direktori.kode_direktori=sharing_dir_unit.kode_direktori
					     ");

  if ($sharing_unit=mysql_fetch_array($sunit)){
    echo "<p>";
	  echo "<table width='100%'>";
    echo "<tr><td class='judul2'>";
    echo "Sharing khusus untuk Unit Kerja Anda:\n";
	  echo "</td></tr></table>\n";
    do {
	    echo "&nbsp;&nbsp;<img src='../ikon/kotak-merah.gif'>"; 
		  echo " <a href='isi_direktori_sharing.php?pdirektorinav=$sharing_unit[0]&pemilik=$sharing_unit[2]'";
		  echo " target='isi_dir'>$sharing_unit[1]</a><br>";
		  }
	
  	while ($sharing_unit=mysql_fetch_array($sunit));
	  }
  }

	
//Sharing Grup
function sharing_grup($kode_pengguna) {
  $sgrup=mysql_query("SELECT direktori.kode_direktori, direktori.nama_direktori, direktori.dibuat_oleh
         FROM pengguna, grup_pengguna, grup, sharing_dir_grup, direktori
         WHERE pengguna.kode_pengguna='$kode_pengguna'
               AND pengguna.kode_pengguna=grup_pengguna.kode_pengguna
               AND grup_pengguna.kode_grup=grup.kode_grup
               AND grup.kode_grup=sharing_dir_grup.kode_grup
               AND sharing_dir_grup.kode_direktori=direktori.kode_direktori	 
					     ");
					 
  if ($sharing_grup=mysql_fetch_array($sgrup)){
    echo "<p>";
	  echo "<table width='100%'>";
    echo "<tr><td class='judul2'>";
    echo "Sharing khusus untuk Grup Anda:\n";
	  echo "</td></tr></table>\n";
    do {
	    echo "&nbsp;&nbsp;<img src='../ikon/kotak-merah.gif'>"; 
		  echo " <a href='isi_direktori_sharing.php?pdirektorinav=$sharing_grup[0]&pemilik=$sharing_grup[2]'";
		  echo " target='isi_dir'>$sharing_grup[1]</a><br>";
		  }
	
	  while ($sharing_grup=mysql_fetch_array($sgrup));
	  }
  }

if ($sharing_publik="" AND $sharing_pengguna="" AND $sharing_unit="" AND $sharing_grup="") {
  echo "Tidak ada sharing Direktori untuk Anda !<p>\n";
	echo mysql_error();
	}
	
	?>
<p><hr size="1">
<b>>></b> <a href="nav_direktori.php">Direktori Anda</a>
<hr size="1">
</font>
</body>
</html>
