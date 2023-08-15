<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
require ("../lib/akses_unit.php");
$css = "../css/".$tampilan_css.".css";

echo "<html><head>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "</head>\n";
echo "<body>\n";
echo			"<div><center>\n";
echo			"<FORM NAME=dataktk METHOD=POST ACTION='olah_data_kontak.php'>\n";
echo "  <table border=0 width=100%>\n";
echo "    <tr>\n";
echo "      <td colspan=4 class=judul1>\n";
echo "        <p>Penambahan Koresponden</p></td>\n";
echo "    </tr></table>\n";
echo "<table width=510>\n";
echo			"<input type=hidden name=kontak_id value=NULL>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Nama</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:<input type=text name='nama' size=50 maxlength=60></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Gelar Depan</font> </td>\n";
echo					"<td width=125><font face=Verdana size=2>:<input type=text name='gelar_dpn' size=10 maxlength=20></font></td>\n";
echo          "<td width=285><font face=Verdana size=2>Gelar \n";
echo                "Belakang :<input type=text name='gelar_blk' size=9 maxlength=10></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Jenis kelamin</font></td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo 							 "<input type=radio name='jenis_kelamin' value=P>Pria &nbsp &nbsp &nbsp \n";
echo							 "<input type=radio name='jenis_kelamin' value=W>Wanita</font> </td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Jabatan</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input type=text name='jabatan' size=50 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Kantor</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input type=text name='kantor' size=50 maxlength=50></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>e-mail</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input type=text name='emailp' size=50 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Homepage Personal</font> </td>\n";
echo					"<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input type=url name='web_personal' size=50 maxlength=60></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Homepage Kantor</font> </td>\n";
echo				  "<td width=410 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input type=url name='web_kantor' size=50 maxlength=60></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>No.\n";
echo                "Telpon</font> </td><td width=10></td></tr></table>\n";
echo "<table width=510>\n";
echo 			"<tr><td width=25></td><td width=70><font face=Verdana size=2>Kantor</font> </td>\n";
echo 					"<td width=150><font face=Verdana size=2>:\n";
echo							 "<input type=text name='telp_kantor' size=17 maxlength=30></font></td>\n";
echo      		"<td width=45><font face=Verdana size=2>Ponsel</font></td>\n";
echo 					"<td width=215><font face=Verdana size=2>:\n";
echo							 "<input type=text name='telp_hp' size=16 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=25></td><td width=70><font face=Verdana size=2>Rumah</font> </td>\n";
echo 					"<td width=150><font face=Verdana size=2>:\n";
echo							 "<input type=text name='telp_rumah' size=17 maxlength=30></font></td>\n";
echo          "<td width=45><font face=Verdana size=2>Fax</font></td>\n";
echo          "<td width=215><font face=Verdana size=2>:\n";
echo							 "<input type=text name='fax' size=16 maxlength=30></font></td></tr></table>\n";
echo "<table width=510><td width=100><font face=Verdana size=2>Alamat Kantor</font> </td><td width=410 colspan=2></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>&nbsp;&nbsp;&nbsp;&nbsp;\n";
echo                "Jalan</font> </td><td width=410 colspan=2><font face=Verdana size=2>:\n";
echo								"<input type=text name='alamat_kantor' size=50 maxlength=100></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>&nbsp;&nbsp;&nbsp;&nbsp;\n";
echo                "Kota</font> </td><td width=155><font face=Verdana size=2>:\n";
echo								"<input type=text name='kota' size=19 maxlength=30></font></td>\n";
echo          "<td width=245><font face=Verdana size=2>Kode Pos:\n";
echo                "<input type=text name='kode_pos' size=13 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>&nbsp;&nbsp;&nbsp;&nbsp;Propinsi</font> </td>\n";
echo          "<td width=405 colspan=2><font face=Verdana size=2>:\n";
echo							 "<input type=text name='propinsi' size=19 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=100><font face=Verdana size=2>&nbsp;&nbsp;&nbsp;&nbsp;Negara</font> </td>\n";
echo							 "<td width=405 colspan=2><font face=Verdana size=2>:\n";
echo							 			"<input type=text name='negara' size=19 maxlength=30></font></td></tr>\n";
echo			"<tr><td width=510 colspan=3> </td></tr></table>\n";

