<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
$css = "../css/".$tampilan_css.".css";

echo "<html>\n";
echo "\n";
echo "<head>\n";
echo "<title>Agenda Bulanan</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>
<script language="JavaScript">
<!--
function harian(kdpgn, tgl, bln, thn) {
	window.open("navagendapublik.php?nav=0&kd_pgn="+kdpgn+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("agenda_umum.php?kd_pengguna="+kdpgn+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
};

function bulanan(kdpgn, bln, thn) {
	window.open("navagendapublik.php?nav=2&kd_pgn="+kdpgn+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("bulanan_umum.php?kd_pengguna="+kdpgn+"&pbln="+bln+"&pthn="+thn, "isi");
};
// -->
</script>
<?php
echo "</head>\n";
echo "<body>\n";

if (isset($pbln)) {$bln = $pbln; } else {$bln = date("n");}
if (isset ($pthn)) {$thn = $pthn;} else {$thn = date("Y");}
$hsl = mysql_query("select nama_pengguna from pengguna where kode_pengguna=$kd_pengguna",$dbh);
if (!$hsl) { echo mysql_error(); }
else { $dat = mysql_fetch_row($hsl); $pemilik = $dat[0]; }
echo "<div align=center>\n";
echo "  <center>\n";
echo "  <table border=0 width=100%>\n";
echo "    <tr>\n";
echo "      <td class=judul1>Agenda Bulanan Milik : <font color=CCCCFF>$pemilik</font></td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </center>\n";
echo "</div>\n";
echo "<div align=center>\n";
echo "  <center>\n";
echo "  <table border=0 width=100% cellpadding=4 cellspacing=0 bordercolorlight=#000080 bordercolordark=#008000>\n";
echo "    <tr>\n";
$namabln = namabulan("P",$bln);
$blns = $bln - 1;
$thns = $thn;
if ($blns == 0) { $blns = 12; $thns -= 1;}
$blnb = $bln + 1;
$thnb = $thn;
if ($blnb == 13) { $blnb = 1; $thnb += 1;}
echo "      <td class=judul2><font face=Verdana >";
echo 		"<a href='javascript:bulanan($kd_pengguna,$blns,$thns)'>&lt;&lt;</a>\n";
echo "        $namabln&nbsp; $thn <a href='javascript:bulanan($kd_pengguna,$blnb,$thnb)'>&gt;&gt;</a></font></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=isi2>\n";
echo "        <div align=center>\n";
echo "          <table border=1 width=100% cellspacing=0 cellpadding=4>\n";
echo "            <tr>\n";
echo "              <td width=14% class=judul2>Senin</td>\n";
echo "              <td width=14% class=judul2>Selasa</td>\n";
echo "              <td width=14% class=judul2>Rabu</td>\n";
echo "              <td width=14% class=judul2>Kamis</td>\n";
echo "              <td width=14% class=judul2>Jumat</td>\n";
echo "              <td width=14% class=judul2>Sabtu</td>\n";
echo "              <td width=14% class=judul2>Minggu</td>\n";
echo "            </tr>\n";
kalender($bln,$thn,$kal);
for ($i=0; $i<count($kal); $i++) {
	switch ($i) {
				 case 0 : $k = "I"; break;
				 case 1 : $k = "II"; break;
				 case 2 : $k = "III"; break;
				 case 3 : $k = "IV"; break;
				 case 4 : $k = "V"; break;
				 case 5 : $k = "VI"; break;
	}
echo "            <tr>\n";
	for ($j=0; $j<7; $j++) {
	  $tgl = $kal[$i][$j]; 
		if ($tgl == 0) {
echo "              <td width=11% bgcolor=dcdcdc>&nbsp;</td>\n";
		}
		else { 
			if ($j == 6) {$font = "<font color='red'>";}
			else {$font = "<font color=0000FF>";}
echo "		 				  <td width=12% bgcolor=dcdcdc>\n";
echo "                <table border=0>\n";
echo "										 <td width=100%>$font<b>";
echo "							        <a href='javascript:harian($kd_pengguna,$tgl,$bln,$thn)'>$tgl</a></b></font></td>\n";
echo "								</table>\n";
echo "							 </td>\n";
		}
	}
echo "            </tr>\n";
echo "            <tr>\n";
//echo "              <td width=12% >&nbsp</td>\n";
	for ($j=0; $j<7; $j++) { 
			$tgl = $kal[$i][$j];
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
			$flg = 0;
echo "              <td width=15%>";
echo "                <table border=0>\n";
					 while ($dat = @mysql_fetch_row($hsl)) {
					 			 $flg++;
					 			 $dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
echo "              	<tr><td width=100%><font size=1>\n";
		 						 if ($dat[4]==1) {
								 
echo "<a href='isi_agenda.php?kode_agenda=$dat[3]'>$dat[2]</a>";
								 } else { echo "SIBUK"; }
								 echo "</font></td>\n";
echo "								</tr>\n";
		 			 }
					 if ($flg == 0) {echo "		 					&nbsp</table></td>\n";}
					 else {echo "		 					</table></td>\n";}
	}
echo "            </tr>\n";
}

echo "          </table>\n";
echo "        </div><br>\n";
echo "        <div align=center>\n";
echo "          <table border=0 cellpadding=0 cellspacing=0 width=95%>\n";
echo "          <tr>\n";
echo "            <td width=100%>\n";
echo "              <ul>\n";
echo "                <li>\n";
echo "                  <p align=left><font size=2 face=Verdana>Klik judul\n";
echo "                  kegiatan untuk melihat detil kegiatan</font></p>\n";
echo "                </li>\n";
echo "              </ul>\n";
echo "              <center></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </div><p>&nbsp</p>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </center>\n";
echo "</div>\n";
echo "\n";
echo "</body>\n";
echo "\n";
echo "</html>\n";
mysql_close($dbh);
?>
