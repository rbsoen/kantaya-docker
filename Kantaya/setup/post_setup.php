<?php
require('../lib/fs_umum.php');
$css = "../css/kantaya.css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Proses Instalasi Kantaya</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<meta http-equiv='PRAGMA' content='no-cache'>\n";
echo "</head>\n";
echo "<body>\n";
echo "<table width='100%' border=1>\n";
echo "<tr>\n";
echo "<td class='judul1' colspan=2>Proses Instalasi Kantaya</td>\n";
echo "</tr>\n";
echo "</table><br>\n";

$logo_perusahaan = $_FILES['logo_perusahaan'];
$logo_perusahaan_type = $logo_perusahaan['type'];
$logo_perusahaan_name = $logo_perusahaan['name'];

$link = mysql_connect($host,$root,$password) or die('Tidak dapat Koneksi Ke $root@$host<br>');
echo "Koneksi Ke $root@$host Sukses<br>\n";

mysql_select_db("mysql", $link) or die('Tidak dapat Koneksi Ke Database mysql<br>');
echo "Koneksi Ke Database mysql Sukses<br>\n";

$logo_file = $logo_perusahaan_name;

if (($nama_user == '') or ($pswd_user == '') or ($host == '') or ($nama_database == '')) {
    $errtext = "Field Nama User, Password, Host dan Nama Database harus diisi";
    tampilkan_error('',$errtext);
}

if ((strtoupper($nama_user) == "ROOT") or (strtoupper($nama_database) == "MYSQL")) {
    $errtext = "User tidak boleh dengan nama 'root' atau nama database tidak boleh 'mysql'";
    tampilkan_error('',$errtext);
}

if (($nama_perusahaan == '') or ($alamat_perusahaan == '') or ($telp_perusahaan == '') or
    ($fax_perusahaan == '') or ($email_perusahaan == '') or ($url_perusahaan == '') or
    ($logo_perusahaan == '')) {
        $errtext = "Profile Perusahaan harus diisi secara lengkap";
        tampilkan_error('',$errtext);
}

if (!is_writable("/$basepath/gambar")) {
    chmod("/$basepath/gambar", 0755);
}

if (!is_writable("/$basepath/gambar")) {
    $errtext = "Direktori \"/$basepath/gambar\" harus writable, ubah dengan chmod command";
    tampilkan_error('',$errtext);
}

if (!eregi("^image/",$logo_perusahaan_type)) {
    $errtext = "Tipe File Logo bukan gambar";
    tampilkan_error('',$errtext);
}

/*if (!is_uploaded_file($logo_perusahaan)) {
    $errtext = "File Logo tidak dapat diupload";
    tampilkan_error('',$errtext);
}*/

if (!is_writable("/$basepath/cfg")) {
    chmod("/$basepath/cfg", 0755);
}

if (!is_writable("/$basepath/cfg")) {
    $errtext = "Direktori \"/$basepath/cfg\" harus writable, ubah dengan chmod command";
    tampilkan_error('',$errtext);
}

/*echo "Pembuatan Mysql User : $nama_user dengan lokasi $host<br>\n";
create_mysqluser($link, $nama_user, $pswd_user, $host);

echo "Pembuatan Mysql User Priviledges<br>\n";
create_user_priv($nama_user, $host, $nama_database);
*/
mysql_close($link);

$link = mysql_connect($host,$nama_user,$pswd_user) or die('Tidak dapat Koneksi ke $nama_user@$host<br>');
echo "Koneksi Ke $nama_user@$host Sukses<br>\n";

/*echo "Pembuatan Mysql Kanataya Database : $nama_database<br>\n";
create_mysqldb($nama_database);
*/
echo "Pembuatan Table-Table Kantaya<br>\n";
create_table_kantaya($nama_database);

echo "Insert Profile Perusahaan<br>\n";
insert_profile_perusahaan();

echo "Insert Administrator<br>\n";
insert_admin();

echo "Insert Unit Kerja<br>\n";
insert_unit_kerja();

echo "Pembuatan Konfigurasi File<br>\n";
create_dbconfig_file($nama_user, $pswd_user, $host, $nama_database);

echo "Upload Logo Perusahaan<br>\n";
copy($logo_perusahaan, "/$basepath/gambar/$logo_perusahaan_name");

echo "
     Instalasi Kantaya Sukses dan anda dapat login ke kantaya dengan
     username, password, serta database sebagai berikut :<br>\n
     <ul><h4>\n
     username : administrator<br>\n
     password : root<br>\n
     database : $nama_database<br>\n
     </h4></ul>\n
     Klik disini untuk <a href='../index.php'><b>Login</b></a> ke Kantaya<br>\n
     ";

echo "</body>\n";
echo "</html>\n";


