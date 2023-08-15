<?php
include ("../lib/cek_sesi.inc");
$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Direktori Baru</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";
?>
<table border="0" cellpadding="2" width="100%" cellspacing="0">
   <tr>
      <td width="49%" class="judul1">Lemari</td>
      <td width="10%" align="center" class="judul1"><a href="cari_file.php?kata_kunci=">Cari</a></td>
      <td width="10%" bgcolor="#000080" align="center" class="judul1">Direktori</td>
      <td width="10%" align="center" class="judul1"><a href="upload.php">Upload</a></td>
   </tr>
</table>
<?php
if (!$nama_direktori) {
  echo "<center>";
	echo "<p>Anda harus menuliskan Nama Direktori !<p>\n";
  echo "<a href='javascript:history.go(-1)'>Ulangi Lagi !</a>\n";
	echo "</center>";
	exit;
	}
	
else {
  echo mysql_error();
	}

require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

//if ($direktori_induk!="") {
  $nama=mysql_query("SELECT nama_direktori 
	      FROM direktori 
	      WHERE nama_direktori='$nama_direktori' 
				AND dibuat_oleh='$kode_pengguna'");
  $hasil_nama=mysql_fetch_row($nama);										

  if ($hasil_nama) {
    echo "<p>Anda sudah mempunyai direktori <b>$nama_direktori</b> !<p>\n";
		echo "Dalam sistem ini tidak diperbolehkan membuat dua direktori dengan nama sama, walaupun induk direktorinya berbeda !<p>\n";
	  echo "<a href='javascript:history.go(-1)'>Ulangi Lagi !</a><p>\n";
    exit;
	  }
  //}
if ($sharing=="1" OR $sharing=="0") {
  $data=mysql_query("INSERT INTO direktori 
	                 (nama_direktori, direktori_induk, keterangan, sharing_publik, tanggal_dibuat, dibuat_oleh)
									 VALUES
									 ('$nama_direktori', '$direktori_induk', '$keterangan', '$sharing', now(), '$kode_pengguna')");
	if ($data) {
  echo "<center><p>";
	echo "Penambahan direktori <b>SUKSES</b> !<p>\n";
	echo "Klik <a href='nav_direktori.php?pdirektorinav=' target='navigasi'>di sini untuk melihatnya !<p>\n";
	echo "</center>";

		}
	else {
	  echo "Penambahan direktori GAGAL !<p>\n";
		echo mysql_error();
		}
	
  }

else {
?>	
<form method="post" action="direktori_baru3.php">	
<table border="0" width="100%" cellpadding="2">
  <tr>
    <td width="100%" valign="top">
      <div align="center">
        <center>
        <table border="0" cellpadding="2" width="500">
          <tr>
            <td colspan="2" class="judul2">Buat Direktori Baru</td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Nama direktori</font></td>
            <td valign="top" bgcolor="#EFEFEF">
                <input type="text" name="nama_direktori" size="30" value='<?php echo $nama_direktori; ?>'>
            </td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Direktori Induk</font></td>
            <td valign="top" bgcolor="#EFEFEF"><select name="direktori_induk">
                <?php
								$sql=mysql_query("SELECT kode_direktori,
								             nama_direktori 
														 FROM direktori 
														 WHERE kode_direktori='$direktori_induk'");
								
								if ($data=mysql_fetch_row($sql)) {
								  echo "<option value='$data[0]'>$data[1]</option>\n";								
																		
									}
								
								else {
								  echo "<option value=''>Tidak Ada</option><p>\n";
								  echo mysql_error();
									}
									echo "</select>\n";
								?>								
            </td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Keterangan</font></td>
            <td valign="top" bgcolor="#EFEFEF">
                <textarea rows="2" name="keterangan" cols="30"><?php echo $keterangan; ?></textarea>
            </td>
          </tr>
          <tr>
            <td valign="top" bgcolor="#EFEFEF"><font size="2" face="Verdana">Penggunaan Bersama<br>(<i>sharing</i>)</font></td>
            <td valign="top" bgcolor="#EFEFEF">
                <input type="radio" name="sharing" value="Publik" disabled><font size="2" face="Verdana">Publik</font><br>
                <?php
								
								//Jika sharing Unit Kerja
								
								if ($sharing=="Unit") {
                  echo "<input type='radio' name='sharing' value='Unit' checked><font size='2' face='Verdana'>Unit Kerja tertentu</font>";
									echo "<ul>";

									$sql_unit=mysql_query("SELECT kode_unit, nama_unit from unit_kerja ORDER BY nama_unit");
									if ($unit=mysql_fetch_array($sql_unit)) {
									  do {
										  echo "<input type='checkbox' name='unit[]' value='$unit[0]'>$unit[1]<br>\n";
											}
										
										while ($unit=mysql_fetch_array($sql_unit));
                    }
									echo "</ul>";
							  }
								
								else {
								  echo "<input type='radio' name='sharing' value='Unit' disabled><font size='2' face='Verdana'>Unit Kerja tertentu</font><br>";
                  }
									 
                //Jika sharing Grup
								
								if ($sharing=="Grup") {
                  echo "<input type='radio' name='sharing' value='Grup' checked><font size='2' face='Verdana'>Grup tertentu</font>";
									echo "<ul>";

									$sql_grup=mysql_query("SELECT kode_grup, nama_grup from grup WHERE status='1' ORDER BY nama_grup");
									if ($grup=mysql_fetch_array($sql_grup)) {
									  do {
										  echo "<input type='checkbox' name='grup[]' value='$grup[0]'>$grup[1]<br>\n";
											}
										
										while ($grup=mysql_fetch_array($sql_grup));
                    }
									echo "</ul>";
							  }
								
								else {
								  echo "<input type='radio' name='sharing' value='Grup' disabled><font size='2' face='Verdana'>Grup tertentu</font><br>";
                  }
									 
								//Jika sharing Pengguna
								
								if ($sharing=="Pengguna") {
                  echo "<input type='radio' name='sharing' value='Pengguna' checked><font size='2' face='Verdana'>Pengguna tertentu</font>";
									echo "<ul>";

									$sql_pengguna=mysql_query("SELECT kode_pengguna, nama_pengguna from pengguna ORDER BY nama_pengguna");
									if ($pengguna=mysql_fetch_array($sql_pengguna)) {
									  do {
										  echo "<input type='checkbox' name='pengguna[]' value='$pengguna[0]'>$pengguna[1]<br>\n";
											}
										
										while ($pengguna=mysql_fetch_array($sql_pengguna));
                    }
									echo "</ul>";
							  }
								
								else {
								  echo "<input type='radio' name='sharing' value='Pengguna' disabled><font size='2' face='Verdana'>Pengguna tertentu</font><p>";
                  }
									 
								?>               
 				     </td>
          </tr>
          <tr>
            <td bgcolor="#EFEFEF" align="center">
                &nbsp;
            </td>
            <td bgcolor="#EFEFEF">
                <input type="submit" value="Simpan" name="B3">
            </td>
          </tr>
        </table>
        </center>
      </div>
      </form>
    </td>
  </tr>
</table>

<?php
}
?>
</body>
</html>
