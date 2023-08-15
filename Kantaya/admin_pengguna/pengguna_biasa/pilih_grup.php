<?php

//////////////////////////////////////////////////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Memilih Menjadi Anggota Grup
/////////////////////////////////////////////////////////////////////////////////////

//Cek keberadaan sesi (session)
include ('../../lib/cek_sesi.inc');

//Koneksi ke database
require("../../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Edit Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>
<script language="JavaScript">

function BukaJendelaAnggota(kode_grup){
reWin=window.open('lihat_anggota_grup.php?huruf=&kode_grup='+kode_grup,'Anggota_Grup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=300,top=100,left=100')
}

</script>
</head>

<body>
<?php


$sql="SELECT 
      kode_grup, nama_grup  
      FROM grup
      WHERE nama_grup LIKE '$huruf%' and sifat_grup='bebas' and status='1'
      ORDER BY nama_grup";

$result = mysql_query($sql);

if ($row=mysql_fetch_array($result)) {
  echo "Klik di belakang nama grup, untuk menjadi anggota grup !<p>\n";
	echo "Tanda <b>X</b>: Anda sudah menjadi anggota Grup tersebut !<ul>";
  echo "<form method='post' action='pilih_grup2.php'>\n";
  echo "<center><table border='1'>\n";
  echo "<tr><td class='judul2'><h2><font color='#0000ff'>$huruf</font></h2></td><td class='judul2'>Nama Grup</td>
	<td class='judul2'>Pilih Grup</td><td class='judul2'>Anggota Grup</td></tr>\n";

  do {
	
	  $sql2=mysql_query("SELECT kode_grup from grup_pengguna where kode_grup='$row[0]' AND kode_pengguna='$kode_pengguna'");
		
		if ($sama=mysql_fetch_row($sql2)){	
      echo "<tr><td bgcolor='#EFEFEF'>&nbsp;</td><td><b>$row[1]</b></td>\n";
      echo "<td align='center'><font size='-1'>X</font></td>\n";
      echo "<td><br><input type='button' onClick='javascript:BukaJendelaAnggota($row[0])' value='Lihat_Anggota'></td></tr>\n";
      }
			
		else {
		  echo "<tr><td bgcolor='#EFEFEF'>&nbsp;</td><td><b>$row[1]</b></td>\n";
      echo "<td align='center'><input type='checkbox' name='pilihan[]' value='$row[0]'></td>\n";
      echo "<td><br><input type='button' onClick='javascript:BukaJendelaAnggota($row[0])' value='Lihat_Anggota'></td></tr>\n";
			}		
		
		} 
 
  while ($row=mysql_fetch_array($result));
    echo "<tr><td colspan='4' bgcolor='#efefef' align='center'><input type='submit' value='Simpan'></td>\n";
    echo "</table></ul>\n";
    echo "</form>\n";
  } 
        
else {
  print "<p><b>Tidak ada grup dengan nama berawalan '$huruf' .... !</b><p>\n";
  } 

//Membuat alpabet untuk melihat grup yang ada
echo "<p><center><hr size='1'>\n";
echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1'>\n";
for ($i='A', $k=1; $k<=26; $i++, $k++) {
  echo "<a href='pilih_grup.php?huruf=$i'>$i</a> - \n";
  }
echo "<A href='pilih_grup.php?huruf='>Semua</A>\n";
echo "</font>\n";
echo "<center><hr size='1'>\n";
?>
</body>
</html>