function create_mysqluser($link,$namauser,$password,$host) {
    if (($namauser == '') or ($password == '') or ($host == '')) {
        $errtext = "Nama User, Password, dan Host harus diisi";
        tampilkan_error('',$errtext);
    }
/*
    $insertsql  = "insert into user (Host, User, Password, Select_priv, Insert_priv, ";
    $insertsql .= "Update_priv, Delete_priv, Create_priv, Drop_priv, ";
    $insertsql .= "File_priv, Grant_priv, References_priv, Index_priv, Alter_priv, ";
    $insertsql .= "Reload_priv, Shutdown_priv, Process_priv) ";
    $insertsql .= "values('$host', '$namauser', password('$password'), ";
    $insertsql .= "'Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','N','N','N')";
*/
    $insertsql  = "insert into user (Host, User, Password) ";
    $insertsql .= "values('$host', '$namauser', password('$password')) ";
    echo "$insertsql<br>\n";
    $insert = mysql_query("$insertsql",$link);
    if (mysql_errno() == 1062) {
        $deletesql = "delete from user where host='$host' and user='$namauser'";
        $delete = mysql_query("$deletesql",$link);
        $deletesql = "delete from db where host='$host' and user='$namauser'";
        $delete = mysql_query("$deletesql",$link);
        $insert = mysql_query("$insertsql",$link);
    } else {
        tampilkan_error(mysql_errno(),mysql_error());
    }
    $flush = mysql_query("FLUSH PRIVILEGES",$link) or die("invalid query");
}

function create_mysqldb($database) {
    if ($database == '') {
        $errtext = "Nama Database harus diisi";
        tampilkan_error('',$errtext);
    }
    if (mysql_create_db($database)) {
        echo "Database $database telah di create dengan sukses\n";
    } else {
        tampilkan_error(mysql_errno(),mysql_error());
    }
}

function create_user_priv($namauser,$host,$database) {
    global $link;

    $insertsql  = "insert into db (Host, Db, User) ";
    $insertsql  .= "values ('$host','mysql','$namauser')";
    $insert = mysql_query("$insertsql",$link);
    check_mysql_error(mysql_errno(),mysql_error());

    $insertsql  = "insert into db (Host, Db, User, Select_priv, Insert_priv, Update_priv, ";
    $insertsql  .= "Delete_priv, Create_priv, Drop_priv) ";
    $insertsql  .= "values ('$host','$database','$namauser','Y','Y','Y','Y','Y','Y')";
    $insert = mysql_query("$insertsql",$link);
    check_mysql_error(mysql_errno(),mysql_error());

    $flush = mysql_query("FLUSH PRIVILEGES",$link) or die("invalid query");

}

function create_table_kantaya($database) {
    global $link;
    include('tbl_admin.php');
    include('tbl_agenda.php');
//    include('tbl_alamat.php');
    include('tbl_dimana.php');
    include('tbl_diskusi.php');
    include('tbl_fasilitas.php');
    include('tbl_forum.php');
    include('tbl_lemari.php');
    include('tbl_proyek.php');
//    include('tbl_url_link.php');

    mysql_select_db($database, $link);
    echo "Setup Table Admin\n";
    setup_table_admin();
    echo "Setup Table Agenda\n";
    setup_table_agenda();
    echo "Setup Table Dimana\n";
    setup_table_dimana();
    echo "Setup Table Diskusi\n";
    setup_table_diskusi();
    echo "Setup Table Fasilitas\n";
    setup_table_fasilitas();
    echo "Setup Table Forum\n";
    setup_table_forum();
    echo "Setup Table Lemari\n";
    setup_table_lemari();
    echo "Setup Table Proyek\n";
    setup_table_proyek();
}

function insert_profile_perusahaan() {
    global $nama_perusahaan, $alamat_perusahaan, $telp_perusahaan, $fax_perusahaan,
           $email_perusahaan, $url_perusahaan, $logo_file, $link;
    $sqldelete = "delete from profile_perusahaan";
    $delete = mysql_query($sqldelete, $link);
    check_mysql_error(mysql_errno(),mysql_error());
    $sqlinsert = "insert into profile_perusahaan(nama_perusahaan, alamat, telp, fax, email, url, logo, tanggal_dibuat, dibuat_oleh) ";
    $sqlinsert .= "values('$nama_perusahaan','$alamat_perusahaan','$telp_perusahaan','$fax_perusahaan','$email_perusahaan', '$url_perusahaan', '$logo_file', now(), 1)";
    $insert = mysql_query($sqlinsert, $link);
    check_mysql_error(mysql_errno(),mysql_error());
}

function insert_unit_kerja() {
    global $nama_perusahaan, $link;
    $sqlinsert = "insert into unit_kerja(kode_unit, nama_unit, tanggal_dibuat, dibuat_oleh) ";
    $sqlinsert .= "values('0000000000', '$nama_perusahaan', now(), 1)";
    $insert = mysql_query($sqlinsert, $link);
    check_mysql_error(mysql_errno(),mysql_error());
}
    
function insert_admin() {
    global $link;
    $sqlinsert = "insert into pengguna(nama_pengguna, level, username, password, unit_kerja, tanggal_dibuat, dibuat_oleh) ";
    $sqlinsert .= "values('Administrator', '1', 'administrator', 'root', '0000000000', now(), 1)";
    $insert = mysql_query($sqlinsert, $link);
    check_mysql_error(mysql_errno(),mysql_error());
}

function create_dbconfig_file($namauser,$password,$host,$database) {
    global $basepath;
    $cfgfile = "/$basepath/cfg/$database.cfg";

    if (file_exists($cfgfile)) {
        $deleted = unlink($cfgfile);
    }

    $isifile =
"<?php
\$db_host = \"$host\";
\$db_user = \"$namauser\";
\$db_pswd = \"$password\";
\$db_database = \"$database\";
\$basepath = \"$basepath\";
?>";

    $fp = fopen($cfgfile,'a+');
    flock($fp, 2);
    $fw = fwrite($fp, $isifile);
    fclose($fp);
}


?>

