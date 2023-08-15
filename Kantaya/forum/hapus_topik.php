<?php
include ('../lib/cek_sesi.inc');
include('../lib/fs_kalender.php');
include('../lib/fs_umum.php');
require("../cfg/$cfgfile");
$css = "../css/$tampilan_css.css";

$db = mysql_connect($db_host, $db_user, $db_pswd);
mysql_select_db($db_database, $db);

echo "<html>\n";
echo "<head>\n";
echo "<title>Hasil Pencarian Topik Diskusi</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv=PRAGMA content='no-cache'>\n";
echo "</head>\n";
echo "<body>\n";
echo "<h1><b>FORUM DISKUSI</h1><br>\n";

if ($p1 == 'F') {
    hapus_forum($db, $p2, $p3);
} else if ($p1 == 'T') {
    hapus_topik($db, $p2, $p3);
}

echo "</body>\n";
echo "</html>\n";

function hapus_forum($db, $nonaktif, $flag) {
    echo "<h2><b>Hapus Non Aktif Forum</b></h2><p>\n";
    echo "Berikut adalah forum-forum yang non aktif lebih dari $nonaktif bulan,
          periksa terlebih dahulu sebelum dilakukan penghapusan<p>\n";
    echo "<form name='hapusforum' method='post' action='postforum.php' target='isi'>\n";
    echo "<input type=hidden name=namaform value='hapusforum'>\n";
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul3' width='5%'>&nbsp;</td>\n";
    echo "<td class='judul3' width='35%'>Forum</td>\n";
    echo "<td class='judul3' width='20%'>Dikirimkan Oleh</td>\n";
    echo "<td class='judul3' width='15%'>Jml Topik</td>\n";
    echo "<td class='judul3' width='15%'>Tgl Pengiriman</td>\n";
    echo "<td class='judul3' width='10%'>Non Aktif Hari</td>\n";
    echo "</tr>\n";
    $query = mysql_query("select * from forum where now() >= date_add(dibuat_tgl,interval $nonaktif day)", $db);
    $hapus = false;
    while ($row = mysql_fetch_array($query)) {
        $topik = mysql_query("select to_days(now())-to_days(max(dibuat_tgl)) from topik where kode_forum =".$row["kode_forum"], $db);
        $topik = mysql_fetch_array($topik);
        $jmltopik = mysql_query("SELECT count(*) FROM topik WHERE kode_forum=".$row["kode_forum"]." and respon_thd = 0", $db);
        $jmltopik = mysql_fetch_array($jmltopik);
         if ($topik[0] >= $nonaktif or $topik[0] == 0) {
            if (!$hapus) {
                $hapus = true;
            }
            ambil_data_pengguna($db, $row["dibuat_oleh"], $pengguna);
            echo "<tr>\n";
            echo "<td width='5%'>";
            if ($flag == 'S') {
                echo "<input type='checkbox' name='cb_hapus[]' value=".$row["kode_forum"]." checked></td>\n";
            } else {
                echo "<input type='checkbox' name='cb_hapus[]' value=".$row["kode_forum"]."></td>\n";
            }

            echo "<td width='35%'><a href='topik.php?pid=".$row["kode_forum"]."'>".$row["nama_forum"]."</a>&nbsp;</td>\n";
            echo "<td width='20%'><a href=mailto:".$pengguna["email"].">".$pengguna["nama"]."</a>&nbsp;</td>\n";
            echo "<td width='15%' align='center'>$jmltopik[0]&nbsp;</td>\n";
            echo "<td width='15%'>".tanggal('S',$row["dibuat_tgl"])."&nbsp;</td>\n";
            echo "<td width='10%' align='center'>$topik[0]&nbsp;</td>\n";
            echo "</tr>\n";
        }
    }
    if ($hapus) {
       echo "<tr>\n";
       echo "<td colspan=6><br><a href='hapus_topik.php?p1=F&p2=$nonaktif&p3=S'>Tandai Semua</a></td>\n";
       echo "</tr>\n";
       echo "<tr>\n";
       echo "<td colspan=6 align='center'><input type=submit name=submit value='Hapus Forum'></td>\n";
       echo "</tr>\n";
    } else {
       echo "<tr>\n";
       echo "<td colspan=6 align='left'>Tidak ditemukan forum dengan kriteria seperti yang tersebut diatas</td>\n";
       echo "</tr>\n";
   }
    echo "</table>\n";
    echo "</form>\n";
}

