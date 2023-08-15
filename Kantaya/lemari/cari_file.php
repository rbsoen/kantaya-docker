<?php
include ("../lib/cek_sesi.inc");							 
echo "<html>\n";
echo "<head>\n";
echo "<title>Upload Direktori Sharing</title>\n";
$css = "../css/" .$tampilan_css. ".css";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";
?>
<table border="0" cellpadding="2" width="100%" cellspacing="2">
   <tr>
      <td width="49%" class="judul1">Lemari</td>
      <td width="10%" align="center" class="judul1">Cari</td>
      <td width="10%" bgcolor="#000080" align="center" class="judul1"><a href="isi_direktori.php">Direktori</a></td>
      <td width="10%" align="center" class="judul1"><a href="upload.php">Upload</a></td>
   </tr>
</table>
<table border="0" cellpadding="2" width="100%" cellspacing="0">
  <tr>
    <td width="98%" valign="top">    	
	  <?php
	  if ($kata_kunci=="") {
	  ?>
      <div align="center">
      <center><p>&nbsp;<br>
			<font size="3" face="Verdana"><b>Pencarian File</b></font>:
			<form>
			<hr size="1">
      <table border="0" cellpadding="2" width="100%" bgcolor="#C0C0C0">
        <tr>
          <td width="33%"><font size="2" face="Verdana">Cari:</font> <input type="text" name="kata_kunci" size="15">
          </td>
          <td width="33%"><font size="2" face="Verdana">di:</font>
				<select size="1" name="jenis">
                <option value="1">Nama File</option>
                <option value="2">Kata Kunci</option>
                <option value="3">Catatan Perbaikan</option>
                <option value="4">Keterangan</option>
              </select>
          </td>
          <td width="34%" align="center">
					    <?php
							/*
							<font size="2" face="Verdana">per halaman </font> <select size="1" name="halaman">
              <option>10</option>
              <option>20</option>
              <option>30</option>
              <option>40</option>
              <option>50</option>
            </select>&nbsp; 
						*/
						?>
						<input type="submit" value="Cari Sekarang!" name="B1">
          </td>
        </tr>
      </table>
			<hr size="1">
      </center>
      </div>
      </form>
			</table>
      <?php
      exit;
       }

		  require("../cfg/$cfgfile");
      $db = mysql_connect($db_host, $db_user, $db_pswd);
      mysql_select_db($db_database, $db);
			
			//Proses pencarian file Pribadi	
			$sql="SELECT 
			     kode_file, 
					 nama_file, 
					 file_tb.tanggal_dibuat, 
					 ukuran_file, 
					 kata_kunci, 
					 ctt_perbaikan, 
					 file_tb.keterangan, direktori.kode_direktori, direktori.nama_direktori
					   FROM file_tb, direktori 
					     WHERE file_tb.direktori=direktori.kode_direktori AND";
						 
			if ($jenis=="1"):
			  $sql=mysql_query($sql. "
				     file_tb.nama_file LIKE '%$kata_kunci%' AND file_tb.dibuat_oleh='$kode_pengguna' ORDER BY nama_file");
			elseif ($jenis=="2"):
			  $sql=mysql_query($sql. " 
			       file_tb.kata_kunci LIKE '%$kata_kunci%' AND file_tb.dibuat_oleh='$kode_pengguna' ORDER BY nama_file");
  		elseif ($jenis=="3"):
			  $sql=mysql_query($sql. " 
			       file_tb.ctt_perbaikan LIKE '%$kata_kunci%' AND file_tb.dibuat_oleh='$kode_pengguna' ORDER BY nama_file");
			else:
			  $sql=mysql_query($sql. "
			       file_tb.keterangan LIKE '%$kata_kunci%' AND file_tb.dibuat_oleh='$kode_pengguna' ORDER BY nama_file");
					 
			endif;
			
			if ($data=mysql_fetch_array($sql)):
			  ?>
			
			    <p>&nbsp;<br><b><font size="2" face="Verdana">Hasil Pencarian File:</b><br>
					&nbsp;&nbsp;&nbsp;==> kata kunci: <b><font color='##ff0000'><?php echo $kata_kunci; ?></font></b>, di:<b>
					<font color='##ff0000'>
					<?php
					if ($jenis=="1"):
					  echo "Nama File";
					elseif ($jenis=="2"):
					  echo "Kata Kunci";
					elseif ($jenis=="3"):
					  echo "Catatan Perbaikan";
					else:
					  echo "Keterangan";
					endif;
					?></font></b></font>
        <hr size="1">
      <div align="center">
        <center>
        <table border="0" cellpadding="4" width="100%" cellspacing="4">
          <tr>
            <td width="15%" class="judul3">Nama File</td>
						<td width="15%" class="judul3">Direktori</td>
            <td width="10%" class="judul3">Tanggal</td>
            <td width="10%" class="judul3">Bytes</td>
            <td width="20%" class="judul3">Kata Kunci</td>
            <td width="20%" class="judul3">Ctt Perbaikan</td>
            <td width="20%" class="judul3">Keterangan</td>
            <td width="10%" class="judul3">Hapus</td>
          </tr>

         <?php
         do {
         ?>
          <tr>
            <td width="15%" valign="top"><b><font face="Verdana" size="-2"><a href="download_file.php?file=<?php echo $data[1]; ?>"><?php echo $data[1]; ?></a></font></b></td>
            <td width="15%" valign="top"><font face="Verdana" size="-2"><a href='isi_direktori.php?pdirektorinav=<?php echo $data[7]; ?>'><?php echo $data[8]; ?></a></font></td>
						<td width="10%" valign="top"><font face="Verdana" size="-2"><?php echo $data[2]; ?></font></td>
            <td width="10%" valign="top"><font face="Verdana" size="-2"><?php echo $data[3]; ?></font></td>
            <td width="20%" valign="top"><font face="Verdana" size="-2"><?php echo $data[4]; ?></font></td>
            <td width="20%" valign="top"><font face="Verdana" size="-2"><?php echo $data[5]; ?></font></td>
            <td width="20%" valign="top"><font face="Verdana" size="-2"><?php echo $data[6]; ?></font></td>
            <td width="10%" valign="top" align="center"><a href="hapus_file.php?status=&kode_file=<?php echo $data[0]; ?>&nama_file=<?php echo $data[1]; ?>&direktori=<?php echo $kode_pengguna;?>"><img src='/gambar/del.gif' border='0'></a></td>
          </tr>
          <tr>
            <td width="16%" valign="top"></td>
            <td width="14%" valign="top"></td>
            <td width="11%" valign="top"></td>
            <td width="20%" valign="top"></td>
            <td width="19%" valign="top"></td>
            <td width="20%" valign="top"></td>
            <td width="17%" valign="top"></td>
          </tr>
          <?php
          }

          while ($data=mysql_fetch_array($sql));
          ?>
        </table>
        <hr size="1">
        </center>
			
			<?php
			else:
			  echo "<center><p>&nbsp;<br>";
				echo "<b>Tidak ditemukan !</b><p>";
				echo mysql_error();
				echo "<hr size='1'>";
				echo "</center>";
			
			endif;				
      ?>
			<div align="center">
      <center><p><form>
      <table border="0" cellpadding="2" width="100%" bgcolor="#C0C0C0">
        <tr>
          <td width="33%"><font size="2" face="Verdana">Cari:</font> <input type="text" name="kata_kunci" size="15">
          </td>
          <td width="33%"><font size="2" face="Verdana">di:</font>
				<select size="1" name="jenis">
                <option value="1">Nama File</option>
                <option value="2">Kata Kunci</option>
                <option value="3">Catatan Perbaikan</option>
                <option value="4">Keterangan</option>
              </select>
          </td>
					
          <td width="34%" align="center">
					<?php
					/*
					<font size="2" face="Verdana">per halaman </font> <select size="1" name="halaman">
              <option>10</option>
              <option>20</option>
              <option>30</option>
              <option>40</option>
              <option>50</option>
            </select>&nbsp; 
						*/
						?>
						<input type="submit" value="Cari Sekarang !" name="B1">
          </td>										
        </tr>
      </table>
      </center>
      </div>
      </form>
    </td>
  </tr>
</table>
<hr size="1">
</body>
</html>
