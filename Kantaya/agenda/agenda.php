<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
require('cfgagenda.php');
$css = "../css/".$tampilan_css.".css";
echo "
<html>

<head>
<title>Agenda Harian</title>
<link rel=stylesheet type='text/css' href='$css'>
<meta http-equiv='Content-Style-Type' content='text/css'>
";
?>
<script language="JavaScript">
<!--
function harian(tgl, bln, thn) {
	window.open("navigasi_agenda.php?nav=0&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("agenda.php?ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
};

function validasi(form) {
  var field = form.judul;  
  var jdl = field.value; 
	var jamml = form.pjammulai.value;
	var mntml = form.pmntmulai.value;
	var jamsl = form.pjamakhir.value;
	var mntsl = form.pmntakhir.value;
  var ok = 0;
	if (jdl == "") {
		 alert("Judul tidak boleh kosong!");
		 field.focus();
		 field.select();
		 ok++;
  }
	if ((jamsl < jamml) || (jamsl == jamml && mntsl <= mntml )) {  
      alert("Waktu mulai harus lebih dulu daripada waktu selesai!");
      ok++;
  }
	if (ok > 0) {return false;} else {return true;}
}

// -->
</script>
<?php
echo "</head>\n";

$hari_skrg = date("w");
$tgl_skrg = date("j");
$bln_skrg = date("n");
$thn_skrg = date("Y");
if (isset($pthn)) {$thn = $pthn;}	
else {$thn = $thn_skrg;}
if (isset($pbln)) {$bln = $pbln;}
else {$bln = $bln_skrg;}
if (isset($ptgl)) {
	 $hari = date("w", mktime(0,0,0,$pbln,$ptgl,$pthn));
	 $tgl = $ptgl;
	 }
else {
	 $hari = $hari_skrg;
	 $tgl = $tgl_skrg;
	 }
if (!isset($pthn) and !isset($pbln) and !isset($ptgl)) {
	 $jam = date("H");}
else {$jam = "12";}	

error_reporting(0);	
$jamntml = $pjammulai.":".$pmntmulai.":00";
$jamntsl = $pjamakhir.":".$pmntakhir.":00";

echo "<body>\n";
echo "\n";
echo "<div align=center>\n";
echo "  <table border=0 width=100% height=100%>\n";
echo "    <tr>\n";
echo "      <td class=judul1 align=left>Agenda Harian</td>\n";
echo "    </tr>\n";

// Kegiatan hari bersangkutan
echo "  <center>\n";
echo "    <tr>\n";
echo "      <td class=isi2 width=90% valign=top>\n";
echo "        <div align=center>\n";
echo "          <center>\n";
echo "          <table border=0 width=100%>\n";
echo "            <tr>\n";
		 								$bltgths = mktime( 0, 0, 0, $bln, $tgl-1, $thn);
										$bltgthb = mktime( 0, 0, 0, $bln, $tgl+1, $thn);
		 								list($haris,$tgls,$blns,$thns) = split("-", date("w-j-n-Y", $bltgths));
										list($harib,$tglb,$blnb,$thnb) = split("-", date("w-j-n-Y", $bltgthb));
echo "              <td class=judul2 width=100% bgcolor='#0099FF'><font size=2 face=Verdana><b>\n";
echo "							  <a href='javascript:harian($tgls,$blns,$thns)'>&lt;&lt;</a>&nbsp;\n";
echo "                ".namahari("P",$hari).", $tgl ".namabulan('P',$bln)." $thn&nbsp;\n";
echo "							  <a href='javascript:harian($tglb,$blnb,$thnb)'>&gt;&gt;</a></b></font></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=100% align=center><font size=2 face=Verdana>";
echo "							  &nbsp;".stripslashes($msg)."&nbsp;</font></td>\n";
echo "            </tr>\n";
echo "            <tr><td width=100% align=right>\n";
echo "				 		<form NAME=tambah METHOD=POST ACTION='isi_agenda.php'>\n";
echo "				   				<input type=hidden name='hmb' value='h'>";
echo "				   				<input type=hidden name='ptgl' value=$tgl>";
echo "				   				<input type=hidden name='pbln' value=$bln>";
echo "				   				<input type=hidden name='pthn' value=$thn>";
echo "				   				<select size=1 name='ptipe'>\n";
		 			foreach ($arrtipe as $t) {
echo "            					<option value='$t'>$t</option>\n";
		 							}
echo "          	 			</select><input type=submit name='B3' value=Tambah></form></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          </center>\n";
echo "        </div>\n";
echo "        <div align=center>\n";
echo "          <center>\n";
echo "          <table border=1 width=100% bordercolorlight='#C0C0C0' bordercolordark='#C0C0C0' cellspacing=0 cellpadding=4>\n";
echo "            <tr>\n";
echo "              <td class=judul2 width=25%><b><font size=2 face=Verdana>Waktu</font></b></td>\n";
echo "              <td class=judul2 width=61%><b><font size=2 face=Verdana>Judul Kegiatan</font></b></td>\n";
echo "              <td class=judul2 width=14%><b><font size=2 face=Verdana>Hapus</font></b></td>\n";
echo "            </tr>\n";

$slctkgtn  = "select waktu_mulai, waktu_selesai, judul, kode_agenda from agenda ";
$slctkgtn .= "where pemilik = $kode_pengguna ";
$slctkgtn .= "and date_format(tgl_mulai, '%e%c%Y') = ".$tgl.$bln.$thn." "; 
$slctkgtn .= "order by waktu_mulai, waktu_selesai, judul";
$hsl = mysql_query($slctkgtn,$dbh);
if (!$hsl) {echo mysql_error();}
list($tjam,$tmnt) = split(':',$awaljamkrj);
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			list($jamml,$mntml,$dtkml) = split(':',$dat[0]);
			if ($tjam < $jamml or ($tjam == $jamml and $tmnt < $mntml)) {
				 $twkt = $tjam.":".$tmnt;
				 $wkt = $twkt." - ".substr($dat[0],0,5);
echo "            <tr>\n";
echo "              <td width=25%><font size=2 face=Verdana>";
echo "							 <a href='isi_agenda.php?hmb=h&pjam=$twkt&ptgl=$tgl&pbln=$bln&pthn=$thn'>$wkt</a></font></td>\n";
echo "              <td width=61%><font size=1 face=Verdana>&nbsp;</font></td>\n";
echo "              <td width=14%>&nbsp;</td>\n";
echo "            </tr>\n";
		 	}
			$wkt = substr($dat[0],0,5)." - ".substr($dat[1],0,5);
			if ($wkt == "00:00 - 23:59") {$wkt = "Sepanjang Hari";}
echo "            <tr>\n";
echo "              <td width=25%><font size=2 face=Verdana>$wkt</font></td>\n";
echo "              <td width=61%><font size=2 face=Verdana>\n";
echo "                <a href='isi_agenda.php?hmb=h&kode_agenda=$dat[3]'>$dat[2]</a></font></td>\n";
echo "              <td align=center width=14%><a href='olah_data_kegiatan.php?hmb=h&judul=$dat[2]&modus=Hapus&ptgl=$tgl&pbln=$bln&pthn=$thn&kode_agenda=$dat[3]'>\n";
echo "								<img border=0 src='del.gif' width=12 height=12></a></td>\n";
echo "            </tr>\n";
		  list($tjam,$tmnt) = split(':',$dat[1]);
}
list($tjak,$tmak) = split(':',$akhirjamkrj);
if ($tjam < $tjak or ($tjam = $tjakand and $tmnt < $tmak)) {
	 $twkt = $tjam.":".$tmnt;
	 $wkt = $tjam.":".$tmnt." - ".$akhirjamkrj;
echo "            <tr>\n";
echo "              <td width=25%><font size=2 face=Verdana>";
echo "							 <a href='isi_agenda.php?hmb=h&pjam=$twkt&ptgl=$tgl&pbln=$bln&pthn=$thn'>$wkt</a></font></td>\n";
echo "              <td width=61%><font size=1 face=Verdana>&nbsp;</font></td>\n";
echo "              <td width=14%>&nbsp;</td>\n";
echo "            </tr>\n";
}
echo "          </table>\n";
echo "          </center>\n";
echo "        </div><br>\n";

