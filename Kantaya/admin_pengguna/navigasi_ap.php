<?php

//////////////////////////////////////////////
//Dibuat oleh: KB
//Fungsi     : Navigasi Administrasi Pengguna
//////////////////////////////////////////////

//Cek keberadaan sesi (session)
include ("../lib/cek_sesi.inc");

$css = "../css/" .$tampilan_css. ".css";
echo "<html>\n";
echo "<head>\n";
echo "<title>Navigasi Admin Pengguna</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";
?>

<table border="0" width="100%" cellpadding="2">
   <tr>
      <td width="100%" class="judul1">Menu Admin Pengguna</td>
   </tr>
</table><p>
<ul>
<li><a href="tambah_unit_kerja.php" target="isi">Tambah Unit Kerja</a>
<li><a href="edit_unit.php?huruf=" target="isi">Edit Unit Kerja</a>
<hr size="1">
<li><a href="tambah_pengguna.php" target="isi">Tambah Pengguna</a>
<li><a href="edit_pengguna.php?huruf=" target="isi">Edit Pengguna</a>
<hr size="1">
<li><a href="tambah_grup.php" target="isi">Tambah Grup</a>
<li><a href="edit_grup.php?kode_pengguna=<?php echo $kode_pengguna ?>" target="isi">Edit Grup Pribadi</a>
<li><a href="lihat_grup.php?huruf=" target="isi">Lihat & Edit Semua Grup</a>
<hr size="1">
<li><a href="profile_warna.php" target="isi">Warna Tampilan</a>
</ul>
<hr size="1">
</body>
</html>