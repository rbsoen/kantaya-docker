<?php
/******************************************
Nama File : detail_bulanan.php
Fungsi    : Menampilkan detail pemesanan
            secara bulanan.
Dibuat    :	
 Tgl.     : 17-09-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

include ('../lib/cek_sesi.inc');  
include ('../lib/fs_kalender.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Detail Daftar Pemesanan Bulanan (Detail)</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";

function ada($tglkal, $blnkal, $thnkal, $pfas, $db) {
	$n=0;
	$dipesan=mysql_query("SELECT  untuk_tgl FROM pemesanan WHERE fasilitas = '$pfas'", $db);
	while ($row=mysql_fetch_array($dipesan)) {
		list($thnmulai,$blnmulai,$tglmulai) = split('-',$row["untuk_tgl"]);
		$tglada[$n] = $tglmulai;
		$blnada[$n] = $blnmulai;
		$thnada[$n] = $thnmulai;
		$n++;
	}
	for ($p=0; $p<$n; $p++) {
		if ($tglkal==$tglada[$p] AND $blnkal==$blnada[$p] AND $thnkal==$thnada[$p]) {
			return "pink";
		} 
	}
	mysql_free_result ($dipesan);
}

?>

<script language="JavaScript">
<!--
function showCldList(fld, dflt, range) {
  window.open("/home/www/lib/kalender.php?pfld="+fld+"&pdflt="+dflt+"&prange="+range, "List", "width=270,height=180");
};
function detailharian(kodefas, tgl, bln, thn) {
	window.open("detail_harian.php?pfas="+kodefas+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
}
// -->
</script>

<?php 
echo "</head>\n";
echo "<body>\n";


	// ----- Nama Hari ------ :
	$hari = array (
			"1" => "Senin",
			"2" => "Selasa",
			"3" => "Rabu",
			"4" => "Kamis",
			"5" => "Jum'at",
			"6" => "Sabtu",
			"7" => "Minggu"
	);

	$hasilfas=mysql_query("SELECT  nama_fas, wewenang FROM fasilitas WHERE kode_fas = '$pfas'", $db);
	$namafas = mysql_result($hasilfas,0,"nama_fas");
	$wwn = mysql_result($hasilfas,0,"wewenang");
	$hsl_pgn = mysql_query("SELECT nama_pengguna FROM pengguna WHERE kode_pengguna='$wwn'", $db);
	$pngjwb = mysql_result($hsl_pgn,"nama_pengguna");

	$n=0;
	$dipesan=mysql_query("SELECT  untuk_tgl, jam_mulai, jam_akhir, keperluan, pemesan, tanggal_dibuat FROM pemesanan WHERE fasilitas = '$pfas'", $db);
	while ($row=mysql_fetch_array($dipesan)) {
		list($thnmulai,$blnmulai,$tglmulai) = split('-',$row["untuk_tgl"]);
		$tglada[$n] = $tglmulai;
		$jammulai[$n] = $row["jam_mulai"];
		$jamakhir[$n] = $row["jam_akhir"];
		$keperluan[$n] = $row["keperluan"];
		$pemesan[$n] = $row["pemesan"];
		$dibuattgl[$n] = $row["tanggal_dibuat"];
		$n++;
	}
	mysql_free_result ($dipesan);

echo"
<table width=100% border='0'>
	<tr>
			<td class='judul1' colspan=3>Daftar Pemesanan Fasilitas (Bulanan)</td>
	</tr>

	<tr>
		<td width=20% ><font size=2>Nama Fasilitas</font></td>
		<td colspan=2><font color=red size=2> : <b>".$namafas."</b></font></td>
	</tr>
	<tr>
		<td><font size=2>Penanggung Jawab</font></td>
		<td colspan=2><font size=2> : ".$pngjwb."</font></td>
	</tr>	
	<tr>
		<td><font size=2>Bulan</font></td>
		<td colspan=2><font size=2> : </font><font size=2 color=red><b>".namabulan("P",$pbln)." ".$pthn."</b></font></td>
	</tr>
</table>

<table width=100% >
  <tr align=\"center\" >
";
?>

<?php
	for ($i=1; $i<7; $i++) {
		print ("<td class='judul2' width=50 align='center'><b><font size=2><center>".namahari("P",$i)."</center></font></b></td>\n\t");
	}
	print ("<td class='judul2' width=50 align=\"center\"><b><font size=2><center>".namahari("P",0)."</center></font></b></td>\n");
?>

<?php
echo"
  </tr>
";
?>

<?php
	$bulan = $pbln;
	$tahun = $pthn;
	kalender($bulan,$tahun,$kalender);
	for ($i=0; $i<count($kalender); $i++) {
		print "   <tr bgcolor=#eeeeee>\n";
		for ($j=0; $j<7; $j++) {
			if ($kalender[$i][$j] == 0) {
				print "\t<td width=50 align=\"center\">&nbsp;<br><br><br></td>\n";	
			}
			else {
				$pval = $kalender[$i][$j]."/".$bulan."/".$tahun;
				$tgl_kal = $kalender[$i][$j];
				$warna = ada($tgl_kal, $bulan, $tahun, $pfas, $db);
				if ($warna <> "pink") { $warna = "#ffffff"; };
				print "\t<td bgcolor='$warna' width=50 height=20 align=\"center\">";
				print "<font size=2><a href=\"javascript:detailharian('$pfas','$tgl_kal','$bulan','$tahun')\">".$kalender[$i][$j]."</a></font><br><br><br></td>\n";
			}
		}
		print "   </tr>\n";
	}
 ?>


<?php
echo"
<tr>
<td>&nbsp;</td>
</tr>
</table>         
<font size=2><b>Ket. :</b> Blok kalender berwarna merah muda menandakan pada hari itu ada pemesanan fasilitas tersebut. Untuk melihat detail informasi pemesanan, silakan klik link tanggal di blok bersangkutan.</font>



";

mysql_close ($db);

echo "</body>";
echo "</html>";

?>
