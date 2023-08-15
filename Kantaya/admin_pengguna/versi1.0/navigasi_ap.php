<?php

//Dibuat oleh: KB
//Fungsi: Edit Grup

//Cek keberadaan sesi (session)
include ('../lib/cek_sesi.inc');
?>
<HTML>
<body>
<b>Menu Administrasi Pengguna</b>
<hr size="1" width="200">
<ul>
<LI><a href="unit_kerja.php" target="isi">Tambah Unit Kerja</a>
<LI><a href="edit_unit.php?huruf=A" target="isi">Edit Unit Kerja</a>
</ul>
<hr size="1" width="200">
<ul>
<li><a href="pengguna.php" target="isi">Tambah Pengguna</a>
<li><a href="edit_pengguna.php?huruf=A" target="isi">Edit Pengguna</a>
</ul>
<hr size="1" width="200">
<ul>
<li><a href="grup.php" target="isi">Tambah Grup</a>
<li>Edit Grup
<ul>
<li><a href="edit_grup.php?kode_pengguna=<?php echo $kode_pengguna ?>" target="isi">Edit Grup yang Anda pimpin</a>
<li>Edit keanggotaan Grup Anda
</ul>
</ul>
<hr size="1" width="200">
</body>
</HTML>
