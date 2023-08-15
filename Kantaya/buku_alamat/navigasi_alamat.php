<?php
session_start();
echo "<html>";
echo "<head>";
echo "<title>Navigasi Buku Alamat</title>";
include('../lib/koneksi_db.inc');
require ("../lib/akses_unit.php");

echo "</head>";
echo "<body>";
echo "<table border=0 width=100%>";
#echo "<tr><td width=100% colspan=10>&nbsp;</td></tr>";
echo "<tr><td width=100% colspan=10 bgcolor='#225F95'><font face=Verdana color='white' size=2><b>Kategori Koresponden</b></font></td></tr>";
#echo "<tr><td width=100% colspan=10>&nbsp;</td></tr>";
echo "<tr><td width=100% colspan=10><font face=Verdana size=2><a target=alamat href=alamat.php?kategori=I>Personal</a></font></td></tr>";
echo "<tr><td width=100% colspan=10><font face=Verdana size=2><a target=alamat href=alamat.php?kategori=P>Publik/Umum</a></font></td></tr>";
echo "<tr><td width=100% colspan=10></td></tr>";
echo "<tr><td width=100% colspan=10><font face=Verdana size=2>Unit Struktural:</font></td></tr>";
$kdunit = $unit_pengguna;
list_akses_unit ($dbh, $kdunit, $arrunit);
$kk = 1; $ll = 0;
error_reporting(0);
#echo "<tr>";
		 while ($arrunit[$kk][$ll])
		 			 {
					 echo "<tr>";
					 for ($indent = 0; $indent < $arrunit[$kk][2]; $indent++) {
					 echo "<td width=5%></td>";}
					 $pct = (100 - 2*$arrunit[$kk][2])."%";
					 $spn = 10 - $arrunit[$kk][2];
					 $tkt = $arrunit[$kk][2] - 1;
					 $tmpkdunit = $arrunit[$kk][0];
					 $tmpnmunit = $arrunit[$kk][1];
					 echo "<td width=$pct colspan=$spn><font face=Verdana size=1><a href=alamat.php?kategori=U&tingkat=$tkt&ktg_grup=$tmpkdunit target=alamat>$tmpnmunit</a></font><td></tr>";
					 $kk++;
					 }
echo "</tr>";
echo "<tr><td width=100% colspan=10></td></tr>";
echo "<tr><td width=100% colspan=10><font face=Verdana size=2>Grup Fungsional:</font></td></tr>";
		 $qry = "SELECT grup_pengguna.kode_grup, nama_grup from grup, grup_pengguna ";
		 $qry .= "where grup_pengguna.kode_pengguna = $kode_pengguna ";
		 $qry .= "and grup.kode_grup = grup_pengguna.kode_grup ";
		 $lstgrp = mysql_query($qry, $dbh) or die ("Query gagal!");
		 while ($row = @mysql_fetch_row($lstgrp))
		 			 {
					 $kdgrup = $row[0];
					 echo "<tr><td width=5%><td width=5%><td width=5%></td><td colspan=7><font face=Verdana size=1>";
					 echo "<a href=alamat.php?kategori=G&ktg_grup=$row[0] target=alamat>$row[1]</a></font></td></tr>";
					 }
		mysql_close();
echo "<tr><td width=100% colspan=10></td></tr>";
echo "</table>";
echo "</body>";
echo "</html>";
?>