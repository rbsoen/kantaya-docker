<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
require('cfgagenda.php');
$css = "../css/".$tampilan_css.".css";
function jmlbaris($bln,$thn) {
	$mulai = date("w",mktime(0,0,0,$bln,1,$thn))-1;
	if ($mulai < 0) {$mulai = 6;}
	$jml_hari = jmlharidlmbulan ($bln, $thn);
	return ceil(($jml_hari+$mulai)/7);
}	
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
						  <td class=isi1 width=25% align=center><a href='javascript:onclick=buka(0)'>
							<font size=2>Pengulangan</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(2)'>
              <font color=FFFFFF size=2 face=Verdana>Fasilitas</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(3)'>
							<font color=FFFFFF size=2 face=Verdana>Ditampilkan</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(4)'>
							<font color=FFFFFF size=2 face=Verdana>Undangan</font></a></td>
            </tr>";
	if ($diulg == 0) { $chk0 = 'checked'; }
	$chk1 = '';
	$chk2 = '';
	if ($diulg == 1) { $chk1='checked'; }
	if ($diulg == 2) { $chk2='checked'; }
	$chk3 = '';
	$chk4 = '';
	if ($tnpbts == 1) { $chk3 = 'checked'; }
	if ($tnpbts == 0) { $chk4 = 'checked'; }
echo "
    <tr>
      <td colspan=4 bgcolor=eeeeee>
        <table cellSpacing=0 cellPadding=4 width=100% border=0>
          <tbody>
            <tr>
              <td colspan=4 bgcolor=eeeeee><input type=radio value=0 name=diulg $chk0>
              <font face=Verdana size=2>Tanpa Pengulangan</font></td>
            </tr>
            <tr>
              <td width=30% bgcolor=eeeeee><input type=radio value=1 name=diulg $chk1>
              <font face=Verdana size=2>Diulang&nbsp;&nbsp;&nbsp;Setiap :</font></td>
              <td  colspan=3 bgcolor=eeeeee><select size=1 name=diulgstp onchange='document.isikgtn.diulg[1].click()'>
";
   $arrulgstp = array (array("1","Hari"), array("7","Minggu"), array("14","2 Minggu"), array("30","Bulan"));
   foreach ($arrulgstp as $a) {
		$slctd = '';
		if ($diulgstp == $a[0]) { $slctd = 'selected'; }
echo "                  <option ".$slctd." value=".$a[0].">".$a[1]."</option>\n";
   }
echo "                </select></td>
            </tr>
            <tr>
              <td width=30% bgColor=eeeeee><input type=radio value=2 name=diulg $chk2>
               <font face=Verdana size=2>Diulang pada hari :</font></td>
              <td colspan=3 bgColor=eeeeee><select disabled size=1 name=slhfsulg onchange='document.isikgtn.diulg[1].click()'>
";
   $hfsulg = date("w",mktime(0,0,0,$pbln,$ptgl,$pthn));
   for ($k=1;$k<8;$k++) {
		$i = $k;
		if ($i == 7) { $i = 0; }
		$slctd = '';
		if ($hfsulg == $i) { 
			 $slctd = 'selected'; 
			 $tmp = $i;
		}
		$nmhari = namahari("P",$i);
echo "                  <option ".$slctd." value=$i>$nmhari</option>\n";
   }
echo "                </select>\n";
echo "<input type=hidden name=hfsulg value=$tmp>\n";
echo"              <font face=Verdana size=2>&nbsp;&nbsp;minggu:</font>
                <select disabled size=1 name=slkefsulg onchange='document.isikgtn.diulg[1].click()'>
";
   $haritgl1 = date("w",mktime(0,0,0,$pbln,1,$pthn));
   if ($haritgl1 == 0) {$haritgl1 = 7;}
   $x = $ptgl + $haritgl1 - 2;
   $kefsulg = ($x-$x%7)/7;
   $arrke = array(Pertama, Kedua, Ketiga, Keempat, Kelima, Keenam);
   $jmlmng = jmlbaris($pbln, $pthn);
   for ($i=0; $i<$jmlmng; $i++) {
		$slctd = '';
		if ($kefsulg == $i) { 
			 $slctd = 'selected'; 
			 $tmp = $i;
		}
echo "                  <option $slctd value=$i>".$arrke[$i]."</option>\n";
   }
echo "                </select>\n";
echo "<input type=hidden name=kefsulg value=$tmp>\n";
echo "              <font face=Verdana size=2>&nbsp;setiap:</font>
                <select size=1 name=D2>
                  <option selected>Bulan</option>
                </select></td>
            </tr>
            <tr>
              <td width=30% bgColor=ffffff>&nbsp;</td>
              <td colspan=3 bgColor=ffffff colSpan=2><input type=radio value=1 name=tnpbts $chk3><font face=Verdana size=2>Tanpa
                batas waktu</font></td>
            </tr>
            <tr>
              <td width=30% bgColor=ffffff>&nbsp;</td>
              <td colspan=3 bgColor=ffffff><input type=radio value=0 name=tnpbts $chk4><font face=Verdana size=2>sampai
                dengan&nbsp;</font><select size=1 name=sdtgl onfocus='document.isikgtn.tnpbts[1].click()'>";
				for ($i=1; $i<=31; $i++) {
						$slctd = '';
						if ($i==$sdtgl) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$i;
				}
echo"
                </select><select size=1 name=sdbln onchange='document.isikgtn.tnpbts[1].click()'>";
				for ($i=1; $i<=12; $i++) {
						$slctd = '';
						if ($i==$sdbln) {$slctd = 'selected';}
						$nmbln = namabulan("S", $i);
echo"					<option ".$slctd." value=".$i.">".$nmbln;
				}
echo"
                </select><select size=1 name=sdthn onchange='document.isikgtn.tnpbts[1].click()'>";
				for ($i=date("Y"); $i<=date("Y")+2; $i++) {
						$slctd = '';
						if ($i==$sdthn) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$i;
				}
echo"
                </select></td>
            </tr>
          </tbody>
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
