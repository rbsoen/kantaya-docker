<?php
/******************************************
Nama File : list_kemajuan.php
Fungsi    : Menampilkan list kemajuan proyek
Dibuat    :	
 Tgl.     : 6-11-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   :
******************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$query = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran, tgl_mulai, tgl_selesai FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($query);

list($y1,$m1,$d1)=split("-",$proyek["tgl_mulai"]);
list($y2,$m2,$d2)=split("-",$proyek["tgl_selesai"]);

$jenis_pelaporan = $pjenislap;
$thbl1 = $y1.$m1;
$thbl2 = $y2.$m2;

$query = mysql_query("SELECT (period_diff('$thbl2','$thbl1')) selisihbulan FROM proyek WHERE kode_proyek='$p1'", $db);
$ttlbulan = (mysql_result($query,0,"selisihbulan")+1);

if ($jenis_pelaporan == "T") {
    $jmltermin = ceil($ttlbulan/3);
} else {
    $jmltermin = $ttlbulan;
}


echo "<html>\n";
echo "<head>\n";
echo "<title>List Kemajuan Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "<script language='Javascript'>\n";

echo "function ubahtermin() {\n";
echo "				 document.listkemajuan.action = 'list_kemajuan.php'\n";
echo "				 document.listkemajuan.submit()\n";
echo "}\n";

echo "</script>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1' width='80%'>List Kemajuan Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<form name='listkemajuan' method='post' target='isi'>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td width='20%'>Nama Proyek</td>\n";
echo "<td width='80%'> : <a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Periode</td>\n";
echo "<td width='80%'> : ".tanggal('S',$proyek["tgl_mulai"])." s/d ".tanggal('S',$proyek["tgl_selesai"])."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Tahun Anggaran</td>\n";
echo "<td width='80%'> : ".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Termin</td>\n";
echo "<td width='80%'> : \n";

if ($ptermin=="") {
    $ptermin = 1;
}

if ($jenis_pelaporan=="T") {
  echo "Triwulan ke - ";
} else {
  echo "Bulan ke - ";
}
     echo "<select name='ptermin' onChange='ubahtermin()'>\n";
     echo "<option value=".$ptermin." selected>".$ptermin."</option>\n";
		 if ($jmltermin > 1) {
		   for ($i=1; $i<=$jmltermin; $i++) {
			  if ($i <> $ptermin) {
         echo "<option value=".$i.">".$i."</option>\n";
				}
       } 
		 }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";

if ($pkoord == $kode_pengguna) {
echo "<tr>\n";
echo "<td colspan=2 align='right'><a href='input_kemajuan.php?p1=$p1'>Pelaporan Kemajuan</a></td>\n";
echo "</tr>\n";
}

echo "</table>\n";
echo "<input type='hidden' name='p1' value='$p1'>\n";
echo "<input type='hidden' name='pkoord' value='$pkoord'>\n";
echo "</form>\n";

$query = mysql_query("SELECT * FROM kemajuan_proyek WHERE kode_proyek='$p1' AND no_termin='$ptermin'", $db);

echo "<table width=100%' border=0>\n";
echo "<tr>\n";
echo "<td width=30% class='judul2' align='center'>Kemajuan</td>\n";
echo "<td width=30% class='judul2' align='center'>Masalah</td>\n";
echo "<td width=30% class='judul2' align='center'>Pemecahan</td>\n";
echo "<td width=10% class='judul2' align='center'>Status Kemajuan</td>\n";
echo "</tr>\n";

$i = 0;
while ($row = mysql_fetch_array($query)) {
    $i++;
    echo "<tr>\n";
    echo "<td class='isi2' >".$row["kemajuan_kegiatan"]."&nbsp;</td>\n";
    echo "<td class='isi2' >".$row["masalah"]."&nbsp;</td>\n";
    echo "<td class='isi2' >".$row["pemecahan"]."&nbsp;</td>\n";
    echo "<td class='isi2' align='right'>".$row["status_kemajuan"]." %"."&nbsp;</td>\n";		
    echo "</tr>\n";
}
if ($i==0) {
    echo "<tr>\n";
    echo "<td colspan=5>Belum ada Kemajuan yang dilaporkan</td>\n";
    echo "</tr>\n";
}
echo "<tr>\n";
echo "<td>\n";
echo "</tr>\n";
echo "</table>\n";



echo "</body>\n";
echo "</html>\n";


