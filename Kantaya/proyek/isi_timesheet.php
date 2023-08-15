<?php
/******************************************
Nama File : isi_timesheet.php
Fungsi    : Form untuk mengisi time sheet.
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

if (!isset($ptgl)) {
	 $ptgl = date("j");
}
if (!isset($pbln)) {
	 $pbln = date("n");
}
if (!isset($pthn)) {
	 $pthn = date("Y");
}
echo "<html>\n";
echo "<head>\n";
echo "<title>Time Sheet</title>\n";
echo "<link rel=stylesheet type='text/css' href='".$css."'>";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>";
?>

<script language="JavaScript">
<!--
function showCldList(fld, dflt, range) {
  window.open("/lib/kalender.php?pfld="+fld+"&pdflt="+dflt+"&prange="+range, "List", "width=270,height=180");
};

function ambilkodeproyek() {
				 document.timesheet.action = 'isi_timesheet.php';
				 document.timesheet.submit();
};

// -->
</script>

<?php
echo "</head>\n";
echo "<body>\n";

echo "
<form name=timesheet method=post action='detail_timesheet.php'>
<table width='100%' Border='0'>
	<tr>
			<td class='judul1' align='left' colspan=5><b>Isi Time Sheet</b></td>
	</tr>

	<tr><td><font size=2>Tanggal </font></td>
	    <td><font size=2> : </font></td>
	    <td colspan=3>
		<select name=ptgl>
		  			<option selected value=".$ptgl.">".$ptgl;

			for ($i=1; $i<=31; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
		<select name=pbln>
						<option selected value=".$pbln.">".namabulan("S", $pbln);
			for ($i=1; $i<=12; $i++) {
				$nmbln = namabulan("S", $i);
echo"				<option value=".$i.">".$nmbln;
			}
echo"
		</select>
		<select name=pthn>
		  			<option selected value=".$pthn.">".$pthn;		
			for ($i=2001; $i<=2002; $i++) {
echo"				<option value=".$i.">".$i;
			}
echo"
		</select>
";
?>

<?php
		$range = date('Y').",".(date('Y')+1);
		$tglsaatini = date('j')."/".date('n')."/".date('Y');
?>
		 <a href="javascript:showCldList('timesheet,ptgl,pbln,pthn','<?=$tglsaatini?>','<?=$range?>')"><font size=1><img border=0 width=17 height=18 src=cld.gif></font></a> 
<?php
echo"
	    </td>
	</tr>
	<tr><td width=115><font size=2>Jumlah Jam</font><font color=red size=2> *</font></td>
	    <td><font size=2> : </font></td>
	    <td><input witdh=20 size=4 align=right name=ptotaljam value=".$ptotaljam."></td>
	</tr>	
	<tr>
		<td>dibebankan ke :</td>
	</tr>
	<tr>
				<td>Proyek<font color=red size=2> *</font></td>		
				<td width=2% >:</td>						 		 
				<td colspan=2>
	 					 		 <select name='proyek' onChange='ambilkodeproyek()'>
";

if ($proyek==0) {
	 echo "				 				 <option selected value=0>Pilih Proyek</option>	";
} else {
	$hsl_singkatan = mysql_query("SELECT nama_proyek FROM proyek WHERE kode_proyek='$proyek'", $db) or mysql_error();
	$singkatanproyek = mysql_result($hsl_singkatan,0,"nama_proyek");
	echo "								 <option selected value=".$proyek.">".$singkatanproyek."</option>	";
	mysql_free_result ($hsl_singkatan);
}

	$hsl_proyek = mysql_query("SELECT kode_proyek FROM personil_proyek WHERE kode_pengguna='$kode_pengguna'", $db) or mysql_error();
	while ($baris=mysql_fetch_array($hsl_proyek)) {
				$kodeproyek = $baris["kode_proyek"];
				$hsl_singkatan = mysql_query("SELECT nama_proyek FROM proyek WHERE kode_proyek='$kodeproyek'", $db) or mysql_error();
				$singkatanproyek = mysql_result($hsl_singkatan,0,"nama_proyek");
				if ($kodeproyek <> $proyek) {				
			    echo "<option value=".$kodeproyek.">".$singkatanproyek."</option>";
				}
				mysql_free_result ($hsl_singkatan); 
	}
	mysql_free_result ($hsl_proyek);
echo "	
							 </select>
				</td>
	</tr>	
	<tr>
				<td>Kegiatan<font color=red size=2> *</font></td>
				<td width=2% >:</td>				
				<td colspan=2>
	 					 		 <select name='kegiatan'>
								 				 <option selected value=0>Pilih Kegiatan</option>				 
";
	$hsl_kegiatan = mysql_query("SELECT no_kegiatan FROM penugasan_personil WHERE kode_proyek='$proyek' AND kode_pengguna='$kode_pengguna'", $db) or mysql_error();
	while ($baris=mysql_fetch_array($hsl_kegiatan)) {
				$nokegiatan = $baris["no_kegiatan"];
				$hsl_namakegiatan = mysql_query("SELECT nama_kegiatan FROM jadwal_proyek WHERE no_kegiatan='$nokegiatan'", $db) or mysql_error();
				$namakegiatan = mysql_result($hsl_namakegiatan,0,"nama_kegiatan");
		    echo "<option value=".$nokegiatan.">".$namakegiatan."</option>";
				mysql_free_result ($hsl_namakegiatan);
	}
	mysql_free_result ($hsl_kegiatan);
echo "	
							 </select>
				</td>
	</tr>
	<tr>
  	<td>&nbsp;</td>
	</tr>	
	<tr>
		<td  colspan=2>&nbsp;</td>
		<td><input type=submit name=psubmit value='Simpan'></td>
		<td>&nbsp;</td>		
	</tr>
	<tr>
  	<td>&nbsp;</td>
	</tr>		
	<tr>
  	<td colspan=5><font size=2><b>Ket. :</b></font><font color=red size=2> * </font><font size=2>= Wajib diisi.</font></td>
	</tr>	
</table>
</form>
";


echo "</body>\n";
echo "</html>\n";

?>



