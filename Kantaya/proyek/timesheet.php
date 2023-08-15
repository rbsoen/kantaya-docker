<?php
/******************************************
Nama File : timesheet.php
Fungsi    : Tampilan time sheet semua
            personil dalam satu proyek.
Dibuat    :	
 Tgl.     : 07-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   : 

******************************************/

include ('../lib/cek_sesi.inc');
include ('../lib/akses_unit.php');
include ('../lib/fs_kalender.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

$tglkegiatan = $pthn."-".$pbln."-".$ptgl;
$tgldibuat = date("Y-m-d H:i:s");
$tgldiubah = date("Y-m-d H:i:s");

if ($psubmit=="Lihat") {
	 if ($proyek_aktif<>0) 				 { $proyek = $proyek_aktif; }
 	 if ($proyek_nonaktif<>0) 		 { $proyek = $proyek_nonaktif; }
}

echo "<html>\n";
echo "<head>\n";
echo "<title>Daftar Time Sheet</title>\n";
echo "<link rel=stylesheet type='text/css' href='".$css."'>";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>";
echo "</head>\n";
echo "<body>\n";

$hsl_proyek = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran FROM proyek WHERE kode_proyek='$proyek'", $db) or mysql_error();
while ($baris=mysql_fetch_array($hsl_proyek)) {
			$noproyek = $baris["no_proyek"];
			$namaproyek = $baris["nama_proyek"];
			$thnanggaran = $baris["tahun_anggaran"];		
}
mysql_free_result ($hsl_proyek);
	
if ($proyek_aktif==0 AND $proyek_nonaktif==0) {  
				 $noproyek = "Proyek belum dipilih";
				 $namaproyek = "Proyek belum dipilih";
				 $thnanggaran = "-";				  
}
	
echo "
<table width='100%' Border='0'>
	<tr>
			<td class='judul1' align='left' colspan=13><b>Daftar Time Sheet Semua Personil Proyek</b></td>
	</tr>
	<tr>
			<td width=20% >No. Proyek</td><td colspan=12> : ".$noproyek."</td>
	</tr>		
	<tr>
			<td width=20% >Nama Proyek</td><td colspan=12> : ".$namaproyek."</td>
	</tr>
	<tr>
			<td width=20% >Tahun</td><td  colspan=12> : ".$thnanggaran."</td>
	</tr>
	<tr>
			<td width=20% >Satuan</td><td colspan=12> : Jam</td>
	</tr>
	<tr>
			<td>&nbsp;</td>
	</tr>	
	<tr>
			<td class='judul2'>Personil</td>
";
for ($i=1; $i<=12; $i++) {
		echo "<td class='judul2' width=10% align=center>".namabulan("S",$i)."</td>";
}
echo "			
	</tr>	
	<tr>
";
$hsl_timesheet = mysql_query("SELECT kode_personil, total_jam, tgl_kegiatan FROM timesheet_proyek WHERE kode_proyek='$proyek'", $db) or mysql_error();
while ($baris=mysql_fetch_array($hsl_timesheet)) {
			$personil = $baris["kode_personil"];
			$totaljam = $baris["total_jam"];
			$bulan_kegiatan = substr($baris["tgl_kegiatan"],5,2);
			if ($bulan_kegiatan[0]==0) { $bulan_kegiatan = $bulan_kegiatan[1]; }
			$totaljam_bulan[$personil][$bulan_kegiatan] = $totaljam_bulan[$personil][$bulan_kegiatan] + $totaljam;
}	
mysql_free_result ($hsl_timesheet);

$hsl_personil = mysql_query("SELECT DISTINCT kode_personil FROM timesheet_proyek WHERE kode_proyek='$proyek'", $db) or mysql_error();
while ($baris=mysql_fetch_array($hsl_personil)) {
			$personil = $baris["kode_personil"];
			$hsl_namapersonil = mysql_query("SELECT nama_pengguna FROM pengguna WHERE kode_pengguna='$personil'", $db) or mysql_error();
			$namapersonil = mysql_result($hsl_namapersonil,0,"nama_pengguna");
			echo "<tr><td class='isi2'><a href=\"detail_timesheet.php?proyek=$proyek&kodepersonil=$personil\">".$namapersonil."</a></td>";
			for ($i=1; $i<=12; $i++) {
					if ($totaljam_bulan[$personil][$i] < 1) { $totaljam_bulan[$personil][$i] = 0; }
					echo "<td class='isi2' align=right>".$totaljam_bulan[$personil][$i]."</td>";
			}
			mysql_free_result ($hsl_namapersonil);
			echo "</tr>";
}	
mysql_free_result ($hsl_personil);
echo "
</table>
";

$psubmit=="";
echo "</body>\n";
echo "</html>\n";

?>



