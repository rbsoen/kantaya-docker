<?php
include ("../lib/cek_sesi.inc");
						 
echo "<html>\n";
echo "<head>\n";
echo "<title>Hapus File</title>\n";
$css = "../css/" .$tampilan_css. ".css";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
?>
<center>
<table border="0" cellpadding="2" width="100%" cellspacing="2">
   <tr>
      <td width="49%" class="judul1">Lemari</td>
      <td width="10%" align="center" class="judul1"><a href="cari_file.php?kata_kunci=">Cari</a></td>
      <td width="10%" bgcolor="#000080" align="center" class="judul1">Direktori</td>
      <td width="10%" align="center" class="judul1"><a href="upload.php">Upload</a></td>
   </tr>
</table>
<p>
<?php

if ($status==""){
  echo "<center>\n";
  echo "Anda yakin akan menghapus file <b>$nama_file</b> ?<p>\n";
	echo "<a href='hapus_file.php?status=ya&kode_file=$kode_file&nama_file=$nama_file&direktori=$direktori'><b>Ya</b></a> | 
	<b><a href='javascript:history.go(-1)'>Tidak</a></b><p>\n";
  echo "</center>\n";
  }	
	
else {

  //Hapus file dari direktori pengguna di hardisk
  $delete=unlink ("file_upload/".$direktori."/".$nama_file);	

  if ($delete) {
	  echo "<center><p>";
    echo "File <b>$nama_file</b> sudah dihapus !<p>\n";	
	  echo "</center>";
		
    //Hapus data file dari database

  	require("../cfg/$cfgfile");

    $db = mysql_connect($db_host, $db_user, $db_pswd);
    mysql_select_db($db_database, $db);
			
  	$sql=mysql_query("DELETE FROM file_tb WHERE kode_file='$kode_file'");
	  if (!$sql) {
	    echo mysql_error();
		  }
	
	  }
	
  else {
    echo "Penghapusan file GAGAL !<p>\n";
	  }
}
?>
<body>
</body>
</html>
