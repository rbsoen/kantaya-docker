<?php

session_start();
error_reporting(0);
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
$css = "../css/".$tampilan_css.".css";
echo "<html><head><link rel=stylesheet type='text/css' href='$css'></head><body bgcolor=#EEEEEE>\n";
echo "<div align=center>\n";
echo "  <table border=0 width=100%>\n";
echo "    <tr>\n";
echo "      <td class=judul1 colspan=4>Buku Alamat</td>\n";
echo "    </tr>\n";
echo "<form action='alamat.php' method=post>\n";
echo "<input type=hidden name='PHPSESSID' value='$PHPSESSID'>\n";
echo "<input type=hidden name='up' value='$up'>\n";
echo "<input type=hidden name='sort' value='$sort'>\n";
echo "<input type=hidden name='kategori' value='$kategori'>\n";
echo "<input type=hidden name='ktg_grup' value='$ktg_grup'>\n";
echo "<input type=hidden name='tingkat' value='$tingkat'>\n";
echo "<tr><td>&nbsp;&nbsp;Cari:<input type=text size=15 name='keyword'>&nbsp;</td>\n";
echo "<td>Dalam Kolom:<select name='filter'><option value='semua'>Nama/Kantor";
echo "<option value='nama'>Nama";
echo "<option value='kantor'> Kantor";
echo "</select></td>\n";
echo "<td><input type=submit value='CARI'></td>";

$deltemp = mysql_query ("delete from temp_alamat", $dbh) or mysql_error();

		 if (!$perpage) { $perpage = 20; } // set default per page
		 echo "<td align=right><select name='perpage'>\n";
		 for ($i = 10; $i <= 30; $i+=5) 
		 		 {
		 		 $j = $i;
				 echo "<option value='$j'";
				 if ($j == $perpage) { echo " selected"; }
				 echo ">$j\n";
      	 }
      echo "</select> Nama/Halaman</td></tr></table></form><br>\n";
			echo "<TABLE border=0 cellpadding=0 cellspacing=1 width=100%><TR><TD>&nbsp;</td></tr></table>";

// arah up/down
if ($up == '') {$up = 1;}
if ($up == "1") { $arah = "ASC"; $up2 = 0; } else { $arah="DESC"; $up2 = 1; }

//where-clause
			// abjad
			echo "<TABLE border=0 cellpadding=0 cellspacing=1 width=100%><TR><TD><B>";
			if ($abjad == "semua" or $abjad == '')
				 { echo "&nbsp;Semua&nbsp;-";
				 	 $where = "where nama like '%'";
					 $where1 = "where nama_pengguna like '%'";
					}
			else 
				 { echo "&nbsp;<A href='alamat.php?abjad=semua&kategori=$kategori&tingkat=$tingkat&ktg_grup=$ktg_grup'>Semua</A>&nbsp;-";
				 	 $where = "where nama like '$abjad%'";
					 $where1 = "where nama_pengguna like '$abjad%'";
					}
			For ($a = ord("A"); $a <= ord("Z"); $a++)
					{ 
					$hrf = chr($a);
					if ($abjad == $hrf)
						 {echo "$hrf-";						 
						 }
					else
						 {echo "<A href='alamat.php?abjad=$hrf&kategori=$kategori&tingkat=$tingkat&ktg_grup=$ktg_grup'>$hrf</A>-";}
						 }			
			echo "</B></td></TR></TABLE>";
			$strktg = "Buku Alamat ";
			switch ($kategori) {
						 case '' 	 : $kategori = 'I';
						 case 'I'	 : $strktg .= "Personal/Pribadi";
						 					 	 $where .= " and kategori = 'I' and didaftar_oleh = '$kode_pengguna'"; break;
						 case 'P'	 : $strktg .= "Publik/Umum";
						 					 	 $where .= " and kategori = 'P'"; break;
						 case 'U'	 : $hsl = mysql_query("select nama_unit from unit_kerja where kode_unit = '$ktg_grup'", $dbh);
						 					 	 if (!hsl) { echo mysql_error(); } 
												 $nmunit = mysql_fetch_row($hsl);
												 $strktg .= "Unit Kerja : ".$nmunit[0];
												 $cutpos = 2*$tingkat;
						 					 	 $funit = substr($ktg_grup,0,$cutpos);										 
						 					 	 $where1 .= " and unit_kerja like '$funit%'";
						 					 	 $where .= " and ktg_grup = '$ktg_grup'";
						 					 	 break;
						 case 'G'	 : $hsl = mysql_query("select nama_grup from grup where kode_grup = '$ktg_grup'", $dbh);
						 					 	 if (!hsl) { echo mysql_error(); } 
												 $nmgrup = mysql_fetch_row($hsl);
												 $strktg .= "Grup : ".$nmgrup[0];
												 $where .= " and ktg_grup = '$ktg_grup'";
						 					 	 $where1 = ", grup_pengguna ".$where1." and grup_pengguna.kode_pengguna = pengguna.kode_pengguna and kode_grup = $ktg_grup";
						 }
			echo "<br>&nbsp;&nbsp;$strktg";
      // filter
      if ($keyword and ($abjad == "semua" or $abjad == '')) 
				{
        if ($filter == "semua" or $filter == '') 
					 { $where .= " and (nama like '%$keyword%' or kantor like '%$keyword%')";}
        else { $where .= " and $filter like '%$keyword%'"; }
				$where1 .= " and nama_pengguna like '%$keyword%'"; 
				}
			//kategori
      echo "<table border=0 width=100%><tr>\n";
      echo "<td class=judul2>&nbsp;</td>";
      $e1="<td class=judul2 width=";
      $e2="><b><a href='alamat.php?kategori=$kategori&tingkat=$tingkat&ktg_grup=$ktg_grup&sort=";
      $e3="&up=$up2&page=$page&perpage=$perpage&keyword=$keyword&filter=$filter&PHPSESSID=$PHPSESSID'>";
      $e4="</a></b></td>\n";
      echo "$e1 30% $e2 nama $e3 NAMA $e4";
      echo "$e1 15% $e2 jabatan $e3 Jabatan $e4";
      echo "$e1 20% $e2 kantor $e3 Kantor $e4";
      echo "$e1 10% $e2 telp_kantor $e3 Telp. $e4";
      echo "$e1 10% $e2 fax $e3 Fax $e4";
      echo "$e1 15% $e2 email $e3 Email $e4";
		
