<html><body> 

<?php 



$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 
/*

// ----------------- Table fasilitas ----------------------------
echo "Table fasilitas  <br><br>";

$hasil = mysql_query("CREATE TABLE fasilitas (
			kode_fas							 INT(10)				 NOT NULL AUTO_INCREMENT,
			nama_fas							 VARCHAR(100)		 NOT NULL,
			unit									 VARCHAR(10)		 NOT NULL,
			wewenang							 VARCHAR(30)		 NOT NULL,
			lokasi								 VARCHAR(20)		 NOT NULL,
			status								 VARCHAR(1)			 NOT NULL,
			keterangan						 VARCHAR(250),
			tanggal_dibuat				 DATETIME,
			tanggal_diubah				 DATETIME,
			dibuat_oleh						 INT(10),
			diubah_oleh						 INT(10),
			PRIMARY KEY	(kode_fas),
			FOREIGN KEY	(dibuat_oleh)	REFERENCES pengguna,
			FOREIGN KEY	(diubah_oleh)	REFERENCES pengguna
						)
			", $db);
// -------------------------------------------------------------
*/


// ------------------ Table pemesanan fasilitas ----------------
echo "Table pemesanan  <br><br>";

$hasil = mysql_query("CREATE TABLE pemesanan (
			kode_pesan						 INT(10)				 NOT NULL AUTO_INCREMENT,
			fasilitas							 INT(10)				 NOT NULL,
			pemesan								 INT(10)				 NOT NULL,
			kode_agenda						 INT(10),
			keperluan							 VARCHAR(250),
			untuk_tgl							 DATE						 NOT NULL,
			jam_mulai							 TIME						 NOT NULL,
			jam_akhir							 TIME,
			keterangan						 VARCHAR(250),
			tanggal_dibuat				 DATETIME,
			tanggal_diubah				 DATETIME,
			dibuat_oleh						 INT(10),
			diubah_oleh						 INT(10),
			PRIMARY KEY	(kode_pesan),
			FOREIGN KEY	(fasilitas)	 			 			REFERENCES fasilitas,
			FOREIGN KEY	(pemesan)		 						REFERENCES pengguna,
			FOREIGN KEY	(kode_agenda)						REFERENCES agenda,
			FOREIGN KEY	(dibuat_oleh)						REFERENCES pengguna,
			FOREIGN KEY	(diubah_oleh)						REFERENCES pengguna
						)
			", $db);
// -------------------------------------------------------------

/*
// ------------------ Table unit/grup pemilik fasilitas --------
echo "Table unit_kerja <br><br>";

$hasil = mysql_query("CREATE TABLE unit_kerja (
			kode_unit	INT(10)		NOT NULL AUTO_INCREMENT,
			nama_unit	VARCHAR(100)	NOT NULL,
			keterangan	VARCHAR(250),
			tanggal_dibuat	DATE,
			tanggal_diubah	DATE,
			dibuat_oleh	INT(10),
			diubah_oleh	INT(10),
			PRIMARY KEY	(kode_unit),
			FOREIGN KEY	(dibuat_oleh)	REFERENCES pengguna,
			FOREIGN KEY	(diubah_oleh)	REFERENCES pengguna
					)
			", $db);
// -------------------------------------------------------------
*/


/*

// ------------------ Table pengguna ----------------
echo "Table pengguna  <br><br>";

$hasil = mysql_query("CREATE TABLE pengguna (
			kode_pengguna	INT(10)		NOT NULL AUTO_INCREMENT,
			nama_pengguna	VARCHAR(60)	NOT NULL,
			level		CHAR(1)		NOT NULL,
			nip		VARCHAR(10)	NOT NULL,
			username	VARCHAR(10)	NOT NULL,
			password	VARCHAR(5),
			email		VARCHAR(30),
			keterangan	VARCHAR(250),
			tanggal_dibuat	DATE,
			tanggal_diubah	DATE,
			dibuat_oleh	INT(10),
			diubah_oleh	INT(10),
			PRIMARY KEY	(kode_pengguna)
						)
			", $db);
// -------------------------------------------------------------

*/

echo"<br><br>Create Table selesai";


mysql_close ($db);


?> 

</body></html> 