// Penambahan langsung (quick add) kegiatan
echo "        <div align=left>\n";
echo "				 <form NAME=qckadd METHOD=POST Target='isi' ACTION='olah_data_kegiatan.php'>\n";
echo "				  <input type=hidden name='hmb' value='h'>\n";
echo "          <table border=0 width=100% cellpadding=2 cellspacing=0>\n";
echo "            <tr>\n";
echo "              <td class=judul1 width=100% colspan=4><b><font size=2 face=Verdana>Penambahan\n";
echo "                Langsung Kegiatan Baru:</font></b></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=30%><font size=2>Judul Kegiatan:</font></td>\n";
echo "              <td width=30%><font size=2>Tanggal:</font></td>\n";
echo "              <td width=20%><font size=2>Waktu Mulai:</font></td>\n";
echo "              <td width=20%><font size=2>Selesai:</font></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td><input type=text name='judul' size=20>\n";
echo "              <td><select size=1 name='ptgl'>\n";
				for ($i=1; $i<=31; $i++) {
						$slctd = '';
						if ($i==$tgl) {$slctd = 'selected';}
echo "						       <option ".$slctd." value=".$i.">".$i;
				}
echo "                  </select><select size=1 name='pbln'>\n";
				for ($i=1; $i<=12; $i++) {
						$slctd = '';
						if ($i==$bln) {$slctd = 'selected';}
						$nmbln = namabulan("S", $i);
echo"					           <option ".$slctd." value=".$i.">".$nmbln;
				}
