<html><body> 

<?php 



$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 


// ----------------- Table timesheet_proyek ----------------------------
echo "Table timesheet_proyek  <br><br>";

$hasil = mysql_query("CREATE TABLE timesheet_proyek (
			kode_proyek						 INT(10)				NOT NULL,
			no_kegiatan						 VARCHAR(10)		NOT NULL,			
			tgl_kegiatan					 DATE		 				NOT NULL,
			kode_personil					 INT(10) 				NOT NULL,
			total_jam							 INT(10)		 		NOT NULL,
			tgl_dibuat				 		 DATETIME,
			tgl_diubah				 		 DATETIME,
			dibuat_oleh						 INT(10),
			diubah_oleh						 INT(10),
			PRIMARY KEY	(kode_proyek,no_kegiatan,tgl_kegiatan,kode_personil),
			FOREIGN KEY	(kode_proyek)						REFERENCES proyek,
			FOREIGN KEY	(kode_personil)					REFERENCES pengguna,
			FOREIGN KEY	(no_kegiatan)						REFERENCES jadwal_proyek,			
			FOREIGN KEY	(dibuat_oleh)						REFERENCES pengguna,
			FOREIGN KEY	(diubah_oleh)						REFERENCES pengguna
						)
			", $db);
// -------------------------------------------------------------



echo"<br><br>Create Table selesai";


mysql_close ($db);


?> 

</body></html> 
