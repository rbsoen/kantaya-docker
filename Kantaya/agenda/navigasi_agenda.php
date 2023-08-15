<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
$css = "../css/".$tampilan_css.".css";
echo "<html>\n";
echo "\n";
echo "<head>\n";
echo "<title>Agenda Harian</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
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

function bulanan(bln, thn) {
	window.open("navigasi_agenda.php?nav=2&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("bulanan.php?pbln="+bln+"&pthn="+thn, "isi");
};

function cek_lihat_lain(form,navi) {
  var kdpgn = form.kd_pengguna.value;
	var tgl = form.ptgl.value;
	var mng = form.pmng.value;
	var bln = form.pbln.value;
	var thn = form.pthn.value;
  var ok = 0;
	if (kdpgn == "") {
		 alert("Pilih pengguna dahulu (klik gambar orang untuk menampilkan list pengguna), baru kemudian klik tombol 'Lihat!'");
		 ok++;
  }
	if (ok > 0) {return false;} 
	else { 
			 window.open("navagendapublik.php?nav="+navi+"&kd_pgn="+kdpgn+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "navigasi");
			 switch (navi) {
			    case 0: window.open("agenda_umum.php?kd_pengguna="+kdpgn+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi"); break;
			    case 1: window.open("mingguan_umum.php?kd_pengguna="+kdpgn+"&pmng="+mng+"&pbln="+bln+"&pthn="+thn, "isi"); break;
			    case 2: window.open("bulanan_umum.php?kd_pengguna="+kdpgn+"&pbln="+bln+"&pthn="+thn, "isi"); break;
			 }
			 return true;
	}
}

function showUserList(pfld,pfltr) {
  if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
	   window.PsnList.close();
  }
  PsnList = window.open('../lib/list_pengguna.php?pfld='+pfld+'&pfltr='+pfltr, 'List', 'width=390,height=450,scrollbars=yes');
};

function carijudul(form) {
   var kwrd = form.carijdl.value;
   window.open("hasil_cari_kegiatan.php?carijdl="+kwrd, "isi");
};
// -->
</script>
<?php
echo "</head>\n";

$hari_skrg = date("w");
$tgl_skrg = date("j");
$bln_skrg = date("n");
$thn_skrg = date("Y");
if (isset($pthn)) {$thn = $pthn;}	
else {$thn = $thn_skrg;}
if (isset($pbln)) {$bln = $pbln;}
else {$bln = $bln_skrg;}
if (isset($ptgl)) {
	 $hari = date("w", mktime(0,0,0,$pbln,$ptgl,$pthn));
	 $tgl = $ptgl;
	 }
else {
	 $hari = $hari_skrg;
	 $tgl = $tgl_skrg;
	 }
if (isset($pmng)) {$mng = $pmng; }
else {
		 $haritgl1 = date("w",mktime(0,0,0,$bln,1,$thn));
		 if ($haritgl1 == 0) {$haritgl1 = 7;}
		 $x = $tgl + $haritgl1 - 2;
		 $mng = ($x-$x%7)/7;
}
if (!isset($pthn) and !isset($pbln) and !isset($ptgl)) {
	 $jam = date("H");}
else {$jam = "12";}	
if (!isset($nav)) { $nav = 0; }

error_reporting(0);
echo "<body>\n";
echo "\n";
echo "<div align=center>\n";
echo "  <table border=0 width=100%>\n";
echo "    <tr>\n";
echo "      <td class=judul1 colspan=2>\n";
echo "        <p align=left>Navigasi Agenda</td>\n";
echo "    </tr>\n";
echo "  <center>\n";
echo "    <tr>\n";
echo "      <td class=isi2>\n";
echo "        <div align=left>\n";
echo "				 <table border=1 width=100%>";
switch ($nav) {
case 0 : $hmb = 'h';
// Harian
echo "           <tr>\n";
echo "             <td width=100%>\n";
echo "               <p align=center><font size=1>Harian |\n";
echo "               <a href='javascript:mingguan($mng,$bln,$thn)'> Mingguan</a> | \n";
echo "							 <a href='javascript:bulanan($bln,$thn)'> Bulanan</a></font></p>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "				 </table>\n";

echo "
		 					 <table border=0 width=100% bgcolor=d0d0d0>
  						   <tr>
    						 	 <td colspan=7 align=center><b>
		";
		$thn_sblm = $thn - 1; 
		print("<font size=1 face=Verdana><b><a href='javascript:harian($tgl,$bln,$thn_sblm)'><< </a></b>&nbsp;</font>\n");
		$bln_sblm = $bln - 1;
		$thns = $thn;
		if ($bln_sblm == 0) {$bln_sblm = 12; $thns = $thn_sblm;}
		print("<font size=1 face=Verdana><b><a href='javascript:harian($tgl,$bln_sblm,$thns)'><</a></b>&nbsp;</font>\n");
		print("<font size=1 face=Verdana color=red>".namabulan('P',$bln)."&nbsp;$thn&nbsp;&nbsp;</font>\n");
		$bln_ssdh = $bln + 1; 
		$thn_ssdh = $thn + 1;
		$thnb = $thn;
		if ($bln_ssdh == 13) {$bln_ssdh = 1; $thnb = $thn_ssdh;}
		print("<font size=1 face=Verdana><b><a href='javascript:harian($tgl,$bln_ssdh,$thnb)'>></a></b>&nbsp;</font>\n");
		print("<font size=1 face=Verdana><b><a href='javascript:harian($tgl,$bln,$thn_ssdh)'> >></a></b>&nbsp;</font>\n");
echo"
     						  </b></td>
  							 </tr>
  							<tr>
";

		for ($i=1; $i<7; $i++) {
			print ("<td align=\"center\"><b> <font size=1 face=Verdana>" . namahari("S",$i) . "</font></b></td>\n\t");
		}
		print ("<td align=\"center\"><b> <font size=1 face=Verdana>" . namahari("S",0) . " </font></b></td>\n");

echo"
  </tr>
";
	kalender($bln,$thn,$kalender);
	for ($i=0; $i<count($kalender); $i++) {
		print "   <tr>\n";
		for ($j=0; $j<7; $j++) {
			if ($kalender[$i][$j] == 0) {
				print "\t<td align=\"center\">&nbsp;</td>\n";	
			}
			else {
				print "\t<td align=\"center\">";
				$tgl_kal = $kalender[$i][$j];
				if ($tgl_kal == $tgl) {print "<font size=1 face=Verdana>".$kalender[$i][$j]."</font></td>\n";}
				else {print "<font size=1 face=Verdana><a href='javascript:harian($tgl_kal,$bln,$thn)'>".$kalender[$i][$j]."</a></font></td>\n";}
			}
		}
		print "   </tr>\n";
	}
echo"
		     <tr>
		 		  <td width=100% colspan=7><font size=1><a href='javascript:harian($tgl_skrg,$bln_skrg,$thn_skrg)'><b>Hari ini</b></a> : 
		 		 		<font face=Verdana><b>".namahari("P",$hari_skrg).", ".$tgl_skrg." ".namabulan("P",$bln_skrg)." ".$thn_skrg."</b></font></font></td>
		 		 </tr>
";
	break;
case 1: $hmb = 'm';
// Mingguan
echo "
            <tr>
";
echo "             <td width=100%><p align=center><font size=1>\n";
echo "               <a href='javascript:harian($tgl,$bln,$thn)'> Harian</a> | \n";
echo "               Mingguan |\n";
echo "							 <a href='javascript:bulanan($bln,$thn)'> Bulanan</a></font></p>\n";
echo "             </td>\n";
echo "
				 	</tr>
				 </table>

				 <table width=100% class=tblabu2>
				   <tr>
				     <td align=center><b>
";
		$thn_sblm = $thn - 1; 
		print("<font size=1 face=Verdana><b><a href='javascript:harian($tgl,$bln,$thn_sblm)'><< </a></b>&nbsp;</font>\n");
		$bln_sblm = $bln - 1;
		$thns = $thn;
		if ($bln_sblm == 0) {$bln_sblm = 12; $thns = $thn_sblm;}
		print("<font size=1 face=Verdana><b><a href='javascript:harian($tgl,$bln_sblm,$thns)'><</a></b>&nbsp;</font>\n");
		print("<font size=1 face=Verdana color=red>".namabulan('P',$bln)."&nbsp;$thn&nbsp;&nbsp;</font>\n");
		$bln_ssdh = $bln + 1; 
		$thn_ssdh = $thn + 1;
		$thnb = $thn;
		if ($bln_ssdh == 13) {$bln_ssdh = 1; $thnb = $thn_ssdh;}
		print("<font size=1 face=Verdana><b><a href='javascript:harian($tgl,$bln_ssdh,$thnb)'>></a></b>&nbsp;</font>\n");
		print("<font size=1 face=Verdana><b><a href='javascript:harian($tgl,$bln,$thn_ssdh)'> >></a></b>&nbsp;</font>\n");
echo"
				     </b></td>
				   </tr>
";
   kalender($bln,$thn,$kal);
   for ($i=0; $i<count($kal); $i++) {
	 		 $mngs = $i;
	 		 switch ($i) {
				 case 0 : $k = "pertama"; break;
				 case 1 : $k = "ke dua"; break;
				 case 2 : $k = "ke tiga"; break;
				 case 3 : $k = "ke empat"; break;
				 case 4 : $k = "ke lima"; break;
				 case 5 : $k = "ke enam"; break;
			 }
echo"
				 		<td><a href='javascript:mingguan($mngs,$bln,$thn)'><center><font size=2>Minggu $k</font></center></a></td>
				 	</tr>
";
   }
echo"
		     <tr>
		 		  <td width=100% ><font size=1><a href='javascript:harian($tgl_skrg,$bln_skrg,$thn_skrg)'><b>Hari ini</b></a> : 
		 		 		<font face=Verdana><b>".namahari("P",$hari_skrg).", ".$tgl_skrg." ".namabulan("P",$bln_skrg)." ".$thn_skrg."</b></font></font></td>
		 		 </tr>
";
   break;
case 2: $hmb = 'b';
// Bulanan
echo "
           <tr>
";
echo "             <td width=100%><p align=center><font size=1>\n";
echo "               <a href='javascript:harian($tgl,$bln,$thn)'> Harian</a> | \n";
echo "							 <a href='javascript:mingguan($mng,$bln,$thn)'> Mingguan</a> | \n";
echo "               Bulanan </font></p>\n";
echo "             </td>\n";
echo "
				 	</tr>
				 </table>
				 <table width=100% class=tblabu2>
				   <tr>
				     <td colspan=3 align=center><b>
";
		$thn_sblm = $thn - 1; 
		$thn_ssdh = $thn + 1;
		print("<font size=1 face=Verdana><b><a href='javascript:bulanan($bln,$thn_sblm)'>< </a></b>&nbsp;</font>\n");
		print("<font size=1 face=Verdana color=red>&nbsp;$thn&nbsp;</font>\n");
		print("<font size=1 face=Verdana><b><a href='javascript:bulanan($bln,$thn_ssdh)'> ></a></b>&nbsp;</font>\n");
echo"
				     </b></td>
				   </tr>
";
   for ($m=1; $m<13; $m+=3) {
	 		 $mm = $m + 1; $mmm = $m +2;
echo "		     <tr>\n";
echo "		 		 		<td align=center><a href='javascript:bulanan($m,$thn)'><font size=2>".namabulan("S",$m)."</font></a></td>\n";
echo "		 		 		<td align=center><a href='javascript:bulanan($mm,$thn)'><font size=2>".namabulan("S",$mm)."</font></a></td>\n";
echo "		 		 		<td align=center><a href='javascript:bulanan($mmm,$thn)'><font size=2>".namabulan("S",$mmm)."</font></a></td>\n";
echo "		     </tr>\n";
   }
echo"
		     <tr>
		 		  <td width=100% colspan=3><font size=1><a href='javascript:harian($tgl_skrg,$bln_skrg,$thn_skrg)'><b>Hari ini</b></a> : 
		 		 		<font face=Verdana><b>".namahari("P",$hari_skrg).", ".$tgl_skrg." ".namabulan("P",$bln_skrg)." ".$thn_skrg."</b></font></font></td>
		 		 </tr>
";
   break;
} // end switch: harian, mingguan, bulanan


echo "
		   </table>
		 </div><br>
";

// Segera dikerjakan
echo "  <center>\n";
echo "        <div align=left>\n";
echo "          <table border=0 width=100% cellpadding=2 cellspacing=0>\n";
echo "            <tr>\n";
echo "              <td class=judul1 width=100%><b><font face=Verdana size=2>Segera Dikerjakan !</font></b></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </div>\n";
echo "        <div align=left>\n";
echo "          <table border=1 width=100% bgcolor='#C0C0C0' cellpadding=1 cellspacing=0>\n";
echo "            <tr>\n";
echo "              <td class=judul2 width=60%><font size=1 face='Verdana'><b>Judul</b></font></td>\n";
echo "              <td class=judul2 width=25%><font size='1' face=Verdana><b>Tgl_Akhir</b></font></td>\n";
echo "              <td class=judul2 width=15%><font size=1 face=Verdana><b>Hapus</b></font></td>\n";
echo "            </tr>\n";
$slctsgr  = "select judul, date_format(tgl_berakhir,'%e/%c/%Y') tanggal, kode_dikerjakan from segera_dikerjakan ";
$slctsgr .= "where pemilik=$kode_pengguna and status='Dalam Pengerjaan' order by tgl_berakhir";
$hsl = mysql_query($slctsgr,$dbh);
if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
echo "            <tr>\n";
echo "              <td width=60%><font size=1 face=Verdana><a target='isi' href='ubah_segera_dikerjakan.php?tanggal=$tgl-$bln-$thn&hmb=$hmb&kode_dikerjakan=$dat[2]'>$dat[0]</a></font></td>\n";
		 								if ($dat[1] == '0/0/0000') {$tstr = "-";}
										else {$tstr = $dat[1];}
echo "              <td width=25% align=middle><font size=1>$tstr</font></td>\n";
echo "              <td width=15% align=middle>\n";
echo "                  <p><a target='isi' href='olah_sgr_dikrj.php?tanggal=$tgl-$bln-$thn&hmb=$hmb&modus=Hapus&judul=$dat[0]&kode_dikerjakan=$dat[2]'>\n";
echo "									<img border=0 src='x.gif' width=8 height=8></a></p>\n";
echo "              </td>\n";
echo "            </tr>\n";
		   }
