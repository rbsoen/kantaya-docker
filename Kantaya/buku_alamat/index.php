<?php
session_start();
include ('../lib/cek_sesi.inc');
?>
<html><head><title>Buku Alamat</title>

</head>
<FRAMESET rows="25%,*" FRAMEBORDER=1 BORDER=0>
	<FRAME SRC="../lib/kepala.php" NAME="kepala" SCROLLING="Auto" MARGINWIDTH=0  MARGINHEIGHT=0 NORESIZE>

<FRAMESET cols="25%,*" FRAMEBORDER=1 BORDER=1>
	<FRAME SRC="navigasi_alamat1.php" NAME="navigasi" scrolling="Auto" MARGINWIDTH=0  MARGINHEIGHT=0 NORESIZE>
	<FRAME SRC="alamat.php" NAME="isi" SCROLLING="Auto" MARGINWIDTH=0  MARGINHEIGHT=0>
</FRAMESET></FRAMESET>
</html>