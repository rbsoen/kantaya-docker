<?php
/*************************************************
Nama File : list_jadwal_m.php
Fungsi    : 
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 13-11-2001
 Oleh     : AS
 Revisi   : css,
**************************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../lib/kantaya_cfg.php");
$css = "../css/".$tampilan_css.".css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

$proyek = mysql_query("SELECT no_proyek, nama_proyek, tahun_anggaran, tgl_mulai, tgl_selesai, (to_days(tgl_selesai)-to_days(tgl_mulai)) ttlhari FROM proyek WHERE kode_proyek='$p1'", $db);
$proyek = mysql_fetch_array($proyek);

$sqltext = "select * from jadwal_proyek where kode_proyek = $p1 order by no_kegiatan";
$query = mysql_query($sqltext, $db);

list($y1,$m1,$d1)=split("-",$proyek["tgl_mulai"]);
list($y2,$m2,$d2)=split("-",$proyek["tgl_selesai"]);

echo "<html>\n";
echo "<head>\n";
echo "<title>List Jadwal Kegiatan Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "<script language='Javascript'>\n";
echo "function ubah_tampilan(fld,p1) {\n";
echo "  var ptamp = fld.options[fld.options.selectedIndex].value;\n";
echo "  if (ptamp == 'B') {\n";
echo "    window.open('list_jadwal_b.php?p1='+p1,'isi');\n";
echo "  } else if (ptamp == 'M') {\n";
echo "    window.open('list_jadwal_m.php?p1='+p1,'isi');\n";
echo "  } else if (ptamp == 'H') {\n";
echo "    window.open('list_jadwal_h.php?p1='+p1,'isi');\n";
echo "  }\n";
echo "};\n";
echo "</script>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1' width='80%'>List Jadwal Kegiatan Proyek</td>\n";
echo "</tr>\n";
echo "</table>\n";

echo "<form name='listjadwal' method='post' action='listproyek.php' target='isi'>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td width='20%'>Tahun Anggaran</td>\n";
echo "<td width='80%'>: ".$proyek["tahun_anggaran"]."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Proyek</td>\n";
echo "<td width='80%'>: <a href='detail_proyek.php?p1=$p1'>".$proyek["nama_proyek"]."</a></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Periode</td>\n";
echo "<td width='80%'>: ".tanggal('S',$proyek["tgl_mulai"])." s/d ".tanggal('S',$proyek["tgl_selesai"])."</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width='20%'>Tampilan</td>\n";
echo "<td width='80%'>: \n";
     echo "<select name='tampilan' onChange=ubah_tampilan(this,$p1)>\n";
     echo "<option value='B'>Bulanan</option>\n";
     echo "<option value='M' selected>Mingguan</option>\n";
     echo "<option value='H'>Harian</option>\n";
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2 align='right'><a href='input_jadwal.php?p1=$p1'>Pendaftaran Kegiatan</a></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</form><p>\n";

$pm = $m1;
$py = $y1;
$ttlminggu = 0;
$i = 0;
$flag = true;
while ($flag) {
    $pday = date('Y-m-d',mktime(0,0,0,$m1,($d1+$i),$y1));
    if ($pday >= $proyek["tgl_selesai"]) {
        $flag = false;
    } else {
        $i = $i + 7;
        $ttlminggu++;
    }
}

echo "<table width='".(900+($ttlminggu*15))."' border=0>\n";
echo "<tr align='center'>\n";
echo "<td rowspan=2 class='judul2' width='100'>No</td>\n";
echo "<td rowspan=2 class='judul2' width='300'>Kegiatan</td>\n";
echo "<td rowspan=2 class='judul2' width='50' align='center'>Jenis</td>\n";
echo "<td rowspan=2 class='judul2' width='50' align='center'>Bobot</td>\n";
echo "<td rowspan=2 class='judul2' width='50' align='center'>Status</td>\n";
echo "<td rowspan=2 class='judul2' width='50' align='center'>R/A</td>\n";
echo "<td rowspan=2 class='judul2' width='150' align='center'>Tgl Mulai</td>\n";
echo "<td rowspan=2 class='judul2' width='150' align='center'>Tgl Selesai</td>\n";
echo "<td colspan=$ttlminggu class='judul3' align='center'>Minggu</td>\n";
echo "</tr>\n";
echo "<tr>\n";

for ($i=1; $i<=$ttlminggu; $i++) {
    echo "<td class='judul3' align='center' width='15'>$i</td>\n";
}

echo "</tr>\n";
$i = 0;
while ($row = mysql_fetch_array($query)) {
    $i++;
    echo "<tr>\n";
    echo "<td class='isi2' rowspan=2 valign='center'>".$row["no_kegiatan"]."&nbsp;</td>\n";
    echo "<td class='isi2' rowspan=2 valign='center'><a href='jadwal_detail.php?p1=$p1'>".$row["nama_kegiatan"]."&nbsp;</a></td>\n";
    echo "<td class='isi2' rowspan=2 valign='center' align='center'>".$row["jenis_kegiatan"]."&nbsp;</td>\n";
    echo "<td class='isi2' rowspan=2 valign='center' align='center'>".$row["bobot"]."&nbsp;</td>\n";
    echo "<td class='isi2' rowspan=2 valign='center' align='center'>".$row["status"]."&nbsp;</td>\n";
    echo "<td class='isi2' align='center'>Renc</td>\n";
    echo "<td class='isi2' align='center'>".tanggal('S',$row["rcn_tgl_mulai"])."&nbsp;</td>\n";
    echo "<td class='isi2' align='center'>".tanggal('S',$row["rcn_tgl_selesai"])."&nbsp;</td>\n";
    
    for ($j=0; $j<$ttlminggu; $j++) {
        $pday1 = date('Y-m-d',mktime(0,0,0,$m1,($d1+($j*7)),$y1));
        $pday2 = date('Y-m-d',mktime(0,0,0,$m1,($d1+($j*7)+6),$y1));
        if (($row["rcn_tgl_mulai"]<=$pday2) and ($pday1<=$row["rcn_tgl_selesai"])) {
            echo "<td bgcolor='#008080' >&nbsp;</td>\n";
        } else {
            echo "<td class='isi2'>&nbsp;</td>\n";
        }
    }
    
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td class='isi2' align='center'>Aktl</td>\n";
    echo "<td class='isi2' align='center'>".tanggal('S',$row["akt_tgl_mulai"])."&nbsp;</td>\n";
    echo "<td class='isi2' align='center'>".tanggal('S',$row["akt_tgl_selesai"])."&nbsp;</td>\n";

    for ($j=0; $j<$ttlminggu; $j++) {
        $pday1 = date('Y-m-d',mktime(0,0,0,$m1,($d1+($j*7)),$y1));
        $pday2 = date('Y-m-d',mktime(0,0,0,$m1,($d1+($j*7)+6),$y1));
        if (($row["akt_tgl_mulai"]<=$pday2) and ($pday1<=$row["akt_tgl_selesai"])) {
            echo "<td bgcolor='#6F6F00' >&nbsp;</td>\n";
        } else {
            echo "<td class='isi2'>&nbsp;</td>\n";
        }
    }
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td colspan=".(5+$ttlminggu).">&nbsp;</td>\n";
    echo "</tr>\n";
}
if ($i==0) {
    echo "<tr>\n";
    echo "<td colspan=5>Belum ada Kegiatan yang terdaftar</td>\n";
    echo "</tr>\n";
}
echo "<tr>\n";
echo "<td colspan=7>\n";
echo "</tr>\n";
echo "</table><p>\n";



echo "</body>\n";
echo "</html>\n";


