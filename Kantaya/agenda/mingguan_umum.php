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
?>
<script language="JavaScript">
<!--
function harian(kdpgn, tgl, bln, thn) {
	window.open("navagendapublik.php?nav=0&kd_pgn="+kdpgn+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("agenda_umum.php?kd_pengguna="+kdpgn+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
};

function mingguan(kdpgn, mng, bln, thn) {
	window.open("navagendapublik.php?nav=1&kd_pgn="+kdpgn+"&pmng="+mng+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("mingguan_umum.php?kd_pengguna="+kdpgn+"&pmng="+mng+"&pbln="+bln+"&pthn="+thn, "isi");
};
// -->
</script>
<?php
$hsl = mysql_query("select nama_pengguna from pengguna where kode_pengguna=$kd_pengguna",$dbh);
if (!$hsl) { echo mysql_error(); }
else { $dat = mysql_fetch_row($hsl); $pemilik = $dat[0]; }
echo "
</head>

<body>
";

if (isset($pbln)) {$bln = $pbln; } else {$bln = date("n");}
if (isset ($pthn)) {$thn = $pthn;} else {$thn = date("Y");}
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
      <td class=judul1><p align=left>Agenda Mingguan Milik : <font color=CCCCFF>$pemilik</font></td>
    </tr>
  </table>
  </center>
</div>&nbsp;
<div align=center>
  <center>
  <table border=0 width=100% cellspacing=0>
    <tr>
      <td class=judul2>
	<a href='javascript:mingguan($kd_pengguna,$mngs,$blns,$thns)'>&lt;&lt;</a> Minggu ke $mng_ke $nmbln $thn 
        <a href='javascript:mingguan($kd_pengguna,$mngb,$blnb,$thnb)'>&gt;&gt;</a></font></b></td>
    </tr>
    <tr>
      <td class=isi2>
        <div align=center>
          <table border=0 width=100% cellpadding=4 cellspacing=0>

            <tr>
              <td width=20% bgcolor=#C0C0C0><font size=2 face=Verdana><b>&nbsp;</b></font></td>
              <td width=80% bgcolor=#C0C0C0><font size=2 face=Verdana><b>&nbsp;</b></font></td>
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
            </tr>";
	  }
		else { 
echo "
            <tr>
              <td colspan=2 bgcolor=dcdcdc><font size=2 face=Verdana><b>$nmhari, 
              <a href='javascript:harian($kd_pengguna,$tgl,$bln,$thn)'>".$tgl." $nmbln $thn</a></b></font></td>
            </tr>";
					 $slctkgtn  = "select distinct waktu_mulai, waktu_selesai, judul, agenda.kode_agenda, sifat_sharing ";
					 $slctkgtn .= "from agenda, sharing_agenda_pengguna ";
					 $slctkgtn .= "where pemilik = $kd_pengguna ";
					 $slctkgtn .= "and date_format(tgl_mulai, '%e%c%Y') = ".$tgl.$bln.$thn." ";
					 $slctkgtn .= "and ((sharing_publik = 1) ";
					 $slctkgtn .= "or   (agenda.kode_agenda = sharing_agenda_pengguna.kode_agenda ";
					 $slctkgtn .= "      and kode_pengguna = $kode_pengguna)) ";
					 $slctkgtn .= "order by waktu_mulai, waktu_selesai, judul";
					 $hsl = mysql_query($slctkgtn,$dbh);
					 if (!$hsl) {echo mysql_error();}
					 $twkt = $awaljamkrj;
					 while ($dat = @mysql_fetch_row($hsl)) {
					 			 $dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
					 			 $wkt = substr($dat[0],0,5)." - ".substr($dat[1],0,5);
								 if ($wkt == "00:00 - 00:00") {$wkt = "Sepanjang Hari";}
echo "            <tr>\n";
echo "              <td width=20% align=right bgcolor=eeeeee><font size=2 face=Verdana>$wkt</font></td>\n";
echo "              <td width=80% bgcolor=eeeeee><font size=2 face=Verdana>\n";
		 								if ($dat[4]==1) {
echo "                &nbsp;<a href='isi_agenda.php?kode_agenda=$dat[3]'>$dat[2]</a>";
		 								} else { echo "S&nbsp;I&nbsp;B&nbsp;U&nbsp;K"; }
										echo "</font></td>\n";
echo "            </tr>\n";
		  		 }
		}
echo "		 				<tr></tr>\n";
}
echo "
          </table>
        </div>
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
