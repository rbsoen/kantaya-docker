<?php
/***********************************************************************
Nama File : list_kamar.php
Fungsi    : Menampilkan list kamar tiap ruang diskusi
Dibuat    :
Tgl.      : 07-11-2001
Oleh      : FB

Revisi 1  :
Tgl.      :
Oleh      :
Revisi    :
***********************************************************************/
include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../lib/kantaya_cfg.php");
$css = "../css/$tampilan_css.css";

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

if ($p1=="U"){
    $query = mysql_query("SELECT * FROM unit_kerja WHERE kode_unit = '$p2'", $db);
    $query = mysql_fetch_array($query);
    $unit_grup = $query["nama_unit"];
} else if ($p1=="G"){
    $query = mysql_query("SELECT * FROM grup WHERE kode_grup = '$p2'", $db);
    $query = mysql_fetch_array($query);
    $unit_grup = $query["nama_grup"];
}
ambil_data_pengguna($db, $kode_pengguna, $pengguna);
$where = "ktgr_ruang='$p1' and nama_ruang='$p2' and (sifat='B' or (sifat='U' and (tuan_rumah like '%".$pengguna["username"]."%' or undangan like '%".$pengguna["username"]."%')))";
//echo "SELECT count('x') FROM kamar_diskusi WHERE $where<br>\n";
$query = mysql_query("SELECT count('x') FROM kamar_diskusi WHERE $where", $db);
$jmldata = mysql_fetch_array($query);
$purl = "list_kamar.php?p1=$p1&p2=$p2";
if ($halaman == "") $halaman = 1;

echo "<html>\n";
echo "<head>\n";
echo "<title>List Kamar Diskusi</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";

echo "<script language='Javascript'>\n";
echo "function check_sifat(pfld) {\n";
echo "  pval = pfld.options[pfld.selectedIndex].value;\n";
echo "  if (pval == 'B') {\n";
echo "     document.buatkamar.undangan.value = '';\n";
echo "     document.buatkamar.nama_undangan.value = '';\n";
echo "  }\n";
echo "}\n";

echo "function check_undangan(pfld) {\n";
echo "  if (pfld.value != '') {\n";
echo "     document.buatkamar.sifat.selectedIndex = 1;\n";
echo "  }\n";
echo "}\n";

echo "function showUserList(pfld,pfltr) {\n";
echo "  if (window.PsnList && window.PsnList.open && !window.PsnList.closed) {\n";
echo "    window.PsnList.close();\n";
echo "  }\n";
//echo " alert(navigator.appName)\n";
echo "  PsnList = window.open('list_undangan.php?pfld='+pfld+'&pfltr='+pfltr, 'List', 'width=390,height=450,scrollbars=yes');\n";
echo "};\n";


echo "</script>\n";
echo "</head>\n";
echo "<body>\n";

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul1'>";
if ($p1 == "U") {
   echo "Ruang Unit : $unit_grup\n";
} elseif ($p1 == "G") {
   echo "Ruang Grup : $unit_grup\n";
} else {
   echo "Ruang : Publik\n";
}

echo "</table><p>\n";
echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td>Berikut adalah list nama-nama kamar yang telah terdaftar pada ruangan ini.
Anda dapat memilih salah satu kamar yang sesuai dengan kebutuhan Anda untuk kemudian ikut berpartisipasi dalam diskusi
yang sedang berlangsung didalamnya. Untuk menambah atau mendaftar kamar baru silahkan isi <a href='list_kamar.php?p1=$p1&p2=$p2#form'>form pendaftaran</a> dibawah.\n</td>";
echo "</tr>\n";
echo "</table><p>\n";

navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$purl);

echo "<table width='100%' border=0>\n";
echo "<tr>\n";
echo "<td class='judul3' width='35%'>Nama Kamar</td>\n";
echo "<td class='judul3' width='20%'>Tuan Rumah</td>\n";
echo "<td class='judul3' width='15%'>Jenis</td>\n";
echo "<td class='judul3' width='15%'>Sifat</td>\n";
echo "<td class='judul3' width='15%'>Jml Pengunjung</td>\n";
echo "</tr>\n";

