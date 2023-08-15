<?php
/******************************************
Nama File : pemesanan.php
Fungsi    : Memesan fasilitas.
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
include ('../lib/akses_unit.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Pemesanan Fasilitas (Detail)</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>

<script language="JavaScript">
<!--
function showCldList(fld, dflt, range) {
  window.open("/lib/kalender.php?pfld="+fld+"&pdflt="+dflt+"&prange="+range, "List", "width=270,height=180");
};
// -->
</script>

<?php 
echo "</head>\n";
echo "<body>\n";

$tgl_ini = date("j");
$bln_ini = date("n");
$jam_ini = date("H");

$sqltext = "SELECT kode_fas, nama_fas, unit FROM fasilitas WHERE kode_fas=".$pfas;
$hsl_fas = mysql_query($sqltext, $db);
$namafas = mysql_result($hsl_fas,0,"nama_fas");
mysql_free_result ($hsl_fas);

echo"
<form name=pemesanan_fasilitas method=post action=simpan_pemesanan.php>
<table width=100% >
	<tr>
			<td class='judul1' colspan=5>Form Pemesanan Fasilitas (Detail)</td>
			<td></td>
			<td></td>
	</tr>
	<tr>
	    <td><font size=2>Nama Fasilitas</font></td>
	    <td><font size=2> : </font></td>
      <td colspan=3><font size=2><b>".$namafas;

echo"
		    </b></font><input type=hidden name=pfas value=".$pfas."></td>
	</tr>

	<tr><td><font size=2>Dipesan</font></td>
	    <td></td><td></td>
	</tr>

	<tr>
	    	<td><input type=hidden name=ppemesan value=".$kode_pengguna."></td>
	</tr>

	<tr><td><font size=2>Untuk Keperluan</font></td>
	    <td><font size=2> : </font></td>
	    <td colspan=3><input type=text name=pkeperluan></input></td>
	</tr>

	<tr><td><font size=2>Tanggal Mulai</font></td>
	    <td><font size=2> : </font></td>
	    <td colspan=3>
		<select name=ptglmulai>
						<option selected value=".$tgl_ini.">".$tgl_ini;
			for ($i=1; $i<=31; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pblnmulai>
						<option selected value=".$bln_ini.">".namabulan("S", $bln_ini);
			for ($i=1; $i<=12; $i++) {
				$nmbln = namabulan("S", $i);
echo"				<option value=".$i.">".$nmbln;
			}
echo"
		</select>
		<select name=pthnmulai>
";
			for ($i=2001; $i<=2002; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
";
?>
<?php
		$range = date('Y').",".(date('Y')+1);
		$tglsaatini = date('j')."/".date('n')."/".date('Y');
?>
		 <a href="javascript:showCldList('pemesanan_fasilitas,ptglmulai,pblnmulai,pthnmulai','<?=$tglsaatini?>','<?=$range?>')"><font size=1><img border=0 width=17 height=18 src=cld.gif></font></a> 
<?php
echo"
	    </td>
	</tr>


	<tr><td width=115><font size=2>Jam (hh:mm)</font></td>
	    <td><font size=2> : </font></td>
	    <td>
		<select name=pjammulai>
						<option selected value=".$jam_ini.">".$jam_ini;
			for ($i=0; $i<=23; $i++) {
				if (strlen($i)==1) { $i="0".$i; }
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pmenitmulai>
";
			for ($i=0; $i<=30; $i=$i+30) {
				if (strlen($i)==1) { $i="0".$i; }
echo"				<option value=".$i.">".$i;
			}
echo"
		</select> 
	    </td>
	    <td><font size=2>s.d.</font></td>
	    <td>
		<select name=pjamakhir>
						<option selected value=".$jam_ini.">".$jam_ini;
			for ($i=0; $i<=23; $i++) {
				if (strlen($i)==1) { $i="0".$i; }
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pmenitakhir>
";
			for ($i=0; $i<=30; $i=$i+30) {
				if (strlen($i)==1) { $i="0".$i; }
echo"				<option value=".$i.">".$i;
			}
echo"
		</select> 
	    </td>
	</tr>



	<tr><td width=96><font size=2>Tanggal Selesai</font></td>
	    <td><font size=2> : </font></td>
	    <td colspan=3>
		<select name=ptglakhir>
						<option selected value=".$tgl_ini.">".$tgl_ini;
			for ($i=1; $i<=31; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pblnakhir>
						<option selected value=".$bln_ini.">".namabulan("S", $bln_ini);
			for ($i=1; $i<=12; $i++) {
				$nmbln = namabulan("S", $i);
echo"				<option value=".$i.">".$nmbln;
			}
echo"
		</select>
		<select name=pthnakhir>
";
			for ($i=2001; $i<=2002; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
";
?>
<?php
		$range = date('Y').",".(date('Y')+1);
		$tglsaatini = date('j')."/".date('n')."/".date('Y');
?>
		<a href="javascript:showCldList('pemesanan_fasilitas,ptglakhir,pblnakhir,pthnakhir','<?=$tglsaatini?>','<?=$range?>')"><font size=1><img border=0 width=17 height=18 src=cld.gif></font></a> 
<?php
echo"
	    </td>
	</tr>


	<tr>
		<td width=108><font size=2>Untuk Tiap</font></td>
		<td><font size=2> : </font></td>
		<td colspan=3>
			<select name=p_ulang>
				<option value=nothing>-</option>
				<option value=h>Hari</option>
				<option value=m>Minggu</option>
				<option value=b>Bulan</option>
				<option value=mk>Minggu ke-n</option>
			</select>
		</td>
	</tr>
	<tr>
		<td width=108><font size=2>Keterangan</font></td>
		<td><font size=2> : </font></td>
		<td colspan=3><textarea rows=3 cols=25 name=pketerangan></textarea></td>
	</tr>

	<tr>
		<td><input type=submit name=submit value='Simpan'></td>
		<td></td>
		<td><input type=submit name=submit value='Simpan dan Lagi'></td>
		<td></td>
		<td><input type='button' value='Batal' onClick='javascript:history.go(-1)'></td>
	</tr>
</table>
</form>

<br><font size=2>Ket. : <br>- Pemesanan hanya untuk satu hari, <b>Tanggal Selesai</b> harus diisi sama dengan <b>Tanggal Mulai</b>, pilihan pengulangan tidak diperhatikan.<br><br>
- Untuk pemesanan berulang tiap <b>Minggu ke-n</b>, maksudnya <b>minggu ke</b> yang sama dengan <b>hari</b> dan <b>minggu ke</b> dari <b>Tanggal Mulai.</b></font>

";

mysql_close ($db);

echo "</body>";
echo "</html>";

?>

