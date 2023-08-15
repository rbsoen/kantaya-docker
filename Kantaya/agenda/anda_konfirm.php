<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
$css = "../css/".$tampilan_css.".css";
$hsl = mysql_query("select judul from agenda where kode_agenda=$kode_agenda",$dbh);
$dat = @mysql_fetch_row($hsl);
$judul = $dat[0];
$hsl0 = mysql_query("UPDATE undangan_pengguna SET konfirmasi=1, alasan=''  
		 	 where kode_agenda=$kode_agenda and kode_pengguna=$kode_pengguna",$dbh);
$hsl1 = mysql_query("select * from agenda where kode_agenda=$kode_agenda",$dbh);
if (!($hsl0 and $hsl1)) {echo mysql_error();}
else {
   $dat = @mysql_fetch_row($hsl1);
	 $query  = "INSERT INTO agenda ";
	 $query .= "VALUES ('', $kode_pengguna, '$dat[2]', '$dat[3]', '$dat[4]',";
	 $query .= "'$dat[5]','$dat[6]',0,$dat[0],'$dat[9]',curdate(),";
	 $query .= "curdate(),'',0)";
	 $cek = mysql_query("select * from agenda where pemilik=$kode_pengguna and kode_undangan=$kode_agenda",$dbh);
	 if (!$cek) { $hsl2 = false; }
	 else { $hsl2 = (mysql_num_rows($cek)==0)?(mysql_query($query,$dbh)):(true); }
	 if(!$hsl2) {echo  "@simpan kegiatan dari undangan:".mysql_error();}
	 else {
echo "
<html>

<head>
<title>Konfirmasi Undangan</title>
<link rel=stylesheet type='text/css' href='$css'>
<meta http-equiv='Content-Style-Type' content='text/css'>
</head>

<body>

<div align=center>
  <center>
  <table border=1 cellpadding=4 cellspacing=0 width=400 bordercolor='#008080'>
    <tr>
      <td><font face=Verdana size=3><b>Kegiatan :</b></font></td>
    </tr>
    <tr>
      <td class=judul2><p align=center><b><font face=Verdana size=3>$judul</font></b></td>
    </tr>
    <tr>
      <td><font size=2 face=Verdana>Terima kasih,<br>
        -Anda telah menyatakan bersedia untuk memenuhi undangan kegiatan ini.<br>
        -Kegiatan ini akan otomatis masuk ke agenda Anda !";
if ($dat[7]<>0) {
	 echo "<br>-Kegiatan berulang ! Pengulangannya belum dimasukkan ke agenda Anda !";
}
echo "
				</font><p align=center>
<input type=button value=Tutup name=B3 onclick='window.close()'></td>
    </tr>
  </table>
  </center>
</div>

</body>

</html>
";
   }
}
mysql_close($dbh);
?>
