<?php
/******************************************
Nama File : post_proyek.php
Fungsi    : Mendaftarkan proyek baru
Dibuat    :	
 Tgl.     : 
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 12-11-2001
 Oleh     : AS
 Revisi   : Insert Jenis Pelaporan, create
            grup baru, direktori baru dan
						anggota grup serta sharing
						direktori tsb.
						Fungsi is_null diganti semua.
******************************************/

include ('../lib/cek_sesi.inc');
require('../lib/kantaya_cfg.php');
$css = "../css/".$tampilan_css.".css";

$js = "<script language='JavaScript'>" ;
$endjs = "</script>\n";

$dibuat_oleh = $kode_pengguna;
$tgljam = date("Y-n-j h:i:s");

$db = mysql_connect($host, $root);
mysql_select_db($database, $db);

echo "<html>\n";
echo "<head><title>Pendaftaran Proyek</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

switch ($namaform) {
    case "daftarproyek":
         $tgl_mulai = date("Y-m-d", mktime(0,0,0,$blnmulai,$tglmulai,$thnmulai));
         $tgl_selesai = date("Y-m-d", mktime(0,0,0,$blnselesai,$tglselesai,$thnselesai));
//         if (is_null($no_proyek) or is_null($nama_proyek) or is_null($singkatan)) {
         if ($no_proyek=="" or $nama_proyek=="" or $singkatan=="") {
             $errtext = "Field No Proyek, Nama Proyek dan Singkatan Proyek Harus Diisi";
             tampilkan_error('',$errtext);
         }
//         if (is_null($jenis_proyek) or is_null($unit_pengelola)) {
         if ($jenis_proyek=="" or $unit_pengelola=="") {
             $errtext = "Field Jenis Proyek dan Unit Pengelola Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($koordinator==0) {
             $errtext = "Field Koordinator Proyek Harus Diisi";
             tampilkan_error('',$errtext);
         }
//         if (is_null($jenis_sharing) or is_null($grup_sharing)) {
         if ($jenis_sharing=="" or $grup_sharing=="") {
             $errtext = "Field Jenis Sharing dan Grup Sharing Harus Diisi";
             tampilkan_error('',$errtext);
         }
//         if (is_null($tahun_anggaran) or is_null($status)) {
         if ($tahun_anggaran=="" or $status=="") {
             $errtext = "Field Tahun Anggaran dan Status Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($tgl_mulai == "0000-00-00" or $tgl_selesai == "0000-00-00" ) {
             $errtext = "Field Tgl Mulai dan Tgl Selesai Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($tgl_mulai > $tgl_selesai) {
             $errtext = "Tgl Mulai tidak boleh lebih besar dari Tgl Selesai";
             tampilkan_error('',$errtext);
         }

         $sqlinsert = "insert into proyek (no_proyek,nama_proyek,jenis_proyek,singkatan,koordinator,unit_pengelola,jenis_sharing,grup_sharing,kode_grup,tahun_anggaran,status,tgl_mulai,tgl_selesai,lokasi,kata_kunci,tujuan,sasaran,jenis_pelaporan,dibuat_oleh,tgl_dibuat)";
         $sqlinsert = $sqlinsert." values ('$no_proyek','$nama_proyek','$jenis_proyek','$singkatan','$koordinator','$unit_pengelola','$jenis_sharing','$grup_sharing','$kode_grup','$tahun_anggaran','$status','$tgl_mulai','$tgl_selesai','$lokasi','$kata_kunci','$tujuan','$sasaran','$jenispelaporan','$kode_pengguna','$tgljam')";

         //echo $sqlinsert."<br>\n";
         $hasil = mysql_query($sqlinsert, $db);
         $kode_proyek = mysql_insert_id($db);
         if (mysql_errno() == 0) {
             echo $js." window.open('detail_proyek.php?p1=$kode_proyek','isi') ".$endjs;
         }
         else {
             tampilkan_error(mysql_errno(),mysql_error());
             echo "$sqltext\n";
         }
				 
				 //Buat grup baru dari proyek ini (AS).	
				 //echo "INSERT INTO grup (nama_grup, sifat_grup, keterangan, pimpinan_grup, tanggal_dibuat, dibuat_oleh, status) values  ('$singkatan', 'Ekslusif','Grup dari proyek $nama_proyek', '$koordinator', now(), '$kode_pengguna', '1')";
				 $grup_baru=mysql_query ("INSERT INTO grup (nama_grup, sifat_grup, keterangan, pimpinan_grup, tanggal_dibuat, dibuat_oleh, status) 
                                values  ('$singkatan', 'Ekslusif','Grup dari proyek $nama_proyek', '$koordinator', now(), '$kode_pengguna', '1')");
	       if (mysql_error())  {
	 		        echo "
					          <table width='100%' Border='0'>
					 				     <tr><td class='judul1' align='left'>Konfirmasi</td></tr>
									     <tr><td><b>Error buat grup baru: </b>".mysql_error()."<br>Penyimpanan gagal.</td></tr>
						        </table>
			             ";
         }					
				 
				 //Buat direktori atau lemari baru dari grup proyek ini (AS).
         $direktori_baru = mysql_query("INSERT INTO direktori (nama_direktori, direktori_induk, keterangan, sharing_publik, tanggal_dibuat, dibuat_oleh)
					                         VALUES ('$singkatan', '', 'Direktori dari proyek $nama_proyek', '0' , now(), '$koordinator')");
	       if (mysql_error())  {
	 		        echo "
					          <table width='100%' Border='0'>
					 				     <tr><td class='judul1' align='left'>Konfirmasi</td></tr>
									     <tr><td><b>Error buat direktori batu: </b>".mysql_error()."<br>Penyimpanan gagal.</td></tr>
						        </table>
			             ";
         }																
		
				 //Buat sharing direktori/lemari proyek ini dengan grup proyek ini  (AS).
				 $hasil_dir = mysql_query("SELECT kode_direktori from direktori WHERE nama_direktori='$singkatan'");
				 $kode_dir = mysql_result($hasil_dir,0,"kode_direktori");
				 $hasil_grup = mysql_query("SELECT kode_grup from grup WHERE nama_grup='$singkatan'");
				 $kode_grup = mysql_result($hasil_grup,0,"kode_grup");				 
 
				 $sharing_dir_grup=mysql_query ("INSERT INTO sharing_dir_grup VALUES ('$kode_dir','$kode_grup')");
	       if (mysql_error())  {
	 		        echo "
					          <table width='100%' Border='0'>
					 				     <tr><td class='judul1' align='left'>Konfirmasi</td></tr>
									     <tr><td><b>Error sharing: </b>".mysql_error()."<br>Penyimpanan gagal.</td></tr>
						        </table>
			             ";
         }	
				 
						 //Mendaftarkan koordinator proyek sbg. anggota grup proyek ini (AS).
						 $anggota_baru = mysql_query ("INSERT INTO grup_pengguna (kode_pengguna, kode_grup, tanggal_dibuat, dibuat_oleh) 
                                   values ('$koordinator', '$kode_grup', now(), '$kode_pengguna')");
	           if (mysql_error())  {
	 		            echo "
					          <table width='100%' Border='0'>
					 				     <tr><td class='judul1' align='left'>Konfirmasi</td></tr>
									     <tr><td><b>Error daftar koordinator ke anggota grup: </b>".mysql_error()."<br>Penyimpanan gagal.</td></tr>
						        </table>
			            ";
             }					 				
						 
						 //--							
						 
				 
    break;
    case "editproyek":
         $tgl_mulai = date("Y-m-d", mktime(0,0,0,$blnmulai,$tglmulai,$thnmulai));
         $tgl_selesai = date("Y-m-d", mktime(0,0,0,$blnselesai,$tglselesai,$thnselesai));
         if ($no_proyek=="" or $nama_proyek=="" or $singkatan=="") {
             $errtext = "Field No Proyek, Singkatan dan Nama Proyek Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($jenis_proyek=="" or $unit_pengelola=="") {
             $errtext = "Field Jenis Proyek dan Unit Pengelola Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($koordinator==0) {
             $errtext = "Field Koordinator Proyek Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($jenis_sharing=="" or $grup_sharing=="") {
             $errtext = "Field Jenis Sharing dan Grup Sharing Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($tahun_anggaran=="" or $status=="") {
             $errtext = "Field Tahun Anggaran dan Status Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($tgl_mulai == "0000-00-00" or $tgl_selesai == "0000-00-00" ) {
             $errtext = "Field Tgl Mulai dan Tgl Selesai Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if ($tgl_mulai > $tgl_selesai) {
             echo "$tgl_mulai > $tgl_selesai<br>\n";
             $errtext = "Tgl Mulai tidak boleh lebih besar dari Tgl Selesai";
             tampilkan_error('',$errtext);
         }

         $update  = "update proyek set ";
         $update .= "kode_proyek='$kode_proyek', ";
         $update .= "no_proyek='$no_proyek', ";
         $update .= "nama_proyek='$nama_proyek', ";
         $update .= "jenis_proyek='$jenis_proyek', ";
         $update .= "singkatan='$singkatan', ";
         $update .= "koordinator='$koordinator', ";
         $update .= "unit_pengelola='$unit_pengelola', ";
         $update .= "jenis_sharing='$jenis_sharing', ";
         $update .= "grup_sharing='$grup_sharing', ";
         $update .= "kode_grup='$kode_grup', ";
         $update .= "tahun_anggaran='$tahun_anggaran', ";
         $update .= "status='$status', ";
         $update .= "tgl_mulai='$tgl_mulai', ";
         $update .= "tgl_selesai='$tgl_selesai', ";
         $update .= "lokasi='$lokasi', ";
         $update .= "kata_kunci='$kata_kunci', ";
         $update .= "tujuan='$tujuan', ";
         $update .= "sasaran='$sasaran', ";
         $update .= "jenis_pelaporan='$jenispelaporan', ";				 
         $update .= "diubah_oleh='$kode_pengguna', ";
         $update .= "tgl_diubah='$tgljam' ";
         $where = "kode_proyek='$kode_proyek'";
         $sqltext = "$update where $where";
         $hasil = mysql_query($sqltext, $db);
         if (mysql_errno() <> 0) {
             echo "$sqltext\n";
             tampilkan_error(mysql_errno(),mysql_error());
         }
         echo $js." window.open('detail_proyek.php?p1=$kode_proyek','isi') ".$endjs;
/*
         $fields = mysql_list_fields($database,"proyek",$db);
         $columns = mysql_num_fields($fields);
         $sqlinsert = "insert into proyek (";
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
         $sqlupdate = "update proyek set ";
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
    case "psnlproyek":
         if (($jnstransaksi <> 'hapus') and ($personil==0)) {
             $errtext = "Field Nama Personil Proyek Harus Diisi, Pilih dari List yang Tersedia";
             tampilkan_error('',$errtext);
         }
         if (($jnstransaksi <> 'hapus') and (is_null($jabatan))) {
             $errtext = "Field Jabatan Dalam Proyek Harus Diisi";
             tampilkan_error('',$errtext);
         }
         if (($jnstransaksi == 'hapus') and (count($cb_hapus)==0)) {
             $errtext = "Cek terlebih dahulu kode yang akan anda hapus";
             tampilkan_error('',$errtext);
         }
         if ($jnstransaksi == 'tambah') {
             $insert = "insert into personil_proyek (kode_proyek,kode_pengguna,jabatan,kualifikasi,dibuat_oleh,tgl_dibuat) ";
             $values = "values ('$kode_proyek','$personil','$jabatan','$kualifikasi','$dibuat_oleh','$tgljam')";
             $sqltext = "$insert$values";
             $hasil = mysql_query($sqltext, $db);
						 
						 //Mendaftarkan personil proyek sbg. anggota grup proyek ini (AS).
						// echo $singkatan."<br>";
		    		 $hasil_grup = mysql_query("SELECT kode_grup from grup WHERE nama_grup='$singkatan'");
    				 $kode_grup = mysql_result($hasil_grup,0,"kode_grup");							 
						 $anggota_baru = mysql_query ("INSERT INTO grup_pengguna (kode_pengguna, kode_grup, tanggal_dibuat, dibuat_oleh) 
                                   values ('$personil', '$kode_grup', now(), '$kode_pengguna')");
	           if (mysql_error())  {
	 		            echo "
					          <table width='100%' Border='0'>
					 				     <tr><td class='judul1' align='left'>Konfirmasi</td></tr>
									     <tr><td><b>Error daftarkan personil proyek ke grup proyek: </b>".mysql_error()."<br>Penyimpanan gagal.</td></tr>
						        </table>
			            ";
             }	
						 //--															
																			 
             if (mysql_errno() == 0) {
                 echo $js." window.open('personil_proyek.php?p1=$kode_proyek','isi') ".$endjs;
             }
             else {
                 tampilkan_error(mysql_errno(),mysql_error());
                 echo "$sqltext\n";
             }
         } elseif ($jnstransaksi == 'ubah')  {
             $update = "update personil_proyek ";
             $set = "set jabatan='$jabatan', kualifikasi='$kualifikasi', diubah_oleh='$kode_pengguna', tgl_diubah='$tgljam '";
             $where = "where kode_proyek='$kode_proyek' and kode_pengguna=$personil";
             $sqltext = "$update$set$where";
             $hasil = mysql_query($sqltext, $db);
             if (mysql_errno() == 0) {
                 echo $js." window.open('personil_proyek.php?p1=$kode_proyek','isi') ".$endjs;
             }
             else {
                 tampilkan_error(mysql_errno(),mysql_error());
                 echo "$sqltext\n";
             }
         } elseif ($jnstransaksi == 'hapus')  {
             $flag = true;
						 
						 //Ambil kode grup untuk menghapus personil proyek dari keanggotaan grup proyek ini (AS).
    		     $hasil_grup = mysql_query("SELECT kode_grup from grup WHERE nama_grup='$singkatan'");
 				     $kodegrup = mysql_result($hasil_grup,0,"kode_grup");	
						 //--
						 						 
             for ($i=0; $i<count($cb_hapus); $i++) {
                 $delete = "delete from personil_proyek ";
                 $where = "where kode_proyek='$kode_proyek' and kode_pengguna='".$cb_hapus[$i]."'";
                 $sqltext = "$delete$where";
                 $hasil = mysql_query($sqltext, $db);
                 if (mysql_errno() <> 0) {
                    $flag = false;
                    tampilkan_error(mysql_errno(),mysql_error());
                    exit -1;
                 }
								 
								 //Menghapus personil proyek dari keanggotaan grup proyek ini (AS).
		    		     $hasil_grup = mysql_query("SELECT kode_grup from grup WHERE nama_grup='$singkatan'");
    				     $kodegrup = mysql_result($hasil_grup,0,"kode_grup");									 
                 $delete = "delete from grup_pengguna ";
                 $where = "where kode_grup='$kodegrup' and kode_pengguna='".$cb_hapus[$i]."'";
                 $sqltext = "$delete$where";
                 $hasil = mysql_query($sqltext, $db);
                 if (mysql_errno() <> 0) {
                    $flag = false;
                    tampilkan_error(mysql_errno(),mysql_error());
                    exit -1;
                 }	
								 //--							 
             }
             if ($flag) {
                 echo $js." window.open('personil_proyek.php?p1=$kode_proyek','isi') ".$endjs;
             }
         }
         
//         echo $sqltext."<br>\n";

    break;


}



echo "</body>\n";
echo "</html>\n";

function tampilkan_error($errno, $errtext){
    echo "<table width= '75%'>\n";
    echo "<tr>\n";
    echo "<td class=judul1>Konfirmasi\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td>\n";
    if ($errno <> "") {
        echo "<font size=+1>".$errno." : </font><br>\n";
        echo "<font size=+1>".$errtext."</font>\n";
    } else {
        echo "<font size=+1>".$errtext."</font>\n";
    }
    echo "</td>\n";
    echo "</tr>\n";
    echo "</table>\n";
    exit -1;
}






    


?>
