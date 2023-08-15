<?php
session_start();
include('../lib/koneksi_db.inc');
$css = "../css/".$tampilan_css.".css";
echo "
<html>
<head>
<title>Pengolahan Data Koresponden</title>
<link rel=stylesheet type='text/css' href='$css'>
";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function openurl(urlpath,tgt)
{
  window.open(urlpath,tgt);
}
// -->
</script>
</head>
<body>

<?php

$prmtr1 = '';
$ktg_grup = '';
if ($kategori == 'U') {
	 $ktg_grup = substr($kd_unit,1,10);
	 $tktunit = substr($kd_unit,0,1);
	 $prmtr1 = "&ktg_grup=".$ktg_grup."&tingkat=".$tktunit;
	 }
if ($kategori == 'G') {
	 $ktg_grup = $kd_grup;
	 $prmtr1 = "&ktg_grup=".$ktg_grup;
	 }
$prmtr = "kategori=".$kategori.$prmtr1; 
echo "<div><center><p><br><br></p><p><br><br>\n";
if ($modus !== 'HAPUS' and ($nama == '' or !isset($jenis_kelamin))) {
	 $msg = "Nama koresponden dan jenis kelamin tidak boleh kosong !";
	 echo "<b><font face=Verdana size=4>$msg</font></b>\n";
	 echo "<br><br><font face=Verdana size=2><input type=button name=B1 value='Kembali' onclick='history.go(-1)'></font><br>\n";
	 echo "</p></center></div>\n";
	 }
else {
	 switch ($modus) {
			 case 'Simpan' :
			 			$query  = "INSERT INTO buku_alamat ";
						$query .= "VALUES ('', '$nama', '$gelar_dpn', '$gelar_blk', '$jenis_kelamin', ";
						$query .= "'$kategori', '$ktg_grup', '$jabatan', '$kantor', '$emailp', '$web_personal', ";
						$query .= "'$web_kantor', '$telp_kantor', '$telp_rumah', '$telp_hp', '$fax', ";
						$query .= "'$alamat_kantor', '$kota', '$kode_pos', '$propinsi', '$negara', ";
						$query .= "'$keterangan', $kode_pengguna, NOW(), '', '')";
						$msg = "Koresponden berhasil didaftarkan !";
						break;
			 case 'Ubah Data' : 
	 		 			$query  = "UPDATE buku_alamat SET ";
						$query .= "nama = '$nama', ";
						$query .= "gelar_dpn = '$gelar_dpn', ";
						$query .= "gelar_blk = '$gelar_blk', ";
						$query .= "jenis_kelamin = '$jenis_kelamin', ";
						$query .= "kategori = '$kategori', ";
						$query .= "ktg_grup = '$ktg_grup', ";
						$query .= "jabatan = '$jabatan', ";
						$query .= "kantor = '$kantor', ";
						$query .= "email = '$emailp', ";
						$query .= "web_personal = '$web_personal', ";
						$query .= "web_kantor = '$web_kantor', ";
						$query .= "telp_kantor = '$telp_kantor', ";
						$query .= "telp_rumah = '$telp_rumah', ";
						$query .= "telp_hp = '$telp_hp', ";
						$query .= "fax = '$fax', ";
						$query .= "alamat_kantor = '$alamat_kantor', ";
						$query .= "kota = '$kota', ";
						$query .= "kode_pos = '$kode_pos', ";
						$query .= "propinsi = '$propinsi', ";
						$query .= "negara = '$negara', ";
						$query .= "keterangan = '$keterangan', ";
						$query .= "diubah_oleh = $kode_pengguna, ";
						$query .= "diubah_tgl = curdate() ";
						$query .= "WHERE kontak_id = $kontak_id";
						$msg = "Data Koresponden berhasil diubah !";
						break;
			 case 'Hapus' :
			 			$query  = "DELETE FROM buku_alamat ";
						$query .= "WHERE kontak_id = $kontak_id";
						$msg = "Data Koresponden berhasil dihapus !";
						break;
			 }
	 $results = mysql_query($query, $dbh) or die ("Invalid query:" . mysql_error());
	 if ($results) {
	 		echo "<script language='JavaScript'>";
			echo "openurl('alamat.php?$prmtr','isi')</script>";
			}
	 else {
	 		echo mysql_error()."\n"; echo "Query: ".$query;
			}
	 }
echo "</p></center></div>\n";
mysql_close();
?>

</body>
</html>
