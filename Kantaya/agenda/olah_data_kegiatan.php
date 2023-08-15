<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
include('../lib/akses_unit.php');

function simpan_kegiatan() {
  global $dbh, $kode_pengguna, $judul, $ptipe, $spjhari, $pthn, $pbln, $ptgl,
				 $jamntml, $jamntsl, $kode_pengulangan, $deskripsi, $sftshar, $sharing_publik;
				 if (!isset($ptipe) or $ptipe=='') { $ptipe = "Lainnya"; }
				 if ($spjhari == 1) { $jamntml = "00:00:00"; $jamntsl= "23:59:59"; }
				 $query  = "INSERT INTO agenda(pemilik, judul, tipe, tgl_mulai, waktu_mulai, waktu_selesai, tgl_selesai, deskripsi, tgl_dibuat,sharing_publik,sifat_sharing) ";
				 $query .= "VALUES ($kode_pengguna, '$judul', '$ptipe', '$pthn.$pbln.$ptgl',";
				 $query .= "'$jamntml','$jamntsl','$pthn.$pbln.$ptgl','$deskripsi',";
				 $query .= "curdate(),'$sharing_publik','$sftshar')";
				 $hsl = mysql_query($query,$dbh); if(!$hsl) {echo  "@simpan kegiatan:".mysql_error();}
				 return $hsl;
}

function hapus_kegiatan($kode_agenda) {
  global $dbh;
				 $query  = "DELETE FROM agenda ";
				 $query .= "WHERE kode_agenda = $kode_agenda";
				 $msg = 'Kegiatan: <b>'.$judul.'</b>, berhasil dihapus';
				 $hsl = mysql_query($query,$dbh); if(!$hsl) {echo "@hapus kegiatan:".mysql_error();}
				 return $hsl;
}

function simpan_fasilitas ($kode_agenda) {
  global $dbh, $fas, $kode_pengguna, $judul, $pthn, $pbln, $ptgl, $jamntml, $jamntsl, $deskripsi;
				 $tgldibuat = date("Y-m-d H:i:s");
				 $tgldiubah = date("Y-m-d H:i:s");
				 $utk_tgl = date("Y-m-d", mktime (0,0,0,$pbln,$ptgl,$pthn));
				 $hsl = mysql_query("INSERT INTO pemesanan VALUES ('', "
								 	 .$fas.",".$kode_pengguna.",".$kode_agenda.",'".$judul."','".$utk_tgl
									 ."','".$jamntml."','".$jamntsl."','".$deskripsi."','".$tgldibuat
									 ."','".$tgldiubah."',".$kode_pengguna.",".$kode_pengguna.")", $dbh);
				 if(!$hsl) {echo "@simpan fasilitas:".mysql_error();}
				 return $hsl;
}

function hapus_fasilitas ($kode_agenda) {
  global $dbh;
				 $query  = "DELETE FROM pemesanan ";
				 $query .= "WHERE kode_agenda = $kode_agenda";
				 $hsl = mysql_query($query,$dbh); if(!$hsl) {echo "@hapus fasilitas:".mysql_error();}
				 return $hsl;
}

function simpan_sharing($kode_agenda, $yg_dishrg) {
  global $dbh;
				 $query  = "select count(kode_agenda) from sharing_agenda_pengguna ";
				 $query .= "where kode_agenda = $kode_agenda and kode_pengguna = $yg_dishrg";
				 $hsl = mysql_query($query ,$dbh); if(!$hsl) {echo  "@simpan undangan:".mysql_error();}
				 if ($hsl) {
				 		$dat = mysql_fetch_row($hsl);
				 		if ($dat[0] == 0) {
				 			 $query  = "insert into sharing_agenda_pengguna values ";
				 			 $query .= "($kode_agenda, $yg_dishrg, curdate())";
				 			 $hsl = mysql_query($query,$dbh); if(!$hsl) {echo "@simpan sharing:".mysql_error();}
				 		}
				 }
				 return $hsl;
}

