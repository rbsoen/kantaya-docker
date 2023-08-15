<?php
/***********************************************************************
Nama File : list_proyek.php
Fungsi    : Menampilkan list proyek tiap unit dan tahun anggaran
Dibuat    :
Tgl.      : 19-10-2001
Oleh      : FB

Revisi 1  :
Tgl.      : 13-11-2001
Oleh      : AS
Revisi    : Link pendaftaran proyek
***********************************************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../lib/kantaya_cfg.php");
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

if ($p1=="") {
    $p1 = "U;".$unit_pengguna;
}
list($jns_sharing,$grup_sharing) = split(';',$p1);
if ($p2 == "") {
    $tahun = date("Y");
} else {
    $tahun = $p2;
}
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
if ($halaman == "") $halaman = 1;

echo "<html>\n";
echo "<head>\n";
echo "<title>List Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "<script language='Javascript'>\n";
echo "function showListProyek() {\n";
echo "  var obj = document.listproyek;\n";
echo "  var p1 = obj.p1.value;\n";
echo "  var p2 = obj.thn_anggaran.options[obj.thn_anggaran.selectedIndex].value;\n";
echo "  var p3 = obj.jnsproyek.options[obj.jnsproyek.selectedIndex].value;\n";
echo "  window.open('list_proyek.php?p1='+p1+'&p2='+p2+'&p3='+p3, 'isi');\n";
echo "};\n";
echo "</script>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1' width='75%'>\n";
if ($jns_sharing == "U") {
   echo "Unit : $unit_grup\n";
} elseif ($jns_sharing == "G") {
   echo "Grup : $unit_grup\n";
}
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";


navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$purl);

echo "<form name='listproyek' method='post' action='listproyek.php' target='isi'>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td width='20%'>Tahun</td>\n";
echo "<td colspan=2>: \n";
     $query = mysql_query("SELECT tahun_anggaran FROM proyek WHERE jenis_sharing='$jns_sharing' and grup_sharing='$grup_sharing' order by tahun_anggaran desc", $db);
     echo "<select name='thn_anggaran'>\n";
     $i = 0;
     echo "<option value=".$tahun." selected>".$tahun."</option>\n";
     while ($row = mysql_fetch_array($query)) {
         if ($row["tahun_anggaran"] <> $tahun) {
             echo "<option value=".$row["tahun_anggaran"].">".$row["tahun_anggaran"]."</option>\n";
         }
         $i++;
     }
     if ($i==0) {
         echo "<option value=".$tahun." selected>".$tahun."</option>\n";
     }
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Jenis Proyek</td>\n";
echo "<td width='50%'>: \n";
     $query = mysql_query("SELECT * FROM kd_jns_proyek order by nama", $db);
     echo "<select name='jnsproyek'><option value='' selected>Semua Proyek</option>\n";
     while ($row = mysql_fetch_array($query)) {
         if ($row["kode"] == $p3) {
             echo "<option value=".$row["kode"]." selected>".$row["nama"]."</option>\n";
         } else {
             echo "<option value=".$row["kode"].">".$row["nama"]."</option>\n";
         }
     }
     echo "</select>\n";
echo "</td>\n";
echo "<td width='30%'>\n";
echo "<input type=hidden name='p1' value='$p1'>\n";
echo "<input type=button name=submit value='Lihat' onClick=showListProyek()></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=3 align='right'><a href='daftar_proyek.php?p1=$p1'>Pendaftaran Proyek</a></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</form><p>\n";

echo "<table width='100%' border=0>\n";
echo "<tr align=center>\n";
echo "<td class='judul2' width='10%'>No Proyek</td>\n";
echo "<td class='judul2' width='30%'>Nama Proyek</td>\n";
echo "<td class='judul2' width='20%'>Koordinator</td>\n";
echo "<td class='judul2' width='15%'>Tgl Mulai</td>\n";
echo "<td class='judul2' width='15%'>Tgl Selesai</td>\n";
echo "<td class='judul2' align='center' width='10%'>Realisasi (%)</td>\n";
echo "</tr>\n";

$i = 1;
$query = mysql_query("SELECT * FROM proyek WHERE $where order by tgl_mulai desc", $db);
while ($row = mysql_fetch_array($query)) {
    ambil_data_pengguna($db, $row["koordinator"], $koordinator);
    if ($i > ($halaman-1)*$ttlperhalaman and $i <= ($halaman)*$ttlperhalaman) {
       echo "<tr>\n";
       echo "<td class='isi2' width='10%'>".$row["no_proyek"]."&nbsp;</td>\n";
       echo "<td class='isi2' width='30%'><a href='detail_proyek.php?p1=".$row["kode_proyek"]."'>".$row["nama_proyek"]."</a>&nbsp;</td>\n";
       echo "<td class='isi2' width='20%'><a href=mailto:".$koordinator["email"].">".$koordinator["nama"]."</a>&nbsp;</td>\n";
       echo "<td class='isi2' width='15%'>".tanggal('S',$row["tgl_mulai"])."&nbsp;</td>\n";
       echo "<td class='isi2' width='15%'>".tanggal('S',$row["tgl_selesai"])."&nbsp;</td>\n";
       echo "<td class='isi2' width='10%' align='center'>".hitung_realisasi_proyek($row["kode_proyek"])."&nbsp;</td>\n";
       echo "</tr>\n";
    }
    $i++;
}

echo "</table><p>\n";

navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$purl);

echo "</body>\n";
echo "</html>\n";


function navigasi_halaman($halaman,$ttlperhalaman,$jmldata,$purl) {
    $jmlhalaman = ceil($jmldata/$ttlperhalaman);
    if ($jmlhalaman == 0) $jmlhalaman = 1;
    if ($jmldata > $ttlperhalaman) {
       echo "<table width='100%' border=0>\n";
       echo "<tr>\n";
       echo "<td align='center'><h4>\n";
       if ($halaman > 1) {
          $hal_sblm = $halaman - 1;
          echo "<a href='$purl"."&halaman=".$hal_sblm."'> < </a> \n";
       } else {
          echo "<\n";
       }
       echo " Hal: ".$halaman." / ".$jmlhalaman. "\n";
       if ($halaman*$ttlperhalaman < $jmldata) {
          $hal_ssdh = $halaman + 1;
          echo "<a href='$purl"."&halaman=".$hal_ssdh."'> > </a> \n";
       } else {
          echo ">\n";
       }
       echo "</td>\n";
       echo "</tr>\n";
       echo "</table><p>\n";
    }
}

function hitung_realisasi_proyek($kdproyek) {
    global $db;
    $query = mysql_query("SELECT no_kegiatan, bobot, status FROM jadwal_proyek where kode_proyek='$kdproyek' and induk_kegiatan=''", $db);
    while ($row = mysql_fetch_array($query)) {
        $prealisasi += $row["bobot"] * hitung_realisasi_kgtn($kdproyek,$row["no_kegiatan"],$row["status"]) / 100;
    }
    return ($prealisasi);
}

function hitung_realisasi_kgtn($kdproyek,$nokgtn,$status) {
    global $db;
    $query = mysql_query("SELECT no_kegiatan, bobot, status FROM jadwal_proyek where kode_proyek='$kdproyek' and induk_kegiatan='$nokgtn'", $db);
    $cnt = 0;
    while ($row = mysql_fetch_array($query)) {
        $prealisasi += $row["bobot"] * hitung_realisasi_kgtn($kdproyek,$row["no_kegiatan"],$row["status"]) / 10000;
        $cnt++;
    }
    if ($cnt==0) {
        return ($status);
    } else {
        return ($prealisasi);
    }
}


