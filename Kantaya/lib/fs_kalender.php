<?PHP
/******************************************
Nama File : fs_kalender.php
Fungsi    : Fungsi-fungsi yang berkaitan
            dgn. penyusunan kalender.
Dibuat    :	
 Tgl.     : 16-10-2001
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

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



function harisblm ($h) {

  if ($h-- == -1) { return ('6');}

	else { return ($h--);}

}

	

function haribrkt ($h) {

  if ($h++ == 7) { return ('0');}

	else { return ($h++);}

}



function namabulan ($p1, $p2) {

	$namabulan = array("P" => array(1 => 	"Januari", "Februari", "Maret", "April",

					"Mei", "Juni", "Juli", "Agustus",

					"September", "Oktober", "Nopember", "Desember"),

			   "S" => array(1 =>	"Jan", "Feb", "Mar", "Apr", "Mei", "Jun",

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

	$mulai = $tgl1_hari-1;

	if ($mulai < 0) {

		$mulai = 6;

	}

	$jml_hari = jmlharidlmbulan ($bulan, $tahun);

	$jml_kolom = 7;

	$jml_baris = ceil(($jml_hari+$mulai)/7);

	$tgl = 0;

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



