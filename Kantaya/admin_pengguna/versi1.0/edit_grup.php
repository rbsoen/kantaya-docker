<?php

//Dibuat oleh: KB
//Fungsi: Edit Grup

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');

//Koneksi ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");
?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Profile Pengguna</title>
<script language="JavaScript">

function BukaJendelaAnggota(kode_grup){
reWin=window.open('anggota_grup.php?kode_grup='+kode_grup,'Anggota_Grup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=350,top=100,left=100')
}

function BukaJendelaGrup(kode_grup){
reWin=window.open('edit_grup2.php?kode_grup='+kode_grup,'Anggota_Grup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=470,height=300,top=100,left=100')
}

</script>
</head>

<body>
<?php

$result = mysql_query("SELECT kode_grup, nama_grup FROM grup WHERE dibuat_oleh='$kode_pengguna' order by nama_grup");
if ($data=mysql_fetch_array($result)) {
  echo "Berikut adalah Grup yang Anda pimpin:";
  echo "<table border='1'>";
  echo "<tr><td>Nama Grup</td><td>Anggota</td></tr>";
  do {   
    echo "<tr><td><a href='javascript:BukaJendelaGrup($data[kode_grup])'>$data[nama_grup]</a></td><td><form><input type='button' onClick='javascript:BukaJendelaAnggota($data[kode_grup])' value='Edit_Anggota'></form></td></tr>";
    }
  
  while ($data=mysql_fetch_array($result));
    echo "</table>";  

  }

else {
  echo "Anda tidak mempunyai Grup di bawah pimpinan Anda !";
  }

?>

</body>
</html>