function hapus_topik($db, $nonaktif, $flag) {
    echo "<h2><b>Hapus Non Aktif Topik</b></h2><p>\n";
    echo "Berikut adalah topik-topik yang non aktif lebih dari $nonaktif bulan,
          periksa terlebih dahulu sebelum dilakukan penghapusan<p>\n";
    echo "<form name='hapustopik' method='post' action='postforum.php' target='isi'>\n";
    echo "<input type=hidden name=namaform value='hapustopik'>\n";
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul3' width='5%'>&nbsp;</td>\n";
    echo "<td class='judul3' width='35%'>Topik</td>\n";
    echo "<td class='judul3' width='20%'>Dikirimkan Oleh</td>\n";
    echo "<td class='judul3' width='15%'>Jml Tanggapan</td>\n";
    echo "<td class='judul3' width='15%'>Tgl Pengiriman</td>\n";
    echo "<td class='judul3' width='10%'>Non Aktif Hari</td>\n";
    echo "</tr>\n";
    $query = mysql_query("select * from topik where respon_thd = 0 and now() >= date_add(dibuat_tgl,interval $nonaktif day)", $db);
    $hapus = false;
    while ($row = mysql_fetch_array($query)) {
        $topik = mysql_query("select to_days(now())-to_days(max(dibuat_tgl)) from topik where struktur like '".$row["struktur"]."-%'", $db);
        $topik = mysql_fetch_array($topik);
        $jmltanggapan = mysql_query("SELECT count(*) FROM topik WHERE struktur like '".$row['struktur']."-%'", $db);
        $jmltanggapan = mysql_fetch_array($jmltanggapan);
        if ($topik[0] >= $nonaktif) {
            if (!$hapus) {
                $hapus = true;
            }
            ambil_data_pengguna($db, $row["dibuat_oleh"], $pengguna);
            echo "<tr>\n";
            echo "<td width='5%'>";
            if ($flag == 'S') {
                echo "<input type='checkbox' name='cb_hapus[]' value=".$row["kode_topik"]."checked></td>\n";
            } else {
                echo "<input type='checkbox' name='cb_hapus[]' value=".$row["kode_topik"]."></td>\n";
            }

            echo "<td width='35%'><a href='topik_detail.php?idtopik=".$row["kode_topik"]."'>".$row["judul"]."</a>&nbsp;</td>\n";
            echo "<td width='20%'><a href=mailto:".$pengguna["email"].">".$pengguna["nama"]."</a>&nbsp;</td>\n";
            echo "<td width='15%' align='center'>$jmltanggapan[0]&nbsp;</td>\n";
            echo "<td width='15%'>".tanggal('S',$row["dibuat_tgl"])."&nbsp;</td>\n";
            echo "<td width='10%' align='center'>$topik[0]&nbsp;</td>\n";
            echo "</tr>\n";
        }
    }
    if ($hapus) {
       echo "<tr>\n";
       echo "<td colspan=6><br><a href='hapus_topik.php?p1=T&p2=$nonaktif&p3=S'>Tandai Semua</a></td>\n";
       echo "</tr>\n";
       echo "<tr>\n";
       echo "<td colspan=6 align='center'><input type=submit name=submit value='Hapus Forum'></td>\n";
       echo "</tr>\n";
    } else {
       echo "<tr>\n";
       echo "<td colspan=6 align='left'>Tidak ditemukan topik dengan kriteria seperti yang tersebut diatas</td>\n";
       echo "</tr>\n";
   }
    echo "</table>\n";
    echo "</form>\n";
}



?>




