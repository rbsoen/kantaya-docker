<?php
/******************************************
Nama File : navigasi_timesheet.php
Fungsi    : Navigasi Time Sheet Proyek.
Dibuat    :	
 Tgl.     : 07-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   : 

******************************************/

include ('../lib/cek_sesi.inc');
include('../lib/akses_unit.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";


$tgl_ini = date("j");
$bln_ini = date("n");
$thn_ini = date("Y");

echo"<html>\n";
echo "<head>\n";
echo "<title>Navigasi Modul Proyek : Time Sheet</title>\n";
echo "<link rel=stylesheet type='text/css' href='".$css."'>";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>";
?>

<script language="JavaScript">
<!--

function daftartimesheet(tgl_ini, bln_ini, thn_ini) {
	window.open("isi_timesheet.php?ptgl="+tgl_ini+"&pbln="+bln_ini+"&pthn="+thn_ini, "isi");
}

/*
function ambilkodeproyekaktif() {
	paktif = document.nav_timesheet.proyek_aktif;
	var p_aktif = paktif.options[paktif.selectedIndex].value;
	window.open("navigasi_timesheet.php?proyek_aktif="+p_aktif+"&proyek_nonaktif=0", "navigasi");
};

function ambilkodeproyeknonaktif() {
	pnonaktif = document.nav_timesheet.proyek_nonaktif;
	var p_nonaktif = pnonaktif.options[pnonaktif.selectedIndex].value;
	window.open("navigasi_timesheet.php?proyek_nonaktif="+p_nonaktif+"&proyek_aktif=0", "navigasi");
};
*/

function ambilkodeproyekaktif1(fld) {
  pnonaktif = document.nav_timesheet.proyek_nonaktif;
  if (fld.options[fld.options.selectedIndex].value != 0) {
	  pnonaktif.options.selectedIndex = 0;
	}		
};

function ambilkodeproyeknonaktif1(fld) {
  paktif = document.nav_timesheet.proyek_aktif;
  if (fld.options[fld.options.selectedIndex].value != 0) {
	  paktif.options.selectedIndex = 0;
	}		
};


// -->
</script>

<?php

echo "</head>\n";
echo "<body>\n";
echo "
<form name='nav_timesheet' method=post action='timesheet.php' target='isi'>
<table width='100%' Border='0'>
			 <tr>
			 		 <td class='judul1' align='left' colspan=3><b>Rekapitulasi Proyek</b></td>
			 </tr>
			 <tr>
			 		 <td width='40%'>Aktif</td><td width=2% > : </td>
			 		 <td class='isi1'>
";
if ($proyek_aktif) {
	$hsl_p_proy_aktif = mysql_query("SELECT kode_proyek, singkatan, nama_proyek FROM proyek WHERE kode_proyek='$proyek_aktif'", $db) or mysql_error();
	$nama_p_proyek_aktif = mysql_result($hsl_p_proy_aktif,0,"singkatan");
}	
echo "					 
								 <select name='proyek_aktif' onChange=ambilkodeproyekaktif1(this)>
";

if ($proyek_aktif<>0) {
	 echo "								 <option selected value=".$proyek_aktif.">".$nama_p_proyek_aktif."</option>";
} else {
	echo "				 				 <option selected value=0>Pilih Proyek</option>";	
} 

	$hsl_proy_aktif = mysql_query("SELECT kode_proyek, singkatan, nama_proyek FROM proyek WHERE status='1'", $db) or mysql_error();
	while ($baris=mysql_fetch_array($hsl_proy_aktif)) {
				echo "<option value=".$baris["kode_proyek"].">".$baris["singkatan"]."</option>";
	}
	mysql_free_result ($hsl_proy_aktif);
echo "	
							 </select>
						</td>
			 </tr>
			 <tr>
			 		 <td  width='40%'>Non Aktif</td><td width=2% > : </td>
			 		 <td class='isi1'>
";
if ($proyek_nonaktif) {
	$hsl_p_proy_nonaktif = mysql_query("SELECT kode_proyek, singkatan, nama_proyek FROM proyek WHERE kode_proyek='$proyek_nonaktif'", $db) or mysql_error();
	$nama_p_proyek_nonaktif = mysql_result($hsl_p_proy_nonaktif,0,"singkatan");
}	
echo "					 
								 <select name='proyek_nonaktif' onChange=\"ambilkodeproyeknonaktif1(this)\">
";

if ($proyek_nonaktif<>0) {
	 echo "								 <option selected value=".$proyek_nonaktif.">".$nama_p_proyek_nonaktif."</option>";
} else {
	echo "				 				 <option selected value=0>Pilih Proyek</option>";	
} 

	$hsl_proy_nonaktif = mysql_query("SELECT kode_proyek, singkatan, nama_proyek FROM proyek WHERE status='0'", $db) or mysql_error();
	while ($baris=mysql_fetch_array($hsl_proy_nonaktif)) {
				echo "<option value=".$baris["kode_proyek"].">".$baris["singkatan"]."</option>";
	}
	mysql_free_result ($hsl_proy_nonaktif);
echo "	
							 </select>
						</td>
			 </tr>

			  			 
			 <tr>
			 		 <td>&nbsp;</td>
			 </tr>		
			 <tr>
			 		 <td width=30% ></td><td colspan=2><input type=submit name=psubmit value='Lihat'></td>
			 </tr>				
			 <tr>
			 		 <td>&nbsp;</td>
			 </tr>				 
			 <tr>
			 		 <td class='judul1' align='left' colspan=3><b>Isi Time Sheet</b></td>
			 </tr>			 
			 <tr>
			 		 <td colspan=3><a href=\"javascript:daftartimesheet('$tgl_ini','$bln_ini','$thn_ini')\">Detail Pengisian</a></td> 
			 </tr>		
			  		 	  
</table>
</form>
";

echo "</body>\n";
echo "</html>\n";

?>


