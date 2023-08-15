<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
$css = "../css/".$tampilan_css.".css";
$hsl = mysql_query("select judul from agenda where kode_agenda=$kode_agenda",$dbh);
$dat = @mysql_fetch_row($hsl);
$judul = $dat[0];
$slct  = "SELECT nama_pengguna, konfirmasi FROM undangan_pengguna, pengguna
			 	 where undangan_pengguna.kode_agenda = $kode_agenda
				 and undangan_pengguna.kode_pengguna = pengguna.kode_pengguna
				 order by nama_pengguna";
$hsl = mysql_query($slct,$dbh);
if (!$hsl) {echo mysql_error();}
else {
echo "
<html>

<head>
<title>Pengguna yang mengkonfirm undangan</title>
<link rel=stylesheet type='text/css' href='$css'>
<meta http-equiv='Content-Style-Type' content='text/css'>
</head>

<body>

<div align=center>
  <center>
  <table border=1 cellpadding=4 cellspacing=0 width=400 bordercolor='#008080'>
    <tr>
      <td colspan=2><font face=Verdana size=3><b>Kegiatan :</b></font></td>
    </tr>
    <tr>
      <td class=judul2 colspan=2><p align=center><b><font face=Verdana size=3>$judul</font></b></td>
    </tr>
    <tr>
      <td width=80% align=center><b>Pengguna yang diundang</b></td>
      <td width=20% align=center><b>Konfirmasi</b></td>
    </tr>
";
$i = 0;
while ($dat = @mysql_fetch_row($hsl)) {
$i++;
echo "    <tr>\n";
echo "          <td>$dat[0]</td>\n";
       switch ($dat[1]) {
			    case '0' : $konfirm = 'Tidak'; break;
			    case '1' : $konfirm = 'Ya'; break;
			    default  : $konfirm = 'Belum'; break;
       }
echo "          <td align=center>$konfirm</td>\n";
echo "    </tr>\n";
}

echo "
      <td colspan=2 align=center><input type=button value=Tutup name=B3 onclick=window.close()></td>
    </tr>
  </table>
  </center>
</div>

</body>

</html>
";
}
mysql_close($dbh);
?>
