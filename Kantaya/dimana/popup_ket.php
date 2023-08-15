<?php
/******************************************
Nama File : popup_ket.php
Fungsi    : Menampilkan secara pop up 
            keterangan keberadaan seorang
            pengguna.
Dibuat    :	
 Tgl.     : 02-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

include ('../lib/cek_sesi.inc'); 
include ('../lib/fs_kalender.php');
include ('akses_unit_kebawah.php'); 
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Keterangan Keberadaan Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
//echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>

<SCRIPT LANGUAGE='JavaScript'>
<!--

function tutup() {
   window.close();
}

// -->
</SCRIPT>


<?php
echo "</head>\n";
echo "<body bgcolor='#FFCC99'>\n";

$hasil = mysql_query("SELECT keterangan FROM dimana WHERE kode_pengguna ='$kd_pengguna'", $db);
$ket = mysql_result($hasil,0,"keterangan");

if ($ket=="-" or $ket=="" or $ket==NULL) { $ket="Tidak ada keterangan."; }

echo "
<form name=popupket>
<table width=100% >
	<tr>
		<td align=center class=judul2>Keterangan Keberadaan</td>
	</tr>
	<tr>
		<td>".$ket."</td>
	</tr>	
	<tr height=50>
    <td align=center><input type=button name=tutup1 value=OK onclick=\"javascript:tutup()\"></td>
  </tr>	
</table>
</form>
";
echo "</body>";
echo "</html>"; 

?>
