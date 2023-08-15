<?php

session_start();

if ($kode_pengguna) {

  header ('Location: agenda/buka_agenda.php');

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



<table border="1" width="762" cellspacing="0" cellpadding="0" height="451" bgcolor="#FFFFFF" align="center">

  <tr> 

    <td width="35%" height="461" valign="top"> 

      <table height="90%" width="100%" bordercolordark="#000000" cellspacing="0" bordercolorlight="#000000" bgcolor="#FFFFFF" border="1">

        <tr> 

          <td width="100%" valign="top" height="462" bgcolor="#004080"> 

            <form method='post' action='login.php' 

target="_parent">

                           <table cellspacing=5 align="center">

                <tr> 

                  <td>&nbsp;</td>

                  <td><font face='Verdana' size='3'><b><font color="#FFFF00">Login</font></b></font></td>

                </tr>

                <tr> 

                  <td><font color="#FFFF00"><b>Username:</b></font></td>

                  <td colspan=2> 

                    <input type='text' name='username' 

							 size="15">

                  </td>

                </tr>

                <tr> 

                  <td><font color="#FFFF00"><b>Password:</b></font></td>

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

              <p>&nbsp;</p>

            </form>

            <div align="center"> 

              <p><b><font size="2" color="#FFFF00">Perangkat Lunak :</font></b></p>

              <p align="center"><font size="2" color="#FFFF00"><b>Portal Intranet 

                Perusahaan</b></font></p>

              <p align="center"><font size="2" color="#FFFF00"><b>Sistem Informasi 

                Perkantoran Berbahasa Indonesia </b></font></p>

              <p align="center"><font size="2" color="#FFFF00"><b>Berbasis Web 

                </b></font></p>

              <p align="center"><font size="2" color="#FFFF00"><b>Untuk Usaha 

                Kecil, Menengah dan Besar</b></font></p>

              <p align="center">&nbsp;</p>

              <p align="center"><font size="2" color="#FFFFFF">Badan Pengkajian 

                dan Penerapan Teknologi</font></p>

            </div>

          </td>

        </tr>

      </table>

    </td>

    <td width="65%" valign="middle" height="461" bgcolor="#FFFFFF"> 

      <div align="center"> 

        <p align="center"><b><img src="gambar/Logo1.jpg" width="242" height="100"></b></p>

        <p align="center"><img src="gambar/depan.jpg" alt="Selamat datang di Kantaya" width="340" height="305"></p>

        </div>

      </td>

  </tr>

</table>



</body>



</html>



<?php

}

?>

