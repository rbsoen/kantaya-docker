<html><body> 

<?php 



$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 


// ----------------- Table dimana ----------------------------
echo "Table dimana  <br><br>";

$hasil = mysql_query("CREATE TABLE dimana (
			kode_pengguna					 INT(10)			NOT NULL,
			keberadaan						 CHAR(1)			NOT NULL,
			keterangan						 VARCHAR(250),
			tanggal_dibuat				 DATETIME,
			tanggal_diubah				 DATETIME,
			dibuat_oleh						 INT(10),
			diubah_oleh						 INT(10),
			PRIMARY KEY	(kode_pengguna),
			FOREIGN KEY	(dibuat_oleh)	REFERENCES pengguna,
			FOREIGN KEY	(diubah_oleh)	REFERENCES pengguna
						)
			", $db);
// -------------------------------------------------------------


echo"<br><br>Create Table selesai";


mysql_close ($db);


?> 

</body></html> 
