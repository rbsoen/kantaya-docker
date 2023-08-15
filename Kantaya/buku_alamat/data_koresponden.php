<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
require ("../lib/akses_unit.php");
$css = "../css/".$tampilan_css.".css";
if ($pguna == 1) {
	 $select  = "select '', nama_pengguna, '', '', '', 'U', unit_kerja, '', 'Internal', ";
	 $select .= "email, '', '', telp_k, telp_r, hp, fax, alamat_k_jalan, kota, kode_pos, ";
	 $select .= "propinsi, negara, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah";
	 $hsl = mysql_query ($select." from pengguna where kode_pengguna = $kontak_id", $dbh) or mysql_error();
	 $data = mysql_fetch_row ($hsl);
	 $dsabl = "disabled";
	 }
else {
		$hsl = mysql_query ("select * from buku_alamat where kontak_id = $kontak_id", $dbh) or mysql_error();
		$data = mysql_fetch_row ($hsl);
		$data = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$data))));
		if ($kode_pengguna == $data[22]) {$dsabl = '';}
		else {$dsabl = "disabled";}
		}
if ($dsabl == '') {$dpt = "(dapat diubah/dihapus)";}
else {$dpt = '';}
echo "<html><head>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "</head>\n";
echo "<body>\n";
echo			"<div><center>\n";
echo "  <table border=0 width=100%>\n";
echo "    <tr>\n";
echo "      <td colspan=4 class=judul1>\n";
echo "        <p><b>Data Koresponden </b>$dpt</p></td>\n";
echo "    </tr></table>\n";
echo			"<FORM NAME=ubah_kontak METHOD=POST ACTION='olah_data_kontak.php'>\n";
echo "<table width=510>\n";
echo			"<input type=hidden name=kontak_id value=$data[0]>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Nama</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='nama' value='$data[1]' size=50 maxlength=60></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Gelar Depan</font> </td>\n";
echo					"<td width=125><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='gelar_dpn' value='$data[2]' size=10 maxlength=20></font></td>\n";
echo          "<td width=285><font face=Verdana size=2>Gelar \n";
echo                "Belakang :<input $dsabl type=text name='gelar_blk' value='$data[3]' size=9 maxlength=10></font></td></tr>\n";
$pria = '';
$wanita = '';
if ($data[4] == 'P') {$pria = 'checked';}
if ($data[4] == 'W') {$wanita = 'checked';}
echo			"<tr><td width=100><font face=Verdana size=2>Jenis kelamin</font></td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo					"<input $dsabl type=radio name='jenis_kelamin' value=P $pria>Pria &nbsp &nbsp &nbsp \n";
echo					"<input $dsabl type=radio name='jenis_kelamin' value=W $wanita>Wanita</font> </td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Jabatan</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='jabatan' value='$data[7]' size=50 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Kantor</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='kantor' value='$data[8]' size=50 maxlength=50></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>e-mail</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='emailp' value='$data[9]' size=50 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Homepage Personal</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=url name='web_personal' value='$data[10]' size=50 maxlength=60></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Homepage Kantor</font> </td>\n";
echo				  "<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=url name='web_kantor' value='$data[11]' size=50 maxlength=60></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>No.\n";
echo                "Telpon</font> </td><td width=10></td></tr></table>\n";
echo "<table width=510>\n";
echo 			"<tr><td width=25></td><td width=70><font face=Verdana size=2>Kantor</font> </td>\n";
echo 					"<td width=150><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='telp_kantor' value='$data[12]' size=17 maxlength=30></font></td>\n";
echo      		"<td width=45><font face=Verdana size=2>Ponsel</font></td>\n";
echo 					"<td width=215><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='telp_hp' value='$data[14]' size=16 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=25></td><td width=70><font face=Verdana size=2>Rumah</font> </td>\n";
echo 					"<td width=150><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='telp_rumah' value='$data[13]' size=17 maxlength=30></font></td>\n";
echo          "<td width=45><font face=Verdana size=2>Fax</font></td>\n";
echo          "<td width=215><font face=Verdana size=2>:\n";
echo                "<input $dsabl type=text name='fax' value='$data[15]' size=16 maxlength=30></font></td></tr></table>\n";
echo "<table width=510><td width=100><font face=Verdana size=2>Alamat Kantor</font> </td><td width=410 colspan=2></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>&nbsp;&nbsp;&nbsp;&nbsp;\n";
echo                "Jalan</font> </td><td width=410 colspan=2><font face=Verdana size=2>:\n";
echo								"<input $dsabl type=text name='alamat_kantor' value='$data[16]' size=50 maxlength=100></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>&nbsp;&nbsp;&nbsp;&nbsp;\n";
echo                "Kota</font> </td><td width=155><font face=Verdana size=2>:\n";
echo								"<input $dsabl type=text name='kota' value='$data[17]' size=19 maxlength=30></font></td>\n";
echo          "<td width=245><font face=Verdana size=2>Kode Pos:\n";
echo                "<input $dsabl type=text name='kode_pos' value='$data[18]' size=13 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>&nbsp;&nbsp;&nbsp;&nbsp;Propinsi</font> </td>\n";
echo          "<td width=405 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input $dsabl type=text name='propinsi' value='$data[19]' size=19 maxlength=30></font></td>\n";
echo			"<tr><td width=100><font face=Verdana size=2>&nbsp;&nbsp;&nbsp;&nbsp;Negara</font> </td>\n";
echo							 "<td width=405 colspan=2><font face=Verdana size=2>:\n";
echo							 			"<input $dsabl type=text name='negara' value='$data[20]' size=19 maxlength=30></font></td>\n";
echo			"<tr><td width=510 colspan=3> </td></tr></table>\n";