echo "<table width=510><tr><td width=100><font face=Verdana size=2>Kategori/Share</font> </td>\n";
echo 				  "<td width=10><font face=Verdana size=2>:</font></td>\n";
echo          "<td width=192><font face=Verdana size=2>\n";

//Tombol Kategori : Personal
$pilihktg1 = '';
if ($kategori == "I")
	 {$pilihktg1 = 'checked';}
echo "<input type=radio name='kategori' value=I $pilihktg1>Personal</font></td><td width=198></td></tr>\n";

//Tombol Kategori : Publik/Umum
$pilihktg2 = '';
if ($kategori == "P")
	 {$pilihktg2 = 'checked';}
echo "<tr><td width=100> </td><td width=10></td><td width=192><font face=Verdana size=2>\n";
echo "<input type=radio name='kategori' value=P $pilihktg2>Publik/Umum</font></td><td width=198></td></tr>\n";

//Tombol Kategori : Unit strutural
$pilihktg3 = '';
if ($kategori == "U")
	 {$pilihktg3 = 'checked';}			
echo "<tr><td width=100> </td><td width=10></td><td width=390 colspan=2><font face=Verdana size=2>\n";
echo "<input type=radio name='kategori' value=U $pilihktg3> Unit Struktural</font>\n";

//Kolom pilihan: Unit Struktural
$kdunit = $unit_pengguna;
list_akses_unit ($dbh, $kdunit, $arrunit);
$kk = 0; $ll = 0;
error_reporting(0);
$expr = "document.dataktk.kategori[2].click()";
echo "&nbsp;&nbsp;&nbsp;&nbsp;<font face=Verdana size=2><select name='kd_unit' onChange=$expr>\n";		
		 while ($arrunit[$kk][$ll])
		 			 {
					 $tmpkdunit = $arrunit[$kk][0];
					 $nmunit = $arrunit[$kk][1];
					 $tktunt = $arrunit[$kk][2] - 1;
					 $pilihunit = '';
					 if ($tmpkdunit == $ktg_grup) 
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
echo "<input type=radio name=kategori value=G $pilihktg4> Grup Fungsional</font>\n";

//Kolom Pilihan: Grup Fungsional
		 $kd_pguna = $kode_pengguna;
		 $qry = "SELECT DISTINCT grup_pengguna.kode_grup, nama_grup from grup, grup_pengguna ";
		 $qry .= "where grup.kode_grup = grup_pengguna.kode_grup ";
		 if ($level<>1) {
		 		$qry .= "and grup_pengguna.kode_pengguna = $kd_pguna ";
		 }
		 $qry .= "order by nama_grup";
		 $lstgrp = mysql_query($qry, $dbh) or die ("Query gagal!");
		 $expr = "document.dataktk.kategori[3].click()";
		 echo "&nbsp;&nbsp;<font face=Verdana size=2><select name='kd_grup' onChange=$expr>\n";
		 while ($row = @mysql_fetch_row($lstgrp))
		 			 {
					 $kdgrup = $row[0];
					 $pilihgrup = '';
					 if ($kdgrup == $ktg_grup) 
					 		{$pilihgrup = 'selected';}
					 echo "<option $pilihgrup value=$kdgrup>\n";
					 echo " $row[1]</font>\n";
					 }
		mysql_close();
		echo "</select></td></tr>\n";
echo "</table>\n";

//Kolom : Keterangan
echo "<table width=510><tr><td width=510 colspan=5> </td>\n";
echo			"<tr><td width=100><font face=Verdana size=2>Keterangan</font> </td>\n";
echo					"<td width=300><font face=Verdana size=2><textarea name='keterangan' rows=5 cols=50></textarea></font></td></tr>\n";
echo "</table><br><br>\n";
echo "<p><font face=Verdana size=2><input type=button name=B1 value='Kembali' onclick='history.go(-1)'></font>\n";
echo "   <font face=Verdana size=2>&nbsp;&nbsp;<input type=submit name=modus value='Simpan'></font>\n";
echo "</p><br><br>\n";
echo "</form></center></div>\n";

echo "</body>\n";
echo "</html>";
?>