// Tabel Koresponden
if (!$sort)
	 { $sort = "nama"; $arah="ASC";}
$qryk  = "insert into temp_alamat ";
$qryk .= "select nama, jabatan, kantor, telp_kantor, fax, email, web_kantor, ";
$qryk .= "kontak_id, didaftar_oleh, 0 pguna from buku_alamat ".$where;
$qryp  = "insert into temp_alamat select nama_pengguna nama, '' jabatan, 'Internal' kantor, ";
$qryp .= "telp_k telp_kantor, fax, email, '' web_kantor, pengguna.kode_pengguna kontak_id, ";
$qryp .= "'' didaftar_oleh, 1 pguna from pengguna ".$where1;
$tmprslt = mysql_query ($qryk, $dbh) or mysql_error();
if ($kategori !== 'I')
	 {$unitrslt =	mysql_query ($qryp, $dbh) or mysql_error();}
$result = mysql_query ("select * from temp_alamat order by $sort $arah", $dbh) or mysql_error();
      while ($row = @mysql_fetch_row($result))
			 {
        if ($b >= $page*$perpage and $b < ($page+1)*$perpage)
				 {
          // show button for personal access
          if ($row[15] == $user_ID and $row[16] <> "a") {$sign = "<img src='img/g.gif' alt='$datei_text13' title='$datei_text13' border=0 width=6>";}
          else { $sign = ""; }
          //change colours
          if (($i/2) == round($i/2)) { $color = "#E5E5E5";$i++; } else { $color = "#D8D8D8";$i++; }
          echo "<tr bgcolor=$color><td class=isi2 align='right'></td>\n";
          echo "<td class=isi2><a href='data_koresponden.php?kontak_id=$row[7]&pendaftar=$row[8]&pguna=$row[9]'>$row[0]</a>&nbsp;</td>\n";
          echo "<td class=isi2>$row[1]&nbsp;&nbsp;</td>";
					$linkktr = '';
					if ($row[6]!=='') {$linkktr = "<a href='http://$row[6]' target=noframe>";}
          echo "<td class=isi2> $linkktr $row[2]&nbsp;</td>";
          echo "<td class=isi2>$row[3]&nbsp;</td>";
          echo "<td class=isi2>$row[4]&nbsp;</td>";
          echo "<td class=isi2><a href='mailto:$row[5]'>$row[5]</a>&nbsp;</td>";
          }
        $b++;
      	}	
				echo "</table>";
      // links for next and previous page
      $result = mysql_query ("select count(kontak_id) from temp_alamat", $dbh) or mysql_error();
      $row = mysql_fetch_row ($result);
      if ($row[0] > $perpage) {
				 echo "<br>";
				 echo "<table border=0 cellpadding=0 cellspacing=0 width=100%><tr>\n";
				 $page_n = $page + 1;
				 $page_p = $page - 1;
         if ($page) {
				 		echo "<td colspan=4 align=left><a href='alamat.php?kategori=$kategori&tingkat=$tingkat&ktg_grup=$ktg_grup&perpage=$perpage&page=$page_p&up=$up&sort=$sort&keyword=$keyword&filter=$filter&PHPSESSID=$PHPSESSID'><< sebelum</a>&nbsp;&nbsp;</td>\n";
						}
				 else echo"<td width=50%>&nbsp;</td>";
         if ($row[0] > $page_n*$perpage) {
				 		echo "<td width=50% colspan=4 align=right><a href='alamat.php?kategori=$kategori&tingkat=$tingkat&ktg_grup=$ktg_grup&perpage=$perpage&page=$page_n&up=$up&sort=$sort&keyword=$keyword&filter=$filter&PHPSESSID=$PHPSESSID'>berikut >></a></td>\n";
						}
         else {echo"<td width=50%>&nbsp;</td>";}
         echo "</tr></table>";
         }
			else {echo "<br>";}
mysql_close($dbh);
echo "<br><br><font face=Verdana size=2>&nbsp;&nbsp;&nbsp; <a href=formalamat.php?kategori=$kategori&ktg_grup=$ktg_grup>Tambah Koresponden</a></font><br><br>\n";
echo "</div></body>";
echo "</html>";
?>
