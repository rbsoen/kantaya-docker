<?PHP

function tanggal($format,$tgl) {
       list($y,$m,$d)=split("-",$tgl);
       $d = substr($d,0,2);
       return $d."-".namabulan($format,$m)."-".$y;
}

function namahari ($p1, $p2) {
	$namahari = array("P"  => array(0 => 	"Minggu", "Senin", "Selasa", "Rabu", 
					"Kamis", "Jumat", "Sabtu"), 
			  "S"  => array(0 => 	"M", "S", "S", "R", "K", "J", "S"));
	return $namahari[$p1][$p2];
}

function namabulan ($p1, $p2) {
	$namabulan = array("P" => array(1 => 	"Januari", "Pebruari", "Maret", "April",
					"Mei", "Juni", "Juli", "Agustus",
					"September", "Oktober", "Nopember", "Desember"),
			   "S" => array(1 =>	"Jan", "Peb", "Mar", "Apr", "Mei", "Jun",
					"Jul", "Agt", "Sep", "Okt", "Nop", "Des"));
	return $namabulan[$p1][($p2+0)];
}

function tahunkabisat ($tahun) {
	if ((($tahun%4==0) && ($tahun%100!=0)) || ($tahun%400==0)) {
		return True; 
	}
	else {
		return False; 
	}
}

function jmlharidlmbulan ($bulan, $tahun) {
	if ($bulan == 2) {
		return (28 + tahunkabisat($tahun));
	}
	elseif ($bulan > 7) {
		return (30 + ($bulan + 1) % 2); 
	}
	else {
		return (30 + $bulan % 2); 
	}
}		

function kalender($bulan, $tahun, &$kalender) {
	$tgl1_hari = date("w",mktime(0,0,0,$bulan,1,$tahun));
	if ($tgl1_hari==0) $tgl1_hari=7;
	$jml_hari = jmlharidlmbulan ($bulan, $tahun);
	$jml_kolom = 7;
	$jml_baris = ceil(($jml_hari+$tgl1_hari-1)/7);
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
				}
				else {
					$tgl = 0;
				}
			}
			else {
				if ($tgl > 0 && $tgl < $jml_hari) {
					$tgl = $tgl + 1;
				}
				else {
					$tgl = 0;
				}
			}
			$kalender[$i][$j] = $tgl;
		}
	}
}
?>

