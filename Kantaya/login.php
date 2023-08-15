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
Revisi 2	:
 Tgl.     : 27-11-2001
 Oleh     : FB
 Revisi   : Konfigurasi File
Revisi 3	:
 Tgl.     : 17-08-2021
 Oleh     : rbsoen
 Revisi   : perbaikan sintax php
******************************************/

//Cek Konfigurasi File
$database = "kantaya";
if (cek_cfgfile($database)) {
    require("cfg/$database.cfg");
} else {
  echo "<center>";
  echo "<p>&nbsp;<p><font face='Verdana' size='2'>";
  echo "Login Anda <b><font color='#ff0000'>salah</font></b>. Silakan mencoba lagi dengan klik <a href='index.php'>di sini</a> !";
  echo "</font>";
  echo "<p></center>";
}

//Konek ke database
mysql_connect ($db_host, $db_user, $db_pswd) or die ('Tidak bisa koneksi');
mysql_select_db ($db_database) or die ('Tidak bisa koneksi ke Database kantaya');

// Rev.3: globals diganti menjadi $_POST
$username = $_POST['username'];
$password = $_POST['password'];

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
        $cfgfile = "$database.cfg";

		//default adalah kantaya.css
  		if ($tampilan_css=='') $tampilan_css='kantaya';
  		
        session_start();
  		
        $_SESSION['kode_pengguna'] = $kode_pengguna;
        $_SESSION['nama_pengguna'] = $nama_pengguna;
        $_SESSION['level'] = $level;
        $_SESSION['email'] = $email;
        $_SESSION['unit_pengguna'] = $unit_pengguna;
        $_SESSION['tampilan_css'] = $tampilan_css;
        $_SESSION['cfgfile'] = $cfgfile;
        
  		header('Location: agenda/buka_agenda.php');
  } else {
      echo "<center>";
      echo "<p>&nbsp;<p><font face='Verdana' size='2'>";
      echo "Login Anda <b><font color='#ff0000'>salah</font></b>. Silakan mencoba lagi dengan klik <a href='index.php'>di sini</a> !";
      echo "</font>";
      echo "<p></center>";
  }


function cek_cfgfile($database) {
    $cfgfile = "cfg/$database.cfg";
    if (file_exists($cfgfile)) {
        return TRUE;
    } else {
        return FALSE;
    }
}
?>
