<?php
/******************************************
Nama File : frame_submenu.php
Fungsi    : Mengatur frame utama 
            modul Proyek untuk 3 Submenu.
Dibuat    :	
 Tgl.     : 02-10-2001
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 07-10-2001
 Oleh     : AS
 Revisi   : Link ke 3 Submenu ke 2 frame.

******************************************/

include ('../lib/cek_sesi.inc');  

$css = "../css/".$tampilan_css.".css";
?>

<script language="JavaScript">
<!--

function list_proyek() {
	window.open("navigasi.php", "navigasi");
	window.open("list_proyek.php", "isi");
}

function timesheet() {
	window.open("navigasi_timesheet.php", "navigasi");
	window.open("isi_timesheet.php", "isi");
}

function pemakaian_personil() {
	window.open("navigasi_pemakaian_personil.php", "navigasi");
	window.open("pemakaian_personil.php", "isi");
}

// -->
</script>


<?php
echo "<html>\n";
echo "<head>\n";
echo "<title>Menu Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "</head>\n";
echo "<body>\n";
echo "<table width=100% border = 0>\n";
echo "<tr align=center>\n";
echo "<td width=20%><a href=\"javascript:list_proyek()\">List Proyek</a></td>\n";
echo "<td width=20%><a href=\"javascript:timesheet()\">Time Sheet</a></td>\n";
echo "<td width=20%><a href=\"javascript:pemakaian_personil()\">Pemakaian Personil</a></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</body>\n";
echo "</html>\n";


?>



