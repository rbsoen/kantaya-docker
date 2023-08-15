<?
if ($submit) {
$password=md5("$password");
include "connect.inc.php";
$sql="SELECT * FROM login WHERE  username='$username' and passwd='$passwd'";
$str01=mysql_query($sql,$dbh);
$i=1;
$u=1;
while ($str01) {
if ($username==$str01[$i] && $password==$str01[$i+2]){
session_start();
$user_session="$str01[$i]";
$cus=$i+1;
$cat_user_session="$str01[$cus]";
session_register("user_session");
session_register("cat_user_session");
echo "selamat datang user : $str01[$i]";
echo ("<p><a href=http://localhost/simpel/menu/konsultasi/data2.php>Jawab Konsultasi</a></p>");
echo ("<p><a href=form.php>Input Data WebMaster</a></p>");
$u=1;
break;
}
$i+=3;
if ($i>(count($str01)+3)){
break;
}
}
if ($u!=1){
echo ("<br>anda bukan user");
}
} 
else 
{
echo ("<form method=post action=$PHP_SELF>");
echo ("<table>");
echo ("<tr>");
echo ("<td>selamat datang");
echo ("</td>");
echo ("</tr>");
echo ("<tr>");
echo ("<td>Username&nbsp;<input type=text name=username>");
echo ("</td>");
echo ("</tr>");
echo ("<tr>");
echo ("<td>Password&nbsp;<input type=password name=password>");
echo ("</td>");
echo ("</tr>");
echo ("<tr>");
echo ("<td align=right><input type=submit name=submit value=Login>");
echo ("</td>");
echo ("</tr>");
echo ("</table>");
echo ("</form>");
}
?>