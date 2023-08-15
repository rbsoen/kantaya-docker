<?
/********************************************************
1 - Yes/On/True
0 - No/Off/False
********************************************************
Supaya diperhatikan_:
Temporari files akan disimpan pada almari/folder file untuk keamanan
dan diharapkan tidak menggunakan sharing folder di web direktori

** Web server mebutuhkan ijin menulis pada folder yang dibuat di temporari file
   (dalama hal ini folder "tmp")
misalkan sebagai berikut :

* Unix/Linux users menggunakan.
   /tmp/websurat
* Win32 users
  c:/winnt/temp/websurat

** Catatan: dengan O/S Win32, menggunakan "right bars";
********************************************************/
$temporary_directory = "/tmp/kantaya_surat/";

/********************************************************
Local SMTP Server (alias or IP) anda seperti : "smtp.domain-anda.com"
eg. "server1;server2;server3"   -> spesifikasi main server dan backup server
********************************************************/
$smtp_server = "202.46.5.6;202.46.240.6";


/********************************************************
Maximum Kuota untuk menyimpan file
********************************************************/
$quota_limit = 8192;  //in KB, eg. 2048 Kb = 2MB


/********************************************************
menggunakan SMTP password (AUTH LOGIN type)
********************************************************/
$use_password_for_smtp = 0;

/********************************************************
Untuk qmail dan POP3/SMTP servers yang lainnya yang menggunakan user@domain
as username (full alamat email ).
$Gunakan_email_as_user_pop3 yang digunakan hanya untuk POP3 authentications
$Gunakan_email_as_user_smtp yang digunakan hanya  SMTP authentications
********************************************************/
$use_email_as_user_pop3 = 0;
$use_email_as_user_smtp = 0;



/********************************************************
Local POP3 Servers anda, ____ OPTIONAL ___
********************************************************/
// 1st
//$pop3_servers[0]["domain"] = "inn.bppt.go.id";
//$pop3_servers[0]["server"] = "202.46.5.6";

// 2nd

//$pop3_servers[1]["domain"] = "bppt.go.id";
//$pop3_servers[1]["server"] = "202.46.240.6";

// Nnd
//$pop3_servers[2]["domain"] = "";
//$pop3_servers[2]["server"] = "";


/********************************************************
Seting Bahasa yang digunakan
********************************************************/
$default_language     = 0;
$allow_user_change    = 0; //allow users select language

$languages[0]["name"] = "Indonesia";
$languages[0]["path"] = "themes/Indonesia";

/********************************************************
Format Tanggal dalam bahasa Indonesia
********************************************************/
$date_format = "d/m/y h:m"; // d = day, m = month, y = year, h = hour, m = minutes


/********************************************************
Support SendMail pada unix/linux (default menggunakan SMTP)
********************************************************/
$use_sendmail     = 0;
$path_to_sendmail = "/usr/sbin/sendmail";


/********************************************************
Pada beberapas POP3 servers, jika kita mengirim perintah "RETR" ,
Surat anda akan otomatis dihapus: pilih option ini sesua kenyamanan anda.
********************************************************/
$pop_use_top = 1;

/********************************************************
Dimungkinkan mengirim dalam bentuk HTML (direkomendasikan)
********************************************************/
$mime_show_html = 1;


$appversion = "2.1";
$appname = "Surat Web - Kantaya";



$footer = "
 
________________________________________________
Surat ini dikirim oleh $appname $appversion
";

/********************************************************
Enable debug :)
********************************************************/
$enable_debug = 0;

/********************************************************
Session timeout for inactivity
********************************************************/
$idle_timeout = 10; //minutes

/********************************************************
Order setting
********************************************************/
$default_sortby = "date";
$default_sortorder = "DESC";

/********************************************************
Default preferences...
********************************************************/
$send_to_trash_default = 1;      //send deleted messages to trash
$st_only_ready_default = 1;      //only read messages, otherwise, delete it
$save_to_sent_default  = 1;      //send sent messages to sent
$empty_trash_default   = 1;      //empty trash on logout
$sortby_default        = "date"; //alowed: "attach","subject","fromname","date","size"
$sortorder_default     = "DESC"; //alowed: "ASC","DESC"
$rpp_default           = 10;     // records per page (messages), alowed: 10,20,30,40,50
$add_signature_default = 0;      //add the signature by default
$signature_default     = "";     // an default signature for all users
?>
