<?php
/*************************************************
Nama File : post_mitra.php
Fungsi    : 
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 23-11-2001
 Oleh     : AS
 Revisi   : css, input & ubah ke buku alamat
**************************************************/

include ('../lib/cek_sesi.inc');
require('../lib/fs_umum.php');
require('../lib/kantaya_cfg.php');
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

//if (is_null($kode_proyek)) {
if ($kode_proyek=="") {
    $errtext = "Field Kode Proyek Harus Diisi";
    tampilkan_error('',$errtext);
}
//if (is_null($jenis_kerjasama) or is_null($nama_mitra)) {
if ($jenis_kerjasama=="" or $nama_mitra=="") {
    $errtext = "Field Jenis Kerjasama dan Nama Mitra Harus Diisi";
    tampilkan_error('',$errtext);
}
//if (is_null($jenis_lembaga)) {
if ($jenis_lembaga=="") {
    $errtext = "Field Jenis Lembaga Harus Diisi";
    tampilkan_error('',$errtext);
}
//if (is_null($kontak_person) or is_null($telp_kantor)) {
if ($kontak_person=="" or $telp_kantor=="") {
    $errtext = "Field Kontak Personil dan Telp Kantor Harus Diisi";
    tampilkan_error('',$errtext);
}

switch ($jnstransaksi) {
    case "input":
         $insert = "insert into mitra_proyek (kode_mitra,kode_proyek,nama_mitra,no_kerjasama,jenis_kerjasama,jenis_lembaga,kontak_person,email,web_kantor,telp_kantor,telp_hp,fax,alamat,kota,propinsi,negara,dibuat_oleh,tgl_dibuat)";
         $values = "values ('$kode_mitra','$kode_proyek','$nama_mitra','$no_kerjasama','$jenis_kerjasama','$jenis_lembaga','$kontak_person','$emailmitra','$web_kantor','$telp_kantor','$telp_hp','$fax','$alamat','$kota','$propinsi','$negara','$kode_pengguna','$tgljam')";
         $sqltext = "$insert$values";
         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() <> 0) {
             tampilkan_error(mysql_errno(),mysql_error());
             echo "$sqltext\n";
         }
				 
				          $kode_mitra = mysql_insert_id($db);
         echo $js." window.open('mitra_detail.php?p1=$kode_proyek&p2=$kode_mitra','isi') ".$endjs;
				 
				 
				 //input kontak person mitra proyek ke buku alamat (AS) :
				 $insert = "insert into buku_alamat (nama,gelar_dpn,gelar_blk,jenis_kelamin,kategori,ktg_grup,jabatan,kantor,email,web_personal,web_kantor,telp_kantor,telp_rumah,telp_hp,fax,alamat_kantor,kota,kode_pos,propinsi,negara,keterangan,didaftar_oleh,didaftar_tgl,diubah_oleh,diubah_tgl)";
         $values = "values ('$kontak_person','','','','G','$kode_grup','','$nama_mitra','$emailmitra','','$web_kantor','$telp_kantor','','$telp_hp','$fax','$alamat','$kota','','$propinsi','$negara','','$kode_pengguna','$tgljam','$kode_pengguna','$tgljam')";
         $sqltext = "$insert$values";
         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() <> 0) {
             tampilkan_error(mysql_errno(),mysql_error());
             echo "$sqltext\n";
         }
				 

				 
         break;
    case "ubah":
         $update  = "update mitra_proyek set ";
         $update .= "no_kerjasama='$no_kerjasama', ";
         $update .= "jenis_kerjasama='$jenis_kerjasama', ";
         $update .= "nama_mitra='$nama_mitra', ";		
         $update .= "jenis_lembaga='$jenis_lembaga', ";
         $update .= "kontak_person='$kontak_person', ";
         $update .= "telp_kantor='$telp_kantor', ";
         $update .= "telp_hp='$telp_hp', ";
         $update .= "fax='$fax', ";				 
         $update .= "email='$emailmitra', ";
         $update .= "web_kantor='$web_kantor', ";
         $update .= "alamat='$alamat', ";
         $update .= "kota='$kota', ";
         $update .= "propinsi='$propinsi', ";
         $update .= "negara='$negara', ";
         $update .= "diubah_oleh='$kode_pengguna', ";
         $update .= "tgl_diubah='$tgljam' ";
         $where = "kode_proyek='$kode_proyek' and kode_mitra='$kode_mitra'";
         $sqltext = "$update where $where";
         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() <> 0) {
             echo "$sqltext\n";
             tampilkan_error(mysql_errno(),mysql_error());
         }

         echo $js." window.open('mitra_detail.php?p1=$kode_proyek&p2=$kode_mitra','isi') ".$endjs;

				 //update ke buku alamat (AS) :
         $update  = "update buku_alamat set ";
         $update .= "nama='$kontak_person', ";
         $update .= "kantor='$nama_mitra', ";
         $update .= "email='$emailmitra', ";
         $update .= "web_kantor='$web_kantor', ";
         $update .= "telp_kantor='$telp_kantor', ";
         $update .= "telp_hp='$telp_hp', ";
         $update .= "fax='$fax', ";
         $update .= "alamat_kantor='$alamat', ";
         $update .= "kota='$kota', ";
         $update .= "propinsi='$propinsi', ";
         $update .= "negara='$negara', ";
         $update .= "diubah_oleh='$kode_pengguna', ";
         $update .= "diubah_tgl='$tgljam' ";
         $where = "kontak_id='$kontakid'";
         $sqltext = "$update where $where";
         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() <> 0) {
             echo "$sqltext\n";
             tampilkan_error(mysql_errno(),mysql_error());
         }
				 

    break;
}
/*

         $fields = mysql_list_fields($database,"mitra_proyek",$db);
         $columns = mysql_num_fields($fields);
         $sqlinsert = "insert into mitra_proyek (";
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
         $sqlupdate = "update mitra_proyek set ";
         for ($i=0; $i<$columns; $i++) {
             if ($i<$columns-1) {
                 $sqlupdate = $sqlupdate."$"."update .= \"".mysql_field_name($fields,$i)."='$".mysql_field_name($fields,$i)."', \";<br>";
             } else {
                 $sqlupdate = $sqlupdate."$"."update .= \"".mysql_field_name($fields,$i)."='$".mysql_field_name($fields,$i)."' \";";
             }
         }
         echo $sqlupdate."<br>\n";
*/

echo "</body>\n";
echo "</html>\n";







