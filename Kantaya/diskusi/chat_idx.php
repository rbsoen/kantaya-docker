<?php
/***********************************************************************
Nama File : chat_idx.php
Fungsi    : Menampilkan halaman muka modul Diskusi (Chat)
Dibuat    :
Tgl.      : 07-11-2001
Oleh      : FB

Revisi 1  :
Tgl.      :
Oleh      :
Revisi    :
***********************************************************************/

include ('../lib/cek_sesi.inc');
include('../lib/fs_umum.php');
require("../lib/kantaya_cfg.php");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);
$tgljam = date("Y-n-j H:i:s");

$sqltext = mysql_query("SELECT count('x') FROM pengunjung_kamar WHERE kode_kamar=$p1 and kode_pengunjung=$kode_pengguna", $db);
$row = mysql_fetch_array($sqltext);
if ($row[0] == 0) {
    $sqlinsert = "insert into pengunjung_kamar (kode_kamar, kode_pengunjung, tgl_login, tgl_respon_akhir)";
    $sqlinsert .= " values($p1, $kode_pengguna, '$tgljam', '$tgljam')";
    $hasil = mysql_query($sqlinsert, $db);
    check_mysql_error(mysql_errno(),mysql_error());

    ambil_data_pengguna($db, $kode_pengguna, $tamu);
    $chatfile = "kamar/kamar_".$p1.".isi";
    $isi = "Jam ".date("H:i:s")." ".$tamu["username"]." Masuk Ruangan";
    /*
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
    */
    if ($isi <> ""){
        $fp = fopen($chatfile,'a+');
        flock($fp, 2);
        $fw = fwrite($fp, "\n<p> $isi<br>");
        fclose($fp);
    }
}

?>

<html>
<head>
<title></title>
<script language='Javascript'>
function settingframe(nokamar) {
    document.open("text/html","index");
    document.writeln("<html>");
    document.writeln("<head> ");
    document.writeln("<title>Kantaya - Forum</title>");
    if (screen.width==800) {
        document.writeln("<frameset rows='38%,*' frameborder='1' border='1' framespacing='1' scrolling='No' noresize>");
            document.writeln("<frame src='../lib/kepala.php' name='judul' >");
            document.writeln("<frameset rows='13%,*' frameborder='1' border='0' framespacing='0' scrolling='No' noresize>");
                document.writeln("<frame src='chat.php?p1=namakamar&p2="+nokamar+"' name='online' noresize>");
                document.writeln("<frameset cols='20%,*' frameborder='1' border='0' framespacing='0' scrolling='No' noresize>");
                    document.writeln("<frame src='chat.php?p1=list_tamu&p2="+nokamar+"' name='online' noresize>");
                    document.writeln("<frameset rows='75%,*' frameborder='1' border='0' framespacing='0' scrolling='No' noresize>");
                        document.writeln("<frame src='chat.php?p1=isi&p2="+nokamar+"#end' name='isi'>");
                        document.writeln("<frame src='chat.php?p1=kirim&p2="+nokamar+"' name='kirim'>");
                    document.writeln("</frameset>");
                document.writeln("</frameset>");
            document.writeln("</frameset>");
        document.writeln("</frameset>");
    } else {
        document.writeln("<frameset rows='23%,*' frameborder='1' border='0' framespacing='0' scrolling='No' noresize>");
            document.writeln("<frame src='../lib/kepala.php' name='judul' >");
            document.writeln("<frameset rows='13%,*' frameborder='1' border='1' framespacing='0' scrolling='No' noresize>");
                document.writeln("<frame src='chat.php?p1=namakamar&p2="+nokamar+"' name='online' noresize>");
                document.writeln("<frameset cols='20%,*' frameborder='1' border='1' framespacing='0' scrolling='No' noresize>");
                    document.writeln("<frame src='chat.php?p1=list_tamu&p2="+nokamar+"' name='online' noresize>");
                    document.writeln("<frameset rows='75%,*' frameborder='1' border='1' framespacing='0' scrolling='No' noresize>");
                        document.writeln("<frame src='chat.php?p1=isi&p2="+nokamar+"#end' name='isi'>");
                        document.writeln("<frame src='chat.php?p1=kirim&p2="+nokamar+"' name='kirim'>");
                    document.writeln("</frameset>");
                document.writeln("</frameset>");
            document.writeln("</frameset>");
        document.writeln("</frameset>");
    }
    document.writeln("</head> ");
    document.writeln("</html>");
    document.close();
};
</script>
</head>
<?php
echo "<body onLoad=settingframe($p1)>\n";
echo "</body>\n";
?>
</html>