echo "                  </select><select size=1 name='pthn'>\n";
				for ($i=$thn_skrg; $i<=$thn_skrg+2; $i++) {
						$slctd = '';
						if ($i==$thn) {$slctd = 'selected';}
echo "					         <option ".$slctd." value=".$i.">".$i;
				}
echo "                  </select></td>\n";
echo "              <td><select size=1 name='pjammulai'>\n";
			for ($i=0; $i<=23; $i++) {
					$slctd = '';
					if ($i==$jam) {$slctd = 'selected';}
					if (strlen($i)==1) { $i="0".$i; }
echo "								<option ".$slctd." value=".$i.">".$i;
					}
echo "                 </select>:<select size=1 name='pmntmulai'>\n";
echo "                  <option>00</option>\n";
echo "                  <option>15</option>\n";
echo "                  <option>30</option>\n";
echo "                  <option>45</option>\n";
echo "                 </select></td><td><select size=1 name='pjamakhir'>\n";
			for ($i=0; $i<=23; $i++) {
					$slctd = '';
					if ($i==$jam+1) {$slctd = 'selected';}
					if (strlen($i)==1) { $i="0".$i; }
echo "					        <option ".$slctd." value=".$i.">".$i;
					}
echo "                 </select>:<select size=1 name='pmntakhir'>\n";
echo "                  <option>00</option>\n";
echo "                  <option>15</option>\n";
echo "                  <option>30</option>\n";
echo "                  <option>45</option>\n";
echo "                 </select></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td colspan=4 align=center><input type=submit value='Simpan' name='modus' onclick='return validasi(document.qckadd)'></center>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "				 </form>";
echo "        </div>\n";

// Undangan dari pengguna lain
$slctundgn  = "SELECT distinct agenda.kode_agenda, judul, nama_pengguna, konfirmasi
							FROM agenda, undangan_pengguna, pengguna
							where agenda.kode_agenda = undangan_pengguna.kode_agenda
							and tgl_mulai >= curdate() and pemilik = pengguna.kode_pengguna
							and undangan_pengguna.kode_pengguna = $kode_pengguna";
