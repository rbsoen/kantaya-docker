<?php
/**********************************************
Nama File : alert_hapus_proyek.php
Fungsi    : Alert/konfirmasi utk. hapus proyek
Dibuat    :	
 Tgl.     : 19-11-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

**********************************************/


include ('../lib/cek_sesi.inc');  
require("../lib/kantaya_cfg.php");
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$qry = mysql_query("SELECT nama_proyek FROM proyek WHERE kode_proyek='$pkode'", $db);
$namaproyek = mysql_result($qry,0,"nama_proyek");

echo "
<html>
<head>
<title>Alert Hapus Proyek</title>
";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
?>

<SCRIPT LANGUAGE='JavaScript'>
<!--

function ya_hapus(kode) {
   window.open("hapus_proyek.php?pkode="+kode, "New", "width=300,height=350");	 
   window.close();
}

function tidak_hapus() {
   window.close();
}

// -->
</SCRIPT>

<?php
echo "
</head>
<body bgcolor=pink text=#000000>
<form name=alerthapus>
<table width=100% Border=0>
  <tr bgcolor=red>
    <td class=judul2 colspan=2 align=center>Konfirmasi</td>
  </tr>
	<tr>
    <td colspan=2>&nbsp;</td>
  </tr>	
	<tr>
    <td colspan=2><font size=2>Proyek <b>".$namaproyek."</b></font></td>
  </tr>
	<tr>
    <td colspan=2><font size=2>benar-benar akan dihapus?</font></td>
  </tr>	
	<tr height=100>
    <td align=right><input type=button name=hapus value=Ya onclick=\"javascript:ya_hapus('$pkode')\"></td>
    <td align=center><input type=button name=hapus value=Tidak onclick=\"javascript:tidak_hapus()\"></td>
  </tr>	
</table>
</form>

</body>
</html>
";

