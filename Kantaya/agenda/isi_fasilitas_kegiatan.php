<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
include ('../lib/akses_unit.php');
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
?>
<SCRIPT language=javascript>
<!--
function chngaction(form) {
   document.isikgtn.action = 'olah_data_kegiatan.php';
	 if (validasi(form)) {
	 		document.isikgtn.submit();
			return true;
	 }
	 else {return false;}
}

function bfas(op) {
   document.isikgtn.op1.value = op;
	 document.isikgtn.submit();
}
//-->
</SCRIPT>
</head>
<?
if ($spjhari == 1) {$chk1 = "checked"; $chk2 = '';} else {$chk1 = ''; $chk2 = "checked";}
$ploc = $loc + 1;
echo "
<body class=bdputih>

<form name=isikgtn method=Post action='isi_fasilitas_kegiatan.php'>
<input type=hidden name=loc value=$ploc>
<input type=hidden name=hmb value='$hmb'>
<input type=hidden name=mode value=$mode>
";
if ($mode <> 1) { echo "<input type=hidden name=kode_agenda value=$kode_agenda>\n"; }
echo "
<input type=hidden name=op1 value=''>
<input type=hidden name=diulg value=$diulg>
<input type=hidden name=diulgstp value='$diulgstp'>
<input type=hidden name=tnpbts value='$tnpbts'>
<input type=hidden name=sdtgl value='$sdtgl'>
<input type=hidden name=sdbln value='$sdbln'>
<input type=hidden name=sdthn value='$sdthn'>
<input type=hidden name=sftshar value=$sftshar>
<input type=hidden name=sharing_publik value='$sharing_publik'>";
$i = 0;
foreach ($untshar as $un) { echo "<input type=hidden name=untshar[$i] value=$un>"; $i++; }
$i = 0;
foreach ($grpshar as $gr) { echo "<input type=hidden name=grpshar[$i] value=$gr>"; $i++; }
$i = 0;
foreach ($pgnshar as $pg) { echo "<input type=hidden name=pgnshar[$i] value=$pg>"; $i++; }
echo "<input type=hidden name=undgn value=$undgn>\n";
$i = 0;
foreach ($untundgn as $un) { echo "<input type=hidden name=untundgn[$i] value=$un>"; $i++; }
$i = 0;
foreach ($grpundgn as $gr) { echo "<input type=hidden name=grpundgn[$i] value=$gr>"; $i++; }
$i = 0;
foreach ($pgnundgn as $pg) { echo "<input type=hidden name=pgnundgn[$i] value=$pg>"; $i++; }

include('kegiatan.php');

echo "
	<table border=0 width=100% bgcolor='eeeeee'>
					  <tr>
						  <td class=judul1 width=25% align=center><a href='javascript:onclick=buka(1)'>
							<font color=FFFFFF size=2 face=Verdana>Pengulangan</font></a></td>
							<td class=isi1 width=25% align=center><a href='javascript:onclick=buka(0)'>
              <font size=2>Fasilitas</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(3)'>
							<font color=FFFFFF size=2 face=Verdana>Ditampilkan</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(4)'>
							<font color=FFFFFF size=2 face=Verdana>Undangan</font></a></td>
            </tr>
    <tr>
      <td colspan=4>";

// Fasilitas
$jmlfas = $dat[0];
list_akses_unit($dbh,$unit_pengguna,&$aksesunit);
$ttlunit = count($aksesunit);
for ($i=0; $i<$ttlunit; $i++) {
				$unit[$i] = $aksesunit[$i][0];
}
$sqlwhere = "WHERE unit = '";
foreach ($unit as $isi) {
				$sqlwhere = $sqlwhere.$isi."' OR unit = '";
}
$sqlwhere = substr ($sqlwhere, 0, -12);
$slctfas = "SELECT kode_fas, nama_fas FROM fasilitas ";
$slctfas = $slctfas.$sqlwhere." ORDER BY unit";
$wml = $pjammulai.":".$pmntmulai;
$wsl = $pjamakhir.":".$pmntakhir;
$slctfasx  = "select distinct fasilitas, pemesan from pemesanan ";
$slctfasx .= "where date_format(untuk_tgl, '%e%c%Y') = ".$ptgl.$pbln.$pthn." ";
$slctfasx .= "and ( ((jam_mulai <= '$wml') and ('$wml' < jam_akhir)) or";
$slctfasx .= "      ((jam_mulai < '$wsl') and ('$wsl' <= jam_akhir)) or";
$slctfasx .= "      ((jam_mulai > '$wml') and ('$wsl' > jam_akhir))   )";
$chk1 = '';
if ($dgfas == 1) { $chk1 = 'checked'; }
if ($dgfas == 0) { $chk0 = 'checked'; }
echo "
          <table border=0 width=100% bgcolor='eeeeee'>
            <tr>
              <td valign=top width=40% >&nbsp;<input  type=radio name=dgfas value=0 $chk0>
									<font size=2 face=Verdana>Tanpa Fasilitas</font></td>
              <td width=60% ><font face=Verdana size=2>&nbsp;</font>
              </td>
            </tr>
            <tr>
              <td valign=top width=40% >&nbsp;<input  type=radio name=dgfas value=1 $chk1>
							<font size=2 face=Verdana>Fasilitas yang akan digunakan :</font></td>
              <td width=60% >";
