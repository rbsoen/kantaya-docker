<?php

/////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Pilih Pengguna untuk Menjadi Anggota Grup
////////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Lihat Calon Anggota</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>
<script language="JavaScript">
function BukaJendelaBaru(kode_pengguna1){
  reWin=window.open('profile_pengguna.php?kode_pengguna1='+kode_pengguna1,'Profile_Pengguna','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=350,top=100,left=100')
  }
</script>
</head>

<body>

<?php

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);


$sql=mysql_query ("SELECT kode_pengguna, nama_pengguna from pengguna where nama_pengguna like '$huruf%' order by nama_pengguna");

if ($row=mysql_fetch_array($sql)) {
  echo "<center>\n";
  echo "Klik di depan nama pengguna, untuk memilih anggota Grup !<p>\n";
	echo "Tanda <b>X</b>: Pengguna tersebut sudah menjadi anggota Grup ini !</p>";
  echo "<form method='post' action='tambah_anggota_grup.php'>\n";
  echo "<table border='1'>\n";
  echo "<tr bgcolor='#CFCFCF'><td><b><font color='#0000ff' size='5'>$huruf</font></b></td><td>Pilih</td><td>Nama Pengguna</td></tr>\n";

  do {
	
	$sql2=mysql_query("SELECT kode_pengguna from grup_pengguna where kode_grup='$kode_grup' AND kode_pengguna='$row[0]'");
		
		if ($sama=mysql_fetch_row($sql2)){	
    echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td>X</td>\n";
    echo "<td><a
href='javascript:BukaJendelaBaru($row[0])'>$row[1]</a></td></tr>\n";
    }
		
		else {
		  echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td><input type='checkbox' name='pilihan[]' value='$row[0]'></td>\n";
    echo "<td><a
href='javascript:BukaJendelaBaru($row[0])'>$row[1]</a></td></tr>\n";
			}
		
		
		} 
 
  while ($row=mysql_fetch_array($sql));
  echo "<tr><td bgcolor='#cfcfcf'>&nbsp;</td><td colspan='2'><input type='submit' value='Simpan Menjadi Anggota Grup'>\n";
  echo "</table>\n";
  echo "<input type='hidden' name='kode_grup' value='$kode_grup'>\n";
  echo "</form>\n";
  } 
        
else {
  print "Tidak ada pengguna dengan nama $huruf .... !\n";
  } 

//Membuat alpabet
echo "<p><hr size='1'>\n";
    echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'>\n";
for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='lihat_calon_anggota.php?huruf=$i&kode_grup=$kode_grup'>$i</a> - \n";
}
echo "<A href='lihat_calon_anggota.php?huruf=&kode_grup=$kode_grup'>Semua</A>\n";
echo "<hr size='1'>";
echo "</center>\n";
?>

</body>
</html>