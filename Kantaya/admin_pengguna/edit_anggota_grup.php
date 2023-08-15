<?php

//Dibuat oleh: KB
//Fungsi: Mengedit Anggota Grup

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Anggota Grup</title>\n";
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


$sql=mysql_query ("SELECT 
     pengguna.kode_pengguna, 
     pengguna.nama_pengguna, 
		 grup.nama_grup 
		   FROM pengguna, grup, grup_pengguna 
			   where grup.kode_grup = grup_pengguna.kode_grup and pengguna.kode_pengguna = grup_pengguna.kode_pengguna and grup.kode_grup ='$kode_grup'");

if ($row=mysql_fetch_array($sql)) {
  echo "<b>Klik form di belakang nama pengguna, untuk <font color='#ff0000'>mencabut keanggotaan</font> Grup</b> !<p>";
  echo "<form method='post' action='edit_anggota_grup2.php'>\n";
  echo "<center>\n<table border='1'>";
  echo "<tr bgcolor='#CFCFCF'><td>Nama Anggota</td><td>Cabut Keanggotaan</td></tr>\n";

  do {
     echo "<tr><td><a href='javascript:BukaJendelaBaru($row[0])'>$row[1]</a></td>\n";
     echo "<td align='center'><input type='checkbox' name='pilihan[]' value='$row[0]'></td></tr>\n";
     } 
 
  while ($row=mysql_fetch_array($sql));
    echo "<tr><td colspan='2'><input type='submit' value='Hapus Keanggotaan Grup'></td></tr>\n";
    echo "</table>\n";
    echo "<input type='hidden' name='kode_grup' value='$kode_grup'>\n";
    echo "</form></center>\n";
  } 
        
else {
  print "Grup ini tidak punya anggota !\n";
  } 

echo "<hr size='1'>";
echo "<b>Jika Anda ingin <font color='#ff0000'>menambah anggota</font> Grup, klik salah satu abjad di bawah ini !</b><br>\n";
//Membuat alpabet

for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='lihat_calon_anggota.php?huruf=$i&kode_grup=$kode_grup'>$i</a> - ";
  }

echo "<A href='lihat_calon_anggota.php?huruf=&kode_grup=$kode_grup'>Semua</A>\n";
echo "<hr size='1'>\n";

?>

</body>
</html>