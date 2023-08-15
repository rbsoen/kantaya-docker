<?php
/***********************************************************************
Nama File : profile_warna.php
Fungsi    : Form pemilihan warna tampilan
Dibuat    :
Tgl.      : 18-11-2001
Oleh      : FB

Revisi 1  :
Tgl.      :
Oleh      :
Revisi    :
***********************************************************************/
include ('../lib/cek_sesi.inc');
include('../lib/fs_umum.php');
require("../lib/kantaya_cfg.php");
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$pilihan_css[0][0] = 'kantaya_biru';    $pilihan_css[0][1] = 'Kantaya Biru';
$pilihan_css[1][0] = 'kantaya_hijau';   $pilihan_css[1][1] = 'Kantaya Hijau';
$pilihan_css[2][0] = 'kantaya_krem';    $pilihan_css[2][1] = 'Kantaya Krem';
$pilihan_css[3][0] = 'kantaya_pink';    $pilihan_css[3][1] = 'Kantaya Pink';
$pilihan_css[4][0] = 'kantaya_putih';   $pilihan_css[4][1] = 'Kantaya Putih';
$pilihan_css[5][0] = 'kantaya_klasik';  $pilihan_css[5][1] = 'Kantaya Klasik';
$pilihan_css[6][0] = 'kantaya_lembut';  $pilihan_css[6][1] = 'Kantaya Lembut';
$pilihan_css[7][0] = 'kantaya_embun';   $pilihan_css[7][1] = 'Kantaya Embun';

echo "<html>\n";
echo "<head>\n";
echo "<title>Pilihan Warna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "</head>\n";
echo "<body>\n";

if ($tampilan == '') {
    pilih_tampilan();
} else {
    update_tampilan($tampilan);
}

echo "</body>\n";
echo "</html>\n";

