<?php

include ('../lib/cek_sesi.inc');
require('../lib/fs_umum.php');
require("../lib/kantaya_cfg.php");
$css = "../css/".$tampilan_css.".css";

$js = "<script language='JavaScript'>" ;
$endjs = "</script>\n";

$pengguna = $kode_pengguna;
$tgljam = date("Y-n-j h:i:s");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

echo "<html>\n";
echo "<head><title>Pendaftaran Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

         $rcn_tgl_mulai = date("Y-m-d", mktime(0,0,0,$rcnblnmulai,$rcntglmulai,$rcnthnmulai));
         $rcn_tgl_selesai = date("Y-m-d", mktime(0,0,0,$rcnblnselesai,$rcntglselesai,$rcnthnselesai));
         $akt_tgl_mulai = date("Y-m-d", mktime(0,0,0,$aktblnmulai,$akttglmulai,$aktthnmulai));
         $akt_tgl_selesai = date("Y-m-d", mktime(0,0,0,$aktblnselesai,$akttglselesai,$aktthnselesai));

         if ($kode_proyek=="") {
             $errtext = "Field Kode Proyek Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($no_kegiatan=="" or $nama_kegiatan=="" or $jenis_kegiatan=="") {
             $errtext = "Field No Kegiatan, Nama Kegiatan dan Jenis Kegiatan Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($bobot==0) {
             $errtext = "Field Bobot Kegiatan Harus Lebih Besar dari 0";
             tampilkan_error('',$errtext);
         }
         if ($rcn_tgl_mulai == "0000-00-00" or $rcn_tgl_selesai == "0000-00-00" ) {
             $errtext = "Field Rencana Tgl Mulai dan Rencana Tgl Selesai Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($rcn_tgl_mulai > $rcn_tgl_selesai) {
             $errtext = "$rcn_tgl_mulai > $rcn_tgl_selesai : Rencana Tgl Mulai tidak boleh lebih besar dari Rencana Tgl Selesai";
             tampilkan_error('',$errtext);
         }
         if ($akt_tgl_mulai <> "0000-00-00" and $akt_tgl_selesai <> "0000-00-00" ) {
             if ($akt_tgl_mulai > $akt_tgl_selesai) {
                 $errtext = "Aktual Tgl Mulai tidak boleh lebih besar dari Aktual Tgl Selesai";
                 tampilkan_error('',$errtext);
             }
         }
         
