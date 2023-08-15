<?php
/******************************************
Nama File : simpan_setup.php
Fungsi    : Menyimpan pendaftaran fasilitas.
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

echo "<html>";
echo "<head><title>Simpan Setup Fasilitas</title>";
echo "<link rel=stylesheet type='text/css' href='".$css."'>";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>";
echo "</head>";
echo "<body>";

if ($submit=="Batal") {
	echo "<meta http-equiv=REFRESH content=\"0; url=detail_hari_ini.php\">";
} else {

 if ($namafas=="" or $wewenang==""or $lokasi=="") {
 echo "
 <table width=100% >
	<tr bgcolor=blue>
		<td class='judul1'>Konfirmasi</td>
	</tr>
 </table>
 Ada field yang wajib diisi yang masih kosong !
 <meta http-equiv=REFRESH content=\"2; url=setup.php\">
 ";
	
 } else {
	
  $cek_fas = mysql_query("SELECT COUNT(nama_fas) FROM fasilitas WHERE nama_fas = '$namafas'", $db);
  $jml_fas = mysql_result($cek_fas,"COUNT(nama_fas)");

  if ($jml_fas>0) {
	 echo "
 <table width=100% >
	<tr bgcolor=blue>
		<td class='judul1'>Konfirmasi</td>
	</tr>
 </table>
 Fasilitas tsb. sudah ada, silakan isi yang lain !
 <meta http-equiv=REFRESH content=\"2; url=setup.php\">
 ";
	} else {
		$dibuatoleh = $kode_pengguna;
		$dibuattgl  = date("Y-m-d H:i:s");
		$diubaholeh = $kode_pengguna;
		$diubahtgl  = date("Y-m-d H:i:s");

		if ($submit=="Simpan")	{
			$hasil = mysql_query("INSERT INTO fasilitas (nama_fas, unit, wewenang, lokasi, status, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ('"
					.$namafas."','".$unit."','".$wewenang."','".$lokasi."','".$status."','".$keterangan."',".$dibuatoleh.",'".$dibuattgl."',".$diubaholeh.",'".$diubahtgl."')", $db);
			echo "<meta http-equiv=REFRESH content=\"0; url=list.php\">";
		} elseif ($submit=="Simpan dan Lagi")	{ 
			$hasil = mysql_query("INSERT INTO fasilitas (nama_fas, unit, wewenang, lokasi, status, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ('"
					.$namafas."','".$unit."','".$wewenang."','".$lokasi."','".$status."','".$keterangan."',".$dibuatoleh.",'".$dibuattgl."',".$diubaholeh.",'".$diubahtgl."')", $db);
			echo "<meta http-equiv=REFRESH content=\"0; url=setup.php\">";
 		}
		
	}
 }
}

mysql_close ($db);

echo "</body>";
echo "</html>";

?>
