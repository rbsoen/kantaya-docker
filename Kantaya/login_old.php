<?php
/******************************************
Nama File : login.php
Fungsi    : Memproses pengguna untuk masuk ke sistem.
Dibuat    :	
 Tgl.     : 
 Oleh     : KB
 
Revisi 1	:	
 Tgl.     : 20-11-2001
 Oleh     : AS
 Revisi   : Session tampilan css.

******************************************/
//Konek ke database
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");

//Cek username dan password
	$sql=mysql_query ("SELECT
     		kode_pengguna, 
     		nama_pengguna,
     		level,
     		email,
     		unit_kerja,
     		tampilan_css
     		FROM pengguna
     		where username='$username' AND password='$password'");

	if ($row=mysql_fetch_array($sql)) {
  		$kode_pengguna=$row['0'];
		  $nama_pengguna=$row['1'];
  		$level=$row["2"];
  		$email=$row["3"];
  		$unit_pengguna=$row['4'];
  		$tampilan_css=$row['5'];

		//default adalah kantaya.css
  		if ($tampilan_css=='') $tampilan_css='kantaya';

	  	session_register("kode_pengguna", "nama_pengguna", "level", "email", "unit_pengguna", "tampilan_css");
  		header('Location: agenda/buka_agenda.php');
  } else {
      echo "<center>";
      echo "<p>&nbsp;<p><font face='Verdana' size='2'>";
      echo "Login Anda <b><font color='#ff0000'>salah</font></b>. Silakan mencoba lagi dengan klik <a href='/index.php'>di sini</a> !";
      echo "</font>";
      echo "<p></center>";
  }
?>
