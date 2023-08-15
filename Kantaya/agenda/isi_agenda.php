<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
require('cfgagenda.php');
$css = "../css/".$tampilan_css.".css";
error_reporting(0);
echo "
<html>

<head>
<title>Pengisian Agenda</title>
";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
require('kegiatan.js');
echo "
</head>
";

if (isset($kode_agenda)) { // lihat atau ubah kegiatan
	 if (!isset($judul)) { // pertama kali buka
	 		$loc = 0;
	 		$hsl = mysql_query("select * from agenda where kode_agenda = $kode_agenda",$dbh);
	 		if (!$hsl) {echo mysql_error();}
	 		$dat = @mysql_fetch_array($hsl);
	 		#$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
	 		if ($dat["pemilik"] == $kode_pengguna) { $mode = 2;/*mode ubah*/ }
			else { $mode = 0; /*mode lihat*/ }
			list($pthn, $pbln, $ptgl) = split("-",$dat["tgl_mulai"]);
	 		list($pjammulai, $pmntmulai) = split(":", $dat["waktu_mulai"]);
	 		list($pjamakhir, $pmntakhir) = split(":", $dat["waktu_selesai"]);
	 		if ($dat["waktu_mulai"]=="00:00:00" and $dat["waktu_selesai"]=="23:59:59") {
	 			 $spjhari = 1;
	 		} else {$spjhari = 0;}
      $judul = $dat["judul"];
			$ptipe = $dat["tipe"];
		  $deskripsi = $dat["deskripsi"];
			// data pengulangan
			$kode_pengulangan = $dat["kode_pengulangan"];
			if ($kode_pengulangan == $kode_agenda) { // ada pengulangan
	 			 $hsl = mysql_query("select * from pengulangan_agenda where kode_agenda = $kode_pengulangan",$dbh);
	 			 if (!$hsl) { echo mysql_error(); }
	 			 if ($dat1 = @mysql_fetch_array($hsl)) {
				 		if ($dat1["fase_ulang"] !== '-') {
							 $diulg = 2; // diulang pada hari apa minggu ke berapa
							 list($hfsulg,$kefsulg) = split("-",$dat1["fase_ulang"]);
							 $diulgstp = '';
						}
						else { 
								 $diulg = 1; // diulang setiap...
								 $diulgstp = $dat1["diulang_setiap"];
								 $hfsulg = ''; $kefsulg = '';
						}
			   }
				 if ($dat1["sd_tgl"] == "0000-00-00") { $tnpbts = 1; }
				 else { 
				 			list($sdthn,$sdbln,$sdtgl) = split("-",$dat1["sd_tgl"]);
							$tnpbts = 0;
				 }				 			
		  }
		  else { $diulg = 0; } // tanpa pengulangan 
			// fasilitas
			$hsl = mysql_query("select fasilitas from pemesanan where kode_agenda = $kode_agenda",$dbh);
			if (!$hsl) {echo mysql_error();}
			$i = 0;
			if ($dat1 = mysql_fetch_row($hsl)) { $fas = $dat1[0]; $i++;}
			if ($i == 0) {$dgfas = 0;} else {$dgfas = 1;}
			// sharing
			$sharing_publik = $dat["sharing_publik"];
			$sftshar = $dat["sifat_sharing"];
			$hsl = mysql_query("select kode_unit from sharing_agenda_unit where kode_agenda = $kode_agenda",$dbh);
			if (!$hsl) {echo mysql_error();}
			$i = 0;
			while ($dat1 = mysql_fetch_row($hsl)) { $untshar[$i++] = $dat1[0]; }
			$hsl = mysql_query("select kode_grup from sharing_agenda_grup where kode_agenda = $kode_agenda",$dbh);
			if (!$hsl) {echo mysql_error();}
			$i = 0;
			while ($dat1 = mysql_fetch_row($hsl)) { $grpshar[$i++] = $dat1[0]; }
			$hsl = mysql_query("select kode_pengguna from sharing_agenda_pengguna where kode_agenda = $kode_agenda",$dbh);
			if (!$hsl) {echo mysql_error();}
			$i = 0;
			while ($dat1 = mysql_fetch_row($hsl)) { $pgnshar[$i++] = $dat1[0]; }
			// undangan
			$hsl = mysql_query("select kode_unit from undangan_unit where kode_agenda = $kode_agenda",$dbh);
			if (!$hsl) {echo mysql_error();}
			$i1 = 0;
			while ($dat1 = mysql_fetch_row($hsl)) { $untundgn[$i1++] = $dat1[0]; }
			$hsl = mysql_query("select kode_grup from undangan_grup where kode_agenda = $kode_agenda",$dbh);
			if (!$hsl) {echo mysql_error();}
			$i2 = 0;
			while ($dat1 = mysql_fetch_row($hsl)) { $grpundgn[$i2++] = $dat1[0]; }
			$hsl = mysql_query("select kode_pengguna from undangan_pengguna where kode_agenda = $kode_agenda",$dbh);
			if (!$hsl) {echo mysql_error();}
			$i3 = 0;
			while ($dat1 = mysql_fetch_row($hsl)) { $pgnundgn[$i3++] = $dat1[0]; }
			if ($i1>0 or $i2>0 or $i3>0) { $undgn = 1; } else { $undgn = 0; }
	 }
}
else { $mode = 1; /*kegiatan baru*/ }
if ($mode==1 and !isset($judul) and !isset($loc)) {/*kegiatan baru, buka awal*/ 
	 $diulg = 0; $dgfas = 0; $sharing_publik = 0; $sftshar = 0; $undgn = 0; $loc = 0;
}
if ($spjhari == 1) {$chk1 = "checked"; $chk2 = '';} else {$chk1 = ''; $chk2 = "checked";}
if ($mode == 1 and isset($pjam)) {
	 list($pjammulai,$pmntmulai) = split(":",$pjam);
	 $pjamakhir = $pjammulai+1;
	 $pmntakhir = $pmntmulai;
}	
if (!isset($pjammulai)) {$pjammulai = "12"; $pjamakhir = "13";}
$frmdisbl = ($mode == 0) ? ('disabled') : ('');
$ploc = $loc + 1;
echo "
<body>

