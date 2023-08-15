<?php
/******************************************
Nama File : simpan_pemesanan.php
Fungsi    : Menyimpan pemesanan fasilitas.
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
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Simpan Pemesanan</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

if (!isset($kodeagenda)) {
	 $kodeagenda = 0;
}
$tgl_mulai = date("Y-m-d", mktime (0,0,0,$pblnmulai,$ptglmulai,$pthnmulai));
$tgl_akhir = date("Y-m-d", mktime (0,0,0,$pblnakhir,$ptglakhir,$pthnakhir));
$jam_mulai = date("H:i:s", mktime ($pjammulai,$pmenitmulai,0,$pblnmulai,$ptglmulai,$pthnmulai));
$jam_akhir = date("H:i:s", mktime ($pjamakhir,$pmenitakhir,0,$pblnmulai,$ptglmulai,$pthnmulai));
$tgl_sekarang = date("Y-m-d");

echo"
<table width=100% >
	<tr>
			<td class='judul1' colspan=3>Konfirmasi</td>
	</tr>
</table>	
";

if ($submit=="Batal") {
	// echo "<meta http-equiv=REFRESH content=\"0; url=detail_hari_ini.php\">";
} else {
	 if ($tgl_mulai<$tgl_sekarang) {
	 		echo "<b>Tanggal pemesanan sudah berlalu !</b>";
	 } else {
	 	 			if ($tgl_mulai>$tgl_akhir) {
		 				 echo "<b>Tanggal Mulai > Tanggal Akhir  !!!</b>";
					} elseif ($tgl_mulai==$tgl_akhir) {
						 if ($jam_mulai>=$jam_akhir) {
			 		 				echo "<b>Jam Mulai >= Jam Akhir !!!</b>";
					 	 } else {
						 	 			pesan_sekali ($ptglmulai, $pblnmulai, $pthnmulai, $jam_mulai, $jam_akhir, $pfas, $ppemesan, $kodeagenda, $pkeperluan, $pketerangan, $db, $submit);
					 	 }
					} else {
					 	 if ($jam_mulai>=$jam_akhir) {
			 		 				echo "<b>Jam Mulai >= Jam Akhir !!!</b>";
					 	 } else {				 
					 	 			switch ($p_ulang) {
					 							 case "h"		:
															pesan_ulang_hari ($ptglmulai, $pblnmulai, $pthnmulai, $ptglakhir, $pblnakhir, $pthnakhir, $jam_mulai, $jam_akhir, $pfas, $ppemesan, $kodeagenda, $pkeperluan, $pketerangan, $db, $submit);
															break;
					 							 case "m"		:
															pesan_ulang_minggu ($ptglmulai, $pblnmulai, $pthnmulai, $ptglakhir, $pblnakhir, $pthnakhir, $jam_mulai, $jam_akhir, $pfas, $ppemesan, $kodeagenda, $pkeperluan, $pketerangan, $db, $submit);
															break;
					 							 case "b"		:
															pesan_ulang_bulan ($ptglmulai, $pblnmulai, $pthnmulai, $ptglakhir, $pblnakhir, $pthnakhir, $jam_mulai, $jam_akhir, $pfas, $ppemesan, $kodeagenda, $pkeperluan, $pketerangan, $db, $submit);
															break;
					 							 case "mk"	:
															pesan_ulang_mingguke ($ptglmulai, $pblnmulai, $pthnmulai, $ptglakhir, $pblnakhir, $pthnakhir, $jam_mulai, $jam_akhir, $pfas, $ppemesan, $kodeagenda, $pkeperluan, $pketerangan, $db, $submit);
															break;
					 							 case "nothing"	:
												 			echo "<b>Dipesan ulang tiap berapa periode? (belum dipilih)</b>";
															break;
									}
						 }
					}
	 }
}

echo "</font>";
echo "</body>";
echo "</html>";

?>

