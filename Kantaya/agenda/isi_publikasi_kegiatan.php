<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
require('cfgagenda.php');
$css = "../css/".$tampilan_css.".css";
error_reporting(0);
echo "
<html>

<head>
<title>Pengisian Agenda</title>";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
require('kegiatan.js');
echo "
</head>
";

if ($spjhari == 1) {$chk1 = "checked"; $chk2 = '';} else {$chk1 = ''; $chk2 = "checked";}
$ploc = $loc + 1;
echo "
<body class=bdputih>

<form name=isikgtn method=Post action='olah_data_kegiatan.php'>
<input type=hidden name=loc value=$ploc>
<input type=hidden name=hmb value='$hmb'>
<input type=hidden name=mode value=$mode>
";
if ($mode <> 1) { echo "<input type=hidden name=kode_agenda value=$kode_agenda>\n"; }
echo "
<input type=hidden name=diulg value=$diulg>
<input type=hidden name=diulgstp value='$diulgstp'>
<input type=hidden name=tnpbts value='$tnpbts'>
<input type=hidden name=sdtgl value='$sdtgl'>
<input type=hidden name=sdbln value='$sdbln'>
<input type=hidden name=sdthn value='$sdthn'>
<input type=hidden name=dgfas value=$dgfas>
<input type=hidden name='fas' value=".$fas.">";
echo "<input type=hidden name=undgn value=$undgn>\n";
$i = 0;
foreach ($untundgn as $un) { echo "<input type=hidden name=untundgn[$i] value=$un>"; $i++; }
$i = 0;
foreach ($grpundgn as $gr) { echo "<input type=hidden name=grpundgn[$i] value=$gr>"; $i++; }
$i = 0;
foreach ($pgnundgn as $pg) { echo "<input type=hidden name=pgnundgn[$i] value=$pg>"; $i++; }

include('kegiatan.php');

echo "
					<table border=0 width=100% bgcolor=eeeeee>
					  <tr>
						  <td class=judul1 width=25% align=center><a href='javascript:onclick=buka(1)'>
							<font color=FFFFFF size=2 face=Verdana>Pengulangan</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(2)'>
              <font color=FFFFFF size=2 face=Verdana>Fasilitas</font></a></td>
							<td class=isi1 width=25% align=center><a href='javascript:onclick=buka(0)'>
							<font size=2>Ditampilkan</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(4)'>
							<font color=FFFFFF size=2 face=Verdana>Undangan</font></a></td>
            </tr>";

$chk1 = '';
if ($sftshar == 1) { $chk1 = 'checked';}
$chk0 = '';
if ($sftshar == 0) { $chk0 = 'checked';}
if ($sharing_publik == 1) { $chkpub = 'checked'; }
else { $chkpub = '';}

echo "
    <tr>
      <td colspan=4 bgcolor=eeeeee>
			 <table border=0 cellpadding=2 cellspacing=0 width=100% bgcolor=eeeeee>
			  <tr><td width=50% ><font size=2 face=Verdana><input type=radio value=1 name=sftshar $chk1> 
						Secara Penuh</font></td>
						<td width=50% ><font size=2 face=Verdana><input type=radio value=0 name=sftshar $chk0> 
						Hanya Tanda Sibuk</font></td></tr></table>
        <div align=center>
          <table border=0 cellpadding=2 cellspacing=0 width=100% bgcolor=eeeeee>
            <tr>
              <td width=5% class=judul2><b><font size=2>&nbsp</font></b></td>
              <td width=20% class=judul2><b><font size=2>Kepada</font></b></td>
              <td width=75% class=judul2><b><font size=2>Pilih</font></b></td>
            </tr>
            <tr>
              <td width=5% bgcolor=dcdcdc><font size=2 face=Verdana>1</font></td>
              <td width=20% bgcolor=dcdcdc><font size=2 face=Verdana>Publik</font></td>
              <td width=75% bgcolor=dcdcdc><font size=2 face=Verdana><input type=checkbox name=sharing_publik value=1 $chkpub></font></td>
            </tr>
            <tr>
              <td width=5% bgcolor=d0d0d0><font size=2 face=Verdana>2</font></td>
              <td width=20% bgcolor=d0d0d0 valign=middle><font size=2 face=Verdana>Unit</font></td>
              <td width=75% bgcolor=d0d0d0><font size=1 face=Verdana>
							         <select name=untshar[] size=3 multiple>
";
$slctpgn = "select kode_unit, nama_unit from unit_kerja order by kode_unit";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctdunt = '';
			foreach ($untshar as $un) { if ($dat[0] == $un) {$slctdunt = 'selected';} }
echo "													<option value=$dat[0] $slctdunt>$dat[1]</option>\n";
}
echo "							    </select></font></td>
            </tr>
            <tr>
              <td width=5% bgcolor=CCCCCC><font size=2 face=Verdana>3</font></td>
              <td width=20% bgcolor=CCCCCC valign=middle><font size=2 face=Verdana>Grup</font></td>
              <td width=75% bgcolor=CCCCCC><font size=1 face=Verdana>
							         <select name=grpshar[] size=3 multiple>
";
$slctpgn = "select kode_grup, nama_grup from grup order by nama_grup";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctdgrp = '';
			foreach ($grpshar as $gr) { if ($dat[0] == $gr) {$slctdgrp = 'selected';} }
echo "													<option value=$dat[0] $slctdgrp>$dat[1]</option>\n";
}
echo "							    </select></font></td>
            </tr>
            <tr>
              <td width=5% bgcolor=C0C0C0><font size=2 face=Verdana>4</font></td>
              <td width=20% bgcolor=C0C0C0><font size=2 face=Verdana>Pengguna Lain</font></td>
              <td width=75% bgcolor=C0C0C0>
									<select name=pgnshar[] size=3 multiple>
";
$slctpgn  = "select kode_pengguna, nama_pengguna from pengguna ";
$slctpgn .= "where kode_pengguna <> $kode_pengguna order by nama_pengguna";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctdpgn = '';
			foreach ($pgnshar as $pg) { if ($dat[0] == $pg) {$slctdpgn = 'selected';} }
echo "													<option value=$dat[0] $slctdpgn>$dat[1]</option>\n";
}
echo "							    </select></td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
   </table>
  </table>
</div><br>";
echo "
<div align=center>
  <table border=0 width=100% cellspacing=0>
    <tr>
      <td>
        <p align=center>
";
echo "				   <input type=button value='Kembali' name='kembali' onclick='javascript:history.go(-$ploc)'>\n";
if ($mode == 1) {
echo "					 &nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value=Simpan name=modus onclick='return validasi(document.isikgtn)'>";
}
else {
echo "					 &nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value='Simpan Pengubahan' name=modus onclick='return validasi(document.isikgtn)'>";
}
echo "
      </td>
    </tr>
  </table>
</div>
<p align=left>&nbsp;</p>
</form>

</body>

</html>
";
mysql_close($dbh);
?>
