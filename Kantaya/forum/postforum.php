<?php
    include ('../lib/cek_sesi.inc');
    require('../lib/fs_umum.php');
    require("../cfg/$cfgfile");
    $css = "../css/$tampilan_css.css";

    echo "<html>\n";
    echo "<head><title>Penambahan Forum dan Topik Diskusi</title>\n";
    echo "<link rel=stylesheet type='text/css' href='$css'>\n";
    echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
    echo "<SCRIPT LANGUAGE='JavaScript'>\n";
    echo "<!--\n";
    echo "function openurl(urlpath,tgt)\n";
    echo "{\n";
    echo "  window.open(urlpath,tgt);\n";
    echo "}\n";
    echo "// --> \n";
    echo "</script>\n";
    echo "</head>\n";
    echo "<body>\n";
    
    $js = "<script language='JavaScript'>" ;
    $endjs = "</script>\n";
	$id_user = $kode_pengguna;
	$dibuat_tgl = date("Y-n-j h:i:s");
	list($jnsgroup,$kodegroup) = split(';',$group);
    $db = mysql_connect($db_host, $db_user, $db_pswd);
    mysql_select_db($db_database, $db);

	switch ($namaform) {
        case "tambahforum":
             if ($namaforum == "" or $keterangan == "") {
                 $errtext = "Nama Forum dan Keterangan harus diisi";
                 tampilkan_error('',$errtext);
             }
             $where = "jenis_group='$jnsgroup' and (('$jnsgroup'!='P' and kode_group='$kodegroup') or ('$jnsgroup'='P'))";
             $sqltext = "select count('x') from forum where nama_forum ='$namaforum' and $where";
             $hasil = mysql_query($sqltext, $db);
             $overlap = mysql_fetch_array($hasil);
             if ($overlap[0] > 0) {
                 $errtext = "Nama Forum tidak boleh sama";
                 tampilkan_error('',$errtext);
             }
             $sqltext = "insert into forum (nama_forum,keterangan,jenis_group,kode_group,moderator, dibuat_oleh,dibuat_tgl) values ('".$namaforum."','".$keterangan."','".$jnsgroup."','".$kodegroup."',".$id_user.",".$id_user.",'".$dibuat_tgl."')";
             $hasil = mysql_query($sqltext, $db);
             check_mysql_error(mysql_errno(),mysql_error());
             echo $js." openurl('forum.php?jnskategori=".$jnsgroup."&kdkategori=".$kodegroup."','isi') ".$endjs;
             break;
        case "tambahtopik":
             if ($judultopik == "" or $isitopik == "") {
                 $errtext = "Judul topik dan isinya harus diisi";
                 tampilkan_error('',$errtext);
             }
             $sqltext = "select count('x') from topik where kode_forum =$idforum and judul='$judultopik'";
             $hasil = mysql_query($sqltext, $db);
             $overlap = mysql_fetch_array($hasil);
             if ($overlap[0] > 0) {
                 $errtext = "Nama Forum tidak boleh sama";
                 tampilkan_error('',$errtext);
             }
             $respon = 0;
             $sqltext = "insert into topik (kode_forum,judul,isi_topik,respon_thd,
					dibuat_oleh,dibuat_tgl)
                    values ('".$idforum."','".$judultopik."','".$isitopik."','".$respon."',".$id_user.",'".$dibuat_tgl."')";
             $hasil = mysql_query($sqltext, $db);
             check_mysql_error(mysql_errno(),mysql_error());
             $hasil = mysql_query("update topik set struktur =  last_insert_id() where kode_topik = last_insert_id()",$db);
             check_mysql_error(mysql_errno(),mysql_error());
             echo $js." openurl('topik.php?pid=$idforum&halaman=$halaman','isi') ".$endjs;
             break;
        case "tanggapantopik":
             if ($judultopik == "" or $isitopik == "") {
                 $errtext = "Judul topik dan isinya harus diisi";
                 tampilkan_error('',$errtext);
             }
             $hasil = mysql_query("select max(struktur) from topik where struktur like '".$struktur."-__'", $db);
             check_mysql_error(mysql_errno(),mysql_error());
             $idstruktur = mysql_fetch_array($hasil);
             if ($idstruktur[0] == "") {
                 $pstruktur = $struktur."-01";
             } else {
                 $struktur = split('-',$idstruktur[0]);
                 $str=count($struktur);
                 $pval = $struktur[count($str)]+1;
                 if (strlen($pval)==1) $pval = str_pad($pval,2,'0',STR_PAD_LEFT);
                 $pstruktur = substr($idstruktur[0],0,strlen($idstruktur[0])-3)."-".$pval;
             }
             $sqltext = "insert into topik (kode_forum,judul,isi_topik,respon_thd,struktur,
					dibuat_oleh,dibuat_tgl)
                    values ('".$idforum."','".$judultopik."','".$isitopik."','".$respon."','".$pstruktur."',".$id_user.",'".$dibuat_tgl."')";
             $hasil = mysql_query($sqltext, $db);
             check_mysql_error(mysql_errno(),mysql_error());
             echo $js." openurl('topik_detail.php?idforum=$idforum&idtopik=$respon','_self') ".$endjs;
             break;
        case "hapusforum":
             if (count($cb_hapus) == 0) {
                 $errtext = "Cek nama-nama forum yang akan anda hapus";
                 tampilkan_error('',$errtext);
             }
             $j = 0;
             $flag = true;
             for ($i=0; $i<count($cb_hapus); $i++) {
                 echo "$cb_hapus[$i]<br>\n";
                 $sqltext = "delete from forum where kode_forum=".$cb_hapus[$i];
                 $hasil = mysql_query($sqltext, $db);
                 check_mysql_error(mysql_errno(),mysql_error());
                 $sqltext = "delete from topik where kode_forum=".$cb_hapus[$i];
                 $hasil = mysql_query($sqltext, $db);
                 check_mysql_error(mysql_errno(),mysql_error());
                 if (mysql_errno() == 0) {
                    $j++;
                 }
                 else {
                    $flag = false;
                 }
             }
             if ($flag) {
                 echo "Penghapusan terhadap sejumlah $j forum telah dilakukan, cek dengan
                      me-refresh brwoser anda<br>\n";
             }
             break;
        case "hapustopik":
             if (count($cb_hapus) == 0) {
                 $errtext = "Cek nama-nama topik yang akan anda hapus";
                 tampilkan_error('',$errtext);
             }
             $j = 0;
             $flag = true;
             for ($i=0; $i<count($cb_hapus); $i++) {
                 $sqltext = "select struktur from topik where kode_topik=".$cb_hapus[$i];
                 $query = mysql_query($sqltext, $db);
                 $row = mysql_fetch_array($query);
                 $sqltext = "delete from topik where kode_topik like '".$row[0]."-%'";
                 $hasil = mysql_query($sqltext, $db);
                 check_mysql_error(mysql_errno(),mysql_error());
                 $sqltext = "delete from topik where kode_topik = ".$cb_hapus[$i];
                 $hasil = mysql_query($sqltext, $db);
                 check_mysql_error(mysql_errno(),mysql_error());
                 if (mysql_errno() == 0) {
                    $j++;
                 }
                 else {
                    $flag = false;
                 }
             }
             if ($flag) {
                 echo "Penghapusan terhadap sejumlah $j topik telah dilakukan, cek dengan
                      me-refresh brwoser anda<br>\n";
             }
             break;
	}
    echo "</body>\n";
    echo "</html>\n";
?>


