<?php
session_start();
if ($kode_pengguna) {
  header ('Location: /agenda/buka_agenda.php');
  }

else {
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 4.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Kantaya P3TIE Groupware</title>
</head>

<body>

<table border="0" width="762" cellspacing="0" cellpadding="0" height="48" bgcolor="#FFFFFF">
  <tr> 
    <td width="25%" height="293" valign="top"> 
      <table height="100%" width="64%" bordercolordark="#000000" cellspacing="0" bordercolorlight="#000000" bgcolor="#FFFFFF">
        <tr> 
          <td width="100%" valign="top" height="308"> 
            <form method='post' action='login.php' 
target="_parent">
              <p align="center"><img src="gambar/logo1.gif" width="104" height="39"></p>
              <table cellspacing=5>
                <tr>
                  <td>&nbsp;</td>
                  <td><font face='Verdana' size='3'><b>Login</b></font></td>
                </tr>
                <tr>
                  <td>Username:</td>
                  <td colspan=2>
                    <input type='text' name='username' 
							 size="15">
                  </td>
                </tr>
                <tr>
                  <td>Password:</td>
                  <td colspan=2>
                    <input type='password' name='password' size="15">
                  </td>
                </tr>
                <tr>
                  <td width=20>&nbsp;</td>
                  <td>
                    <input type='submit' value='Masuk'>
                  </td>
                </tr>
              </table>
            </form>
            <div align="center">
              <p>&nbsp;</p>
              <p>&nbsp;</p>
            </div>
          </td>
        </tr>
      </table>
    </td>
    <td width="35%" valign="top" height="293" bgcolor="#FFFFFF"> 
      <div align="center">
        <p align="left"><img src="gambar/depan.jpg" alt="Selamat datang di Kantaya" width="281" height="299"></p>
      </div>
    </td>
    <td width="40%" valign="top" height="293">
      <p>&nbsp;</p>
      <p align="center"><b>Perangkat Lunak</b></p>
      <p align="center"><b>Portal Intranet Perusahaan</b></p>
      <p align="center"><b>Sistem Informasi Perkantoran Berbahasa Indonesia </b></p>
      <p align="center"><b>Berbasis Web </b></p>
      <p align="center"><b>Untuk Usaha Kecil, Menegah dan Besar</b></p>
      <p align="center"><img src="gambar/logo1.gif" width="104" height="39"></p>
      </td>
  </tr>
</table>

</body>

</html>

<?php
}
?>
