<?php
/******************************************
Nama File : post_kdproyek.php
Fungsi    : Setup kode-kode proyek
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 20-11-2001
 Oleh     : AS
 Revisi   : css,
******************************************/
include ('../lib/cek_sesi.inc');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$js = "<script language='JavaScript'>" ;
$endjs = "</script>\n";

$tgl = date("Y-n-j h:i:s");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

echo "<html>\n";
echo "<head>";
echo "<title>Penambahan Forum dan Topik Diskusi</title>";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width=100% border=0>";
echo "<tr>";
echo "<td class='judul1'>Konfirmasi</td>";
echo "</tr>";
echo "</table>";

switch ($namaform) {
    case "jnsproyek":
         if ($kode=="" or $nama=="") {
             //echo "<h2> Error </h2><br>\n";
             echo "Kode dan nama harus diisi<br>\n";
             exit -1;
         }
         if ($jnstransaksi == 'tambah') {
             $sqltext = "insert into kd_jns_proyek (kode, nama, singkatan, dibuat_oleh, tgl_dibuat) ";
             $sqltext = $sqltext."values ('".$kode."','".$nama."','".$singkatan."','".$kode_pengguna."','".$tgl."')";
         } else {
             $sqltext = "update kd_jns_proyek set kode='$kode', nama='$nama', singkatan='$singkatan', diubah_oleh='$kode_pengguna', tgl_diubah='$tgl' where kode='$kode'";
         }

         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() == 0) {
             echo $js." window.open('kd_jnsproyek.php','isi') ".$endjs;
         }
         else {
             //echo "<h2> Error </h2><br>\n";
             echo mysql_errno().": ".mysql_error()."<br>";
             echo "$sqltext\n";
         }
         break;
    case "jbtnproyek":
         if ($kode=="" or $nama=="") {
             //echo "<h2> Error </h2><br>\n";
             echo "Kode dan nama harus diisi<br>\n";
             exit -1;
         }
         if ($jnstransaksi == 'tambah') {
             $sqltext = "insert into kd_jbtn_proyek (kode, nama, singkatan, dibuat_oleh, tgl_dibuat) ";
             $sqltext = $sqltext."values ('".$kode."','".$nama."','".$singkatan."','".$kode_pengguna."','".$tgl."')";
         } else {
             $sqltext = "update kd_jbtn_proyek set kode='$kode', nama='$nama', singkatan='$singkatan', diubah_oleh='$kode_pengguna', tgl_diubah='$tgl' where kode='$kode'";
         }

         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() == 0) {
             echo $js." window.open('kd_jbtnproyek.php','isi') ".$endjs;
         }
         else {
             //echo "<h2> Error </h2><br>\n";
             echo mysql_errno().": ".mysql_error()."<br>";
             echo "$sqltext\n";
         }
         break;
    case "jnskjsama":
         if ($kode=="" or $nama=="") {
             //echo "<h2> Error </h2><br>\n";
             echo "Kode dan nama harus diisi<br>\n";
             exit -1;
         }
         if ($jnstransaksi == 'tambah') {
             $sqltext = "insert into kd_jns_kjsama (kode, nama, singkatan, dibuat_oleh, tgl_dibuat) ";
             $sqltext = $sqltext."values ('".$kode."','".$nama."','".$singkatan."','".$kode_pengguna."','".$tgl."')";
         } else {
             $sqltext = "update kd_jns_kjsama set kode='$kode', nama='$nama', singkatan='$singkatan', diubah_oleh='$kode_pengguna', tgl_diubah='$tgl' where kode='$kode'";
         }

         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() == 0) {
             echo $js." window.open('kd_jnskjsama.php','isi') ".$endjs;
         }
         else {
            // echo "<h2> Error </h2><br>\n";
             echo mysql_errno().": ".mysql_error()."<br>";
             echo "$sqltext\n";
         }
         break;
    case "jnslembaga":
         if ($kode=="" or $nama=="") {
             //echo "<h2> Error </h2><br>\n";
             echo "Kode dan nama harus diisi<br>\n";
             exit -1;
         }
         if ($jnstransaksi == 'tambah') {
             $sqltext = "insert into kd_jns_lembaga (kode, nama, singkatan, dibuat_oleh, tgl_dibuat) ";
             $sqltext = $sqltext."values ('".$kode."','".$nama."','".$singkatan."','".$kode_pengguna."','".$tgl."')";
         } else {
             $sqltext = "update kd_jns_lembaga set kode='$kode', nama='$nama', singkatan='$singkatan', diubah_oleh='$kode_pengguna', tgl_diubah='$tgl' where kode='$kode'";
         }

         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() == 0) {
             echo $js." window.open('kd_jnslembaga.php','isi') ".$endjs;
         }
         else {
             //echo "<h2> Error </h2><br>\n";
             echo mysql_errno().": ".mysql_error()."<br>";
             echo "$sqltext\n";
         }
         break;
    case "hapusjnsproyek":
         if (count($cb_hapus) == 0) {
            // echo "<h2> Error </h2><br>\n";
             echo "Cek terlebih dahulu kode yang akan anda hapus<br>\n";
             exit -1;
         }
         $j = 0;
         $flag = true;
         for ($i=0; $i<count($cb_hapus); $i++) {
             $sqltext = "delete from kd_jns_proyek where kode='".$cb_hapus[$i]."'";
             $hasil = mysql_query($sqltext, $db);
             if (mysql_errno() == 0) {
                 $j++;
             }
             else {
                 $flag = false;
                 //echo "<h2> Error </h2><br>\n";
                 echo mysql_errno().": ".mysql_error()."<br>";
                 echo "$sqltext\n";
                 exit -1;
             }
         }
         if ($flag) {
             echo $js." window.open('kd_jnsproyek.php','isi') ".$endjs;
         }
         break;
    case "hapusjbtnproyek":
         if (count($cb_hapus) == 0) {
            // echo "<h2> Error </h2><br>\n";
             echo "Cek terlebih dahulu kode yang akan anda hapus<br>\n";
             exit -1;
         }
         $j = 0;
         $flag = true;
         for ($i=0; $i<count($cb_hapus); $i++) {
             $sqltext = "delete from kd_jbtn_proyek where kode='".$cb_hapus[$i]."'";
             $hasil = mysql_query($sqltext, $db);
             if (mysql_errno() == 0) {
                 $j++;
             }
             else {
                 $flag = false;
                // echo "<h2> Error </h2><br>\n";
                 echo mysql_errno().": ".mysql_error()."<br>";
                 echo "$sqltext\n";
                 exit -1;
             }
         }
         if ($flag) {
             echo $js." window.open('kd_jbtnproyek.php','isi') ".$endjs;
         }
         break;
    case "hapuskjsama":
         if (count($cb_hapus) == 0) {
             //echo "<h2> Error </h2><br>\n";
             echo "Cek terlebih dahulu kode yang akan anda hapus<br>\n";
             exit -1;
         }
         $j = 0;
         $flag = true;
         for ($i=0; $i<count($cb_hapus); $i++) {
             $sqltext = "delete from kd_jns_kjsama where kode='".$cb_hapus[$i]."'";
             $hasil = mysql_query($sqltext, $db);
             if (mysql_errno() == 0) {
                 $j++;
             }
             else {
                 $flag = false;
                 //echo "<h2> Error </h2><br>\n";
                 echo mysql_errno().": ".mysql_error()."<br>";
                 echo "$sqltext\n";
                 exit -1;
             }
         }
         if ($flag) {
             echo $js." window.open('kd_jnskjsama.php','isi') ".$endjs;
         }
         break;
    case "hapusjnslembaga":
         if (count($cb_hapus) == 0) {
             //echo "<h2> Error </h2><br>\n";
             echo "Cek terlebih dahulu kode yang akan anda hapus<br>\n";
             exit -1;
         }
         $j = 0;
         $flag = true;
         for ($i=0; $i<count($cb_hapus); $i++) {
             $sqltext = "delete from kd_jns_lembaga where kode='".$cb_hapus[$i]."'";
             $hasil = mysql_query($sqltext, $db);
             if (mysql_errno() == 0) {
                 $j++;
             }
             else {
                 $flag = false;
                // echo "<h2> Error </h2><br>\n";
                 echo mysql_errno().": ".mysql_error()."<br>";
                 echo "$sqltext\n";
                 exit -1;
             }
         }
         if ($flag) {
             echo $js." window.open('kd_jnslembaga.php','isi') ".$endjs;
         }
         break;
}

echo "</body>\n";
echo "</html>\n";

?>

