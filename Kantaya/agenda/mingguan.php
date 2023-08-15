<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
$css = "../css/".$tampilan_css.".css";

function jmlbaris($bln,$thn) {
	$mulai = date("w",mktime(0,0,0,$bln,1,$thn))-1;
	if ($mulai < 0) {$mulai = 6;}
	$jml_hari = jmlharidlmbulan ($bln, $thn);
	return ceil(($jml_hari+$mulai)/7);
}

echo "
<html>

<head>
<title>Agenda Mingguan</title>
<link rel=stylesheet type='text/css' href='$css'>
<meta http-equiv='Content-Style-Type' content='text/css'>
";
require('kegiatan.js');
?>
<script language="JavaScript">
<!--
function harian(tgl, bln, thn) {
	window.open("navigasi_agenda.php?nav=0&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("agenda.php?ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
};

function mingguan(mng, bln, thn) {
	window.open("navigasi_agenda.php?nav=1&pmng="+mng+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("mingguan.php?pmng="+mng+"&pbln="+bln+"&pthn="+thn, "isi");
};

function validasi(form) {
  var field = form.judul;  
  var jdl = field.value; 
	var jamml = form.pjammulai.value;
	var mntml = form.pmntmulai.value;
	var jamsl = form.pjamakhir.value;
	var mntsl = form.pmntakhir.value;
  var ok = 0;
	if (jdl == "") {
		 alert("Judul tidak boleh kosong!");
		 field.focus();
		 field.select();
		 ok++;
  }
	if ((jamsl < jamml) || (jamsl == jamml && mntsl <= mntml )) {  
      alert("Waktu mulai harus lebih dulu daripada waktu selesai!");
      ok++;
  }
	if (ok > 0) {return false;} else {return true;}
}

// -->
</script>
<?php
echo "
</head>

<body class=bdputih>
";

$thn_skrg = date("Y");
if (isset($pbln)) {$bln = $pbln; } else {$bln = date("n");}
if (isset($pthn)) {$thn = $pthn;} else {$thn = date("Y");}
if (isset($pmng)) {$mng = $pmng; }
else {
		 $haritgl1 = date("w",mktime(0,0,0,$bln,1,$thn));
		 if ($haritgl1 == 0) {$haritgl1 = 7;}
		 if (isset($ptgl)) {$tg = $ptgl;} else {$tg = date("j");}
		 $x = $tg + $haritgl1 - 2;
		 $mng = ($x-$x%7)/7;
}
kalender($bln,$thn,$kal);
$nmbln = namabulan("P",$bln);
$mng_ke = $mng + 1;
$thns = $thn;
$blns = $bln;
$mngs = $mng - 1;
if ($mngs < 0) {
	$blns = $bln - 1;
	if ($blns == 0) {$blns = 12; $thns -= 1;}
	$mngs =  jmlbaris($blns,$thns) - 1;
}
$thnb = $thn;
$blnb = $bln;
$mngb = $mng + 1;
if ($mngb == count($kal)) { 
	$mngb = 0;
	$blnb = $bln + 1;
	if ($blnb == 13) { $blnb = 1; $thnb += 1;}
}

echo "
<div align=center>
  <center>
  <table width=100% border=0>
    <tr>
      <td class=judul1><p align=left>Agenda Mingguan</td>
    </tr>
  </table>
  </center>
</div>
<div align=center>
  <center>
  <table width=100% border=0>
    <tr>
      <td class=judul2>
	<a href='javascript:mingguan($mngs,$blns,$thns)'>&lt;&lt;</a> Minggu ke $mng_ke $nmbln $thn 
        <a href='javascript:mingguan($mngb,$blnb,$thnb)'>&gt;&gt;</a></font></b></td>
    </tr>
    <tr>
      <td class=isi2 width=100% align=center><font size=2 face=Verdana>
				  &nbsp;".stripslashes($msg)."&nbsp;</font></td>
    </tr>
    <tr>
      <td class=isi2>
        <div align=center>
          <table class=tblputih border=0 width=100% cellpadding=4 cellspacing=0>

            <tr>
              <td width=20% bgcolor=#C0C0C0><font size=2 face=Verdana><b>&nbsp;</b></font></td>
              <td width=70% bgcolor=#C0C0C0><font size=2 face=Verdana><b>&nbsp;</b></font></td>
              <td width=10% bgcolor=#C0C0C0><font size=2 face=Verdana><b>&nbsp;</b></font></td>
            </tr><tr></tr>";

for ($j=0; $j<7; $j++) { 
	  $tgl = $kal[$mng][$j];
		$w = $j + 1;
		if ($w == 7) {$w = 0;}
		$nmhari = namahari("P",$w);
		if ($tgl == 0) {
echo "
            <tr>
              <td colspan=2 bgcolor=dcdcdc><font size=2 face=Verdana>$nmhari</font></td>
              <td width=10% bgcolor=dcdcdc>&nbsp;</td>
            </tr>";
	  }
		else { 
echo "
            <tr>
              <td colspan=2 bgcolor=dcdcdc><font size=2 face=Verdana><b>$nmhari, 
              <a href='javascript:harian($tgl,$bln,$thn)'>".$tgl." $nmbln $thn</a></b></font></td>
              <td width=10% bgcolor=dcdcdc><a href='isi_agenda.php?hmb=m&ptgl=$tgl&pbln=$bln&pthn=$thn'>tambah</a>&nbsp;</td>
            </tr>";
					 $slctkgtn  = "select waktu_mulai, waktu_selesai, judul, kode_agenda from agenda ";
					 $slctkgtn .= "where pemilik = $kode_pengguna ";
					 $slctkgtn .= "and date_format(tgl_mulai, '%e%c%Y') = ".$tgl.$bln.$thn." "; 
					 $slctkgtn .= "order by waktu_mulai, waktu_selesai, judul";
					 $hsl = mysql_query($slctkgtn,$dbh);
					 if (!$hsl) {echo mysql_error();}
					 $twkt = $awaljamkrj;
					 while ($dat = @mysql_fetch_row($hsl)) {
					 			 $dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
					 			 $wkt = substr($dat[0],0,5)." - ".substr($dat[1],0,5);
								 if ($wkt == "00:00 - 23:59") {$wkt = "Sepanjang Hari";}
echo "            <tr>\n";
								 if ($wkt == "Sepanjang Hari") {
echo "              <td width=20% align=center bgcolor=eeeeee><font size=2 face=Verdana>$wkt</font></td>\n";
								 } else {
echo "              <td width=20% align=right bgcolor=eeeeee><font size=2 face=Verdana>$wkt</font></td>\n";
								 }
echo "              <td width=70% bgcolor=eeeeee><font size=2 face=Verdana>\n";
echo "                &nbsp;<a href='isi_agenda.php?hmb=m&kode_agenda=$dat[3]'>$dat[2]</a></font></td>\n";
echo "              <td align=center width=10% bgcolor=eeeeee><a href='olah_data_kegiatan.php?hmb=m&judul=$dat[2]&modus=Hapus&ptgl=$tgl&pbln=$bln&pthn=$thn&kode_agenda=$dat[3]'>\n";
echo "								<img border=0 src='del.gif' width=12 height=12></a></td>\n";
echo "            </tr>\n";
		  		 }
		}
echo "		 				<tr></tr>\n";
}
echo "
          </table>
        </div>
";

// Penambahan langsung (quick add) kegiatan
echo "        <div align=left>\n";
echo "				 <form NAME=qckadd METHOD=POST ACTION='olah_data_kegiatan.php'>\n";
echo "				  <input type=hidden name='hmb' value='m'>\n";
echo "          <table border=0 width=100% cellpadding=2 cellspacing=0>\n";
echo "            <tr>\n";
echo "              <td class=judul1 width=100% colspan=4><b><font size=2 face=Verdana>Penambahan\n";
echo "                Langsung Kegiatan Baru:</font></b></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=30%><font size=2>Judul Kegiatan:</font></td>\n";
echo "              <td width=30%><font size=2>Tanggal:</font></td>\n";
echo "              <td width=20%><font size=2>Waktu Mulai:</font></td>\n";
echo "              <td width=20%><font size=2>Selesai:</font></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td><input type=text name='judul' size=20>\n";
echo "              <td><select size=1 name='ptgl'>\n";
				for ($i=1; $i<=31; $i++) {
						$slctd = '';
						if ($i==$ptgl) {$slctd = 'selected';}
echo "						       <option ".$slctd." value=".$i.">".$i;
				}
echo "                  </select><select size=1 name='pbln'>\n";
				for ($i=1; $i<=12; $i++) {
						$slctd = '';
						if ($i==$bln) {$slctd = 'selected';}
						$nmbln = namabulan("S", $i);
echo"					           <option ".$slctd." value=".$i.">".$nmbln;
				}
echo "                  </select><select size=1 name='pthn'>\n";
				for ($i=$thn_skrg; $i<=$thn_skrg+2; $i++) {
						$slctd = '';
						if ($i==$thn) {$slctd = 'selected';}
echo "					         <option ".$slctd." value=".$i.">".$i;
				}
echo "                  </select></td>\n";
echo "              <td><select size=1 name='pjammulai'>\n";
			for ($i=0; $i<=23; $i++) {
					$slctd = '';
					if ($i==$jam) {$slctd = 'selected';}
					if (strlen($i)==1) { $i="0".$i; }
echo "								<option ".$slctd." value=".$i.">".$i;
					}
echo "                 </select>:<select size=1 name='pmntmulai'>\n";
echo "                  <option>00</option>\n";
echo "                  <option>15</option>\n";
echo "                  <option>30</option>\n";
echo "                  <option>45</option>\n";
echo "                 </select></td><td><select size=1 name='pjamakhir'>\n";
			for ($i=0; $i<=23; $i++) {
					$slctd = '';
					if ($i==$jam+1) {$slctd = 'selected';}
					if (strlen($i)==1) { $i="0".$i; }
echo "					        <option ".$slctd." value=".$i.">".$i;
					}
echo "                 </select>:<select size=1 name='pmntakhir'>\n";
echo "                  <option>00</option>\n";
echo "                  <option>15</option>\n";
echo "                  <option>30</option>\n";
echo "                  <option>45</option>\n";
echo "                 </select></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td colspan=4 align=center><input type=submit value='Simpan' name='modus' onclick='return validasi(document.qckadd)'></center>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "				 </form>";
echo "        </div>\n";

echo "
<p align=left>&nbsp;</p>
      </td>
    </tr>
  </table>
  </center>
</div>

</body>

</html>
";
mysql_close($dbh);
?>
