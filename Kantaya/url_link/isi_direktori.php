<?php

/**************************************
Dibuat oleh: KB
Fungsi: Menampilkan URL
**************************************/

//Cek keberadaan sesi (session)
include ("../lib/cek_sesi.inc");

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>List Url Anda</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

$sql=mysql_query("SELECT nama_direktori FROM direktori_url WHERE kode_direktori='$pdirektorinav'");
$data=mysql_fetch_row($sql);
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">URL Link
			<?php
			if ($data) {
			  echo "--> '" .$data[0]. "'";
				}
			?>
			</td>
   </tr>
</table><p>

<?php
if (!$pdirektorinav) {
  echo "<ul>Anda dapat mengorganisasi URL favorit Anda dalam Modul ini.<p>\n";
  echo "Di mana pun Anda berada, Anda akan tetap bisa menggunakannya (LEBIH DARI sekedar BOOKMARK)<p>\n";
	echo "</ul>";
	echo "<hr size='1'>";
	exit;
  }

$sql="SELECT url.url, url.nama_url, url.keterangan, url.kode_url 
      from url, direktori_url 
        where url.nama_url LIKE '$huruf%' 
        AND url.direktori='$pdirektorinav'
        AND url.direktori=direktori_url.kode_direktori
          order by url.nama_url";
	
$result = mysql_query($sql);

if ($row=mysql_fetch_array($result)) {

  echo "<div align='right'>";
	echo "<a href='direktori_baru.php?direktori=$pdirektorinav'>Buat Direktori Baru</a> | ";
	echo "<a href='tambah_url.php?direktori=$pdirektorinav'>Tambah URL</a>";
	echo "</div><br>";
	echo "<center>\n";
  echo "<table border='1' width='100%'>\n";
  echo "<tr bgcolor='#CFCFCF'>";
	echo "<td class='judul2'><font color='#ffff00' size='5'><b>$huruf</b></font></td>";
	echo "<td class='judul2'>URL</td>";
	echo "<td class='judul2'>Nama URL</td>";
	echo "<td class='judul2'>Keterangan</td>";
	echo "<td class='judul2'>Edit</td>";
	echo "<td class='judul2'>Hapus</td>";
	echo "</tr>\n";

  do {
    echo "<tr><td bgcolor='#cfcfcf' class='isi'>&nbsp;</td><td>$row[0]</td>\n";
    echo "<td class='isi'><a href='$row[0]' target='_Hahaha'>$row[1]</a></td>\n";
    echo "<td class='isi'>$row[1]</td>";
		echo "<td class='isi'><a href='edit_url.php?kode_url=$row[3]'>Edit</a></td>";
    echo "<td class='isi' align='center'><a href='hapus_url.php?kode_url=$row[3]'><img src='../gambar/del.gif' border='0'></a></td>";
		echo "</tr>\n";
    } 
 
  while ($row=mysql_fetch_array($result));
    echo "</table><p>\n";
    echo "</center>\n";
  } 
        
else {
  echo "<center>\n";
  echo "<p><b>Tidak ada URL dalam direktori ini"; 
	if ($huruf) {
	  echo " yang berawalan huruf <font size='4' color='#ff0000'>$huruf</font>";
	  }
	echo " !</b><p>\n";
	echo "</center>\n";
  } 

//Membuat alpabet

echo "<p><center><hr size='1'>\n";
echo "<font size='-2'>\n";
for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='isi_direktori.php?pdirektorinav=$pdirektorinav&huruf=$i'><b>$i</b></a>-\n";
  }
echo "<A href='isi_direktori.php?pdirektorinav=$pdirektorinav&huruf='>Semua</A>";
echo "</font>\n";
echo "</center>\n";
?>
<hr size="1">
</body>
</html>