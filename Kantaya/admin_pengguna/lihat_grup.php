<?php

////////////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Edit Grup
///////////////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Lihat Grup</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>
<script language="JavaScript">
function BukaJendelaAnggota(kode_grup){
  reWin=window.open('edit_anggota_grup.php?huruf=&kode_grup='+kode_grup,'Anggota_Grup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=350,top=100,left=100')
  }

function BukaJendelaGrup(kode_grup){
  reWin=window.open('edit_grup2.php?huruf=&kode_grup='+kode_grup,'Anggota_Grup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=300,top=100,left=100')
  }
</script>
</head>

<body>
<?php


//Menampilkan grup milik pengguna
$result = mysql_query("SELECT kode_grup, nama_grup, sifat_grup, status FROM grup 
WHERE status='1' and nama_grup like '$huruf%' order by nama_grup");
if ($data=mysql_fetch_array($result)) {
  echo "<center>Berikut adalah Semua Grup yang Ada:<p>\n";
  echo "<table border='1' cellpadding='2' cellspacing='0'>\n";
  echo "<tr><td class='judul2'>Nama Grup</td><td class='judul2'>Sifat Grup</td><td class='judul2'>Status</td><td class='judul2'>Anggota</td></tr>\n";
  do {   
    echo "<tr><td><a href='javascript:BukaJendelaGrup($data[0])'>$data[1]</a></td>
    <td>$data[2]</td>
    <td>\n";
    if ($data[3]=="1") {
      echo "Aktif";
      }
    else {
      echo "Non Aktif";
      }
      
    echo "</td>
    <td><br><form><input type='button' onClick='javascript:BukaJendelaAnggota($data[0])' value='Edit_Anggota'></form></td>
    </tr>\n";
    }
  
  while ($data=mysql_fetch_array($result));
    echo "</table>\n";  

  }

else {
  echo "Tidak ada Grup yang berawalan huruf <b>$huruf</b> .... !\n";
  }

//Membuat alpabet

echo "<p><center><hr size='1'>\n";
echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'>\n";
for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='lihat_grup.php?huruf=$i'>$i</a> - \n";
  }
echo "<A href='lihat_grup.php?huruf='>Semua</A>";
echo "</font>\n";
echo "<hr size='1'></center>\n";
?>

</body>
</html>