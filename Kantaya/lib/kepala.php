<?php



/******************************************



Nama File : kepala.php



Fungsi    : Tampilan di frame kepala.



Dibuat    :AW



 Tgl.     : 13.10.2001



 Oleh     : KB/AW







Revisi 1	:



 Tgl.     : 02-11-2001



 Oleh     : AS



 Revisi   : Selamat Datang etc., perubahan style







******************************************/







include ("../lib/cek_sesi.inc");

include ("config_kepala.php");

include ("../lib/fs_kalender.php");


$css = "../css/".$tampilan_css.".css";




ini_alter ("session.cookie_lifetime", "180");







?>





<html>

<head>

<title>Untitled Document</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<?php
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
?>

</head>



<body bgcolor="#FFFFFF" text="#000000">

<table width="768" border="0" align="center" cellpadding="1" cellspacing="0">

  <tr> 

    <td rowspan="4" width="150" valign="top"> 

      <div align="center"><img src="<?php echo $lokasi_logo ; ?>" width="150" height="70"></div>

    </td>

    <td width="438"> 

      <div align="center"><font size="4"><b><font size="3">

        <?php echo $perusahaan ; ?>

        </font></b></font></div>

    </td>

    <td rowspan="4" width="150" valign="top"> 

      <div align="center"><img src="../gambar/logo_kantaya.gif" width="150" height="70"></div>

    </td>

  </tr>

  <tr> 

    <td width="438"> 

      <div align="center"><font size="2">

        <?php echo $alamat ; ?>

        </font></div>

    </td>

  </tr>

  <tr> 

    <td width="438"> 

      <div align="center"><font size="2">

        <?php echo $telepon; echo $faximil;  ?>

        </font></div>

    </td>

  </tr>

  <tr> 

    <td width="438"> 

      <div align="center"><font size="2">

        <?php echo $email; echo $url;  ?>

        </font></div>

    </td>

  </tr>

  <tr> 

    <td colspan="3"> 

      <div align="center"><img src="../gambar/bar_mnu.jpg" width="599" height="16" usemap="#Map" border="0">

        <map name="Map"> 

          <area shape="rect" coords="39,3,81,13" href="/agenda/buka_agenda.php" target="_parent" alt="Agenda" title="Agenda">

          <area shape="rect" coords="89,4,135,12" href="/fasilitas/fasilitas.php" target="_parent" alt="Fasilitas" title="Fasilitas">

          <area shape="rect" coords="140,4,209,14" href="/buku_alamat/index.php" target="_parent" alt="Buku Alamat" title="Buku Alamat">

          <area shape="rect" coords="216,3,255,13" href="/lemari/index_lemari.php" target="_parent" alt="Almari File" title="Almari File">

          <area shape="rect" coords="261,3,303,12" href="/dimana/dimana.php" target="_parent" alt="Dimana " title="Dimana ">

          <area shape="rect" coords="309,4,347,13" href="/proyek/index.php" target="_parent" alt="Proyek" title="Proyek">

          <area shape="rect" coords="353,3,391,13" href="/forum/index.php?jnskategori=P" target="_parent" alt="Forum" title="Forum">

          <area shape="rect" coords="398,3,439,14" href="/diskusi/index.php" target="_parent" alt="Diskusi" title="Diskusi">

          <area shape="rect" coords="447,4,486,13" href="/url_link/index_url.php" target="_parent" alt="index Url Link" title="index Url Link">

          <area shape="rect" coords="494,4,521,12" href="/surat_web/index.php" target="_parent" alt="Surat Web" title="Surat Web">

          <?php

        if ($level=="1") {

  ?>

          <area shape="rect" coords="528,4,554,13" href="/admin_pengguna/index_ap.php" target="_parent" alt="Admin Pengguna" title="Admin"  >

          <?php



        }

        else       

        {

  ?>

          <area shape="rect" coords="528,4,554,13" href="/admin_pengguna/pengguna_biasa/index_ap_biasa.php " target="_parent" alt="profil Pengguna" title="profil">

          <?php 



        } 

  ?>

          <area shape="rect" coords="562,3,592,13" href="/logout.php" target="_parent" alt="keluar" title="keluar">

        </map>

      </div>

    </td>

  </tr>

  <tr> 

    <td colspan="3"> 

      <div align="center"><font size="2">Selamat datang sdr.</font> 

        <?php echo "<font size=2 color=blue>"; ?>

        <?php echo $nama_pengguna; echo "</font><font size=2>, hari ini </font><font size=2 color=red>".namahari('P',date("w"))." ".date("d")." ".namabulan('P',date("n"))." ".date("Y"); ?>

      </div>

    </td>

  </tr>

</table>

</body>

</html>

