<?php
/******************************************
Nama File : pesan_ulang.php
Fungsi    : Menentukan penyimpanan
            fasilitas secara berulang
            harian, mingguan, bulanan.
Dibuat    :	
 Tgl.     : 17-09-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

session_start();
include ('../lib/cek_sesi.inc');  
include ('../lib/fs_kalender.php');

echo "<html>";
echo "<body>";
echo "<font size=1>";

//Cek apakah pada tgl. dan jam yg dipesan sudah ada record pemesanan di db 
function cek_ada($utk_tgl, $jampesanmulai, $jampesanakhir, $pfas, $db) {
	$n = 0;
	$sudahada = "belum";	
	$dipesan=mysql_query("SELECT  jam_mulai, jam_akhir FROM pemesanan WHERE fasilitas = '$pfas' AND untuk_tgl = '$utk_tgl'", $db);
	while ($row=mysql_fetch_array($dipesan)) {
		$jammulai[$n] 	= $row["jam_mulai"]; 
		$jamakhir[$n] 	= $row["jam_akhir"]; 
		if ( (($jampesanakhir >= $jammulai[$n]) AND ($jampesanakhir <= $jamakhir[$n])) OR (($jampesanmulai >= $jammulai[$n]) AND ($jampesanmulai <= $jamakhir[$n]))
			OR
		     (($jampesanmulai >= $jammulai[$n]) AND ($jampesanmulai <= $jamakhir[$n])) AND (($jampesanakhir >= $jammulai[$n]) AND ($jampesanakhir <= $jamakhir[$n]))
			OR
		     (($jampesanmulai <= $jammulai[$n])) AND (($jampesanakhir >= $jamakhir[$n])) ) {
			$sudahada = "ya";
			$jam_ml = $jammulai[$n];
			$jam_ak = $jamakhir[$n];
		} else {
			//$sudahada = "belum";	
		}		
		$n++;
	}
	mysql_free_result ($dipesan);
	return array ($sudahada, $jam_ml, $jam_ak);
}

//Fungsi pemesanan sekali saja
function pesan_sekali ($tglpesan, $blnpesan, $thnpesan, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit) {
				 $tgldibuat = date("Y-m-d H:i:s");
				 $tgldiubah = date("Y-m-d H:i:s");
				 $utk_tgl = date("Y-m-d", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan));
				 list($sudahada, $jam_ml, $jam_ak) = cek_ada($utk_tgl, $jammulai, $jamakhir, $fas, $db);

				 if ($sudahada=="belum") {
				 		if ($submit=="Simpan")	{
					//	echo $fas.",".$pem.",".$keg.",'".$kep."','".$utk_tgl."','".$jammulai."','".$jamakhir."','".$ket."',".$pem.",'".$tgldibuat."',".$pem.",'".$tgldiubah;
							 $hasil = mysql_query("INSERT INTO pemesanan (fasilitas, pemesan, kode_agenda, keperluan, untuk_tgl, jam_mulai, jam_akhir, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ("
											.$fas.",".$pem.",".$keg.",'".$kep."','".$utk_tgl."','".$jammulai."','".$jamakhir."','".$ket."',".$pem.",'".$tgldibuat."',".$pem.",'".$tgldiubah."')", $db);
							 echo "<font color=blue size=1>Tgl. </font><font color=red size=1>".date("d", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan))." ".namabulan("S",date("n", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan)))." ".date("Y", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan))."</font><font color=blue size=1>, Jam </font><font color=red size=1>".$jammulai."</font><font color=blue size=1> s.d. </font><font color=red size=1>".$jamakhir."</font><font color=blue size=1> , sukses disimpan....</font><br>";										
						} elseif ($submit=="Simpan dan Lagi")	{ 
							 $hasil = mysql_query("INSERT INTO pemesanan (fasilitas, pemesan, kode_agenda, keperluan, untuk_tgl, jam_mulai, jam_akhir, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ("
											.$fas.",".$pem.",".$keg.",'".$kep."','".$utk_tgl."','".$jammulai."','".$jamakhir."','".$ket."',".$pem.",'".$tgldibuat."',".$pem.",'".$tgldiubah."')", $db);
							 echo "<font color=blue size=1>Tgl. </font><font color=red size=1>".date("d", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan))." ".namabulan("S",date("n", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan)))." ".date("Y", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan))."</font><font color=blue size=1>, Jam </font><font color=red size=1>".$jammulai."</font><font color=blue size=1> s.d. </font><font color=red size=1>".$jamakhir."</font><font color=blue size=1> , sukses disimpan....</font><br>";
							 $pesanlagi = "pemesanan.php?pfas=".$fas;
							 echo "<meta http-equiv=REFRESH content=\"4; url=".$pesanlagi."\">";	
 					  } 
				} else {
							 echo "<font color=blue size=1><br>Tgl. </font><font color=red size=1>".date("d", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan))." ".namabulan("S",date("n", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan)))." ".date("Y", mktime (0,0,0,$blnpesan,$tglpesan,$thnpesan))."</font><font color=blue size=1>, Jam </font><font color=red size=1>".$jammulai."</font><font color=blue size=1> s.d. </font><font color=red size=1>".$jamakhir."</font><font color=blue size=1> , </font><font color=red size=1><b>gagal disimpan....</b><br><b>(Sudah ada yang memesan dari jam ".$jam_ml." s.d. ".$jam_ak." !)</b></font><br><br>";
				}
}


//Fungsi pemesanan berulang tiap hari
function pesan_ulang_hari ($tglmulai, $blnmulai, $thnmulai, $tglakhir, $blnakhir, $thnakhir, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit) {
	echo "<font color=blue>Pesan </font><font color=red>tiap hari</font><font color=blue> ";
	echo "dari tgl. </font><font color=red>".$tglmulai."-".$blnmulai."-".$thnmulai."</font><font color=blue> s.d. tgl. </font><font color=red>".$tglakhir."-".$blnakhir."-".$thnakhir."</font><br><br>";

	if ($thnakhir==$thnmulai) {
		$th=$thnmulai;
		if ($blnakhir==$blnmulai) {
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=$tglakhir; $tg++) {
				//echo $jammulai."--".$jamakhir."--".$fas."--".$pem."--".$keg."--".$kep."--".$ket."--".$db."--".$submit;
 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
			}
		} else {
			$bl=$blnmulai;
			$jmlhari=jmlharidlmbulan($blnmulai, $thnmulai);
			for ($tg=$tglmulai; $tg<=$jmlhari; $tg++) {
 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
			}
			if ($blnakhir<>($blnmulai+1)) {
				for ($bl=$blnmulai+1; $bl<$blnakhir; $bl++) {
					$jmlhari=jmlharidlmbulan($bl, $thnmulai);
					for ($tg=1; $tg<=$jmlhari; $tg++) {
 	 						pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
					}
				}
				$jmlhari=jmlharidlmbulan($blnakhir, $thnmulai);
				$bl=$blnakhir;
				for ($tg=1; $tg<=$tglakhir; $tg++) {
				 	 	pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			} else {
				$bl=$blnakhir;
				for ($tg=1; $tg<=$tglakhir; $tg++) {
				 	 	pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}

		}
	} else {
		$th=$thnmulai;
		if ($blnmulai==12) {
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=31; $tg++) {
 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
			}
		} else {
			$jmlhari=jmlharidlmbulan($blnmulai, $thnmulai);
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=$jmlhari; $tg++) {
 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
			}
			for ($bl=$blnmulai+1; $bl<=12; $bl++) {
				$jmlhari=jmlharidlmbulan($bl, $thnmulai);
				for ($tg=1; $tg<=$jmlhari; $tg++) {
 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		}

		$th=$thnakhir;
		if ($blnakhir==1) {
			$bl=$blnakhir;
			for ($tg=1; $tg<=$tglakhir; $tg++) {
 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
			}
		} else {
			for ($bl=1; $bl<$blnakhir; $bl++) {
				$jmlhari=jmlharidlmbulan($bl, $thnmulai);
				for ($tg=1; $tg<=$jmlhari; $tg++) {
 	 							pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
			$bl=$blnakhir;
			for ($tg=1; $tg<=$tglakhir; $tg++) {
 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
			}
		}
	}

} // Akhir function


//Fungsi pemesanan berulang tiap minggu
function pesan_ulang_minggu ($tglmulai, $blnmulai, $thnmulai, $tglakhir, $blnakhir, $thnakhir, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit) {
	$kode_hari = date("w",mktime(0,0,0,$blnmulai,$tglmulai,$thnmulai));
	echo "<font color=blue>Pesan </font><font color=red>tiap minggu</font><font color=blue> ";
	echo "dari tgl. </font><font color=red>".$tglmulai."-".$blnmulai."-".$thnmulai."</font><font color=blue> s.d. tgl. </font><font color=red>".$tglakhir."-".$blnakhir."-".$thnakhir."</font><font color=blue> pada tiap hari : </font><font color=red>".namahari("P",$kode_hari)."</font><br><br>";
	
	if ($thnakhir==$thnmulai) {
		$th=$thnmulai;
		if ($blnakhir==$blnmulai) {
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=$tglakhir; $tg++) {
				if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
				 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		} else {
			$bl=$blnmulai;
			$jmlhari=jmlharidlmbulan($blnmulai, $thnmulai);
			for ($tg=$tglmulai; $tg<=$jmlhari; $tg++) {
				if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
				 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
			if ($blnakhir<>($blnmulai+1)) {
				for ($bl=$blnmulai+1; $bl<$blnakhir; $bl++) {
					$jmlhari=jmlharidlmbulan($bl, $thnmulai);
					for ($tg=1; $tg<=$jmlhari; $tg++) {
						if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
						 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
						}
					}
				}
				$jmlhari=jmlharidlmbulan($blnakhir, $thnmulai);
				$bl=$blnakhir;
				for ($tg=1; $tg<=$tglakhir; $tg++) {
					if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
					}
				}
			} else {
				$bl=$blnakhir;
				for ($tg=1; $tg<=$tglakhir; $tg++) {
					if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
					}
				}
			}

		}
	} else {
		$th=$thnmulai;
		if ($blnmulai==12) {
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=31; $tg++) {
				if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
				 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		} else {
			$jmlhari=jmlharidlmbulan($blnmulai, $thnmulai);
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=$jmlhari; $tg++) {
				if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
				 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
			for ($bl=$blnmulai+1; $bl<=12; $bl++) {
				$jmlhari=jmlharidlmbulan($bl, $thnmulai);
				for ($tg=1; $tg<=$jmlhari; $tg++) {
					if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
					}
				}
			}
		}

		$th=$thnakhir;
		if ($blnakhir==1) {
			$bl=$blnakhir;
			for ($tg=1; $tg<=$tglakhir; $tg++) {
				if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
				 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		} else {
			for ($bl=1; $bl<$blnakhir; $bl++) {
				$jmlhari=jmlharidlmbulan($bl, $thnmulai);
				for ($tg=1; $tg<=$jmlhari; $tg++) {
					if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
					}
				}
			}
			$bl=$blnakhir;
			for ($tg=1; $tg<=$tglakhir; $tg++) {
				if (date("w",mktime(0,0,0,$bl,$tg,$th))==$kode_hari) {
				 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		}
	}
} // Akhir function


//Fungsi pemesanan berulang tiap bulan
function pesan_ulang_bulan ($tglmulai, $blnmulai, $thnmulai, $tglakhir, $blnakhir, $thnakhir, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit) {
	echo "<font color=blue>Pesan </font><font color=red>tiap minggu ";
	echo "</font><font color=blue>dari tgl. </font><font color=red>".$tglmulai."-".$blnmulai."-".$thnmulai."</font><font color=blue> s.d. tgl. </font><font color=red>".$tglakhir."-".$blnakhir."-".$thnakhir."</font><font color=blue> pada tiap tgl </font><font color=red>".$tglmulai."</font><br><br>";

	if ($thnakhir==$thnmulai) {
		$th=$thnmulai;
		if ($blnakhir==$blnmulai) {
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=$tglakhir; $tg++) {
				if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		} else {
			$bl=$blnmulai;
			$jmlhari=jmlharidlmbulan($blnmulai, $thnmulai);
			for ($tg=$tglmulai; $tg<=$jmlhari; $tg++) {
				if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
			if ($blnakhir<>($blnmulai+1)) {
				for ($bl=$blnmulai+1; $bl<$blnakhir; $bl++) {
					$jmlhari=jmlharidlmbulan($bl, $thnmulai);
					for ($tg=1; $tg<=$jmlhari; $tg++) {
							if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
							}
					}
				}
				$jmlhari=jmlharidlmbulan($blnakhir, $thnmulai);
				$bl=$blnakhir;
				for ($tg=1; $tg<=$tglakhir; $tg++) {
						if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
						}
				}
			} else {
				$bl=$blnakhir;
				for ($tg=1; $tg<=$tglakhir; $tg++) {
						if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
						}
				}
			}

		}
	} else {
		$th=$thnmulai;
		if ($blnmulai==12) {
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=31; $tg++) {
				if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		} else {
			$jmlhari=jmlharidlmbulan($blnmulai, $thnmulai);
			$bl=$blnmulai;
			for ($tg=$tglmulai; $tg<=$jmlhari; $tg++) {
				if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
			for ($bl=$blnmulai+1; $bl<=12; $bl++) {
				$jmlhari=jmlharidlmbulan($bl, $thnmulai);
				for ($tg=1; $tg<=$jmlhari; $tg++) {
						if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
						}
				}
			}
		}

		$th=$thnakhir;
		if ($blnakhir==1) {
			$bl=$blnakhir;
			for ($tg=1; $tg<=$tglakhir; $tg++) {
				if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		} else {
			for ($bl=1; $bl<$blnakhir; $bl++) {
				$jmlhari=jmlharidlmbulan($bl, $thnmulai);
				for ($tg=1; $tg<=$jmlhari; $tg++) {
						if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
						}
				}
			}
			$bl=$blnakhir;
			for ($tg=1; $tg<=$tglakhir; $tg++) {
				if ($tg==$tglmulai) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
				}
			}
		}
	}
	
} // Akhir function




//Fungsi caritgl_mingguke() diperlukan untuk fungsi pesan_ulang_mingguke()
function caritgl_mingguke ($bulan, $tahun, $kodehari, $mingguke) {
	$tgl1_hari = date("w",mktime(0,0,0,$bulan,1,$tahun));
	$jml_hari = jmlharidlmbulan ($bulan, $tahun);
	$jml_kolom = 7;
	$jml_baris = $mingguke;
	$mulai = $tgl1_hari-1;
	$tgl = 0;
	if ($mulai < 0) {
		$mulai = 6;
	}
	
	for ($i=0; $i<$jml_baris; $i++) {
	
		for ($j=0; $j<$jml_kolom; $j++) {
		
			if ($i == 0) {
				if ($j >= $mulai) {
					$tgl = $tgl + 1;
					$hari =  date("w",mktime(0,0,0,$bulan,$tgl,$tahun));
					if (($hari==$kodehari) AND ($i==($mingguke-1))) {
						 $tg = $tgl;
						 return $tg;
					} else {
						 $tg = 0;
					}				
				}
				else {
					$tgl = 0;
				}
			}
			else {
				if ($tgl > 0 && $tgl < $jml_hari) {
					$tgl = $tgl + 1;
					$hari =  date("w",mktime(0,0,0,$bulan,$tgl,$tahun));
					if (($hari==$kodehari) AND ($i==($mingguke-1))) {
						 $tg = $tgl;
						 return $tg;
					} else {
						 $tg = 0;
					}				
				} else {
					$tgl = 0;
				}
			}
			
		}
		
	}
	
} // Akhir fungsi


//Fungsi pemesanan berulang bulanan tiap minggu ke-n
function pesan_ulang_mingguke ($tglmulai, $blnmulai, $thnmulai, $tglakhir, $blnakhir, $thnakhir, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit) {

	// Mencari minggu ke-n dari tgl. mulai.
	$tgl1_hari = date("w",mktime(0,0,0,$blnmulai,1,$thnmulai));
	$jml_hari = jmlharidlmbulan ($blnmulai, $thnmulai);
	$jml_kolom = 7;
	$jml_baris = ceil(($jml_hari+$tgl1_hari-1)/7);
	$mulai = $tgl1_hari-1;
	$tgl = 0;
	$mingguke = 0;
	if ($mulai < 0) {
		$mulai = 6;
	}
	for ($i=0; $i<$jml_baris; $i++) {
		for ($j=0; $j<$jml_kolom; $j++) {
			if ($i == 0) {
				if ($j >= $mulai) {
					$tgl = $tgl + 1;
					if ($tgl == $tglmulai) {
						 $mingguke = $i+1;
					}
				}
				else {
					$tgl = 0;
				}
			}
			else {
				if ($tgl > 0 && $tgl < $jml_hari) {
					$tgl = $tgl + 1;
					if ($tgl == $tglmulai) {
						 $mingguke = $i+1;
					}
				}
				else {
					$tgl = 0;
				}
			}
		}
	}

	 //Mencari kode hari dari tgl. mulai.
 	 $kode_hari = date("w",mktime(0,0,0,$blnmulai,$tglmulai,$thnmulai));
   echo "<font color=blue>Pesan </font><font color=red>tiap bulan</font><font color=blue> pada </font><font color=red>minggu ke-".$mingguke."</font><font color=blue> dan hari : </font><font color=red>".namahari("P",$kode_hari)."</font><font color=blue> dari tgl. </font><font color=red>".$tglmulai."-".$blnmulai."-".$thnmulai."</font><font color=blue> s.d. tgl. </font><font color=red>".$tglakhir."-".$blnakhir."-".$thnakhir."</font><br><br>";
	
	 	//Mencari tgl. bulan berikutnya yang minggu ke-n dan harinya sama dgn. tgl. mulai dan < tgl. akhir.	
		if ($thnakhir==$thnmulai) {
			 $th=$thnmulai;
			 for ($bl=$blnmulai; $bl<=$blnakhir; $bl++) {
					 $tg = caritgl_mingguke($bl, $th, $kode_hari, $mingguke);
					 if ($tg<>0) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
					 }
			 }
		} else {
			 $th=$thnmulai;
			 for ($bl=$blnmulai; $bl<=12; $bl++) {
					 $tg = caritgl_mingguke($bl, $th, $kode_hari, $mingguke);
					 if ($tg<>0) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
					 }
			 }
			 $th=$thnakhir;
			 for ($bl=1; $bl<=$blnakhir; $bl++) {
					 $tg = caritgl_mingguke($bl, $th, $kode_hari, $mingguke);
					 if ($tg<>0) {
					 	 			pesan_sekali ($tg, $bl, $th, $jammulai, $jamakhir, $fas, $pem, $keg, $kep, $ket, $db, $submit);
					 }
			 }
		}

} // Akhir function

echo "</font>";
echo "</body>";
echo "</html>";

?>



