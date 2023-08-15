<?php
include ('../lib/cek_sesi.inc');
$css = "../css/" .$tampilan_css. ".css";
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

echo "<html>\n";
echo "<head>\n";
echo "<title>Manajemen Direktori</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";

if ($pdirektorinav) {
  $dir=mysql_query("SELECT nama_direktori FROM direktori WHERE kode_direktori='$pdirektorinav'");
	$data_dir=mysql_fetch_row($dir);
  }
?>

<body>
<table border="0" width="100%" cellpadding="2">
	<tr>
     <td width="49%" class='judul1'>Lemari 
		 <?php 
		   if ($data_dir) {
		   echo ": ".$data_dir[0];
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
	echo "<tr><td align='center' width='100%'>";
	echo "<br><table border='1' bgcolor='#cccccc' width='100%'>";
  echo "<tr><td bgcolor='#FFFFFF'>";
  echo "<br>";
	echo "Dalam LEMARI ini, Anda dapat mengatur manajemen FILE Anda, mulai dari";
	echo " membuat DIREKTORI, menghapus, menyimpan (upload) file, mencarinya, serta menghapus file<p>\n";
	echo "Jika Anda sudah mempunyai DIREKTORI:\n"; 
	echo "<ul><li>Klik pada <b>nama direktori</b> di frame sebelah kiri, untuk melihat file-file di dalamnya !\n";
	echo "<li>Klik <b>ikon</b> di sebelah kiri nama direktori untuk <b>membuka/menutup</b> sub-direktori di bawahnya !</ul>\n";
	echo "</td></tr>";
	echo "</table>";
	echo "</td></tr>";
	}

else {
?>

  <tr>
    <td width="100%" valign="top">
      <div align="center">
        <center>       
			  <table border="0" cellpadding="4" width="100%" cellspacing="4">
				
					<?php					 
					
					if ($urut=='') {
					  $file=mysql_query("SELECT * from file_tb WHERE direktori='$pdirektorinav'");
						}
					else {
            if ($sort!='1'){
					    $file=mysql_query("SELECT * from file_tb WHERE direktori='$pdirektorinav' order by $urut ASC");
						  $sort='1';
							}
						else {
						  $file=mysql_query("SELECT * from file_tb WHERE direktori='$pdirektorinav' order by $urut DESC");
						  $sort='0';
							}
						
						}
					
					if ($data_file=mysql_fetch_array($file)) {
					?>
					<tr>
						<td width="16%" class="judul2"><a href='isi_direktori.php?pdirektorinav=<?php echo $pdirektorinav; ?>&urut=nama_file&sort=<?php echo $sort; ?>' id='link'>Nama File</a></td>
            <td width="12%" class="judul2"><a href='isi_direktori.php?pdirektorinav=<?php echo $pdirektorinav; ?>&urut=tanggal_dibuat&sort=<?php echo $sort; ?>' id='link'>Tanggal</a></td>
            <td width="10%" class="judul2"><a href='isi_direktori.php?pdirektorinav=<?php echo $pdirektorinav; ?>&urut=ukuran_file&sort=<?php echo $sort; ?>' id='link'>Bytes</a></td>
            <td width="15%" class="judul2"><a href='isi_direktori.php?pdirektorinav=<?php echo $pdirektorinav; ?>&urut=kata_kunci&sort=<?php echo $sort; ?>' id='link'>Kata Kunci</a></td>
            <td width="17%" class="judul2"><a href='isi_direktori.php?pdirektorinav=<?php echo $pdirektorinav; ?>&urut=ctt_perbaikan&sort=<?php echo $sort; ?>' id='link'>Ctt Perbaikan</a></td>
            <td width="25%" class="judul2"><a href='isi_direktori.php?pdirektorinav=<?php echo $pdirektorinav; ?>&urut=keterangan&sort=<?php echo $sort; ?>' id='link'>Keterangan</a></td>
						<td width="5%" class="judul2">Hapus</td>
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
            <td width="25%" valign="top"><font face="Verdana" size="1"><?php echo $data_file[5]; ?></font></td>
						<td width="5%" valign="top" align="center"><font face="Verdana" size="1"><a href="hapus_file.php?status=&kode_file=<?php echo $data_file[0]; ?>&nama_file=<?php echo $data_file[1]; ?>&direktori=<?php echo $kode_pengguna;?>"><img src='../gambar/del.gif' border='0'></a></font></td>
          
          </tr>
					<tr><td colspan="7"><hr size="1"></td>
					</tr><tr><td colspan="7" class="isi1">

					<?php					  
							}							
						while ($data_file=mysql_fetch_array($file));					
            echo "Klik pada salah satu <b>kolom judul</b>, untuk mengurutkan file berdasarkan kolom tersebut !\n";
						echo "<p><a href='upload.php?letak_direktori=$pdirektorinav'>Upload file</a> ke Direktori ini !<p>\n";
						echo "<a href='direktori_baru.php?direktori_induk=$pdirektorinav'>Buat Sub Direktori </a>!</center><p>\n";
						echo "</td>";						
						}
						
					else {
					echo "<tr><td>";
            echo "<center><b>Tidak ada file dalam direktori ini !</b><p>\n";
						echo "<a href='upload.php?letak_direktori=$pdirektorinav'>Upload file</a> sekarang !<p>\n";
						echo "<a href='direktori_baru.php?direktori_induk=$pdirektorinav'>Buat Sub Direktori </a>!</center><p>\n";
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