if (!isset($op1)) {$op1 = 0;}
if ($op1 == 0 or $op1 == 2) {
echo "
							  <a href=javascript:onclick=bfas(1)>
								 <img border=0 src=plus.gif width=16 height=16></a>
                <font size=2 face=Verdana>Lihat semua fasilitas</font><br>";
}
if ($op1 == 1) {
echo "
                <a href=javascript:onclick=bfas(0)><img border=0 src=minus.gif width=16 height=16></a><font size=2 face=Verdana>
                Semua fasilitas</font><br>";
	 $hsl1 = mysql_query($slctfas,$dbh); 
	 if (!$hsl1) {echo mysql_error();}
	 $jmlfas = mysql_num_rows($hsl1);
	 $hsl2 = mysql_query($slctfasx,$dbh);
	 if (!$hsl2) {echo mysql_error();}
	 $i = -1;
	 while ($dat = @mysql_fetch_row($hsl2)) {
	 			 $i += 1;
				 $dipsn[$i] = $dat[0]."-".$dat[1];
	 }
	 if ($i < 0) {$dipsn = NULL;}
   for ($i=0;$i<$jmlfas;$i++) {
	 		 $dat = @mysql_fetch_row($hsl1);
			 $dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat)))); 
			 $chk3 = '';
			 if ($fas == $dat[0]) {$chk3 = 'checked';}
			 $dsabl = '';
			 foreach ($dipsn as $t) {
			 				 list($tfas,$pmlk) = split("-",$t);
							 if ($tfas == $dat[0] and $kode_pengguna<>$pmlk) {
							 		$dsabl = 'disabled';
							 } 
			 }
			 $ket = '';
			 if ($dsabl !== '') {$ket = '(dipesan)';}
echo "                &nbsp;&nbsp;&nbsp;&nbsp;<input  $dsabl type=radio value=$dat[0] name=fas $chk3> <font face=Verdana size=2>$dat[1] <i>$ket</i></font><br>\n";
   }
}
if ($op1 == 0 or $op1 == 1) {
echo "
                <a href=javascript:onclick=bfas(2)><img border=0 src=plus.gif width=16 height=16></a> <font size=2 face=Verdana>Hanya
                fasilitas yang bebas sesuai waktu kegiatan ini</font><br>";
}
if ($op1 == 2) {
echo "
                <a href=javascript:onclick=bfas(0)><img border=0 src=minus.gif width=16 height=16></a>
                <font size=2 face=Verdana>Fasilitas yang bebas sesuai waktu kegiatan ini</font><br>";
	 $hsl1 = mysql_query($slctfas,$dbh); 
	 if (!$hsl1) {echo mysql_error();}
	 $jmlfas = mysql_num_rows($hsl1);
	 $hsl2 = mysql_query($slctfasx,$dbh);
	 if (!$hsl2) {echo mysql_error();}
	 $i = -1;
	 while ($dat = @mysql_fetch_row($hsl2)) {
	 			 $i += 1;
				 $dipsn[$i] = $dat[0];
	 }
	 if ($i < 0) {$dipsn = NULL;}
   for ($i=0;$i<$jmlfas;$i++) {
	 		 $dat = @mysql_fetch_row($hsl1);
			 $dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat)))); 
			 $chk3 = '';
			 if ($fas == $dat[0]) {$chk3 = 'checked';}
			 $dsabl = '';
			 foreach ($dipsn as $t) { if ($t == $dat[0]) {$dsabl = 'disabled';} }
			 if ($dsabl == '') {
echo "                &nbsp;&nbsp;&nbsp;&nbsp;<input  type=radio value=$dat[0] name=fas $chk3> <font face=Verdana size=2>$dat[1]</font><br>\n";
		   }
   }
}
if ($op1 == 0) {
echo "    <input type=hidden name='fas' value=".$fas.">\n";
}
echo "
              </td>
            </tr>
          </table>
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
echo "					 &nbsp;&nbsp;&nbsp;&nbsp;<input type=button value=Simpan name=B1 onclick='javascript:chngaction(document.isikgtn)'>\n";
echo "				   <input type=hidden value='Simpan' name='modus'>\n";
}
else {
echo "					 &nbsp;&nbsp;&nbsp;&nbsp;<input type=button value=Simpan name=B1 onclick='javascript:chngaction(document.isikgtn)'>";
echo "				   <input type=hidden value='Simpan Pengubahan' name='modus'>\n";
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