function hapus_sharing($kode_agenda) {
  global $dbh;
				 $query1  = "delete from sharing_agenda_pengguna where kode_agenda = $kode_agenda";
				 $query2  = "delete from sharing_agenda_unit where kode_agenda = $kode_agenda";
				 $query3  = "delete from sharing_agenda_grup where kode_agenda = $kode_agenda";
				 $hsl1 = mysql_query($query1, $dbh); if(!$hsl1) {echo "@hapus sharing:".mysql_error();}
				 $hsl2 = mysql_query($query2, $dbh); if(!$hsl2) {echo "@hapus sharing:".mysql_error();}
				 $hsl3 = mysql_query($query3, $dbh); if(!$hsl3) {echo "@hapus sharing:".mysql_error();}
				 return ($hsl1 and $hsl2 and $hsl3);
}

function simpan_undangan($kode_agenda, $yg_diundang) {
  global $dbh;
				 $query  = "select count(kode_agenda) from undangan_pengguna ";
				 $query .= "where kode_agenda = $kode_agenda and kode_pengguna = $yg_diundang";
				 $hsl = mysql_query($query ,$dbh); if(!$hsl) {echo  "@simpan undangan:".mysql_error();}
				 if ($hsl) {
				 		$dat = mysql_fetch_row($hsl);
				 		if ($dat[0] == 0) {
				 			 $query  = "insert into undangan_pengguna values ";
				 			 $query .= "($kode_agenda, $yg_diundang, '', '', curdate())";
				 			 $hsl = mysql_query($query,$dbh); if(!$hsl) {echo "@simpan undangan:".mysql_error();}
				 		}
				 }
				 return $hsl;
}

function hapus_undangan($kode_agenda) {
  global $dbh;
				 $query1  = "delete from undangan_pengguna where kode_agenda = $kode_agenda";
				 $query2  = "delete from undangan_unit where kode_agenda = $kode_agenda";
				 $query3  = "delete from undangan_grup where kode_agenda = $kode_agenda";
				 $query4  = "delete from agenda where kode_undangan = $kode_agenda";
				 $hsl1 = mysql_query($query1, $dbh); if(!$hsl1) {echo "@hapus undangan:".mysql_error();}
				 $hsl2 = mysql_query($query2, $dbh); if(!$hsl2) {echo "@hapus undangan:".mysql_error();}
				 $hsl3 = mysql_query($query3, $dbh); if(!$hsl3) {echo "@hapus undangan:".mysql_error();}
				 $hsl4 = mysql_query($query4, $dbh); if(!$hsl4) {echo "@hapus undangan:".mysql_error();}
				 return ($hsl1 and $hsl2 and $hsl3 and $hsl4);
}

function simpan_4tabel($tabel, $kode_agenda, $kode_uorg) {
  global $dbh, $kode_pengguna;
				 $query  = "insert into $tabel values ";
				 $query .= "($kode_agenda, $kode_uorg, curdate())";
				 $hsl = mysql_query($query,$dbh);
				 if(!$hsl) {echo "@simpan 4 tabel:".mysql_error();}
				 return $hsl;
}

function simpan_beberapa ($tipe, $kode_agenda, $kode_uorg) {
  global $dbh, $kode_pengguna;
	    if (substr($tipe,0,4) == 'unit') {
				 list_akses_unit ($dbh, $kode_unit, $arrunit);
				 $i = 0;
				 while ($arrunit[$i][0] !== $kode_uorg) {$i++;}
				 $cutpos = 2*($arrunit[$i][2]-1); $funit = substr($kode_uorg,0,$cutpos);
				 $hsl = mysql_query("select kode_pengguna from pengguna where unit_kerja like '$funit%' and kode_pengguna <> $kode_pengguna",$dbh);
			}
      if (substr($tipe,0,4) == 'grup') {
				 $hsl = mysql_query("select kode_pengguna from grup_pengguna where kode_grup=$kode_uorg",$dbh);
			}
		  if ($hsl) {
				 $i = 0;
				 while ($dat = @mysql_fetch_row($hsl)) { $yg_di[$i++] = $dat[0]; }
				 foreach ($yg_di as $yd) { 
						if (substr($tipe,4) == 'sharing') { $s = simpan_sharing($kode_agenda, $yd); }
						if (substr($tipe,4) == 'undangan') { $s = simpan_undangan($kode_agenda, $yd); }
						if (!$s) { $hsl = $s; break; }
				 }
      }
			else { if(!$hsl) {echo "@simpan beberapa:".mysql_error();} }
			return $hsl;
}

//Fungsi caritgl_mingguke() diperlukan untuk fungsi pengulangan_mingguke()
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