echo "            <tr>\n";
echo "              <td judul2 width=100% colspan=3>\n";
echo "                <p align=center><b><font size=2 face=Verdana><a target='isi' href='tambah_segera_dikerjakan.php?tanggal=$tgl-$bln-$thn&hmb=$hmb'>Tambah\n";
echo "                Baru</a></font></b></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </div>\n";
echo "      </center>\n";

// Lihat Agenda Pengguna Lain
echo "  <center>\n";
echo "        <div align=left>\n";
echo "				 <form name='lihat_lain' method='post' target='isi' ACTION='agenda_umum.php'>\n";
echo "          <table border=0 width=100% cellspacing=0 cellpadding=2>\n";
echo "            <tr>\n";
echo "              <td class=judul1 width=100%><b><font size=2>Agenda\n";
echo "                Pengguna Lain</font></b></td>\n";
echo "            </tr>\n";
echo "						  <input type=hidden name='ptgl' value=$tgl>\n";
echo "						  <input type=hidden name='pmng' value=$mng>\n";
echo "						  <input type=hidden name='pbln' value=$bln>\n";
echo "						  <input type=hidden name='pthn' value=$thn>\n";
echo "						  <input type=hidden name='kd_pengguna' value=''>\n";
echo "            <tr>\n";
echo "              <td width=100%>Pilih Pengguna :  \n";
echo "							<a href=\"javascript:showUserList('lihat_lain,kd_pengguna,pgn_lain','')\">\n";
echo "							<img align=top border=0 height=21 src='../gambar/p108.gif'></a></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=100%><input disabled type=text name='pgn_lain' value='' size=20>\n";
echo "              <input type=button name=lihat value='Lihat!' onclick='return cek_lihat_lain(document.lihat_lain,$nav)'></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "				 </form>\n";
echo "        </div>\n";
echo "      </center>\n";

// Pencarian Judul Kegiatan
echo "  <center>\n";
echo "        <div align=left>\n";
echo "				 <form name='cari' method='post' ACTION='navigasi_agenda.php'>\n";
echo "          <table border=0 width=100% cellspacing=0 cellpadding=2>\n";
echo "            <tr>\n";
echo "              <td class=judul1 width=100% colspan=2><b><font size=2>Pencarian\n";
echo "                Judul Kegiatan</font></b></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=50%><input type=text name=carijdl size=15></td>\n";
echo "              <td width=50%><input type=button value='Cari !' name=b3 onclick='javascript:carijudul(document.cari)'></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=50%><font size=2 face=Verdana>\n";
echo "        <a target='isi' href='pencarian_detil.php'>\n";
echo "        Pencarian Detil</a></font></td>\n";
echo "              <td width=50%></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "				 </form>\n";
echo "        </div>\n";
echo "      </center>\n";
echo "      <p align=left>&nbsp;</p>\n";

echo "    </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";
echo "\n";
echo "</body>\n";

mysql_close($dbh);

echo "\n";
echo "</html>\n";
echo "\n";
?>
