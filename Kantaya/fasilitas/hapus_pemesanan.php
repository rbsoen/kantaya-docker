<?php
/******************************************
Nama File : hapus_pemesanan.php
Fungsi    : Menghapus pemesanan.
Dibuat    :	
 Tgl.     : 17-09-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

include ('../lib/cek_sesi.inc'); 
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Hapus Pemesanan Fasilitas</title>\n";
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

$hasil = mysql_query("DELETE FROM pemesanan WHERE kode_pesan = '$kodepesan'", $db);

echo"
<form name=hapuspemesanan>
<table width=100% >
	<tr>
		<td class=judul2 align=center>Hasil Hapus Pemesanan</td>
	</tr>
";
	if (mysql_error()) {
    echo "<tr><td><b>Error : </b>".mysql_error().".</td></tr>";
} else {
    echo "<tr><td>Pemesanan telah dihapus.<br></td></tr>";
}
echo "
	</tr>	
	<tr height=100>
    <td align=center><input type=button name=tutup1 value=OK onclick=\"javascript:tutup()\"></td>
  </tr>	
</table>
</form>
";


mysql_close ($db);

echo "</body>";
echo "</html>";

?>
