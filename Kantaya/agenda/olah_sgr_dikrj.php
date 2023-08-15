<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
$css = "../css/".$tampilan_css.".css";
echo "
<html>
<head>
<title></title>
<link rel=stylesheet type='text/css' href='$css'>
</head>
";
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function openurl(urlpath,tgt)
{
	window.open(urlpath,tgt);
}
// -->
</script>
<body>

<?php
echo "<div><center><p><br><br></p><p><br><br>";
if ($modus !== 'Hapus' and $judul == '' ) {
	 $msg = "Judul tidak boleh kosong !";
	 echo "<b><font face=Verdana size=4>$msg</font></b>\n";
	 echo "<br><br><font face=Verdana size=2><input type=button name=B1 value='Kembali' onclick='history.go(-1)'></font><br>\n";
	 echo "</p></center></div>\n";
} else {
   switch ($modus) {
			 case	'Hapus' :
			 			$query  = "DELETE FROM segera_dikerjakan ";
						$query .= "WHERE kode_dikerjakan = $kode_dikerjakan";
						$msg = 'Tugas segera dikerjakan: <b>'.$judul.'</b>, berhasil dihapus';
						break;
			 case 'Ubah' :
			 			if ($batas_akhir == 'ON') {$tgl_berakhir = $pthn."-".$pbln."-".$ptgl;}
						else {$tgl_berakhir = '';}
						$query  = "UPDATE segera_dikerjakan SET ";
						$query .= "judul = '$judul', ";
						$query .= "status = '$status', ";
						$query .= "tgl_berakhir = '$tgl_berakhir', ";
						$query .= "deskripsi = '$deskripsi', ";
						$query .= "tgl_diubah = curdate() ";
						$query .= "where kode_dikerjakan = $kode_dikerjakan";
						$msg = 'Data tugas segera dikerjakan: <b>'.$judul.'</b>, berhasil diubah';
						break;
			 case 'Simpan' :
			 			if ($batas_akhir == 'ON') {$tgl_berakhir = $pthn."-".$pbln."-".$ptgl;}
						else {$tgl_berakhir = 'NULL';}
			 			$query  = "INSERT INTO segera_dikerjakan ";
						$query .= "VALUES ('', $pemilik, '$judul', '$status', '$tgl_berakhir', ";
						$query .= "'$deskripsi', curdate(), '')";
						$msg = 'Tugas segera dikerjakan: <b>'.$judul.'</b>, berhasil ditambahkan';
			 			break;
   }
	 list($tgl,$bln,$thn) = split("-",$tanggal);
   $hsl = mysql_query($query,$dbh);
   if ($hsl) {
	 		echo "<script language='JavaScript'>\n";
			switch ($hmb) {
	    case 'h': echo "openurl('agenda.php?msg=$msg&ptgl=$tgl&pbln=$bln&pthn=$thn','isi');\n";
					 			$nav=0; break;
	    case 'm': echo "openurl('mingguan.php?msg=$msg&ptgl=$tgl&pbln=$bln&pthn=$thn','isi');\n";
					 			$nav=1; break;
	    case 'b': echo "openurl('bulanan.php?msg=$msg&ptgl=$tgl&pbln=$bln&pthn=$thn','isi');\n";
					 			$nav=2; break;
      }
			echo "openurl('navigasi_agenda.php?nav=$nav&ptgl=$tgl&pbln=$bln&pthn=$thn','navigasi');</script>";
	 } else {
	 		echo mysql_error()."\n";
			echo "Query: ".$query;
   }
}
echo "</p></center></div>";
?>
</body>
</html>

