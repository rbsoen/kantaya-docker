<?php
/******************************************
Nama File : list.php
Fungsi    : Menampilkan fasilitas yang ada.
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
echo "<title>Daftar/List Fasilitas</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

echo"

<table width=100% >
	<tr>
		<td class='judul1'><b>Daftar/List Fasilitas</td>
	</tr>
</table>
<table width=100% >
	<tr>
		<td align=center class='judul2'>Nama</td>
		<td align=center class='judul2'>Unit/Grup Pemilik</td>
		<td align=center class='judul2'>Penanggung Jawab</td>
		<td align=center class='judul2'>Lokasi</td>
		<td align=center class='judul2'>Status</td>
	</tr>
";

	$hasil = mysql_query("SELECT * FROM fasilitas ORDER BY nama_fas", $db);
	$n = 0;
	while ($baris=mysql_fetch_array($hasil)) {
	$n++;

echo"
	<tr>
		<td  class='isi2'>".$baris["nama_fas"]."</td>
";
		$kodeunit = $baris["unit"];
		$dummy = mysql_query("SELECT nama_unit FROM unit_kerja WHERE kode_unit='$kodeunit'", $db);
		$namaunit = mysql_result($dummy,"nama_unit");
		$wwn = $baris["wewenang"];
		$hsl_pgn = mysql_query("SELECT nama_pengguna FROM pengguna WHERE kode_pengguna='$wwn'", $db);
		$pngjwb = mysql_result($hsl_pgn,"nama_pengguna");
echo"
		<td  class='isi2'>".$namaunit."</td>
		<td  class='isi2'>".$pngjwb."</td>
		<td  class='isi2'>".$baris["lokasi"]."</td>
";
		if ($baris["status"] == 1) {
			$stt = "Siap Pakai";
		} elseif ($baris["status"] == 2) {
			$stt = "Dalam Perbaikan";
		} elseif ($baris["status"] == 3) {
			$stt = "Rusak Permanen";
		}
echo"
		<td class='isi2'>".$stt."</td>
	</tr>
";
	}
	mysql_free_result ($hasil);
echo"
</table>
";

mysql_close ($db);

echo "</body>";
echo "</html>";

?>