<form $frmdisbl name=isikgtn method=Post action='olah_data_kegiatan.php'>
<input type=hidden name=loc value=$ploc>
<input type=hidden name=hmb value='$hmb'>
<input type=hidden name=mode value=$mode>
";
if ($mode <> 1) { echo "<input type=hidden name=kode_agenda value=$kode_agenda>\n"; }
echo "<input type=hidden name=diulg value=$diulg>\n";
if ($diulg <> 0) { 
	 echo "
<input type=hidden name=diulgstp value='$diulgstp'>
<input type=hidden name=hfsulg value='$hfsulg'>
<input type=hidden name=kefsulg value='$kefsulg'>
<input type=hidden name=tnpbts value='$tnpbts'>
<input type=hidden name=sdtgl value='$sdtgl'>
<input type=hidden name=sdbln value='$sdbln'>
<input type=hidden name=sdthn value='$sdthn'>\n";
}
echo "<input type=hidden name=dgfas value=$dgfas>\n";
if ($dgfas <> 0) { echo "<input type=hidden name=fas value=$fas>\n"; }
echo "<input type=hidden name=sftshar value=$sftshar>\n";
echo "<input type=hidden name=sharing_publik value='$sharing_publik'>\n";
$i = 0;
foreach ($untshar as $un) { echo "<input type=hidden name=untshar[$i] value=$un>\n"; $i++; }
$i = 0;
foreach ($grpshar as $gr) { echo "<input type=hidden name=grpshar[$i] value=$gr>\n"; $i++; }
$i = 0;
foreach ($pgnshar as $pg) { echo "<input type=hidden name=pgnshar[$i] value=$pg>\n"; $i++; }
echo "<input type=hidden name=undgn value=$undgn>\n";
if ($undgn <> 0) {
	 $i = 0;
	 foreach ($untundgn as $un) { echo "<input type=hidden name=untundgn[$i] value=$un>\n"; $i++; }
	 $i = 0;
	 foreach ($grpundgn as $gr) { echo "<input type=hidden name=grpundgn[$i] value=$gr>\n"; $i++; }
	 $i = 0;
	 foreach ($pgnundgn as $pg) { echo "<input type=hidden name=pgnundgn[$i] value=$pg>\n"; $i++; }
}

include('kegiatan.php');
if ($mode == 0) { include('data_lihat.php'); }
else {
echo "
					<table width=100% border=0>
					  <tr>
						  <td class=judul1 width=25% align=center><a href='javascript:onclick=buka(1)'>
							<font color=FFFFFF size=2 face=Verdana>Pengulangan</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(2)'>
              <font color=FFFFFF size=2 face=Verdana>Fasilitas</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(3)'>
							<font color=FFFFFF size=2 face=Verdana>Ditampilkan</font></a></td>
							<td class=judul1 width=25% align=center><a href='javascript:onclick=buka(4)'>
							<font color=FFFFFF size=2 face=Verdana>Undangan</font></a></td>
            </tr>
					</table>
  </td></tr></table>
</div><br>";
}
if ($mode == 0) {echo "  </form>";}
echo "
<div align=center>
  <table border=0 width=100% cellspacing=0>
    <tr>
      <td align=center>
";
echo "				   <button type=button name='kembali' onclick='javascript:history.go(-$ploc)'><font color=000000>Kembali</font></button>\n";
if ($mode <> 0) {
	 if ($mode == 1) {
echo "					 &nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value=Simpan name=modus onclick='return validasi(document.isikgtn)'>\n";
   } else {
echo "					 &nbsp;&nbsp;&nbsp;&nbsp;<input type=submit value='Simpan Pengubahan' name=modus onclick='return validasi(document.isikgtn)'>\n";
   }
}
echo "
      </td>
    </tr>
  </table>
</div>
<p align=left>&nbsp;</p>
";
if ($mode <> 0) {echo "  </form>";}
echo "
</body>

</html>
";
mysql_close($dbh);
?>
