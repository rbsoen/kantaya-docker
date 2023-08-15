<?php
include ("../lib/cek_sesi.inc");
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);
							 
echo "<html>\n";
echo "<head>\n";
echo "<title>Isi Direktori Bersama</title>\n";
$css = "../css/" .$tampilan_css. ".css";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";

if ($pdirektorinav) {
  $direktori=mysql_query("SELECT nama_direktori FROM direktori WHERE kode_direktori='$pdirektorinav'");
  $data_d=mysql_fetch_row($direktori);
  }
?>

<table border="0" width="100%" cellpadding="2">
	<tr>
     <td width="49%" class='judul1'>Lemari Bersama
		 <?php 
		   if ($data_d) {
		   echo ": ".$data_d[0];
		   }
		 ?>
		 </td>
     <td width="10%" align="center" class='judul1'><a href="cari_file.php?kata_kunci=">Cari</a></td>
     <td width="10%" bgcolor="#000080" align="center" class='judul1'>Direktori</td>
     <td width="10%" align="center" class='judul1'><a href="upload.php">Upload</a></td>
  </tr>
</table>
<?php


if ($pdirektorinav=="") {
  echo "<table border='0' width='100%' cellpadding='2'>";
	echo "<tr><td align='center' width='100%' colspan='4'>";
	echo "<table border='1' bgcolor='#cccccc' width='100%'>";
  echo "<tr><td>";
  echo "<p><center>";
	echo "<font face='Verdana' size='2'>";
	echo "Klik pada <b>nama direktori</b> di frame sebelah kiri, untuk melihat file-file di dalamnya !<p>\n";
	echo "Klik <b>ikon</b> di sebelah kiri nama direktori untuk membuka sub-direktori di bawahnya !<p>\n";
	echo "</font>";
	echo "</center>";
	echo "</td></tr>";
	echo "</table>";
	echo "<p><center><a href='direktori_baru.php'>Buat Direktori Baru</a></center>\n";
	echo "</td></tr>";
	}

else {
?>

  <tr>
    <td width="100%" valign="top">
      <div align="center">
        <center>
							
					<?php
					
					$file=mysql_query("SELECT * from file_tb WHERE direktori='$pdirektorinav' order by nama_file");
					if ($data_file=mysql_fetch_array($file)) {
					  $sql=mysql_query("SELECT nama_pengguna, email FROM pengguna WHERE kode_pengguna='$pemilik'");
						
						if ($data_pemilik=mysql_fetch_row($sql)) {
						?><p>
						<table border="0" width="100%">
					  <tr><td align="left">
						Pemilik Direktori: <b><a href='mailto:<?php echo $pemilik[1]; ?>'><?php echo $data_pemilik[0]; ?></a></b><br>
						</td><td align="right">
						<a href='upload_sharing.php?direktori=<?php echo $pdirektorinav; ?>&pemilik=<?php echo $pemilik; ?>'><b>Upload File</b></a> ke Direktori ini !
					  </td></tr>
						</table>
						<?php
						}
						else {
						  echo mysql_error();
							}
						?>
						   
			  <table border="0" cellpadding="4" width="100%" cellspacing="4">
					<tr>
						<td width="16%" class="judul2">Nama File</td>
            <td width="12%" class="judul2">Tanggal</td>
            <td width="10%" class="judul2">Bytes</td>
            <td width="15%" class="judul2">Kata Kunci</td>
            <td width="17%" class="judul2">Ctt Perbaikan</td>
            <td width="20%" class="judul2">Keterangan</td>
            <td width="10%" class="judul2">Pemilik</td>
          </tr>					
					<?php
					
					  do {
						?>
						<tr>
            <td width="16%" valign="top"><b><font face="Verdana" size="1"><a href="download_file.php?file=<?php echo $data_file[1]; ?>&direktori=<?php echo $data_file[9]; ?>"><?php echo $data_file[1]; ?></a></font></b></td>
            <td width="12%" valign="top"><font face="Verdana" size="1"><?php echo $data_file[7]; ?></font></td>
            <td width="10%" valign="top"><font face="Verdana" size="1"><?php echo $data_file[2]; ?></font></td>
            <td width="15%" valign="top"><font face="Verdana" size="1"><?php echo $data_file[3]; ?></font></td>
            <td width="17%" valign="top"><font face="Verdana" size="1"><?php echo $data_file[4]; ?></font></td>
            <td width="20%" valign="top"><font face="Verdana" size="1"><?php echo $data_file[5]; ?></font></td>
            <td width="10%" valign="top"><font face="Verdana" size="1">
						<?php
						$punya=mysql_query("SELECT nama_pengguna, email FROM pengguna WHERE kode_pengguna='$data_file[9]'");
						if ($data_p=mysql_fetch_row($punya)){				
						  echo "<a href='mailto:$data_p[1]'>$data_p[0]</a>";
							}
						else {
						  echo mysql_error();
							}
						?>
							
						</font></td>						  
					</tr>
					<tr><td colspan="7"><hr size="1"></td>

					<?php					  
							}							
						while ($data_file=mysql_fetch_array($file));					
					  }
						
					else {
					echo "<tr><td class='isi2'>";
            echo "<p><center><b>Tidak ada file dalam direktori ini !</b><p>\n";
						echo "<a href='upload_sharing.php?direktori=$pdirektorinav'>Upload File</a> ke Direktori ini !</center>\n";
						echo mysql_error();
						echo "</td></tr>";
	          }
						
					echo"</tr>";
					echo "</table>";
					?>										
    </td>
  </tr>
  <?php
  }

	
?>
</table>

</body>

</html>