function pilih_tampilan() {
    global $pilihan_css;
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul1' width='100%'>Pilihan Warna</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='100%'>&nbsp;</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='100%'>Anda dapat melakukan pilihan warna yang tersedia dibawah ini
         untuk melakukan pengubahan terhadap tampilan aplikasi anda secara personal.</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "<p>\n";

    echo "<form name='pilihwarna' method='post' action='profile_warna.php' target='isi'>\n";
    echo "<table width='100%' border=0>\n";
		
    echo "<tr>\n";
    echo "<td width='50%'>\n";
         contoh_tampilan_css('#eeeeee','#eeeeee','#eeeeee','#225F95','#CCCCFF','#eeeeee');
         echo "<center><input type='radio' name='tampilan' value=0>".$pilihan_css[0][1]."</center>\n";
    echo "</td>\n";
    echo "<td width='50%'>\n";
         contoh_tampilan_css('#ccffcc','#ccffcc','#ccffcc','#006633','#009900','#ccffcc');
         echo "<center><input type='radio' name='tampilan' value=1>".$pilihan_css[1][1]."</center>\n";
    echo "</td>\n";
    echo "</tr>\n";
		
    echo "<tr>\n";
    echo "<td width='50%'>\n";
         contoh_tampilan_css('#ffffcc','#ffffcc','#ffffcc','#996633','#CC9900','#ffffcc');
         echo "<center><input type='radio' name='tampilan' value=2>".$pilihan_css[2][1]."</center>\n";
    echo "</td>\n";
    echo "<td width='50%'>\n";
         contoh_tampilan_css('#ffccff','#ffccff','#ffccff','#ff0033','#ff3399','#ffccff');
         echo "<center><input type='radio' name='tampilan' value=3>".$pilihan_css[3][1]."</center>\n";
    echo "</td>\n";
    echo "</tr>\n";
		
		echo "<tr>\n";
    echo "<td width='50%'>\n";
         contoh_tampilan_css('#ffffff','#ffffff','#ffffff','#000000','#808080','#ffffff');
         echo "<center><input type='radio' name='tampilan' value=4>".$pilihan_css[4][1]."</center>\n";
    echo "</td>\n";
    echo "<td width='50%'>\n";
         contoh_tampilan_css('#ffffcc','ffffcc','#ffffcc','#225F95','#6699cc','#ffffcc');
         echo "<center><input type='radio' name='tampilan' value=5>".$pilihan_css[5][1]."</center>\n";
    echo "</td>\n";
    echo "</tr>\n";
		
		echo "<tr>\n";
    echo "<td width='50%'>\n";
         contoh_tampilan_css('#F0FAFF','#F0FAFF','#F0FAFF','#00025E','#A3A3E0','#F0FAFF');
         echo "<center><input type='radio' name='tampilan' value=6>".$pilihan_css[6][1]."</center>\n";
    echo "</td>\n";
    echo "<td width='50%'>\n";
         contoh_tampilan_css('#ffffff','#ffffff','#ffffff','#009966','#99CC99','#ffffff');
         echo "<center><input type='radio' name='tampilan' value=7>".$pilihan_css[7][1]."</center>\n";
    echo "</td>\n";
    echo "</tr>\n";		
		
		
    echo "<tr>\n";
    echo "<td colspan=2 align='center'><br><input type=submit name=submit value='Ubah Warna Tampilan'></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}

function update_tampilan($tampilan) {
    global $db, $pilihan_css, $kode_pengguna;
    $sqltext = "update pengguna set tampilan_css='".$pilihan_css[$tampilan][0]."' where kode_pengguna='$kode_pengguna'\n";
    $hasil = mysql_query($sqltext, $db);
    check_mysql_error(mysql_errno(),mysql_error());

    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul1' width='100%'>Konfirmasi Pilihan Warna</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='100%'>&nbsp;</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='100%'>Anda telah memilih <b>".$pilihan_css[$tampilan][1]."</b>
         sebagai warna tampilan aplikasi anda. Silakan terlebih dahulu <b>Keluar/Logoff</b> dan <b>Masuk/Login</b> kembali untuk melihat perubahannya.<p> Untuk merubahnya anda dapat kembali kebagian
         pemilihan warna tampilan.</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "<p>\n";
}


function contoh_tampilan_css($wkepala,$wnavig,$wisi,$wjudul1,$wjudul2,$wisitable) {
    echo "&nbsp\n";
    echo "<table width='100%' border=1>\n";
    echo "<tr>\n";
    echo "<td bgcolor='$wkepala' colspan=2 height=40>&nbsp</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td bgcolor='$wnavig' width='40%'>\n";
         echo "<table width='100%' border=1>\n";
         echo "<tr>\n";
         echo "<td bgcolor='$wjudul1' width='100%'>&nbsp</td>\n";
         echo "</tr>\n";
         echo "<tr>\n";
         echo "<td bgcolor='$wisitable' height='70'>&nbsp</td>\n";
         echo "</tr>\n";
         echo "</table><p>\n";
         echo "<table width='100%' border=1>\n";
         echo "<tr>\n";
         echo "<td bgcolor='$wjudul1' width='100%'>&nbsp</td>\n";
         echo "</tr>\n";
         echo "<tr>\n";
         echo "<td bgcolor='$wisitable' height='30'>&nbsp</td>\n";
         echo "</tr>\n";
         echo "</table><p>\n";
    echo "</td>\n";
    echo "<td bgcolor='$wisi' width='60%' valign='top'>\n";
         echo "<table width='100%' border=1>\n";
         echo "<tr>\n";
         echo "<td bgcolor='$wjudul1' width='100%'>&nbsp</td>\n";
         echo "</tr>\n";
         echo "</table><p>\n";
         echo "<table width='100%' border=1>\n";
         echo "<tr>\n";
         echo "<td bgcolor='$wjudul2' width='100%'>&nbsp</td>\n";
         echo "</tr>\n";
         echo "<tr>\n";
         echo "<td bgcolor='$wisitable' width='100%' height='100'>&nbsp</td>\n";
         echo "</tr>\n";
         echo "</table><p>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
}





