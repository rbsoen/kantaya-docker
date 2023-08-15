<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
$css = "../css/".$tampilan_css.".css";

echo "<html>\n";
echo "\n";
echo "<head>\n";
echo "<title>Agenda Bulanan</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
require('kegiatan.js');
?>
<script language="JavaScript">
<!--
function harian(tgl, bln, thn) {
	window.open("navigasi_agenda.php?nav=0&ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("agenda.php?ptgl="+tgl+"&pbln="+bln+"&pthn="+thn, "isi");
};

function bulanan(bln, thn) {
	window.open("navigasi_agenda.php?nav=2&pbln="+bln+"&pthn="+thn, "navigasi");
	window.open("bulanan.php?pbln="+bln+"&pthn="+thn, "isi");
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
echo "<body>\n";

$thn_skrg = date("Y");
if (isset($pbln)) {$bln = $pbln; } else {$bln = date("n");}
if (isset ($pthn)) {$thn = $pthn;} else {$thn = date("Y");}
	
echo "<div align=center>\n";
echo "  <center>\n";
echo "  <table border=0 width=100%>\n";
echo "    <tr>\n";
echo "      <td class=judul1>Agenda Bulanan</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </center>\n";
echo "</div>\n";
echo "<div align=center>\n";
echo "  <center>\n";
echo "  <table border=0 width=100% cellpadding=4 cellspacing=0 bordercolorlight=#000080 bordercolordark=#008000>\n";
echo "    <tr>\n";
$namabln = namabulan("P",$bln);
$blns = $bln - 1;
$thns = $thn;
if ($blns == 0) { $blns = 12; $thns -= 1;}
$blnb = $bln + 1;
$thnb = $thn;
if ($blnb == 13) { $blnb = 1; $thnb += 1;}
echo "      <td class=judul2><font face=Verdana >";
echo 		"<a href='javascript:bulanan($blns,$thns)'>&lt;&lt;</a>\n";
echo "        $namabln&nbsp; $thn <a href='javascript:bulanan($blnb,$thnb)'>&gt;&gt;</a></font></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=isi2 width=100% align=center><font size=2 face=Verdana>";
echo "			 &nbsp;".stripslashes($msg)."&nbsp;</font></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=isi2>\n";
echo "        <div align=center>\n";
echo "          <table border=1 width=100% cellspacing=0 cellpadding=4>\n";
echo "            <tr>\n";
echo "              <td width=14% class=judul2>Senin</td>\n";
echo "              <td width=14% class=judul2>Selasa</td>\n";
echo "              <td width=14% class=judul2>Rabu</td>\n";
echo "              <td width=14% class=judul2>Kamis</td>\n";
echo "              <td width=14% class=judul2>Jumat</td>\n";
echo "              <td width=14% class=judul2>Sabtu</td>\n";
echo "              <td width=14% class=judul2>Minggu</td>\n";
echo "            </tr>\n";
kalender($bln,$thn,$kal);
for ($i=0; $i<count($kal); $i++) {
	switch ($i) {
				 case 0 : $k = "I"; break;
				 case 1 : $k = "II"; break;
				 case 2 : $k = "III"; break;
				 case 3 : $k = "IV"; break;
				 case 4 : $k = "V"; break;
				 case 5 : $k = "VI"; break;
	}
echo "            <tr>\n";
	for ($j=0; $j<7; $j++) {
	  $tgl = $kal[$i][$j]; 
		if ($tgl == 0) {
echo "              <td width=11% bgcolor=dcdcdc>&nbsp;</td>\n";
		}
		else { 
			if ($j == 6) {$font = "<font color='red'>";}
			else {$font = "<font color=0000FF>";}
echo "		 				  <td width=12% bgcolor=dcdcdc>\n";
echo "                <table border=0>\n";
echo "										 <td width=100%>$font<b>";
echo "							        <a href='javascript:harian($tgl,$bln,$thn)'>$tgl</a></b></font></td>\n";
echo "										 <td width=14 align=right><a href='isi_agenda.php?hmb=b&ptgl=$tgl&pbln=$bln&pthn=$thn'><img border=0 src='plus.gif'></a></td>\n";
echo "								</table>\n";
echo "							 </td>\n";
		}
	}
echo "            </tr>\n";
echo "            <tr>\n";
//echo "              <td width=12% >&nbsp</td>\n";
	for ($j=0; $j<7; $j++) { 
			$tgl = $kal[$i][$j];
			$slctkgtn  = "select waktu_mulai, waktu_selesai, judul, kode_agenda from agenda ";
			$slctkgtn .= "where pemilik = $kode_pengguna ";
			$slctkgtn .= "and date_format(tgl_mulai, '%e%c%Y') = ".$tgl.$bln.$thn." "; 
			$slctkgtn .= "order by waktu_mulai, waktu_selesai, judul";
			$hsl = mysql_query($slctkgtn,$dbh);
			if (!$hsl) {echo mysql_error();}
			$flg = 0;
echo "              <td width=15%>";
echo "                <table border=0>\n";
					 while ($dat = @mysql_fetch_row($hsl)) {
					 			 $flg++;
					 			 $dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
echo "              	<tr><td width=100%><font size=1><a href='isi_agenda.php?hmb=b&kode_agenda=$dat[3]'>$dat[2]</a></font></td>\n";
echo "									  <td width=10 align=right><a href='olah_data_kegiatan.php?hmb=b&judul=$dat[2]&modus=Hapus&ptgl=$tgl&pbln=$bln&pthn=$thn&kode_agenda=$dat[3]'>\n";
echo "													<img border=0 src='x.gif' width=8 height=8></a></td>\n";
echo "								</tr>\n";
		 			 }
					 if ($flg == 0) {echo "		 					&nbsp</table></td>\n";}
					 else {echo "		 					</table></td>\n";}
	}
echo "            </tr>\n";
}

echo "          </table>\n";
echo "        </div><br>\n";
echo "        <div align=center>\n";
echo "          <table border=0 cellpadding=0 cellspacing=0 width=95%>\n";
echo "          <tr>\n";
echo "            <td width=100%>\n";
echo "              <ul>\n";
echo "                <li>\n";
echo "                  <p align=left><font size=2 face=Verdana>Klik judul\n";
echo "                  kegiatan untuk melihat detil kegiatan</font></p>\n";
echo "                </li>\n";
echo "                <li>\n";
echo "                  <p align=left><font size=2 face=Verdana>Klik tombol\n";
echo "                  tambah (+) untuk menambah kegiatan</font></p>\n";
echo "                </li>\n";
echo "                <li>\n";
echo "                  <p align=left><font size=2 face=Verdana>Klik tombol\n";
echo "                  silang (X) untuk menghapus kegiatan</font></p>\n";
echo "                </li>\n";
echo "              </ul>\n";
echo "              <center></td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </div>\n";

// Penambahan langsung (quick add) kegiatan
echo "        <div align=left>\n";
echo "				 <form NAME=qckadd METHOD=POST ACTION='olah_data_kegiatan.php'>\n";
echo "				  <input type=hidden name='hmb' value='b'>\n";
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
						if ($i==15) {$slctd = 'selected';}
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
echo "        </div><p>&nbsp</p>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </center>\n";
echo "</div>\n";
echo "\n";
echo "</body>\n";
echo "\n";
echo "</html>\n";
mysql_close($dbh);
?>
