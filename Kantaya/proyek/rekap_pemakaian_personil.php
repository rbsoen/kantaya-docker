<?php
/***********************************************
Nama File : rekap_pemakaian_personil.php
Fungsi    : Perhitungan rekapitulasi pemakaian
            personil dalam proyek.
Dibuat    :	
 Tgl.     : 14-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   : 

************************************************/


include ('../lib/cek_sesi.inc'); 

// Fungsi-fungsi dibawah digunakan untuk suatu $kode_proyek tertentu.
function hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db) {
				 $sqltext = "SELECT (TO_DAYS(rcn_tgl_selesai)-TO_DAYS(rcn_tgl_mulai)) AS totalhari FROM jadwal_proyek WHERE kode_proyek='$kodeproyek' AND no_kegiatan='$nokegiatan'";
				 $hasil = mysql_query($sqltext, $db);
				 $totalhari = mysql_result($hasil,0,"totalhari");
				 $ratarata = $orangjam / $totalhari;
				 return $ratarata;
}

function hitung_totalorangjam_perbulan_dalamsetahun_tiappersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db) {

				 //Yang dihitung adalah total orang jam dari semua kegiatan dan semua proyek
				 //dari seorang personil/pengguna untuk tiap-tiap bulan dalam setahun.
				 //Dihitung dulu untuk tiap kegiatan jumlah hari total, lalu orangjam di kegiatan
				 //itu dibagi jumlah hari total per kegiatan = dihaslkan rata-rata.
				 //Nilai rata-rata ini dikalikan masing-masing jumlah hari di masing-masing bulan =
				 //didapatkan total orang jam dalam masing-masing bulan. Nilai total orang jam tiap
				 //bulan ini diakumulasi untuk semua kegiatan dan semua proyek dalam setahun untuk
				 //tiap personil tsb.
				 
				 global $totalorangjamperbulan;
				 $sqltext = "SELECT DAYOFMONTH(rcn_tgl_mulai) AS tglmulai, MONTH(rcn_tgl_mulai) AS blnmulai, YEAR(rcn_tgl_selesai) AS thnmulai, DAYOFMONTH(rcn_tgl_selesai) AS tglselesai, MONTH(rcn_tgl_selesai) AS blnselesai, YEAR(rcn_tgl_selesai) AS thnselesai FROM jadwal_proyek WHERE kode_proyek='$kodeproyek' AND no_kegiatan='$nokegiatan'";
				 $hasil = mysql_query($sqltext, $db);
				 $tglmulai = mysql_result($hasil,0,"tglmulai");
 				 $tglselesai = mysql_result($hasil,0,"tglselesai");					 
				 $blnmulai = mysql_result($hasil,0,"blnmulai");
 				 $blnselesai = mysql_result($hasil,0,"blnselesai");	
				 $thnmulai = mysql_result($hasil,0,"thnmulai");
 				 $thnselesai = mysql_result($hasil,0,"thnselesai");		
/*				 
 				 echo "<br><br>kode proyek = ".$kodeproyek."<br>";
				 echo "no kegiatan = ".$nokegiatan."<br><br>";	
				 echo "tgl mulai = ".$tglmulai."<br>";
				 echo "bln mulai = ".$blnmulai."<br>";		
				 echo "thn mulai = ".$thnmulai."<br><br>";				 		 
				 echo "tgl selesai = ".$tglselesai."<br>";					 			 
				 echo "bln selesai = ".$blnselesai."<br>";	
				 echo "thn selesai = ".$thnselesai."<br>";
				 echo "<br><br>";
*/
				 //Perhitungan untuk kegiatan proyek dalam rentang waktu satu tahun.
				 if ($thnselesai==$thnmulai) {
				 		if ($blnselesai==$blnmulai) {
							 $jumlahharidipakai[$personil][$blnmulai][$thnmulai] = ($tglselesai - $tglmulai) + 1;
//							 echo "bulan = ".$blnmulai." tahun = ".$thnmulai." jumlah hari dipakai = ".$jumlahharidipakai[$personil][$blnmulai][$thnmulai]."<br>";
							 $rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);
//							 echo "rata-rata orang jam (dari 180) = ".$rata2x."<br>";
							 $totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$blnmulai][$thnmulai];
							 $totalorangjamperbulan[$personil][$blnmulai][$thnmulai] = $totalorangjamperbulan[$personil][$blnmulai][$thnmulai] + $totalorangjam;
//							 echo " Total Orang Jam dari si = ".$personil." di bulan = ".$blnmulai." adalah = ".$totalorangjamperbulan[$personil][$blnmulai][$thnmulai]."<br><br>"; 
						} else {
							 		 $jmlhari=jmlharidlmbulan($blnmulai, $thnmulai);
							 		 $jumlahharidipakai[$personil][$blnmulai][$thnmulai] = ($jmlhari - $tglmulai) + 1;
//							 		 echo "bulan = ".$blnmulai." tahun = ".$thnmulai." jumlah hari dipakai = ".$jumlahharidipakai[$personil][$blnmulai][$thnmulai]."<br>";
							 		 $rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);