switch ($jnstransaksi) {
    case "input":
         $insert = "insert into jadwal_proyek (kode_proyek,no_kegiatan,nama_kegiatan,jenis_kegiatan,bobot,rcn_tgl_mulai,rcn_tgl_selesai,akt_tgl_mulai,akt_tgl_selesai,Status,induk_kegiatan,subkont_mitra,keterangan,dibuat_oleh,tgl_dibuat) ";
         $values = "values ('$kode_proyek','$no_kegiatan','$nama_kegiatan','$jenis_kegiatan','$bobot','$rcn_tgl_mulai','$rcn_tgl_selesai','$akt_tgl_mulai','$akt_tgl_selesai','$Status','$induk_kegiatan','$subkont_mitra','$keterangan','$pengguna','$tgljam')";
         $sqltext = "$insert$values";
         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() <> 0) {
             tampilkan_error(mysql_errno(),mysql_error());
             echo "$sqltext\n";
         }
         for ($i=0; $i<count($personil); $i++) {
             if ($org_jam[$i]<=0) {
                 $errtext = "Field Org jam Harus Lebih Besar dari 0";
                 tampilkan_error('',$errtext);
             }
             $insert = "insert into penugasan_personil (kode_proyek,no_kegiatan,kode_pengguna,job,orang_jam,dibuat_oleh,tgl_dibuat) ";
             $values = "values ('$kode_proyek', '$no_kegiatan', '$personil[$i]', '$job[$i]', '$org_jam[$i]', '$pengguna', '$tgljam')";
             $sqltext = "$insert$values";
             echo "$sqltext<br>\n";
             $hasil = mysql_query($sqltext, $db);
             if (mysql_errno() <> 0) {
                 tampilkan_error(mysql_errno(),mysql_error());
                 echo "$sqltext\n";
             }
         }
         echo $js." window.open('jadwal_detail.php?p1=$kode_proyek&p2=$no_kegiatan','isi') ".$endjs;
         break;
    case "ubah":
         $update  = "update jadwal_proyek set ";
         $update .= "nama_kegiatan='$nama_kegiatan', ";
         $update .= "jenis_kegiatan='$jenis_kegiatan', ";
         $update .= "bobot='$bobot', ";
         $update .= "rcn_tgl_mulai='$rcn_tgl_mulai', ";
         $update .= "rcn_tgl_selesai='$rcn_tgl_selesai', ";
         $update .= "akt_tgl_mulai='$akt_tgl_mulai', ";
         $update .= "akt_tgl_selesai='$akt_tgl_selesai', ";
         $update .= "status='$status', ";
         $update .= "induk_kegiatan='$induk_kegiatan', ";
         $update .= "subkont_mitra='$subkont_mitra', ";
         $update .= "keterangan='$keterangan', ";
         $update .= "diubah_oleh='$pengguna', ";
         $update .= "tgl_diubah='$tgljam' ";
         $where = "kode_proyek='$kode_proyek' and no_kegiatan='$no_kegiatan'";
         $sqltext = "$update where $where";
         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() <> 0) {
             echo "$sqltext\n";
             tampilkan_error(mysql_errno(),mysql_error());
         }
         $delete = "delete from penugasan_personil where $where";
         $hasil = mysql_query($delete, $db);
         if (mysql_errno() <> 0) {
             echo "$sqltext\n";
             tampilkan_error(mysql_errno(),mysql_error());
         }
         for ($i=0; $i<count($idpersonil); $i++) {
             $j = $idpersonil[$i];
             $insert = "insert into penugasan_personil (kode_proyek,no_kegiatan,kode_pengguna,job,orang_jam,dibuat_oleh,tgl_dibuat) ";
             $values = "values ('$kode_proyek', '$no_kegiatan', '$personil[$j]', '$job[$j]', '$org_jam[$j]', '$pengguna', '$tgljam')";
             $sqltext = "$insert$values";
             if ($org_jam[$j]<=0) {
                 $errtext = "Field Org jam Harus Lebih Besar dari 0";
                 tampilkan_error('',$errtext);
             }
             $hasil = mysql_query($sqltext, $db);
             if (mysql_errno() <> 0) {
                 echo "$sqltext\n";
                 tampilkan_error(mysql_errno(),mysql_error());
             }
         }
         echo $js." window.open('jadwal_detail.php?p1=$kode_proyek&p2=$no_kegiatan','isi') ".$endjs;

/*
         $fields = mysql_list_fields($database,"jadwal_proyek",$db);
         $columns = mysql_num_fields($fields);
         $sqlinsert = "insert into jadwal_proyek (";
         for ($i=0; $i<$columns; $i++) {
             if ($i<$columns-1) {
                 $sqlinsert = $sqlinsert.mysql_field_name($fields,$i).",";
             } else {
                 $sqlinsert = $sqlinsert.mysql_field_name($fields,$i).")";
             }
         }
         $sqlinsert = $sqlinsert." values (";
         for ($i=0; $i<$columns; $i++) {
             if ($i<$columns-1) {
                 $sqlinsert = $sqlinsert."'$".mysql_field_name($fields,$i)."',";
             } else {
                 $sqlinsert = $sqlinsert."'$".mysql_field_name($fields,$i)."')";
             }
         }
         echo $sqlinsert."<br>\n";
         $sqlupdate = "update jadwal_proyek set ";
         for ($i=0; $i<$columns; $i++) {
             if ($i<$columns-1) {
                 $sqlupdate = $sqlupdate."$"."update = "."$"."update.\"".mysql_field_name($fields,$i)."='$".mysql_field_name($fields,$i)."', \";<br>";
             } else {
                 $sqlupdate = $sqlupdate."$"."update = "."$"."update.\"".mysql_field_name($fields,$i)."='$".mysql_field_name($fields,$i)."' \";";
             }
         }
         echo $sqlupdate."<br>\n";
*/

    break;


}



echo "</body>\n";
echo "</html>\n";




