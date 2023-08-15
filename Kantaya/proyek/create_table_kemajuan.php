<html><body> 

<?php 



$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 


// ----------------- Table kemajuan_proyek ----------------------------
echo "Table kemajuan_proyek  <br><br>";

$hasil = mysql_query("CREATE TABLE kemajuan_proyek (
			kode_proyek          INT(10)        NOT NULL,
			no_termin            INT(10)        NOT NULL,			
			kemajuan_kegiatan    VARCHAR(250),
			masalah              VARCHAR(250),
			pemecahan            VARCHAR(250),
			status_kemajuan      INT(10),
			tgl_dibuat           DATETIME,			
			tgl_diubah           DATETIME,
			dibuat_oleh          INT(10),
			diubah_oleh          INT(10),
			PRIMARY KEY	(kode_proyek,no_termin),
			FOREIGN KEY	(kode_proyek)          REFERENCES proyek,	
			FOREIGN KEY	(dibuat_oleh)          REFERENCES pengguna,
			FOREIGN KEY	(diubah_oleh)          REFERENCES pengguna
						)
			", $db);
// -------------------------------------------------------------



echo"<br><br>Create Table selesai";


mysql_close ($db);


?> 

</body></html> 
