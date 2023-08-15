<?php
/******************************************
Nama File : hapus_proyek.php
Fungsi    : Menghapus proyek.
Dibuat    :	
 Tgl.     : 19-11-2001
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

function konfirmasi_hapus($item) {
if (mysql_error()) {
    echo "<tr><td><b>Error : </b>".mysql_error().".</td></tr>";
} else {
    echo "<tr><td><font size=2>".$item." sukses dihapus.<br></font></td></tr>";
}
}

echo "<html>\n";
echo "<head>\n";
echo "<title>Hapus Proyek</title>\n";
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

$qry = mysql_query("SELECT nama_proyek, singkatan FROM proyek WHERE kode_proyek='$pkode'", $db);
$namaproyek = mysql_result($qry,0,"nama_proyek");
$singkatanproyek = mysql_result($qry,0,"singkatan");
$qry = mysql_query("SELECT kode_grup FROM grup WHERE nama_grup='$singkatanproyek'", $db);
$gruppgn = mysql_result($qry,0,"kode_grup");
$qry = mysql_query("SELECT kode_direktori FROM direktori WHERE nama_direktori='$singkatanproyek'", $db);
$kodedir = mysql_result($qry,0,"kode_direktori");

echo"
<form name=hapusproyek>
<table bgcolor='#FFCC99' width=100% >
	<tr>
		<td align=center class=judul2>Hasil Penghapusan Proyek</td>
	</tr>
";


$hps_proyek      = mysql_query("DELETE FROM proyek             WHERE kode_proyek = '$pkode'", $db);
konfirmasi_hapus("Proyek <b>".$namaproyek."</b>");

$hps_mitra       = mysql_query("DELETE FROM mitra_proyek       WHERE kode_proyek = '$pkode'", $db);
konfirmasi_hapus("Mitra proyek");

$hps_personil    = mysql_query("DELETE FROM personil_proyek    WHERE kode_proyek = '$pkode'", $db);
konfirmasi_hapus("Personil proyek");

$hps_jadwal      = mysql_query("DELETE FROM jadwal_proyek      WHERE kode_proyek = '$pkode'", $db);
konfirmasi_hapus("Jadwal proyek");

$hps_penugasan   = mysql_query("DELETE FROM penugasan_personil WHERE kode_proyek = '$pkode'", $db);
konfirmasi_hapus("Penugasan personil proyek");

$hps_timesheet   = mysql_query("DELETE FROM timesheet_proyek   WHERE kode_proyek = '$pkode'", $db);
konfirmasi_hapus("Time sheet proyek");

$hps_kemajuan    = mysql_query("DELETE FROM kemajuan_proyek    WHERE kode_proyek = '$pkode'", $db);
konfirmasi_hapus("Kemajuan proyek");

$hps_grup        = mysql_query("DELETE FROM grup               WHERE nama_grup   = '$singkatanproyek'", $db);
konfirmasi_hapus("Grup proyek");

$hps_anggotagrup = mysql_query("DELETE FROM grup_pengguna      WHERE kode_grup   = '$gruppgn'", $db);
konfirmasi_hapus("Anggota grup proyek");

$hps_dir         = mysql_query("DELETE FROM direktori          WHERE nama_direktori   = '$singkatanproyek'", $db);
konfirmasi_hapus("Direktori proyek");

$hps_anggotagrup = mysql_query("DELETE FROM sharing_dir_grup   WHERE kode_direktori   = '$kodedir'", $db);
konfirmasi_hapus("Sharing direktori-grup proyek");

echo "
	</tr>	
	<tr height=50>
    <td align=center><input type=button name=tutup1 value=OK onclick=\"javascript:tutup()\"></td>
  </tr>	
</table>
</form>
";

mysql_close ($db);

echo "</body>";
echo "</html>";

?>