//Fungsi pengulangan kegiatan tiap minggu ke-n
function pesan_ulang_mingguke ($tglmulai, $blnmulai, $thnmulai, $tglakhir, $blnakhir, $thnakhir) {
   global $hfsulg, $kefsulg, $pthn, $pbln, $ptgl;
	 $hsl = true;
	// Mencari minggu ke-n dari tgl. mulai.
	$mingguke = $kefsulg + 1;

	 //Mencari kode hari dari tgl. mulai.
 	 $kode_hari = $hfsulg;
	
	 	//Mencari tgl. bulan berikutnya yang minggu ke-n dan harinya sama dgn. tgl. mulai dan < tgl. akhir.	
		if ($thnakhir==$thnmulai) {
			 $th=$thnmulai;
			 for ($bl=$blnmulai+1; $bl<=$blnakhir; $bl++) {
					 $tg = caritgl_mingguke($bl, $th, $kode_hari, $mingguke);
					 if ($tg<>0) {
					 		$pthn = $th; $pbln = $bl; $ptgl = $tg;
							$sk = simpan_kegiatan();
							if (!$sk) { $hsl = false; }
					 }
			 }
		} else {
			 $th=$thnmulai;
			 for ($bl=$blnmulai+1; $bl<=12; $bl++) {
					 $tg = caritgl_mingguke($bl, $th, $kode_hari, $mingguke);
					 if ($tg<>0) {
					 		$pthn = $th; $pbln = $bl; $ptgl = $tg;
							$sk = simpan_kegiatan();
							if (!$sk) { $hsl = false; }
					 }
			 }
			 $th=$thnakhir;
			 for ($bl=1; $bl<=$blnakhir; $bl++) {
					 $tg = caritgl_mingguke($bl, $th, $kode_hari, $mingguke);
					 if ($tg<>0) {
					 		$pthn = $th; $pbln = $bl; $ptgl = $tg;
							$sk = simpan_kegiatan();
							if (!$sk) { $hsl = false; }
					 }
			 }
		}
		return $hsl;
} // Akhir function

function hapus_pengulangan($kode_agenda) {
  global $dbh;
				 $query  = "delete from pengulangan_agenda where kode_agenda = $kode_agenda";
				 $hsl = mysql_query($query, $dbh);
				 if(!$hsl) {echo "@hapus pengulangan:".mysql_error();}
				 $query  = "delete from agenda where kode_pengulangan=$kode_agenda";
				 $hsl1 = mysql_query($query, $dbh);
				 if(!$hsl1) {echo "@hapus pengulangan:".mysql_error();}
				 return ($hsl and $hsl1);
}

?>
<html>
<head>
<title>Pengolahan Data Koresponden</title>
<link rel=stylesheet type='text/css' href="win.css">
</head>
<SCRIPT LANGUAGE="JavaScript">
<!--
function openurl(urlpath,tgt)
{
  window.open(urlpath,tgt);
}
// -->
</script>
<body>

