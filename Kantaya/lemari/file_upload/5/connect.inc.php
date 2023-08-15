<?
$database="web";
$hostname="localhost";
$username="root";
$password="";
if (!$dbh=mysql_connect($hostname,$username,$password)) {
echo mysql_error();
exit;
}
mysql_select_db($database,$dbh);
?>
