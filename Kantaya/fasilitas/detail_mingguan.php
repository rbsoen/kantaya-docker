<?php
/******************************************
Nama File : detail_mingguan.php
Fungsi    : Menampilkan detail pemesanan
            secara mingguan.
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
//echo $pkal0."-".$pkal1."-".$pkal2."-".$pkal3."-".$pkal4."-".$pkal5."-".$pkal6."-".$pmingguke."-".$pbln."-".$pthn;

function cekada($tgml, $tglhari, $pfas, $db, $hari) {
	$n = 0;
	$recordttl = "";

	$hitung=mysql_query("SELECT  COUNT(untuk_tgl) FROM pemesanan WHERE fasilitas = '$pfas' AND untuk_tgl = '$tgml'", $db);
	$jml=mysql_result($hitung, 0, "COUNT(untuk_tgl)");

	$dipesan=mysql_query("SELECT  kode_pesan, kode_agenda, untuk_tgl, jam_mulai, jam_akhir, keperluan, keterangan, pemesan, tanggal_dibuat FROM pemesanan WHERE fasilitas = '$pfas' AND untuk_tgl = '$tgml' ORDER BY jam_mulai", $db);
	while ($row=mysql_fetch_array($dipesan)) {
		list($thnmulai,$blnmulai,$tglmulai) = split('-',$row["untuk_tgl"]);

		$kodepesan[$n]	= $row["kode_pesan"];
		$tglada[$n] 	= $tglmulai;
		$jammulai[$n] 	= $row["jam_mulai"];
		$jamakhir[$n] 	= $row["jam_akhir"];
		$keperluan[$n] 	= $row["keperluan"];
			if ($keperluan[$n]=="") { $keperluan[$n]="-"; } else { $keperluan[$n]=substr($keperluan[$n], 0, 5); $keperluan[$n]=$keperluan[$n]."...";}
		$pemesan[$n] 	= $row["pemesan"];
	//	$dibuattgl[$n] 	= $row["tanggal_dibuat"];
		$tglml[$n]	= $row["untuk_tgl"];
		$jamml[$n]	= $row["jam_mulai"];
		$jamak[$n]	= $row["jam_akhir"];
		$ket[$n]		= $row["keterangan"];
			if ($ket[$n]=="NULL") { $ket[$n] = "-";  }
		$dibuattgl[$n] 	= $row["tanggal_dibuat"];
		$dibuattg = substr($dibuattgl[$n],0,10);
		$keg[n]		= $row["kode_agenda"];
		if ($keg[n]==0) {
			$link = "javascript:infopemesanan('$kodepesan[$n]','$pfas','$pemesan[$n]','$keperluan[$n]','$tglml[$n]','$jamml[$n]','$jamak[$n]','$ket[$n]','$dibuattg')";
			$linkprompt = $keperluan[$n];
		} else {
			$link = "info_kegiatan.php?pkeg='$keg[n]'";
			$linkprompt = "Kegiatan No. ".$keg[n];
		}	

		$hsl_pgn = mysql_query("SELECT nama_pengguna, email FROM pengguna WHERE kode_pengguna='$pemesan[$n]'", $db);
		$namapemesan = mysql_result($hsl_pgn,0,"nama_pengguna");
		$emailpemesan = mysql_result($hsl_pgn,0,"email");

		list($th,$bl,$tg) = split('-',$dibuattgl[$n]);
		$tg = substr($tg,0,2);
		if ($bl[0]=="0") { $bl=$bl[1]; }
		$nm_bl = namabulan('S', $bl);

		if ($n > 0) {
			$record_ada[$n] = 	"
				<tr bgcolor=pink>
					<td width=100><font size=2>".$jammulai[$n]."-".$jamakhir[$n]."</font></td>
					<td align=center width=50><font size=2><a href=".$link.">".$linkprompt."</a></font></td>
					<td width=50><font size=2><a href=mailto:".$emailpemesan.">".$namapemesan."</a></font></td>
					<td width=100><font size=2>".$tg." ".$nm_bl.". ".$th."</font></td>
				</tr>		";
		} else {
			$record_ada[$n] = 	"
				<tr bgcolor=pink>
					<td rowspan=".$jml." width=100><center><font size=2><b>$hari</b></font><br><font size=2 color=blue><b>$tglhari<b></font></center></td>
					<td width=100><font size=2>".$jammulai[$n]."-".$jamakhir[$n]."</font></td>
					<td align=center width=50><font size=2><a href=".$link.">".$linkprompt."</a></font></td>
					<td width=50><font size=2><a href=mailto:".$emailpemesan.">".$namapemesan."</a></font></td>
					<td width=100><font size=2>".$tg." ".$nm_bl.". ".$th."</font></td>
				</tr>		";
		}
		mysql_free_result ($hsl_pgn);
		$recordttl = $recordttl.$record_ada[$n];
		$n++;
	}
	return $recordttl;
	mysql_free_result ($hitung);
	mysql_free_result ($dipesan);
}


echo "<html>\n";
echo "<head>\n";
echo "<title>Detail Daftar Pemesanan Mingguan (Detail)</title>\n";
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


	// ----- Nama Hari ------ :
	$hari = array (
			"0" => "Senin",
			"1" => "Selasa",
			"2" => "Rabu",
			"3" => "Kamis",
			"4" => "Jum'at",
			"5" => "Sabtu",
			"6" => "Minggu"
	);

	$kal = array (
			"0" => $pkal0,
			"1" => $pkal1,
			"2" => $pkal2,
			"3" => $pkal3,
			"4" => $pkal4,
			"5" => $pkal5,
			"6" => $pkal6
	);

	$bulan = $pbln;
	$tahun = $pthn;

	$n=0;
	$dipesan=mysql_query("SELECT  untuk_tgl, jam_mulai, jam_akhir, keperluan, pemesan, tanggal_dibuat FROM pemesanan WHERE fasilitas = '$pfas' ORDER BY jam_mulai", $db);
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
	
	$hasilfas=mysql_query("SELECT  nama_fas, wewenang FROM fasilitas WHERE kode_fas = '$pfas'", $db);

	$namafas = mysql_result($hasilfas,0,"nama_fas");
	$wwn = mysql_result($hasilfas,0,"wewenang");
	$hsl_pgn = mysql_query("SELECT nama_pengguna FROM pengguna WHERE kode_pengguna='$wwn'", $db);
	$pngjwb = mysql_result($hsl_pgn,"nama_pengguna");

echo"
<table width=100% border='0'>
	<tr>
			<td class='judul1' colspan=6>Daftar Pemesanan Fasilitas (Mingguan)</td>
	</tr>

	<tr>
		<td width=150><font size=2>Nama Fasilitas</font></td>
		<td colspan=2><font color=red size=2> : <b>".$namafas."</b></font></td>
	</tr>
	<tr>
		<td width=150><font size=2>Penanggung Jawab</font></td>
		<td colspan=2><font size=2> : ".$pngjwb."</font></td>
	</tr>	
	<tr>
		<td width=150><font size=2>Minggu ke</font></td>
		<td><font size=2> : </font></td>
		<td width=100><font size=2 color=red><b>".$pmingguke."</b></font></td>
		<td width=50><font size=2>Bulan</font></td>
		<td><font size=2> : </font></td>
		<td width=200><font size=2 color=red><b>".namabulan("P",$pbln)." ".$pthn."</b></font></td>
	</tr>
</table>
<table width=100% >
	<tr>
		<td class='judul2' width=100><center><b>Hari/<br>Tanggal</b></center></td>
		<td class='judul2' width=100><center><b>Jam</center></b></td>
		<td class='judul2' width=100><center><b>Keperluan</center></b></td>
		<td class='judul2' width=100><center><b>Pemesan</center></b></td>
		<td class='judul2' width=50><center><b>Tgl. Pemesanan</b></center></td>
	</tr>
";
	for ($i=0; $i<7; $i++) {
		if ($kal[$i] == 0) {
			$kal[$i]="-";
		}
		$tgml = $tahun."-".$bulan."-".$kal[$i];
		$barisada = cekada($tgml, $kal[$i], $pfas, $db, $hari[$i]);
		if ($barisada <> "") {
			echo $barisada;
		} else {
			$warna =  "#ffffff"; 
echo"
			<tr bgcolor=".$warna.">
				<td width=100><font size=2><center><b>$hari[$i]</b></font><br><font size=2 color=blue><b>$kal[$i]<b></font></center></td>
				<td width=100><center>-</center></td>
				<td width=100><center>-</center></td>
				<td width=50><center>-</center></td>
				<td width=50><center>-</center></td>
			</tr>	
";
		}
	}


echo"	
<tr>
<td>&nbsp;</td>
</tr>
</table>         
<font size=2><b>Ket. :</b> Blok kalender berwarna merah muda menandakan pada hari itu ada pemesanan fasilitas tersebut. Untuk melihat detail informasi pemesanan, silakan klik link <b>Keperluan</b> di blok bersangkutan.</font>


";

mysql_close ($db);

echo "</body>";
echo "</html>";

?>
