<?php
/******************************************
Nama File : info_pemesanan.php
Fungsi    : Menampilkan detail informasi 
            tentang suatu pemesanan
            fasilitas tertentu.
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
echo "<title>Info Pemesanan</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";

?>

<script language="JavaScript">
<!--

function showAlertHapusPemesanan(kodepesan, kodefas) {
  window.open("alert_hapus_pemesanan.php?kodepesan="+kodepesan+"&pkodefas="+kodefas, "List", "width=270,height=180");
};

// -->
</script>

<?php 
echo "</head>\n";
echo "<body>\n";

$hsl_pesan = mysql_query("SELECT keperluan, keterangan FROM pemesanan WHERE kode_pesan='$pkodepesan'", $db);
$hsl_fas = mysql_query("SELECT nama_fas FROM fasilitas WHERE kode_fas='$pkodefas'", $db);
$hsl_pgn = mysql_query("SELECT nama_pengguna FROM pengguna WHERE kode_pengguna='$ppemesan'", $db);

$kep = mysql_result($hsl_pesan,0,"keperluan");
if ($kep=="NULL" or $kep=="") { $kep = "-";  };
$ket = mysql_result($hsl_pesan,0,"keterangan");
if ($ket=="NULL" or $ket=="") { $ket = "-";  };

list($th1,$bl1,$tg1) = split('-',$ptglmulai);
if ($bl1[0]=="0") { $bl1=$bl1[1]; }
$nm_bl1 = namabulan('P', $bl1);

list($th2,$bl2,$tg2) = split('-',$pdibuattgl);
if ($bl2[0]=="0") { $bl2=$bl2[1]; }
$nm_bl2 = namabulan('P', $bl2);

echo"
<form name=hapus_pemesanan method=post action=hapus_pemesanan.php >
<table width=100% >
	<tr>
		<td class='judul1' colspan=5>Informasi Pemesanan</td>
	</tr>
";

if ($ppemesan==$kode_pengguna) {
echo "	
  <tr>
    <td colspan=5 align='right'>
		    <a href=\"javascript:showAlertHapusPemesanan('$pkodepesan','$pkodefas')\">Hapus (Batalkan) Pemesanan</a>
		</td>
  </tr>	
";
}

echo "	
	<tr>
		<td><font size=2>Nama Fasilitas</font></td>
		<td><font size=2> : </font></td>
		<td colspan=3><font size=2>".mysql_result($hsl_fas,0,"nama_fas")."</font></td>
	</tr>

	<tr>
		<td><font size=2>Dipesan</font></td>
	</tr>

	<tr>
		<td><font size=2>Oleh</font></td>
		<td><font size=2> : </font></td>
		<td colspan=3><font size=2>".mysql_result($hsl_pgn,0,"nama_pengguna")."</font></td>
	</tr>

	<tr>
		<td><font size=2>Untuk Keperluan</font></td>
		<td><font size=2> : </td>
		<td colspan=3><font size=2>".$kep."</font></td>
	</tr>

	<tr>
		<td><font size=2>Untuk Tgl.</font></td>
		<td><font size=2> : </font></td>
		<td colspan=3><font size=2>".$tg1." ".$nm_bl1." ".$th1."</font></td>
	</tr>

	<tr><td width=120><font size=2>Jam</font></td>
	    <td><font size=2> : </font></td>
	    <td><font size=2>".$pjammulai."</font></td>
	    <td><font size=2>s.d.</font></td>
	    <td><font size=2>".$pjamakhir."</font></td>
	</tr>

	<tr>
		<td><font size=2>Keterangan</font></td>
		<td><font size=2> : </font></td>
		<td  colspan=3 height=50 ><font size=2>".$ket."</font></td>
	</tr>

	<tr>
		<td><font size=2>Tgl. Pemesanan</font></td>
		<td><font size=2> : </font></td>
		<td colspan=3><font size=2>".$tg2." ".$nm_bl2." ".$th2."</font></td>
		
	</tr>

<tr align=center>
		<input type=hidden name=kodepesan value=".$pkodepesan.">
		<td></td><td></td>
";

/*
if ($ppemesan==$kode_pengguna) {
echo"
		<td width=70><input type=submit name=submit value='Hapus'></td>
";
} else {
}
*/

echo"
		<td></td><td></td>
	</tr>
</table>
</form>
";

mysql_free_result ($hsl_pesan);	
mysql_free_result ($hsl_fas);	
mysql_free_result ($hsl_pgn);
mysql_close ($db);

echo "</body>";
echo "</html>";

?>
