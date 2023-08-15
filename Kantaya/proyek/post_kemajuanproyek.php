<?php
/******************************************
Nama File : post_kemajuanproyek.php
Fungsi    : Menghapus pemesanan.
Dibuat    :	
 Tgl.     : 07-11-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/


include ('../lib/cek_sesi.inc'); 
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$css = "../css/".$tampilan_css.".css";

$tgldibuat = date("Y-m-d H:i:s");
$tgldiubah = date("Y-m-d H:i:s");

echo "<html>\n";
echo "<head>\n";
echo "<title>Simpan Input Detail Kemajuan Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";  
echo "</head>\n";
echo "<body>\n";

if ($statuskemajuan=="") {$statuskemajuan  = 0; }
if ($kemajuan=="")       {$kemajuan  = "Belum ada"; }
if ($masalah=="")        {$masalah  = "Belum ada"; }
if ($pemecahan=="")      {$pemecahan  = "Belum ada"; }

if ($jnstransaksi == "input kemajuan") {
$hasil = mysql_query("INSERT INTO kemajuan_proyek (kode_proyek, no_termin, kemajuan_kegiatan, masalah, pemecahan, status_kemajuan, dibuat_oleh, tgl_dibuat, diubah_oleh, tgl_diubah) VALUES ("
											.$kodeproyek.",".$terminke.",'".$kemajuan."','".$masalah."','".$pemecahan."',".$statuskemajuan.",".$kode_pengguna.",'".$tgldibuat."',".$kode_pengguna.",'".$tgldiubah."')", $db);

} else {
$query = "UPDATE kemajuan_proyek SET kode_proyek=".$p1.",no_termin=".$p2.",kemajuan_kegiatan='".$kemajuan."',masalah='".$masalah."',pemecahan='".$pemecahan."',status_kemajuan=".$statuskemajuan.",dibuat_oleh=".$kode_pengguna.",tgl_dibuat='".$p3."',diubah_oleh=".$kode_pengguna.",tgl_diubah='".$tgldiubah."' ";
$where = "WHERE kode_proyek = $p1 AND no_termin = $p2 ";
$sqltext = $query.$where;
$hasil = mysql_query($sqltext, $db);
}

$query = mysql_query("SELECT nama_proyek FROM proyek WHERE kode_proyek='$kodeproyek'", $db);
$proyek = mysql_fetch_array($query);

echo"
<table width=100% >
	<tr>
		<td class='judul1'><b>Konfirmasi</td>
	</tr>
";
	

if (mysql_error()) {
    echo "<tr><td><b>Error : </b>".mysql_error()."</td></tr>";
} else {
    echo "<tr><td>Sukses disimpan. Kembali ke proyek <a href='detail_proyek.php?p1=$kodeproyek'>".$proyek["nama_proyek"]."</a></td></tr>";
}

echo "
</table>
";


mysql_close ($db);

echo "</body>";
echo "</html>";

?>
