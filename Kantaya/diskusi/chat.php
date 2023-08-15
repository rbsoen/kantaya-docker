<?php
/***********************************************************************
Nama File : chat.php
Fungsi    : Menampilkan diskusi
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

$reload = 10000;
$max_lines = 1000;

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

if ($p1 == 'keluar') {
    keluar_kamar ($p2,$kode_pengguna,'Y');
} elseif ($p1 == 'namakamar') {
    nama_kamar($p2);
} elseif ($p1 == 'list_tamu') {
    list_tamu_kamar($p2);
} elseif ($p1 == 'kirim') {
    kirim_tanggapan ($p2);
} elseif ($p1 == 'isi') {
    isi_diskusi($p2);
} elseif ($p1 == 'proses') {
    proses_tanggapan ($p2);
}

function nama_kamar($nokamar) {
    global $db, $css, $reload;
    $query = mysql_query("SELECT * FROM kamar_diskusi WHERE kode_kamar=$nokamar", $db);
    $row = mysql_fetch_array($query);
    echo "<html>\n";
    echo "<head>\n";
    echo "<title>Kamar Diskusi</title>\n";
    echo "<link rel=stylesheet type='text/css' href='$css'>\n";
    echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td width='90%'><b>Ruang: ".$row["nama_kamar"]."&nbsp;(".$row["kata_sambutan"].")&nbsp;</td>\n";
    echo "<td width='10%'><b><a href='chat.php?p1=keluar&p2=$nokamar'>Keluar</a></td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</body>\n";
    echo "</html>\n";
}

function list_tamu_kamar($nokamar) {
    global $db, $css, $reload;
    $query = mysql_query("SELECT kode_pengunjung FROM pengunjung_kamar WHERE kode_kamar=$nokamar", $db);
    echo "<html>\n";
    echo "<head>\n";
    echo "<script language='JavaScript'>\n";
    echo "window.setTimeout(\"location.reload()\",$reload)\n";
    echo "</script>\n";
    echo "<noscript>\n";
    echo "<meta http-equiv=\"refresh\" content=\"$reload; URL=chat.php?p1=list_tamu&p2=$nokamar\">\n";
    echo "</noscript>\n";
    echo "<title>List Pengunjung</title>\n";
    echo "<link rel=stylesheet type='text/css' href='$css'>\n";
    echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
    echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
    echo "</head>\n";
    echo "<body>\n";

    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td class='judul1'>Pengunjung</td>";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td>&nbsp;</td>\n";
    echo "</tr>\n";
    while ($row = mysql_fetch_array($query)) {
        ambil_data_pengguna($db, $row["kode_pengunjung"], $tamu);
        echo "<tr>\n";
        echo "<td>".$tamu["username"]."&nbsp;</td>\n";
        echo "</tr>\n";
    }
    echo "</table>\n";
    
    echo "</body>\n";
    echo "</html>\n";
}

function kirim_tanggapan($nokamar) {
    global $db, $css;
    echo "<html>\n";
    echo "<head>\n";
    echo "<title>Kirim Tanggapan</title>\n";
    echo "<link rel=stylesheet type='text/css' href='$css'>\n";
    echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "<form name='kirim' method='post' action='chat.php'>\n";
    echo "<input type=hidden name='namaform' value='kirim'>\n";
    echo "<input type=hidden name='p1' value='proses'>\n";
    echo "<input type=hidden name='p2' value='$nokamar'>\n";
    echo "<table width='100%' border=0>\n";
    echo "<tr>\n";
    echo "<td width='20%'>Pesan/Tanggapan</td>\n";
    echo "<td width='70%'><textarea rows=3 cols=40 name='mesg'></textarea></td>\n";
    echo "<td width='10%' valign='center'>\n";
    echo "<input type=submit name=submit value='Kirim'>\n";
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    echo "</form>\n";
    echo "</body>\n";
    echo "</html>\n";
}

function proses_tanggapan($nokamar) {
    global $db, $max_lines, $mesg, $kode_pengguna;
    $tgljam = date("Y-n-j H:i:s");
    $chatfile = "kamar/kamar_".$nokamar.".isi";
    $isi = nl2br(htmlspecialchars($mesg));
    if (file_exists($chatfile)) {
        $lines = file($chatfile);
        for($i = count($lines); $i >= (count($lines)-$max_lines);$i--){
            $contents= $lines[$i].$contents;
        }
        $deleted = unlink($chatfile);
        $fp = fopen($chatfile, "a+");
        flock($fp, 2);
        $fw = fwrite($fp, $contents);
        fclose($fp);
    }
    ambil_data_pengguna($db, $kode_pengguna, $tamu);
    if ($isi <> ""){
        $fp = fopen($chatfile,'a+');
        flock($fp, 2);
        $fw = fwrite($fp, "\n<b>&lt;".$tamu["username"]."&gt;</b> $isi<br>");
        fclose($fp);
    }
    $sqltext = "update pengunjung_kamar set tgl_respon_akhir = '$tgljam' where kode_kamar=$nokamar and kode_pengunjung=$kode_pengguna";
    $hasil = mysql_query($sqltext, $db);
    check_mysql_error(mysql_errno(),mysql_error());
    
    echo "<script language='JavaScript'>\n";
//    echo "window.open('chat_idx.php?p1=$nokamar#end','_parent')\n";
//    echo "window.open('chat.php?p1=isi&p2=$nokamar#end','isi')\n";
    echo "parent.isi.document.close();\n";
    echo "parent.isi.location.replace(\"chat.php?p1=isi&p2=$nokamar#end\");\n";
    echo "</script>\n";
    
    kirim_tanggapan($nokamar);

}

function keluar_kamar($nokamar,$kode_pengguna,$exit) {
    global $db, $max_lines, $mesg;
    ambil_data_pengguna($db, $kode_pengguna, $tamu);
    $chatfile = "kamar/kamar_".$nokamar.".isi";
    $isi = "Jam ".date("H:i:s")." ".$tamu["username"]." Keluar Ruangan";
    if (file_exists($chatfile)) {
        $lines = file($chatfile);
        for($i = count($lines); $i >= (count($lines)-$max_lines);$i--){
            $contents= $lines[$i].$contents;
        }
        $deleted = unlink($chatfile);
        $fp = fopen($chatfile, "a+");
        flock($fp, 2);
        $fw = fwrite($fp, $contents);
        fclose($fp);
    }
    if ($isi <> ""){
        $fp = fopen($chatfile,'a+');
        flock($fp, 2);
        $fw = fwrite($fp, "\n<p> $isi<br>");
        fclose($fp);
    }
    $sqltext = "delete from pengunjung_kamar where kode_kamar=$nokamar and kode_pengunjung=$kode_pengguna";
    $hasil = mysql_query($sqltext, $db);
    check_mysql_error(mysql_errno(),mysql_error());
    $sqltext = "select count('x') from pengunjung_kamar where kode_kamar=$nokamar";
    $hasil = mysql_query($sqltext, $db);
    $hasil = mysql_fetch_array($hasil);
    if ($hasil[0] == 0) {
        $query = mysql_query("select jenis_kamar from kamar_diskusi where kode_kamar=$nokamar", $db);
        $query = mysql_fetch_array($query);
        if ($query["jenis_kamar"] == "S") {
            $sqltext = "delete from kamar_diskusi where kode_kamar=$nokamar";
            $sql = mysql_query($sqltext, $db);
            check_mysql_error(mysql_errno(),mysql_error());
        }
        if (file_exists($chatfile)) unlink($chatfile);
    }
    if ($exit == 'Y') {
        echo "<script language='JavaScript'>\n";
        echo "window.open('index.php','_parent')\n";
        echo "</script>\n";
    }
}


function isi_diskusi($nokamar) {
    global $db, $css, $reload, $max_lines;
    $chatfile = "kamar/kamar_".$nokamar.".isi";
    echo "<html>\n";
    echo "<head>\n";
    echo "<title>Isi Diskusi</title>\n";
    echo "<script language='JavaScript'>\n";
    echo "window.setTimeout(\"location.reload()\",$reload);\n";
    echo "window.open('chat.php?p1=isi&p2=$nokamar#end','isi');\n";
    echo "</script>\n";
    echo "<noscript>\n";
    echo "<meta http-equiv=\"refresh\" content=\"$reload; URL=chat.php?p1=isi&p2=$nokamar#end\">\n";
    echo "</noscript>\n";
    echo "<link rel=stylesheet type='text/css' href='$css'>\n";
    echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
    echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
    echo "</head>\n";
    echo "<body>\n";
    if (file_exists($chatfile)) {
        $lines = file($chatfile);
        for ($i = (count($lines)-$max_lines); $i <= count($lines)  ;$i++) {
            if ($i == count($lines)-1) {
                echo "<a id='end'>$lines[$i]</a>";
            } else {
                echo $lines[$i];
            }
        }
    }
    echo "</body>\n";
    echo "</html>\n";
}

?>


    

