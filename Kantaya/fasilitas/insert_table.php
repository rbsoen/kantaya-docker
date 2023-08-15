<html><body> 

<?php 



$db = mysql_connect("localhost", "root"); 
mysql_select_db("kantaya", $db); 

/*

// ---- Insert Table : unit_kerja -------

echo"Insert Table : unit_kerja <br>";
$result = mysql_query("INSERT INTO unit_kerja (nama_unit, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ('Fakultas Teknik',NULL, 1, '2001-09-19', 1, '2001-09-19')", $db);
$result = mysql_query("INSERT INTO unit_kerja (nama_unit, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ('FMIPA','Fakultas Matematika dan IPA', 1, '2001-09-19', 1, '2001-09-19')", $db);
$result = mysql_query("INSERT INTO unit_kerja (nama_unit, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ('FISIP','Sosial dan Politik', 1, '2001-09-19', 1, '2001-09-19')", $db);
*/


// ---- Insert Table : pengguna -------

echo"Insert Table : pengguna";
$result = mysql_query("INSERT INTO pengguna (nama_pengguna, level, nip, username, password, email, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ('Faisol Baabdullah', '1', '680001255', 'FAISOL', 'fai', 'faisol@inn.bppt.go.id', NULL, 1, '2001-09-20', 1, '2001-09-20')", $db);
$result = mysql_query("INSERT INTO pengguna (nama_pengguna, level, nip, username, password, email, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ('Agoeng Srimoeljanto', '1', '680003078', 'AGOENG', 'ago', 'agoeng@bppt.go.id', NULL, 1, '2001-09-20', 1, '2001-09-20')", $db);
$result = mysql_query("INSERT INTO pengguna (nama_pengguna, level, nip, username, password, email, keterangan, dibuat_oleh, tanggal_dibuat, diubah_oleh, tanggal_diubah) VALUES ('Andre Lapian', '1', '680001301', 'ANDRE', 'and', NULL, NULL, 1, '2001-09-20', 1, '2001-09-20')", $db);



echo"<br><br>Insert Table selesai";

mysql_close ($db);

?> 

</body></html> 
