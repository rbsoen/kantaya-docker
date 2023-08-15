<?php
/***********************************************************************
Nama File : setup.php
Fungsi    : Form setup instalasi Kantaya
Dibuat    :
Tgl.      : 18-11-2001
Oleh      :

Revisi 1  :
Tgl.      :
Oleh      :
Revisi    :
***********************************************************************/
$css = "../css/kantaya.css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Setup Kantaya</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "</head>\n";
echo "<body>\n";
echo "<center>\n";
echo "<form enctype='multipart/form-data' name='setup' method='post' action='post_setup.php'>\n";
echo "<table width='80%' border=1>\n";
echo "<tr>\n";
echo "<td class='judul1' colspan=2>Setup Kantaya</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2>&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td valign='top' width='50%'>\n";
     echo "<table width='100%' border=1>\n";
     echo "<tr>\n";
     echo "<td bgcolor='#666699' colspan=2><font color='#FFFFFF'><b>MySql Admin</b></font></td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Root</td>\n";
     echo "<td width='70%'><input type='text' name='root'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Password</td>\n";
     echo "<td width='70%'><input type='password' name='password'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Host</td>\n";
     echo "<td width='70%'><input type='text' name='host' value='localhost'><td>\n";
     echo "</tr>\n";
     echo "</table>\n";
     echo "<table width='100%' border=1>\n";
     echo "<tr>\n";
     echo "<td bgcolor='#666699' colspan=2><font color='#FFFFFF'><b>Kantaya Database User</b></font></td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Nama User</td>\n";
     echo "<td width='70%'><input type='text' name='nama_user'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Password</td>\n";
     echo "<td width='70%'><input type='password' name='pswd_user'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Nama Database</td>\n";
     echo "<td width='70%'><input type='text' name='nama_database'><td>\n";
     echo "</tr>\n";
     echo "</table>\n";
     echo "<table width='100%' border=1>\n";
     echo "<tr>\n";
     echo "<td bgcolor='#666699' colspan=2><font color='#FFFFFF'><b>Instalasi</b></font></td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Path</td>\n";
     echo "<td width='70%'><input type='text' name='basepath'><td>\n";
     echo "</tr>\n";
     echo "</table>\n";
echo "</td>\n";
echo "<td valign='top' width='50%'>\n";
     echo "<table width='100%' border=1>\n";
     echo "<tr>\n";
     echo "<td bgcolor='#666699' colspan=2><font color='#FFFFFF'><b>Profile Instansi/Perusahaan</b></font></td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Nama</td>\n";
     echo "<td width='70%'><input type='text' name='nama_perusahaan'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Alamat</td>\n";
     echo "<td width='70%'><textarea name='alamat_perusahaan' rows=3 cols=30 wrap='off'></textarea><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>No Telp.</td>\n";
     echo "<td width='70%'><input type='text' name='telp_perusahaan'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>No Fax</td>\n";
     echo "<td width='70%'><input type='text' name='fax_perusahaan'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Email</td>\n";
     echo "<td width='70%'><input type='text' name='email_perusahaan'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>URL</td>\n";
     echo "<td width='70%'><input type='text' name='url_perusahaan'><td>\n";
     echo "</tr>\n";
     echo "<tr>\n";
     echo "<td width='30%'>Logo</td>\n";
     echo "<td width='70%'><input type='file' name='logo_perusahaan'><td>\n";
     echo "</tr>\n";
     echo "</table>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2>&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2 align='center'><p><input type='submit' name='submit' value='Setup Kantaya'></td>\n";
echo "</tr>\n";

echo "</table>\n";
echo "<p>\n";








echo "</body>\n";
echo "</html>\n";