echo "<table width=510><tr><td width=100><font face=Verdana size=2>Kategori/Share</font> </td>\n";
echo 				  "<td width=10><font face=Verdana size=2>:</font></td>\n";
echo          "<td width=192><font face=Verdana size=2>\n";

//Tombol Kategori : Personal
$pilihktg1 = '';
$kategori = $data[5]; 
if ($kategori == "I")
	 {$pilihktg1 = 'checked';}
echo "<input $dsabl type=radio name='kategori' value=I $pilihktg1>Personal</font></td><td width=198></td></tr>\n";

//Tombol Kategori : Publik/Umum
$pilihktg2 = '';
if ($kategori == "P")
	 {$pilihktg2 = 'checked';}
echo "<tr><td width=100> </td><td width=10></td><td width=192><font face=Verdana size=2>\n";
echo "<input $dsabl type=radio name='kategori' value=P $pilihktg2>Publik/Umum</font></td><td width=198></td></tr>\n";

//Tombol Kategori : Unit strutural
$pilihktg3 = '';
if ($kategori == "U")
	 {$pilihktg3 = 'checked';}			
echo "<tr><td width=100> </td><td width=10></td><td width=390 colspan=2><font face=Verdana size=2>\n";
echo "<input $dsabl type=radio name='kategori' value=U $pilihktg3> Unit Struktural</font>\n";

$kdunit = $unit_pengguna;
$ktg_grup = $data[6];

//Kolom pilihan: Unit Struktural
list_akses_unit ($dbh, $kdunit, $arrunit);
$kk = 0; $ll = 0;
error_reporting(0);
$expr = "document.ubah_kontak.kategori[2].click()";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<font face=Verdana size=2><select $dsabl name='kd_unit' onChange=$expr>\n";		
		 while ($arrunit[$kk][$ll])
		 			 {
					 $tmpkdunit = $arrunit[$kk][0];
					 $nmunit = $arrunit[$kk][1];
					 $tktunt = $arrunit[$kk][2] - 1;
					 $pilihunit = '';
					 if ($kdunit == $ktg_grup) 
					 		{$pilihunit = 'selected';}
					 echo "<option $pilihunit value=".$tktunt.$tmpkdunit.">\n";
					 for ($indent = 1; $indent < $arrunit[$kk][2]; $indent++) {
					 		 echo "&nbsp;&nbsp;&nbsp;&nbsp\n";}
					 if (1 < $arrunit[$kk][2]) {echo "-\n";}			
					 echo "$nmunit</font>\n";	 
					 $kk++;
					 }
echo "</select></td></tr>\n";
					 
//Tombol Kategori: Grup Fungsional
echo "<tr><td width=100> </td><td width=10></td>\n";
echo "<td width=390 colspan=2><font face=Verdana size=2>\n";
$pilihktg4 = '';
if ($kategori == "G")
	 {$pilihktg4 = 'checked';} 
echo "<input $dsabl type=radio name=kategori value=G $pilihktg4> Grup Fungsional</font>\n";

//Kolom Pilihan: Grup Fungsional
		 $kd_pguna = $kode_pengguna;
		 $qry = "SELECT DISTINCT grup_pengguna.kode_grup, nama_grup from grup, grup_pengguna ";
		 $qry .= "where grup.kode_grup = grup_pengguna.kode_grup ";
		 if ($level<>1) {
		 		$qry .= "and grup_pengguna.kode_pengguna = $kd_pguna ";
		 }
		 $qry .= "order by nama_grup";
		 $lstgrp = mysql_query($qry, $dbh) or die ("Query gagal!");
		 $expr = "document.ubah_kontak.kategori[3].click()";
		 echo "&nbsp;&nbsp;<font face=Verdana size=2><select $dsabl name='kd_grup' onChange=$expr>\n";
		 while ($row = @mysql_fetch_row($lstgrp))
		 			 {
					 $kdgrup = $row[0];
					 $pilihgrup = '';
					 if ($kdgrup == $ktg_grup) 
					 		{$pilihgrup = 'selected';}
					 echo "<option $pilihgrup value=$kdgrup>\n";
					 echo " $row[1]</font>\n";
					 }
		mysql_close($dbh);
		echo "</select></td></tr>\n";
echo "</table>\n";

//Kolom : Keterangan
echo "<table width=510><tr><td width=510 colspan=5> </td>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Keterangan</font> </td>\n";
echo					"<td width=300><font face=Verdana size=2><textarea $dsabl name='keterangan' value='$data[21]' rows=5 cols=50></textarea></font></td></tr>\n";
echo "</table><br><br>\n";
echo "<p><font face=Verdana size=2><input type=button name=B1 value='Kembali' onclick='history.go(-1)'></font>\n";
if ($dsabl == '') {
	 echo "   <font face=Verdana size=2>&nbsp;&nbsp;<input type=submit name='modus' value='Ubah Data'>&nbsp;&nbsp;</font>\n";
	 echo "   <font face=Verdana size=2><input type=submit name='modus' value='Hapus'></font>\n";
	 }
echo "</p></form></center></div>\n";
echo "<br><br>\n";
echo "</body>\n";
echo "</html>";
?>
