<html><body> 

<?php 



$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 


// ----------------- Alter Table proyek ----------------------------
echo "Alter Table proyek  <br><br>";

//$hasil = mysql_query("ALTER TABLE proyek ADD jenis_pelaporan CHAR(1) NOT NULL", $db);

$hasil = mysql_query("ALTER TABLE proyek CHANGE singkatan singkatan VARCHAR(10) NOT NULL", $db);

echo mysql_error();

// -------------------------------------------------------------



echo"<br><br>Alter Table selesai";


mysql_close ($db);


?> 

</body></html> 
