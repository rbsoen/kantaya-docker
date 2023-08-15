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
<input type=hidden name='fas' value=".$fas.">
<input type=hidden name=sftshar value=$sftshar>
<input type=hidden name=sharing_publik value='$sharing_publik'>";
$i = 0;
foreach ($untshar as $un) { echo "<input type=hidden name=untshar[$i] value=$un>"; $i++; }
$i = 0;
foreach ($grpshar as $gr) { echo "<input type=hidden name=grpshar[$i] value=$gr>"; $i++; }
$i = 0;
foreach ($pgnshar as $pg) { echo "<input type=hidden name=pgnshar[$i] value=$pg>"; $i++; }

include('kegiatan.php');

echo "
					<table border=0 width=100% bgcolor=eeeeee>
					  <tr>
						  <td class=judul1 width=25% align=center><a href='javascript:onclick=buka(1)'>
							<font color=FFFFFF size=2 face=Verdana>Pengulangan</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(2)'>
              <font color=FFFFFF size=2 face=Verdana>Fasilitas</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(3)'>
							<font color=FFFFFF size=2 face=Verdana>Ditampilkan</font></a></td>
							<td class=isi1 width=25% align=center><a href='javascript:onclick=buka(0)'>
							<font size=2>Undangan</font></a></td>
            </tr>";
$chk1 = '';
if ($undgn == 1) { $chk1 = 'checked'; }
if ($undgn == 0) { $chk0 = 'checked'; }
echo "
    <tr>
      <td colspan=4>
        <div align=center>
          <table cellSpacing=0 cellPadding=4 width=100% border=0>
            <tbody>
						  <tr>
							  <td colspan=3 bgColor=eeeeee>
						      <input type=radio value=0 name=undgn $chk0>
									<font face=Verdana size=2>Tidak Kirim Undangan</font></td>
							</tr>
              <tr>
							  <td colspan=3 bgColor=eeeeee><input type=radio value=1 name=undgn $chk1>
								  <font face=Verdana size=2>Kirim Undangan :</font></td>
							</tr>
              <tr>
                <td width=5% class=judul2><b><font size=2>&nbsp</font></b></td>
                <td width=20% class=judul2><b><font size=2>Kepada</font></b></td>
                <td width=80% class=judul2><b><font size=2>Pilih</font></b></td>
              </tr>
              <tr>
                <td width=5% bgColor=d0d0d0><font face=Verdana size=2>1</font></td>
                <td width=20% bgColor=d0d0d0><font face=Verdana size=2>Unit</font></td>
                <td width=80% bgColor=d0d0d0>
							         <select name=untundgn[] size=3 multiple onfocus='document.isikgtn.undgn[1].click()'>
";
$slctpgn = "select kode_unit, nama_unit from unit_kerja order by kode_unit";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctdunt = '';
			foreach ($untundgn as $un) { if ($dat[0] == $un) {$slctdunt = 'selected';} }
echo "													<option value=$dat[0] $slctdunt>$dat[1]</option>\n";
}
echo "							    </select></font></td>
              </tr>
              <tr>
                <td width=5% bgColor=cccccc><font face=Verdana size=2>2</font></td>
                <td width=20% bgColor=cccccc><font face=Verdana size=2>Grup</font></td>
                <td width=75% bgColor=cccccc>
									<select name=grpundgn[] size=3 multiple>
";
$slctpgn = "select kode_grup, nama_grup from grup order by nama_grup";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctgrp = '';
			if (count($grpundgn)>0) { 
				 foreach ($grpundgn as $gr) { if ($dat[0] == $gr) {$slctgrp = 'selected';} }
			}
echo "													<option value=$dat[0] $slctgrp>$dat[1]</option>\n";
}
echo "								  </select></td>
              </tr>
              <tr>
                <td width=5% bgColor=c0c0c0><font face=Verdana size=2>3</font></td>
                <td width=20% bgColor=c0c0c0><font face=Verdana size=2>Pengguna Lain</font></td>
                <td width=75% bgColor=c0c0c0><font face=Verdana size=2>
									<select name=pgnundgn[] size=3 multiple>
";
$slctpgn  = "select kode_pengguna, nama_pengguna from pengguna ";
$slctpgn .= "where kode_pengguna <> $kode_pengguna order by nama_pengguna";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctpgn = '';
			if (count($pgnundgn)>0) { 
				 foreach ($pgnundgn as $pg) { if ($dat[0] == $pg) {$slctpgn = 'selected';} }
			}
echo "													<option value=$dat[0] $slctpgn>$dat[1]</option>\n";
}
echo "								  </select></td>
              </tr>
            </tbody>
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
