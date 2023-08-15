<?php
/******************************************
Nama File : detail_hari_ini.php
Fungsi    : Menampilkan detail pemesanan
            pada hari saat login.
Dibuat    :	
 Tgl.     : 17-09-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

include ('../lib/cek_sesi.inc');  
include ('pesan_ulang.php');
include ('../lib/akses_unit.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";
?>

<script language="JavaScript">
<!--
function detailharian(kodefas, tgl, bln, thn) {
	window.open("detail_harian.php?pfas="+kodefas+"&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
}
// -->
</script>

<?php
echo "<html>\n";
echo "<head>\n";
echo "<title>Detail Hari Ini</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

list_akses_unit($db,$unit_pengguna,&$aksesunit);

$ttlunit = count($aksesunit);
for ($i=0; $i<$ttlunit; $i++) {
			$unit[$i] = $aksesunit[$i][0];
}
$sqlwhere = "WHERE unit = '";
foreach ($unit as $isi) {
			$sqlwhere = $sqlwhere.$isi."' OR unit = '";
}
$sqlwhere = substr ($sqlwhere, 0, -12);
$sqltext = "SELECT kode_fas, nama_fas, unit FROM fasilitas ";
$sqltext = $sqltext.$sqlwhere." ORDER BY unit";
		
$hsl_fas = mysql_query($sqltext, $db);
$kodefas = mysql_result($hsl_fas, "kode_fas");

$bln = date("n");
$tgl = date("j");
$thn = date("Y");

echo "<script language='Javascript'>detailharian($kodefas, $tgl, $bln, $thn)</script>\n";

echo "</body>";
echo "</html>";

?>
