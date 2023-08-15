<?php
include ('../lib/cek_sesi.inc');
require("../cfg/$cfgfile");

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Admin Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>";
?>

<body>

<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Administrasi Pengguna</td>
   </tr>
</table><p>

<font size="2" face="Verdana">Di modul ini, Anda akan dapat:</font></p>
  <blockquote>
    <ul>
      <li><font size="2" face="Verdana">Menambah dan mengedit Unit Kerja</font></li>
      <li><font size="2" face="Verdana">Menambah dan mengedit Pengguna</font></li>
      <li><font size="2" face="Verdana">Menambah dan Mengedit Grup di bawah pimpinan
    Anda</font></li>
      <li><font size="2" face="Verdana">Mengedit semua grup</font></li>
    </ul>
  </blockquote>
<hr size="1">

</blockquote>

</body>

</html>
