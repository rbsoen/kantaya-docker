<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
$query  = "select distinct date_format(tgl_mulai, '%d/%m/%y'), waktu_mulai, waktu_selesai, agenda.kode_agenda, judul, pemilik ";
$query .= "from agenda, sharing_agenda_pengguna ";
$query .= "where ((agenda.kode_agenda = sharing_agenda_pengguna.kode_agenda ";
$query .= "and kode_pengguna = $kode_pengguna and sifat_sharing = 1) or ";
$query .= "(pemilik = $kode_pengguna)) and judul like '%$carijdl%'"; 
$query .= "order by tgl_mulai, waktu_mulai, waktu_selesai, judul";
$hsl = mysql_query($query,$dbh);
if (!$hsl) {echo mysql_error(); echo "<br>Query: ".$query;}
$css = "../css/".$tampilan_css.".css";
echo "
<html>

<head>
<title>Hasil Pencarian Judul Kegiatan</title>
<link rel=stylesheet type='text/css' href='$css'>
</head>

<body>

<div align=center>
    <table width=100% cellpadding=0 cellspacing=0>
      <tr>
        <td>
  <div align=center>
  <table border=0 width=100% border=1 cellpadding=4 cellspacing=0>
    <tr>
      <td></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan=2 class=judul1>Hasil Pencarian Judul Kegiatan</td>
    </tr>
  </table>
  </div>
  <div align=center>
   <table width=100% border=0 cellpadding=2 cellspacing=0>
    <tr>
      <td colspan=4><br>
      </td>
    </tr>
    <tr>
      <td class=judul2><b><font size=2 face=Verdana>Tanggal</font></b></td>
      <td class=judul2><b><font size=2 face=Verdana>Waktu</font></b></td>
      <td class=judul2><b><font size=2 face=Verdana>Judul</font></b></td>
      <td class=judul2><b><font size=2 face=Verdana>Milik</font></b></td>
    </tr>
";
while ($dat = @mysql_fetch_row($hsl)) {
			$hsl1 = mysql_query("select nama_pengguna from pengguna where kode_pengguna=$dat[5]",$dbh);
			if (!$hsl1) { echo mysql_error(); }
			else { $milik = mysql_fetch_row($hsl1); }
echo "
    <tr>
      <td class=isi1>$dat[0]</td>
      <td class=isi1>".substr($dat[1],0,5)." - ".substr($dat[2],0,5)."</td>
      <td class=isi1><a href='isi_agenda.php?kode_agenda=$dat[3]'>$dat[4]</a></td>
      <td class=isi1>$milik[0]</td>
    </tr>
";
}
echo "
   </table>
  </div>
          <p>&nbsp;</td>
      </tr>
 </table>
</div>

</body>

</html>
";
mysql_close($dbh);
?>
