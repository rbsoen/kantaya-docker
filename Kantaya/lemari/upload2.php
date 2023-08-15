<?
include ("../lib/cek_sesi.inc");
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Upload File</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
echo "<body>";
	
if ($direktori=="") {
  echo "<center>";
	echo "<p>&nbsp;<br>Anda harus memilih Direktori !<p>\n";
	echo "<a href='javascript:history.go(-1)'>Ulangi Lagi !</a><p>\n";
	echo "</center>";
	exit;
	}
 
// Jika $img1_name ada
if ($img1_name != "") { 

   //Cek apakah ada file yang sama dalam satu direktori
	 
	 $cek=mysql_query("SELECT kode_file, nama_file, direktori FROM file_tb where nama_file='$img1_name' AND dibuat_oleh='$kode_pengguna'");
	 if ($data_cek=mysql_fetch_row($cek)){
	   echo "Anda sudah mempunyai file <b>".$img1_name. "</b> !<p>\n";
	   echo "Dalam sistem ini tidak diperbolehkan menyimpan file dengan nama yang sama, walaupun berbeda direktorinya !<p>\n";
		 echo "Anda bisa melakukan <a href='hapus_file.php?status=&kode_file=$data_cek[0]&nama_file=$data_cek[1]&direktori=$data_cek[2]'>";
		 echo "penghapusan</a> file tersebut atau<p>\n";
		 echo "Anda <a href='javascript:history.go(-1)'>mengganti nama file</a> yang akan diupload terlebih dahulu !<p>\n";
     exit;
		 }

  // upload ke direktori atau pesan gagal (die)

  // jika menggunakan Windows
  //copy("$img1", "D:\\WebKantaya\\lemari\\file_upload\\$img1_name")  

  //Jika menggunakan UNIX
	
	$sql=mysql_query("SELECT dibuat_oleh FROM direktori WHERE kode_direktori='$direktori'");
	
	if ($data=mysql_fetch_row($sql)){
    copy("$img1", "file_upload/".$data[0]."/".$img1_name)
//    rename($induk_dir."/lemari/file_upload/".$data[0]."/".$img1_name, $induk_dir."/lemari/file_upload/".$data[0]."/hahah.php");
		
    or die("File GAGAL di Upload!");  

    //Memasukkan data file ke database
		
	  $sql=mysql_query("INSERT INTO file_tb
	     (nama_file, ukuran_file, kata_kunci, ctt_perbaikan, keterangan, direktori, tanggal_dibuat, dibuat_oleh)
			 VALUES
			 ('$img1_name', '$img1_size', '$kata_kunci', '$ctt_perbaikan', '$keterangan', '$direktori', now(), '$kode_pengguna')
			 ");
	
	  if (!$sql) {
	    echo "Input ke database GAGAL !<p>\n";
		  echo mysql_error();
		  }
		
	  }
	
  } 

else {
  // Jika $img_name Kosong
  die("Tidak ada input file yang akan di-upload !");
  }
?> 
<table summary="konfirmasi" width="100%">
<tr><td class="judul1" colspan="2">Berhasil!</td></tr>
<tr><td width="200"><p>Anda meng-upload file</td>
<td>: <? echo "$img1_name"; ?></td></tr>
<tr><td width="200">Ukuran file
</td><td>: <? echo "$img1_size"; ?> bytes</td></tr>
<tr><td width="200">Tipe file
</td><td>: <? echo "$img1_type"; ?></td></tr>
</table>
<p>
<?php
if ($jenis=="sharing"){
  echo "<a href='isi_direktori_sharing.php?pdirektorinav=$direktori&pemilik=$pemilik'>Lihat di sini !</a>";
	}
else {
  echo "<a href='isi_direktori.php?pdirektorinav=$direktori'>Lihat di sini !</a>";
	}

?>
</body>
</html>
