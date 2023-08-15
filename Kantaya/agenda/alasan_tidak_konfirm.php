<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
$css = "../css/".$tampilan_css.".css";
if (isset($kirim)) {
	 $qry = "UPDATE undangan_pengguna SET konfirmasi = 0, alasan = '$alasan' 
		 	 		where kode_agenda=$kode_agenda and kode_pengguna=$kode_pengguna";
   $hsl = mysql_query($qry,$dbh);
   if (!$hsl) {echo mysql_error();}
	 else { echo "<html><head></head><body onload=window.close()></body></html>"; }
}
else {
   $hsl = mysql_query("select judul from agenda where kode_agenda=$kode_agenda",$dbh);
   $dat = @mysql_fetch_row($hsl);
   $judul = $dat[0];
   echo "
<html>

<head>
<title>Alasan tidak konfirm</title>
<link rel=stylesheet type='text/css' href='$css'>
<meta http-equiv='Content-Style-Type' content='text/css'>
</head>

<body>

<div align=center>
<form NAME=alasan METHOD=POST ACTION='alasan_tidak_konfirm.php'>
<input type=hidden name=kode_agenda value='$kode_agenda'>
  <center>
  <table border=1 cellpadding=4 cellspacing=0 width=400 bordercolor=008080>
    <tr>
      <td><font face=Verdana size=3><b>Undangan Kegiatan</b></font></td>
    </tr>
    <tr>
      <td class=judul2><p align=center><b><font face=Verdana size=3>$judul</font></b></td>
    </tr>
    <tr>
      <td><font size=2 face=Verdana>Alasan tidak bisa:</font>
        <p align=center><font size=2 face=Verdana><textarea rows=5 name=alasan cols=35></textarea></p>
        <p align=center><input type=submit value='Kirim' name='kirim'></td>
    </tr>
  </table>
  </center>
</form>
</div>

</body>

</html>
";
}
mysql_close($dbh);
?>

