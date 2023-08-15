<html>
<head>
<title>Grup</title>
</head>
<body>
<?php
print "<font face='Verdana' size='2'>";

//Menu awal (grup belum dipilih)

if ($grup=="") {
  print "Pilih Grup: ";
  print "<form method='post' action='grup.php' target='kiri'>";
  print "<select name='grup'>";
  print "<option value=''></option>";
  
  mysql_connect (localhost, root);
  mysql_select_db (kantaya);
  $result=mysql_query ("SELECT kode_grup, nama_grup FROM grup ORDER BY nama_grup");

  if ($row=mysql_fetch_array($result)) {
    do {
	print "<option value=";
	print $row["kode_grup"];
	print ">";
	print $row["nama_grup"];
	print "</option>";
	} 
 
    while ($row=mysql_fetch_array($result));
	print "</select>";
	print "<input type=submit value='>>'>";
	print "</form>";
	} else {print "Tidak ada grup !";}

	echo "<hr>";
	echo "Majanemen Grup<br>";
	echo "<form method='post' action='grup_baru.php' target='isi'>";
	echo "<input type='submit' value='Tambah Grup'>";
	echo "</form>";
	print "Pilih Grup: ";
	print "<form method='post' action='grup.php' target='isi'>";
	print "<select name='grup'>";
	print "<option value=''></option>";

	mysql_connect (localhost, root);
	mysql_select_db (kantaya);
	$result=mysql_query ("SELECT kode_grup, nama_grup FROM grup ORDER BY nama_grup");
	
	if ($row=mysql_fetch_array($result)) {
	do {
		print "<option value=";
		print $row["kode_grup"];
		print ">";
		print $row["nama_grup"];
		print "</option>";
		} while ($row=mysql_fetch_array($result));
	print "</select><br>";
	print "<input type=submit value='Ubah'><br>";
	print "<input type=submit value='Hapus'>";
	print "</form>";
	} else {print "Tidak ada grup !";}


} else

{ print $grup;}

print "</font>";
?>
</body>
</html>
