<html>
<head><title>Pemesanan Fasilitas</title></head>

<body alink=blue vlink=blue>


<?php 
	$db = mysql_connect("localhost", "root"); 
	mysql_select_db("dbagoeng", $db); 

	// ----- Style warna ------ :
	$style_agoeng = array (
			"judul" => "#225F95",
			"dasar" => "#eeeeee",
			"field" => "#ffeeaa",
	);

	// ------ Def. Bulan -------
	$bln[1]  = "Januari";
	$bln[2]  = "Pebruari";
	$bln[3]  = "Maret";
	$bln[4]  = "April";
	$bln[5]  = "Mei";
	$bln[6]  = "Juni";
	$bln[7]  = "Juli";
	$bln[8]  = "Agustus";
	$bln[9]  = "September";
	$bln[10] = "Oktober";
	$bln[11] = "Nopember";
	$bln[12] = "Desember";

	// ------- File Action -------
	$aksi="simpan_pemesanan.php";

	// ------- Konstanta Tabel -------
	$lebar=700;
	$batas=0;

echo"
<form name=pemesanan_fasilitas method=post action=".$aksi.">
<table bgcolor=".$style_agoeng["dasar"]." width=".$lebar." border=".$batas.">
	<tr bgcolor=".$style_agoeng["judul"]."><font color=white size=4><b> Form Pemesanan Fasilitas (Detail) </b></font></tr>
	<tr><td width=200 bgcolor=".$style_agoeng["field"].">Nama Fasilitas</td>
            <td>
		<select name=pfas>
";
			$hasil = mysql_query("SELECT kode_fas, nama_fas FROM fasilitas", $db);
			while ($baris=mysql_fetch_array($hasil)) {
				echo "	<option value=".$baris["kode_fas"].">".$baris["nama_fas"];
			}
echo"
		</select>
	    </td>
	</tr>

	<tr><td bgcolor=".$style_agoeng["field"]." width=200>Dipesan</td>
	    <td></td><td></td>
	</tr>

	<tr><td bgcolor=".$style_agoeng["field"]." width=200>Oleh *</td>
	    <td width=200><input type=text name=ppemesan></td>
	</tr>

	<tr><td bgcolor=".$style_agoeng["field"]." width=200>Untuk Keperluan</td>
	    <td width=200><textarea  rows=5 cols=25 name=pkeperluan></textarea></td>
	</tr>

	<tr><td bgcolor=".$style_agoeng["field"]." width=200>Tanggal</td>
	    <td width=200>
		<select name=ptglmulai>
";
			for ($i=1; $i<=31; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pblnmulai>
";
			for ($i=1; $i<=12; $i++) {
echo"				<option value=".$i.">".$bln[$i];
			}
echo"
		</select>
		<select name=pthnmulai>
";
			for ($i=2001; $i<=2020; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
	    </td>
	</tr>
<table bgcolor=".$style_agoeng["dasar"]." width=".$lebar." border=".$batas.">
	<tr><td bgcolor=".$style_agoeng["field"]." width=200>Jam (hh:mm)</td>
	    <td>
		<select name=pjammulai>
";
			for ($i=7; $i<=18; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pmenitmulai>
";
			for ($i=0; $i<=30; $i=$i+30) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select> <font size=2><b>WIB</b></font>
	    </td>
	    <td>s.d.</td>
	    <td>
		<select name=pjamakhir>
";
			for ($i=7; $i<=18; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pmenitakhir>
";
			for ($i=0; $i<=30; $i=$i+30) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select> <font size=2><b>WIB</b></font>
	    </td>
	    <td>
		<input type=checkbox name=pseharian value=Y> Sehari Penuh
	    </td>
	</tr>
</table>
<table bgcolor=".$style_agoeng["dasar"]." width=".$lebar." border=".$batas.">
";
/*
	<tr><td bgcolor=".$style_agoeng["field"]." width=200>s.d Tanggal</td>
	    <td>
		<select name=ptglakhir>
";
			for ($i=1; $i<=31; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pblnakhir>
";
			for ($i=1; $i<=12; $i++) {
echo"				<option value=".$i.">".$bln[$i];
			}
echo"
		</select>
		<select name=pthnakhir>
";
			for ($i=2001; $i<=2020; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
	    </td>
	    <td width=93></td>
	    <td>
		<input type=checkbox name=pselamanya value=Y> Selamanya
	    </td>
	</tr>
";
*/
echo"

	<tr><td bgcolor=".$style_agoeng["field"]." width=200>Keterangan</td>
	    <td ><textarea rows=5 cols=25 name=pketerangan></textarea></td>
	</tr>
</table>

<table bgcolor=#eeeeee height=50 width=".$lebar." border=".$batas.">
	<tr>
		<td></td>
		<td width=70><input type=submit name=submit value='Simpan'></td>
		<td></td>
		<td width=70><input type=submit name=submit value='Simpan dan Lagi'></td>
		<td></td>
		<td width=70><input type=submit name=submit value='Batal'></td>
		<td></td>
		<td width=70><input type=submit name=submit value='Hapus'></td>
		<td></td>
	</tr>
</table>

<a href=http://127.0.0.1/user_scripts/fasilitas/pemesanan.php>Ulang</a>
<br>Ket. : * = Wajib diisi.

";
?>


</body>
</html> 