<?php
#error_reporting(0);
$hsl = true;
$jamntml = $pjammulai.":".$pmntmulai.":00";
$jamntsl = $pjamakhir.":".$pmntakhir.":00";
if ($modus == "Simpan Pengubahan") { $ubah = 1; $modus = "Hapus"; }
else { $ubah = 0; }
if ($modus == "Hapus") {
	 $hpskgtn = hapus_kegiatan($kode_agenda);
	 if (!$hpskgtn) { $hsl = false; $msg = mysql_error($dbh); }
	 else {
	 			if ($dgfas <> 0) {
					 $hpsfas = hapus_fasilitas($kode_agenda);
					 if (!$hpsfas) { $hsl = false; $msg = mysql_error($dbh); }
			  }
	 			if ($sftshar <> 0) {
					 $hpsshar = hapus_sharing($kode_agenda);
					 if (!$hpsshar) { $hsl = false; $msg = mysql_error($dbh); }
			  }
	 			if ($undgn <> 0) {
					 $hpsundgn = hapus_undangan($kode_agenda);
					 if (!$hpsundgn) { $hsl = false; $msg = mysql_error($dbh); }
			  }
	 			if ($diulg <> 0) {
					 $hpsdiulg = hapus_pengulangan($kode_agenda);
					 if (!$hpsdiulg) { $hsl = false; $msg = mysql_error($dbh); }
			  }
	 }
	 if ($hsl) { 
	 		$msg = 'Data kegiatan: <b>'.$judul.'</b>, berhasil dihapus';
			if ($ubah==1) { $modus = "Simpan"; }
	 }
}
if ($modus == "Simpan") {
	 $kode_pengulangan = 0;
	 $smpkgtn = simpan_kegiatan();
	 if (!$smpkgtn) { $hsl = false; $msg = mysql_error($dbh); }
	 else {
	 			$kd_agenda = mysql_insert_id($dbh);
				if ($dgfas <> 0) { simpan_fasilitas($kd_agenda); } // fasilitas
				if ($undgn <> 0) { // undangan
					 if (isset($untundgn) and $untundgn!=='') { 
					 		foreach ($untundgn as $u) {
											$smpundgnunt = simpan_4tabel("undangan_unit", $kd_agenda, $u);
											if (!$smpundgnunt) { $hsl = false; break;}
											$smpundgn = simpan_beberapa('unitundangan', $kd_agenda, $u);
											if (!$smpundgn) { $hsl = false; $msg = mysql_error($dbh); break;}
						  }
					 }
					 if (isset($grpundgn) and $grpundgn!=='') {
					 		foreach ($grpundgn as $g) {
											$smpundgngrp = simpan_4tabel("undangan_grup", $kd_agenda, $g);
											if (!$smpundgngrp) { $hsl = false; break;}
											$smpundgn = simpan_beberapa('grupundangan', $kd_agenda, $g);
											if (!$smpundgn) { $hsl = false; $msg = mysql_error($dbh); break;}
						  }
					 }
					 if (isset($pgnundgn) and $pgnundgn!=='') {
					 		foreach ($pgnundgn as $p) {
											$smpundgn = simpan_undangan($kd_agenda, $p);
											if (!$smpundgn) { $hsl = false; $msg = mysql_error($dbh); break;}
						  }
					 }
			  }
	 			if ($sftshar <> 0) { // sharing
					 if (isset($untshar) and $untshar!=='') { 
					 		foreach ($untshar as $u) {
											$smpsharunt = simpan_4tabel("sharing_agenda_unit", $kd_agenda, $u);
											if (!$smpsharunt) { $hsl = false; break;}
											$smpshar = simpan_beberapa('unitsharing', $kd_agenda, $u);
											if (!$smpshar) { $hsl = false; $msg = mysql_error($dbh); break;}
						  }
					 }
					 if (isset($grpshar) and $grpshar!=='') {
					 		foreach ($grpshar as $g) {
											$smpshargrp = simpan_4tabel("sharing_agenda_grup", $kd_agenda, $g);
											if (!$smpshargrp) { $hsl = false; break;}
											$smpshar = simpan_beberapa('grupsharing', $kd_agenda, $g);
											if (!$smpshar) { $hsl = false; $msg = mysql_error($dbh); break;}
						  }
					 }
					 if (isset($pgnshar) and $pgnshar!=='') {
					 		foreach ($pgnshar as $p) {
											$smpshar = simpan_sharing($kd_agenda, $p);
											if (!$smpshar) { $hsl = false; $msg = mysql_error($dbh); break;}
						  }
					 }
			  }
				if ($diulg <> 0) { // pengulangan
					 $kode_pengulangan = $kd_agenda;
					 $hsl = mysql_query("update agenda set kode_pengulangan=$kode_pengulangan where kode_agenda=$kd_agenda",$dbh);
					 if(!$hsl) {echo "@ubah kode pengulangan:".mysql_error();}
					 if ($tnpbts == 1) {
					 		$sdtgl = 31; $sdbln = 12; $sdthn = date("Y")+2;
					 }
					 if ($diulg == 1) { // diulang setiap.....
					 		$query  = "INSERT INTO pengulangan_agenda ";
					 		$query .= "VALUES ($kd_agenda, '-', '$diulgstp', '$sdthn.$sdbln.$sdtgl',curdate())";
					 		$hsl = mysql_query($query);
					 		if(!$hsl) {echo "@simpan pengulangan agenda:".mysql_error();}
							$tgl = $ptgl; $bln = $pbln; $thn = $pthn;
					 		switch ($diulgstp) {
							   case 1 : while (date("U", mktime(0,0,0,$pbln,++$ptgl,$pthn))<=date("U", mktime(0,0,0,$sdbln,$sdtgl,$sdthn))) {
								 								list($pthn,$pbln,$ptgl)=split("-",date("Y-m-d", mktime(0,0,0,$pbln,$ptgl,$pthn)));
																$sk = simpan_kegiatan();
																if (!$sk) { $hsl = false; }
													}
													break;
								 case 7 : $ptgl += 7;
								 					while (date("U", mktime(0,0,0,$pbln,$ptgl,$pthn))<=date("U", mktime(0,0,0,$sdbln,$sdtgl,$sdthn))) {
								 								list($pthn,$pbln,$ptgl)=split("-",date("Y-m-d", mktime(0,0,0,$pbln,$ptgl,$pthn)));
																$sk = simpan_kegiatan();
																if (!$sk) { $hsl = false; }
																$ptgl += 7;
													}
													break;
								 case 14: $ptgl += 14;
								 					while (date("U", mktime(0,0,0,$pbln,$ptgl,$pthn))<=date("U", mktime(0,0,0,$sdbln,$sdtgl,$sdthn))) {
								 								list($pthn,$pbln,$ptgl)=split("-",date("Y-m-d", mktime(0,0,0,$pbln,$ptgl,$pthn)));
																$sk = simpan_kegiatan();
																if (!$sk) { $hsl = false; }
																$ptgl += 14;
													}
													break;
								 case 30: while (date("U", mktime(0,0,0,++$pbln,$ptgl,$pthn))<=date("U", mktime(0,0,0,$sdbln,$sdtgl,$sdthn))) {
								 								list($pthn,$pbln,$ptgl)=split("-",date("Y-m-d", mktime(0,0,0,$pbln,$ptgl,$pthn)));
																$sk = simpan_kegiatan();
																if (!$sk) { $hsl = false; }
													}
													break;
						  }
							$ptgl = $tgl; $pbln = $bln; $pthn = $thn;
					 }
					 if ($diulg == 2) { // diulang pada hari H minggu ke M
					 		$query  = "INSERT INTO pengulangan_agenda ";
					 		$query .= "VALUES ($kd_agenda, '$hfsulg-$kefsulg', '0', '$sdthn.$sdbln.$sdtgl',curdate())";
					 		$hsl = mysql_query($query);
					 		if(!$hsl) {echo "@simpan pengulangan agenda:".mysql_error();}
					 		$pumk = pesan_ulang_mingguke($ptgl,$pbln,$pthn,$sdtgl,$sdbln,$sdthn);
							if (!$pumk) { $hsl = false; }
					 }
	 			}
   }
	 if ($hsl) { 
	 		if ($ubah==0) { $msg = 'Kegiatan: <b>'.$judul.'</b>, berhasil ditambahkan'; } 
	 		else { $msg = 'Kegiatan: <b>'.$judul.'</b>, berhasil diubah'; }
	 }
}
mysql_close($dbh);
if ($hsl) {
	 echo "<script language='JavaScript'>";
	 switch ($hmb) {
	    case 'h': echo "openurl('agenda.php?msg=$msg&ptgl=$ptgl&pbln=$pbln&pthn=$pthn','isi');\n";
								echo "openurl('navigasi_agenda.php?nav=0&ptgl=$ptgl&pbln=$pbln&pthn=$pthn','navigasi');\n";
					 			break;
	    case 'm': echo "openurl('mingguan.php?msg=$msg&ptgl=$ptgl&pbln=$pbln&pthn=$pthn','isi');\n";
								echo "openurl('navigasi_agenda.php?nav=1&ptgl=$ptgl&pbln=$pbln&pthn=$pthn','navigasi');\n";
					 			break;
	    case 'b': echo "openurl('bulanan.php?msg=$msg&ptgl=$ptgl&pbln=$pbln&pthn=$pthn','isi');\n";
								echo "openurl('navigasi_agenda.php?nav=2&ptgl=$ptgl&pbln=$pbln&pthn=$pthn','navigasi');\n";
					 			break;
   }
	 echo "</script>\n";
}
else {
		 echo "<div><center><p><br><br></p><p><br><br>";
		 echo "<b><font face=Verdana size=4>$msg</font></b>\n";
		 echo "<br><br><font face=Verdana size=2><input type=button name=B1 value='Kembali' onclick='history.go(-1)'></font><br>\n";
		 echo "</p></center></div>\n";
}
echo "</p></center></div>";
?>
</body>
</html>

