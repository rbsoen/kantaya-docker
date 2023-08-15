<?php
/*************************************************
Nama File : list_jadwal_h.php
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
     echo "<option value='M'>Mingguan</option>\n";
     echo "<option value='H' selected>Harian</option>\n";
     echo "</select>\n";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan=2 align='right'><a href='input_jadwal.php?p1=$p1'>Pendaftaran Kegiatan</a></td>\n";
echo "</tr>\n";
echo "</table>\n";
echo "</form><p>\n";
echo "<table width='".(900+($proyek["ttlhari"]*15))."' border=0>\n";
echo "<tr align='center'>\n";
echo "<td rowspan=2 class='judul2' width='100'>No</td>\n";
echo "<td rowspan=2 class='judul2' width='300'>Kegiatan</td>\n";
echo "<td rowspan=2 class='judul2' width='50' align='center'>Jenis</td>\n";
echo "<td rowspan=2 class='judul2' width='50' align='center'>Bobot</td>\n";
echo "<td rowspan=2 class='judul2' width='50' align='center'>Status</td>\n";
echo "<td rowspan=2 class='judul2' width='50' align='center'>R/A</td>\n";
echo "<td rowspan=2 class='judul2' width='150' align='center'>Tgl Mulai</td>\n";
echo "<td rowspan=2 class='judul2' width='150' align='center'>Tgl Selesai</td>\n";

$pd = $d1;
$pm = $m1;
$py = $y1;
$flag = true;
while ($flag) {
    $t = date('t',mktime(0,0,0,$pm,$pd,$py));
    $pday = date('Y-m-d',mktime(0,0,0,$pm,$t,$py));
    echo "<td colspan=".($t-$pd+1)." class='judul3' align='center'>".namabulan("S",$pm)." $py</td>\n";
    if ($pday >= $proyek["tgl_selesai"]) {
        $flag = false;
    } else {
        $pd = 1;
        if ($pm == 13) {
            $pm = 1;
            $py = $py + 1;
        } else {
            $pm = $pm + 1;
        }
    }
}

echo "</tr>\n";
echo "<tr>\n";

for ($i=0; $i<=$proyek["ttlhari"]; $i++) {
    $pday = date('d',mktime(0,0,0,$m1,($d1+$i),$y1));
    echo "<td class='judul3' width='15'><font size=-2>$pday</font></td>\n";
}

echo "</tr>\n";
$i = 0;
while ($row = mysql_fetch_array($query)) {
    $i++;
    echo "<tr>\n";
    echo "<td class='isi2' rowspan=2 valign='center'>".$row["no_kegiatan"]."&nbsp;</td>\n";
    echo "<td class='isi2' rowspan=2 valign='center'><a href='jadwal_detail.php?p1=$p1&p2=".$row["no_kegiatan"]."'>".$row["nama_kegiatan"]."&nbsp;</a></td>\n";
    echo "<td class='isi2' rowspan=2 valign='center' align='center'>".$row["jenis_kegiatan"]."&nbsp;</td>\n";
    echo "<td class='isi2' rowspan=2 valign='center' align='center'>".$row["bobot"]."&nbsp;</td>\n";
    echo "<td class='isi2' rowspan=2 valign='center' align='center'>".$row["status"]."&nbsp;</td>\n";
    echo "<td class='isi2' align='center'>Renc</td>\n";
    echo "<td class='isi2' align='center'>".tanggal('S',$row["rcn_tgl_mulai"])."&nbsp;</td>\n";
    echo "<td class='isi2' align='center'>".tanggal('S',$row["rcn_tgl_selesai"])."&nbsp;</td>\n";
    
    for ($j=0; $j<=$proyek["ttlhari"]; $j++) {
        $pday = date('Y-m-d',mktime(0,0,0,$m1,($d1+$j),$y1));
        if (($pday>=$row["rcn_tgl_mulai"]) and ($pday<=$row["rcn_tgl_selesai"])) {
            echo "<td bgcolor='#008080' width='10'>&nbsp;</td>\n";
        } else {
            echo "<td class='isi2' width='15'>&nbsp;</td>\n";
        }
    }
    
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td class='isi2' align='center'>Aktl</td>\n";
    echo "<td class='isi2' align='center'>".tanggal('S',$row["akt_tgl_mulai"])."&nbsp;</td>\n";
    echo "<td class='isi2' align='center'>".tanggal('S',$row["akt_tgl_selesai"])."&nbsp;</td>\n";

    for ($j=0; $j<=$proyek["ttlhari"]; $j++) {
        $pday = date('Y-m-d',mktime(0,0,0,$m1,($d1+$j),$y1));
        if (($pday>=$row["akt_tgl_mulai"]) and ($pday<=$row["akt_tgl_selesai"])) {
            echo "<td bgcolor='#6F6F00' width='10'>&nbsp;</td>\n";
        } else {
            echo "<td class='isi2' width='15'>&nbsp;</td>\n";
        }
    }
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td colspan=".(5+$proyek["ttlhari"]).">&nbsp;</td>\n";
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


