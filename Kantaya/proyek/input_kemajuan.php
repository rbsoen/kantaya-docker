<?php
/*************************************************
Nama File : input_kemajuan.php
Fungsi    : Memasukkan pelaporan kemajuan proyek
Dibuat    :	
 Tgl.     : 7-11-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     : 
 Oleh     : 
 Revisi   :
**************************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
include('../lib/akses_unit.php');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$query = mysql_query("SELECT * FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($query);

list($y1,$m1,$d1)=split("-",$proyek["tgl_mulai"]);
list($y2,$m2,$d2)=split("-",$proyek["tgl_selesai"]);

$jenis_pelaporan = $proyek["jenis_pelaporan"];
$thbl1 = $y1.$m1;
$thbl2 = $y2.$m2;

$query = mysql_query("SELECT (period_diff('$thbl2','$thbl1')) selisihbulan, koordinator FROM proyek WHERE kode_proyek='$p1'", $db);
$ttlbulan = (mysql_result($query,0,"selisihbulan")+1);
$koordproyek = mysql_result($query,0,"koordinator");

if ($terminke=="") {
    $terminke = 1;
}

if ($jenis_pelaporan == "T") {
    $jmltermin = ceil($ttlbulan/3);
} else {
    $jmltermin = $ttlbulan;
}

list($jns_sharing,$grup_sharing) = split(';',$p1);
if ($jns_sharing == "U") {
    $query = mysql_query("SELECT * FROM unit_kerja WHERE kode_unit = '$grup_sharing'", $db);
    $query = mysql_fetch_array($query);
    $unit_grup = $query["nama_unit"];
} elseif ($jns_sharing == "G") {
    $query = mysql_query("SELECT * FROM grup WHERE kode_grup = '$grup_sharing'", $db);
    $query = mysql_fetch_array($query);
    $unit_grup = $query["nama_grup"];
}
$grup = $jnskategori.";".$kdkategori;
$where = "jenis_sharing='$jns_sharing' and grup_sharing='$grup_sharing' and tahun_anggaran='$tahun' and jenis_proyek like '$p3%'";
$query = mysql_query("SELECT count('x') FROM proyek WHERE $where", $db);
$jmldata = mysql_fetch_array($query);
$purl = "list_proyek.php?p1=$p1&p2=$p2&p3=$p3";

echo "<html>\n";
echo "<head>\n";
echo "<title>Input Kemajuan Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<script language='Javascript'>\n";

echo "function ubahtermin() {\n";
echo "				 document.kemajuanproyek.action = 'input_kemajuan.php'\n";
echo "				 document.kemajuanproyek.submit()\n";
echo "}\n";

echo "</script>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
if ($kode_pengguna == $koordproyek){
echo "<tr>\n";
echo "<td colspan=2 class='judul1'>Input Detail Kemajuan Proyek</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2>&nbsp;</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td align=right><a href='ubah_kemajuan.php?p1=$p1&p2=$terminke&p3=$jenis_pelaporan'>Ubah Kemajuan Proyek</a></td>\n";
echo "</tr>\n";
} else {
echo "<tr>\n";
echo "<td class='judul1'>Input Detail Kemajuan Proyek</td>\n";
echo "</tr>\n";
}
echo "</table>\n";

echo "<form name='kemajuanproyek' method='post' action='post_kemajuanproyek.php' target='isi'>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td>Nama Proyek</td>\n";
echo "<td> : </td>\n";
echo "<td><a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Periode</td>\n";
echo "<td> : </td>\n";
echo "<td>".tanggal('S',$proyek["tgl_mulai"])." s/d ".tanggal('S',$proyek["tgl_selesai"])."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Tahun Anggaran</td>\n";
echo "<td> : </td>\n";
echo "<td>".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>Termin</td>\n";
echo "<td> : </td>\n";
echo "<td>\n";

if ($jenis_pelaporan=="T") {
  echo "Triwulan ke - ";
} else {
  echo "Bulan ke - ";
}
     echo "<select name='terminke' onChange='ubahtermin()'>\n";
     echo "<option value=".$terminke." selected>".$terminke."</option>\n";
		 if ($jmltermin > 1) {
		   for ($i=1; $i<=$jmltermin; $i++) {
			  if ($i <> $terminke) {			 
         echo "<option value=".$i.">".$i."</option>\n";
				}
       } 
		 }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td>&nbsp;</td>\n";
echo "</tr>\n";

$where = "kode_proyek='$p1' AND no_termin='$terminke'";
$query = mysql_query("SELECT * FROM kemajuan_proyek WHERE $where", $db);
$row = mysql_fetch_array($query);
$proyek_termin_tbl = $row["kode_proyek"].$row["no_termin"];
$proyek_termin_frm = $p1.$terminke;

if ($proyek_termin_tbl <> $proyek_termin_frm) {
  echo "<tr>\n";
  echo "<td>Kemajuan</td><td> : </td><td><textarea name=kemajuan  rows=3 cols=25></textarea></td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td>Masalah</td><td> : </td><td><textarea name=masalah rows=3 cols=25></textarea></td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td>Pemecahan</td><td> : </td><td><textarea name=pemecahan rows=3 cols=25></textarea></td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td>Status Kemajuan</td><td> : </td><td><input name=statuskemajuan size=5>  %</input></td>\n";
  echo "</tr>\n";
} else {
  echo "<tr>\n";
  echo "<td width=35% >Kemajuan</td><td width=5% > : </td><td width=60% rows=3>".$row["kemajuan_kegiatan"]."</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td width=35% >Masalah</td><td width=5% > : </td><td width=60% rows=3>".$row["masalah"]."</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td width=35% >Pemecahan</td><td width=5% > : </td><td width=60% rows=3>".$row["pemecahan"]."</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td width=35% >Status Kemajuan</td><td width=5% > : </td><td width=60%>".$row["status_kemajuan"]." %</td>\n";
  echo "</tr>\n";
}

echo "<input type='hidden' name='kodeproyek' value='$p1'>\n";
echo "<input type='hidden' name='p1' value='$p1'>\n";
echo "<input type='hidden' name='jnstransaksi' value='input kemajuan'>\n";
echo "<input type='hidden' name='jnspelaporan' value='$jenis_pelaporan'>\n";

if ($proyek_termin_tbl <> $proyek_termin_frm) {
  echo "<tr>\n";
  echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;<input type=submit name=psubmit value='Simpan'></td>\n";
  echo "</tr>\n";
} else {
}
echo "</table>\n";
echo "</form>\n";
echo "</body>\n";
echo "</html>\n";



