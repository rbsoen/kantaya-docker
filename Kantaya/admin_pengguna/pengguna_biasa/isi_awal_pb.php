<?php

//Dibuat oleh: KB
//Fungsi: Navigasi

//Cek keberadaan sesi (session)
include ("../../lib/cek_sesi.inc");
$css = "../../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Profil Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>
<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Administrasi Pengguna</td>
   </tr>
</table><p>
<blockquote>
  <p><font size="2" face="Verdana">Di modul ini, Anda akan dapat:</font></p>
  <ul>
    <li><font size="2" face="Verdana">Mengedit Profile Anda</font></li>
    <li><font size="2" face="Verdana">Menambah dan Mengedit Grup di bawah pimpinan
    Anda</font></li>
  <li><font size="2" face="Verdana">Memilih keanggota grup</font></li>
  </ul>
</blockquote>
<hr size="1">
</body>

</html>
