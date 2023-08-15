<?php
/***********************************************************************
Nama File : index.php
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
?>

<html>
<head>
<title></title>
<script language='Javascript'>
function settingframe() {
    document.open("text/html","index");
    document.writeln("<html>");
    document.writeln("<head> ");
    document.writeln("<title>Kantaya - Forum</title>");
    if (screen.width==800) {
        document.writeln("<frameset rows='33%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
            document.writeln("<frame src='../lib/kepala.php' name='judul' >");
            document.writeln("<frameset cols='30%,*' frameborder='1' border='1' framespacing='1'>");
                document.writeln("<frame src='navigasi_chat.php' name='navigasi' noresize>");
                document.writeln("<frame src='list_kamar.php?p1=P' name='isi'>");
            document.writeln("</frameset>");
        document.writeln("</frameset>");
    } else {
        document.writeln("<frameset rows='26%,*' frameborder='0' border='0' framespacing='0' scrolling='No' noresize>");
            document.writeln("<frame src='../lib/kepala.php' name='judul' >");
            document.writeln("<frameset cols='30%,*' frameborder='1' border='1' framespacing='1'>");
                document.writeln("<frame src='navigasi_chat.php' name='navigasi' noresize>");
                document.writeln("<frame src='list_kamar.php?p1=P' name='isi'>");
            document.writeln("</frameset>");
        document.writeln("</frameset>");
    }
    document.writeln("</head> ");
    document.writeln("</html>");
    document.close();
};
</script>
</head>
<body onLoad=settingframe()>
</body>
</html>
