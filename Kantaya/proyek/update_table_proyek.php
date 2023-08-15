<html><body> 

<?php 



$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 


// ----------------- Update Table proyek ----------------------------
echo "Update Table proyek  <br><br>";

$hasil = mysql_query("UPDATE proyek SET jenis_pelaporan='T' WHERE kode_proyek=1 OR kode_proyek=4", $db);
$hasil = mysql_query("UPDATE proyek SET jenis_pelaporan='B' WHERE kode_proyek=2 OR kode_proyek=3 OR kode_proyek=5", $db);
// -------------------------------------------------------------

echo"<br><br>Update Table selesai";


mysql_close ($db);


?> 

</body></html> 