$i = 1;
$query = mysql_query("SELECT * FROM kamar_diskusi WHERE $where order by nama_ruang", $db);
while ($row = mysql_fetch_array($query)) {
    $jmltamu = mysql_query("SELECT count(*) FROM pengunjung_kamar WHERE kode_kamar = ".$row["kode_kamar"], $db);
    $jmltamu = mysql_fetch_array($jmltamu);
    if ($i > ($halaman-1)*$ttlperhalaman and $i <= ($halaman)*$ttlperhalaman) {
       echo "<tr>\n";
       echo "<td width='35%'><a href='chat_idx.php?p1=".$row["kode_kamar"]."' target='_parent'>".$row["nama_kamar"]."</a>&nbsp;</td>\n";
       echo "<td width='20%'>".$row["tuan_rumah"]."&nbsp;</td>\n";
       echo "<td width='15%'>\n";
            if ($row["jenis_kamar"] == 'S') {
                echo "Sementara\n";
            } else {
                echo "Permanen\n";
            }
       echo "&nbsp;</td>\n";
       echo "<td width='15%'>\n";
            if ($row["sifat"] == 'B') {
                echo "Bebas\n";
            } else {
                echo "Undangan\n";
            }
       echo "&nbsp;</td>\n";
       echo "<td width='15%' align='center'>$jmltamu[0]</td>\n";
       echo "</tr>\n";
    }
    $i++;
}

if ($i == 1) {
    echo "<tr>\n";
    echo "<td colspan=3>Belum ada kamar yang terdaftar sampai saat ini</td>\n";
    echo "</tr>\n";
}

echo "</table>\n";

navigasi_halaman($halaman,$ttlperhalaman,$jmldata[0],$purl);

pendaftaran_kamar($db);

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

function pendaftaran_kamar($db) {
    global $p1, $p2, $level, $kode_pengguna;
    echo "<p id='form'>\n";
    echo "<form name='buatkamar' method='post' action='post_diskusi.php' target='isi'>\n";
    echo "<input type=hidden name='namaform' value='buatkamar'>\n";
    echo "<input type=hidden name='ktgr_ruang' value='$p1'>\n";
    echo "<input type=hidden name='nama_ruang' value='$p2'>\n";
    echo "<input type=hidden name=jnstransaksi value='tambah'>\n";
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul1' colspan=4>Pendaftaran Kamar Diskusi</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Nama Kamar</td>\n";
    echo "<td colspan=3>\n";
    echo "<input type=text name='nama_kamar' size=30 value=''>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Tuan Rumah</td>\n";
    echo "<td width='30%'>\n";
    if ($level == 1) {
        ambil_data_pengguna($db, $kode_pengguna, $admin);
        echo "<select name='tuan_rumah'>\n";
        echo "<option value=".$admin["username"]." selected>".$admin["username"]."</option>\n";
        echo "<option value='Administrator'>Administrator</option>\n";
        echo "</select>\n";
    } else {
        ambil_data_pengguna($db, $kode_pengguna, $pengguna);
        echo "<input type=hidden name='tuan_rumah' value='".$pengguna["username"]."'>\n";
        echo "<font size=+1>".$pengguna["username"]."</font>\n";
    }
    echo "</td>\n";
    echo "<td width='20%'>Jenis Kamar</td>\n";
    echo "<td width='30%'>\n";
    if ($level == 1) {
        echo "<select name='jenis_kamar'>\n";
        echo "<option value='P' selected>Permanen</option>\n";
        echo "<option value='S'>Sementara</option>\n";
        echo "</select>\n";
    } else {
        echo "<input type=hidden name='jenis_kamar' value='S'>\n";
        echo "<font size=+1>Sementara</font>\n";
    }
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Sifat</td>\n";
    echo "<td colspan=3>\n";
        echo "<select name='sifat' onChange=check_sifat(this)>\n";
        echo "<option value='B' selected>Bebas</option>\n";
        echo "<option value='U'>Khusus Undangan</option>\n";
        echo "</select>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Undangan</td>\n";
    echo "<td colspan=3>\n";
    echo "<input type=hidden name='undangan' size=40 value=''>\n";
    echo "<input type=text name='nama_undangan' size=40 value='' onBlur=check_undangan(this)>\n";
    echo "<a href=\"javascript:showUserList('buatkamar,undangan,nama_undangan','$p2')\">\n";
    echo "<img align=top border=0 height=21 src='../gambar/p108.gif'></a>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Kata Sambutan</td>\n";
    echo "<td colspan=3><input type=text name='kata_sambutan'  size=40 value=''></td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td colspan=4 align='center'><p><input type=submit name=submit value='Tambahkan'></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";

}

