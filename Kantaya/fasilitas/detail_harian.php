<?php
/******************************************
Nama File : detail_harian.php
Fungsi    : Menampilkan detail pemesanan
            secara harian.
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

if (!isset($pfas)) { $pfas=1; }

echo "<html>\n";
echo "<head>\n";
echo "<title>Detail Daftar Pemesanan Harian (Detail)</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>

<script language="JavaScript">
<!--
function infopemesanan(kodepesan, kodefas, pemesan, keperluan, tglmulai, jammulai, jamakhir, keterangan, dibuattgl) {
	window.open("info_pemesanan.php?pkodepesan="+kodepesan+"&pkodefas="+kodefas+"&ppemesan="+pemesan+"&pkeperluan="+keperluan+"&ptglmulai="+tglmulai+"&pjammulai="+jammulai+"&pjamakhir="+jamakhir+"&pketerangan="+keterangan+"&pdibuattgl="+dibuattgl, "isi");
}
// -->
</script>

<?php 
echo "</head>\n";
echo "<body>\n";
		
$hasilfas=mysql_query("SELECT  nama_fas, wewenang FROM fasilitas WHERE kode_fas = '$pfas'", $db);
$namafas = mysql_result($hasilfas,0,"nama_fas");
$wwn = mysql_result($hasilfas,0,"wewenang");
$hsl_pgn = mysql_query("SELECT nama_pengguna FROM pengguna WHERE kode_pengguna='$wwn'", $db);
$pngjwb = mysql_result($hsl_pgn,"nama_pengguna");


echo"
<table width=100% border='0'>
	<tr>
			<td class='judul1' colspan=3>Daftar Pemesanan Fasilitas (Harian)</td>
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
		<td><font size=2>Dipesan untuk Tgl.</font></td>
		<td colspan=2><font size=2> : </font>
";
		if ($pbln[0]=="0") { $pbln=$pbln[1]; }
echo"
		<font size=2 color=red><b>".$ptgl." ".namabulan('P',$pbln)." ".$pthn."</b></font></td>
	</tr>
</table>
<table width=100% >
	<tr>
		<td class='judul2' width=50><center><b>Jam</b></center></td>
		<td class='judul2' width=100><center><b>Keperluan</b></center></td>
		<td class='judul2' width=100><center><b>Pemesan</b></center></td>
		<td class='judul2' width=50><center><b>Tgl. Pemesanan</b></center></td>
	</tr>
";

	$tglmulai = $pthn."-".$pbln."-".$ptgl;
	$dipesan=mysql_query("SELECT  kode_pesan, pemesan, kode_agenda, keperluan, untuk_tgl, jam_mulai, jam_akhir, keterangan, tanggal_dibuat FROM pemesanan WHERE untuk_tgl='$tglmulai' and fasilitas='$pfas' ORDER BY jam_mulai", $db);
	while ($row=mysql_fetch_array($dipesan)) {
		list($hh_mulai,$mm_mulai,$ss_mulai) = split(':',$row["jam_mulai"]);
		list($hh_akhir,$mm_akhir,$ss_akhir) = split(':',$row["jam_akhir"]);
		list($th,$bl,$tg) = split('-',$row["tanggal_dibuat"]);
		$tg = substr($tg,0,2);
		if ($bl[0]=="0") { $bl=$bl[1]; }
		$nm_bl = namabulan('S', $bl);
echo"			
		<tr bgcolor=#ffffff>
			<td width=50><font size=2><center>".$hh_mulai.":".$mm_mulai."<br> - <br>".$hh_akhir.":".$mm_akhir."</center></font></td>
";
			$kodepesan	= $row["kode_pesan"];
			$pem 		= $row["pemesan"];
			$kep 		= $row["keperluan"];
				if ($kep=="") { $kep="-"; } else { $kep=substr($kep, 0, 5); $kep=$kep."...";}
			$tglml 		= $row["untuk_tgl"];
			$jamml 		= $row["jam_mulai"];
			$jamak 		= $row["jam_akhir"];
			$ket 		= $row["keterangan"];
				if ($ket=="NULL") { $ket = "-";  }
			$dibuattgl 	= $row["tanggal_dibuat"];
			$keg		= $row["kode_agenda"];

			if ($keg==0) {
				print "<td width=100><center><font size=2><a href=\"javascript:infopemesanan('$kodepesan','$pfas','$pem','$kep','$tglml','$jamml','$jamak','$ket','$dibuattgl')\">".$kep."</a></font></center></td>\n";
			} else {
				print "<td width=100><center><font size=2><a href=\"../agenda/isi_agenda.php?kode_agenda=$keg\">Kegiatan No. ".$keg."</a></font></center></td>\n";
			}				
			$hsl_pgn = mysql_query("SELECT nama_pengguna, email FROM pengguna WHERE kode_pengguna='$pem'", $db);
			$namapemesan = mysql_result($hsl_pgn,0,"nama_pengguna");
			$emailpemesan = mysql_result($hsl_pgn,0,"email");
echo"
			<td width=100><center><font size=2><a href=mailto:".$emailpemesan.">".$namapemesan."</a></font></center></td>
			<td width=100><center><font size=2>".$tg." ".$nm_bl.". ".$th."</font></center></td>
		</tr>	
";
	}
	// mysql_free_result ($dipesan);

echo"	
<tr>
<td>&nbsp;</td>
</tr>
</table>         
<font size=2><b>Ket. :</b> Untuk melihat detail informasi pemesanan, silakan klik link <b>Keperluan</b>.</font>


";
mysql_close ($db);

echo "</body>";
echo "</html>";

?>