//							 		 echo "rata-rata orang jam (dari 180) = ".$rata2x."<br>";
							 		 $totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$blnmulai][$thnmulai];
							 		 $totalorangjamperbulan[$personil][$blnmulai][$thnmulai] = $totalorangjamperbulan[$personil][$blnmulai][$thnmulai] + $totalorangjam;
//							 		 echo " Total Orang Jam dari si = ".$personil." di bulan = ".$blnmulai." adalah = ".$totalorangjamperbulan[$personil][$blnmulai][$thnmulai]."<br><br>"; 
									 if ($blnselesai<>($blnmulai+1)) {
								 	 		for ($bl=$blnmulai+1; $bl<$blnselesai; $bl++) {
							 		 				$jmlhari=jmlharidlmbulan($bl, $thnmulai);											
													$jumlahharidipakai[$personil][$bl][$thnmulai] = $jmlhari;
//													echo "bulan = ".$bl." tahun = ".$thnmulai." jumlah hari dipakai = ".$jumlahharidipakai[$personil][$bl[$thnmulai]]."<br>";
							 						$rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);
//							 						echo "rata-rata orang jam (dari 180) = ".$rata2x."<br>";
							 						$totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$bl][$thnmulai];
							 						$totalorangjamperbulan[$personil][$bl][$thnmulai] = $totalorangjamperbulan[$personil][$bl][$thnmulai] + $totalorangjam;
//							 						echo " Total Orang Jam dari si = ".$personil." di bulan = ".$bl." adalah = ".$totalorangjamperbulan[$personil][$bl][$thnmulai]."<br><br>"; 
											}
										 	$jumlahharidipakai[$personil][$blnselesai][$thnselesai] = $tglselesai;
//							 				echo "bulan = ".$blnselesai." tahun = ".$thnselesai." jumlah hari dipakai = ".$jumlahharidipakai[$personil][$blnselesai][$thnselesai]."<br>";
							 				$rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);
//							 				echo "rata-rata orang jam (dari 180) = ".$rata2x."<br>";
							 				$totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$blnselesai][$thnselesai];
							 				$totalorangjamperbulan[$personil][$blnselesai][$thnselesai] = $totalorangjamperbulan[$personil][$blnselesai][$thnselesai] + $totalorangjam;
//							 				echo " Total Orang Jam dari si = ".$personil." di bulan = ".$blnselesai." adalah = ".$totalorangjamperbulan[$personil][$blnselesai][$thnselesai]."<br><br>"; 
									 } else {
										 	$jumlahharidipakai[$personil][$blnselesai][$thnselesai] = $tglselesai;
//							 				echo "bulan = ".$blnselsai." tahun = ".$thnselesai." jumlah hari dipakai = ".$jumlahharidipakai[$personil][$blnselesai][$thnselesai]."<br>";
							 				$rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);