$hsl = mysql_query($slctundgn,$dbh);
if (!$hsl) {echo mysql_error();}
if (mysql_num_rows($hsl) > 0) {
echo "        <div align=center>\n";
echo "          <center>\n";
echo "          <table border=1 width=100% bordercolorlight='#C0C0C0' cellspacing=0 cellpadding=4 bordercolordark='#C0C0C0'>\n";
echo "            <tr>\n";
echo "              <td class=judul1 width=100% colspan=5 bgcolor='#008000'><font size=2 face=Verdana><b>Undangan\n";
echo "                dari pengguna lain:</b></font></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=40% align=center><b><font size=1 face=Verdana>Judul\n";
echo "                Kegiatan</font></b></td>\n";
echo "              <td width=20% align=center><b><font size=1 face=Verdana>Dari</font></b></td>\n";
echo "              <td width=20% colspan=2 align=center><b><font size=1 face=Verdana>Konfirmasi\n";
echo "                Diri</font></b></td>\n";
echo "              <td width=20% align=center><b><font size=1 face=Verdana>Konfirmasi\n";
echo "                pengguna lainnya</font></b></td>\n";
echo "            </tr>\n";
   while ($dat = @mysql_fetch_row($hsl)) {
echo "            <tr>\n";
echo "              <td width=20%><font size=1 face=Verdana><a class=std_a href='isi_agenda.php?kode_agenda=$dat[0]'>$dat[1]</a></font></td>\n";
echo "              <td width=20%><font size=1 face=Verdana>$dat[2]</font></td>\n";
echo "              <td width=10% align=center>";
echo ($dat[3]==1) ? ("Bisa\n")
		 :("                <input type=button value=Bisa name=B3 onClick=window.open('anda_konfirm.php?kode_agenda=$dat[0]','Anda_Konfirm','width=450,height=200')></td>\n");
echo "              <td width=10% align=center>";
echo ($dat[3]==0) ? ("Tidak\n")
		 :("                <input type=button value=Tidak name=B3 onClick=window.open('alasan_tidak_konfirm.php?kode_agenda=$dat[0]','Alasan_Tidak_Bisa','width=500,height=300')></td>\n");
echo "              <td width=20% align=center><font size=1 face=Verdana><a href='agenda.php' onClick=window.open('pengguna_konfirm.php?kode_agenda=$dat[0]','Pengguna_Konfirm','width=500,height=300')>Lihat</a></font></td>\n";
echo "            </tr>\n";
   }
echo "          </table>\n";
echo "          </center>\n";
echo "        </div>\n";
}

// Undangan ke pengguna lain
$slctundgn  = "SELECT distinct date_format(tgl_mulai,'%d/%m/%y'), time_format(waktu_mulai,'%H:%i'),
							time_format(waktu_selesai,'%H:%i'), agenda.kode_agenda, judul
							FROM agenda, undangan_pengguna, pengguna
							where agenda.kode_agenda = undangan_pengguna.kode_agenda
							and pemilik = $kode_pengguna and tgl_mulai >= curdate()
							order by tgl_mulai, waktu_mulai, waktu_selesai";
$hsl = mysql_query($slctundgn,$dbh);
if (!$hsl) {echo mysql_error();}
if (mysql_num_rows($hsl) > 0) {
echo "        <div align=center>\n";
echo "          <center>\n";
echo "          <table border=1 width=100% bordercolorlight='#C0C0C0' cellspacing=0 cellpadding=2 bordercolordark='#C0C0C0'>\n";
echo "            <tr>\n";
echo "              <td class=judul1 width=100% colspan=3 bgcolor='#008000'><font size=2 face=Verdana><b>Undangan\n";
echo "                ke pengguna lain:</b></font></td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=27% align=center><b><font size=1 face=Verdana>Waktu</font></b></td>\n";
echo "              <td width=63% align=center><b><font size=1 face=Verdana>Judul Kegiatan</font></b></td>\n";
echo "              <td width=10% align=center><b><font size=1 face=Verdana>Konfirmasi\n";
echo "                yang diundang</font></b></td>\n";
echo "            </tr>\n";
   while ($dat = @mysql_fetch_row($hsl)) {
echo "            <tr>\n";
echo "              <td width=27% align=center><font size=1 face=Verdana>$dat[0] $dat[1]-$dat[2]</font></td>\n";
echo "              <td width=63%><font size=1 face=Verdana>$dat[4]</font></td>\n";
echo "              <td width=10% align=center><font size=1 face=Verdana>\n";
echo "							  <a href='agenda.php' onClick=window.open('pengguna_konfirm.php?kode_agenda=$dat[3]','Pengguna_Konfirm','width=500,height=300')>Lihat</a></font></td>\n";
echo "            </tr>\n";
   }
echo "          </table>\n";
echo "          </center>\n";
echo "        </div>\n";
}

echo "      <p align=left>&nbsp;</p>\n";
echo "     </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo " </div>\n";
echo "</body>\n";

mysql_close($dbh);

echo "\n";
echo "</html>\n";
echo "\n";
?>
