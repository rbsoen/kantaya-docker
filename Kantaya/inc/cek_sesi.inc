ini_alter ("session.cookie_lifetime", "180");

session_start();
if (!$kode_pengguna or !$nama_pengguna or !$level) {
echo "<center>Silakan login terlebih dahulu !<p><a href='/index.php'>Login sekarang ....</a></center>"; exit;}
