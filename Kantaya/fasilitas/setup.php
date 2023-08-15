<?php
/******************************************
Nama File : setup.php
Fungsi    : Setup/pendaftaran fasilitas.
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
echo "<title>Pendaftaran/Setup Fasilitas</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
?>

<script language='Javascript'>
<!--
function showUserList(pfld,pfltr) {
				 if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {
				 		window.PsnList.close();
				 }
				 PsnList = window.open('../lib/list_pengguna.php?pfld='+pfld+'&pfltr='+pfltr, 'List', 'width=390,height=450,scrollbars=yes');
}
// -->
</script>

<?php
echo "</head>\n";
echo "<body>\n";
echo"
<form name=setup_fasilitas method=post action='simpan_setup.php'>
<table width=100% border='0'>
	<tr>
		<td class='judul1' colspan=5>Pendaftaran/Setup Fasilitas</td>
	</tr>

	<tr><td><font size=2>Nama Fasilitas </font><font size=2 color=red>*</font></td>
	<td><font size=2> : </font></td>
            <td colspan=3><input type=text name=namafas></td>
	</tr>
	<tr><td><font size=2>Unit/Group Pemilik</font></td>
	<td><font size=2> : </font></td>
	    <td colspan=3>
		<select name=unit>
";

	$hasil = mysql_query("SELECT kode_unit, nama_unit FROM unit_kerja", $db);
	while ($baris=mysql_fetch_array($hasil)) {
		echo "	<option value=".$baris["kode_unit"].">".$baris["nama_unit"];
	}
	mysql_free_result ($hasil);

echo"                              
		</select>
	    </td>
	</tr>
	<tr>
		<td><font size=2>Penanggung Jawab </font><font size=2 color=red>*</font></td>
		<td><font size=2> : </font></td>
		<td>
							<input type=hidden name=wewenang value=''>
							<input type=text name=nama_wewenang value='' size=20>
							<a href=\"javascript:showUserList('setup_fasilitas,wewenang,nama_wewenang',document.setup_fasilitas.unit.options[document.setup_fasilitas.unit.selectedIndex].value)\"><img align=top border=0 height=21 src='../gambar/p108.gif'></a>
		</td>
	</tr>	
	<tr><td><font size=2>Lokasi </font><font size=2 color=red>*</font></td>
	<td><font size=2> : </font></td>
	    <td colspan=3><input type=text name=lokasi></td>
	</tr>
	<tr><td><font size=2>Status</font></td>
	<td><font size=2> : </font></td>
	    <td colspan=3>
		<select name=status>
			<option value=1>Siap Pakai
			<option value=2>Dalam Perbaikan
			<option value=3>Rusak Permanen
		</select>
	    </td>
	</tr>
	<tr><td><font size=2>Keterangan</font></td>
	<td><font size=2> : </font></td>
	    <td colspan=3><textarea  rows=5 cols=25 name=keterangan></textarea></td>
	</tr>

	<tr>
		<td><input type=submit name=submit value='Simpan'></td>
		<td></td>
		<td><input type=submit name=submit value='Simpan dan Lagi'></td>
		<td></td>
		<td><input type=submit name=submit value='Batal'></td>
	</tr>
</table>
<br><font size=2>Ket. :</font><font size=2 color=red> * </font><font size=2>= Wajib diisi.</font>

";

mysql_close ($db);

echo "</body>";
echo "</html>";

?>
