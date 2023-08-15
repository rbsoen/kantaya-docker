<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
require('cfgagenda.php');
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
function harian(kdpgn, tgl, bln, thn) {
	window.open("navagendapublik.php?nav=0&kd_pgn="+kdpgn+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("agenda_umum.php?kd_pengguna="+kdpgn+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
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
if (!isset($pthn) and !isset($pbln) and !isset($ptgl)) {
	 $jam = date("H");}
else {$jam = "12";}	

error_reporting(0);	
$jamntml = $pjammulai.":".$pmntmulai.":00";
$jamntsl = $pjamakhir.":".$pmntakhir.":00";
$hsl = mysql_query("select nama_pengguna from pengguna where kode_pengguna=$kd_pengguna",$dbh);
if (!$hsl) { echo mysql_error(); }
else { $dat = mysql_fetch_row($hsl); $pemilik = $dat[0]; }
echo "<body>\n";
echo "\n";
echo "<div align=center>\n";
echo "  <table border=0 width=100%>\n";
echo "    <tr>\n";
echo "      <td class=judul1 align=left>Agenda Harian Milik : <font color=CCCCFF>$pemilik</font></td>\n";
echo "    </tr>\n";

// Kegiatan hari bersangkutan
echo "  <center>\n";
echo "    <tr>\n";
echo "      <td class=isi2 width=90% valign=top>\n";
echo "        <div align=center>\n";
echo "          <center>\n";
echo "          <table border=0 width=100%>\n";
echo "            <tr>\n";
		 								$bltgths = mktime( 0, 0, 0, $bln, $tgl-1, $thn);
										$bltgthb = mktime( 0, 0, 0, $bln, $tgl+1, $thn);
		 								list($haris,$tgls,$blns,$thns) = split("-", date("w-j-n-Y", $bltgths));
										list($harib,$tglb,$blnb,$thnb) = split("-", date("w-j-n-Y", $bltgthb));
echo "              <td class=judul2 width=100% bgcolor='#0099FF'><font size=2 face=Verdana><b>\n";
echo "							  <a href='javascript:harian($kd_pengguna,$tgls,$blns,$thns)'>&lt;&lt;</a>&nbsp;\n";
echo "                ".namahari("P",$hari).", $tgl ".namabulan('P',$bln)." $thn&nbsp;\n";
echo "							  <a href='javascript:harian($kd_pengguna,$tglb,$blnb,$thnb)'>&gt;&gt;</a></b></font></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=100% align=center><font size=2 face=Verdana>";
echo "							  &nbsp;".stripslashes($msg)."&nbsp;</font></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          </center>\n";
echo "        </div>\n";
echo "        <div align=center>\n";
echo "          <center>\n";
echo "          <table border=1 width=100% bordercolorlight='#C0C0C0' bordercolordark='#C0C0C0' cellspacing=0 cellpadding=4>\n";
echo "            <tr>\n";
echo "              <td class=judul2 width=25%><b><font size=2 face=Verdana>Waktu</font></b></td>\n";
echo "              <td class=judul2 width=75% align=center><b><font size=2 face=Verdana>Judul Kegiatan</font></b></td>\n";
echo "            </tr>\n";

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
list($tjam,$tmnt) = split(':',$awaljamkrj);#date("H:i:s", mktime((int)$tjam,(int)$tmnt,0,0,0,0))
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			list($jamml,$mntml,$dtkml) = split(':',$dat[0]); #date("U", mktime((int)$jamml,(int)$mntml,0,0,0,0))
			if ($tjam < $jamml or ($tjam == $jamml and $tmnt < $mntml)) {
				 $twkt = $tjam.":".$tmnt;
				 $wkt = $twkt." - ".substr($dat[0],0,5);
echo "            <tr>\n";
echo "              <td width=25%><font size=2 face=Verdana>$wkt</a></font></td>\n";
echo "              <td width=75%><font size=1 face=Verdana>&nbsp;</font></td>\n";
echo "            </tr>\n";
		 	}
			$wkt = substr($dat[0],0,5)." - ".substr($dat[1],0,5);
			if ($wkt == "00:00 - 23:59") {$wkt = "Sepanjang Hari";}
echo "            <tr>\n";
echo "              <td width=25%><font size=2 face=Verdana>$wkt</font></td>\n";
echo "              <td width=75%><font size=2 face=Verdana>\n";
if ($dat[4]==1) { echo "                <a href='isi_agenda.php?kode_agenda=$dat[3]'>$dat[2]</a>"; }
else { echo "S&nbsp;I&nbsp;B&nbsp;U&nbsp;K"; }
echo "</font></td>\n";
echo "            </tr>\n";
		  list($tjam,$tmnt) = split(':',$dat[1]);
}
list($tjak,$tmak) = split(':',$akhirjamkrj);
if ($tjam < $tjak or ($tjam = $tjakand and $tmnt < $tmak)) {
	 $twkt = $tjam.":".$tmnt;
	 $wkt = $tjam.":".$tmnt." - ".$akhirjamkrj;
echo "            <tr>\n";
echo "              <td width=25%><font size=2 face=Verdana>$wkt</font></td>\n";
echo "              <td width=75%><font size=1 face=Verdana>&nbsp;</font></td>\n";
echo "            </tr>\n";
}
echo "          </table>\n";
echo "          </center>\n";
echo "        </div>\n";

echo "    </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo " </div>\n";
echo "</body>\n";

mysql_close($dbh);

echo "\n";
echo "</html>\n";
echo "\n";
?>