//							 				echo "rata-rata orang jam (dari 180) = ".$rata2x."<br>";
							 				$totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$blnselesai][$thnselesai];
							 				$totalorangjamperbulan[$personil][$blnselesai][$thnselesai] = $totalorangjamperbulan[$personil][$blnselesai][$thnselesai] + $totalorangjam;
//							 				echo " Total Orang Jam dari si = ".$personil." di bulan = ".$blnselesai." adalah = ".$totalorangjamperbulan[$personil][$blnselesai][$thnselesai]."<br><br>"; 
									 }
						}
				  } else {
								 //Perhitungan untuk kegiatan proyek lintas tahun.
								 //Perhitungan tahun pertama.
								 if ($blnmulai==12) {
								 		$jumlahharidipakai[$personil][$blnmulai][$thnmulai] = (31 - $tglmulai) + 1;
							 			$rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);										
							 			$totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$blnmulai][$thnmulai];
							 			$totalorangjamperbulan[$personil][$blnmulai][$thnmulai] = $totalorangjamperbulan[$personil][$blnmulai][$thnmulai] + $totalorangjam;
								 } else {
								 	  $jmlhari=jmlharidlmbulan($blnmulai, $thnmulai);
				 						$jumlahharidipakai[$personil][$blnmulai][$thnmulai] = ($jmlhari - $tglmulai) + 1;
							 			$rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);										
							 			$totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$blnmulai][$thnmulai];
							 			$totalorangjamperbulan[$personil][$blnmulai][$thnmulai] = $totalorangjamperbulan[$personil][$blnmulai][$thnmulai] + $totalorangjam;										
										for ($bl=$blnmulai+1; $bl<=12; $bl++) {
												$jmlhari=jmlharidlmbulan($bl, $thnmulai);											
												$jumlahharidipakai[$personil][$bl][$thnmulai] = $jmlhari;
							 					$rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);										
							 					$totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$bl][$thnmulai];
							 					$totalorangjamperbulan[$personil][$bl][$thnmulai] = $totalorangjamperbulan[$personil][$bl][$thnmulai] + $totalorangjam;												
			  					  }
								 }
   							 //Perhitungan tahun kedua.
								 if ($blnselesai==1) {
								 		$jumlahharidipakai[$personil][$blnselesai][$thnselesai] = $tglselesai;
							 			$rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);										
							 			$totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$blnselesai][$thnselesai];
							 			$totalorangjamperbulan[$personil][$blnselesai][$thnselesai] = $totalorangjamperbulan[$personil][$blnselesai][$thnselesai] + $totalorangjam;										
								 } else {
								 	 for ($bl=1; $bl<$blnselesai; $bl++) {
				  				 		  $jmlhari=jmlharidlmbulan($bl, $thnselesai);
											  $jumlahharidipakai[$personil][$bl][$thnselesai] = $jmlhari;
							 					$rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);										
							 					$totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$bl][$thnselesai];
							 					$totalorangjamperbulan[$personil][$bl][$thnselesai] = $totalorangjamperbulan[$personil][$bl][$thnselesai] + $totalorangjam;												
									 }
									 $jumlahharidipakai[$personil][$blnselesai][$thnselesai] = $tglselesai;
	 								 $rata2x = hitung_ratarata_orangjam_perkegiatan_perpersonil ($kodeproyek, $nokegiatan, $personil, $orangjam, $db);										
							 		 $totalorangjam =	$rata2x * $jumlahharidipakai[$personil][$blnselesai][$thnselesai];
							 		 $totalorangjamperbulan[$personil][$blnselesai][$thnselesai] = $totalorangjamperbulan[$personil][$blnselesai][$thnselesai] + $totalorangjam;										
								 }
				  }
}

?>
