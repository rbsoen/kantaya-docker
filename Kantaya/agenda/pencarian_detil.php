<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('cfgagenda.php');
$css = "../css/".$tampilan_css.".css";
echo "
<html>

<head>
<title>Pencarian Detil</title>
<link rel=stylesheet type='text/css' href='$css'>";
?>
<script language="JavaScript">
<!--
function submitcari(form) {
   var cr = form.cari.value;
	 var kwrd = form.ktkunci.value;
	 var tp = form.ptipe.value;
	 var fltr1;
	 var fltr2;
	 if (form.filter1.checked) {fltr1=1;} else {fltr1=0;}
	 if (form.filter2.checked) {fltr2=1;} else {fltr2=0;}
   window.open("pencarian_detil.php?cari="+cr+"&ktkunci="+kwrd+"&ptipe="+tp+"&filter1="+fltr1+"&filter2="+fltr2, "isi");
};
// -->
</script>
<?php
echo "
</head>

<body>

<div align=top>
   <table width=100% cellpadding=0 cellspacing=0>
      <tr>
        <td width=100% height=100% class=isi2>
  <div align=top>
  <table width=100% border=0 cellpadding=4 cellspacing=0>
   <form name=frmcari method=post action='pencarian_detil.php'>
    <tr>
      <td colspan=3 class=judul1>Pencarian Detil</td>
    </tr>
    <tr>
      <td class=isi2></td>
      <td class=isi2>&nbsp;</td>
      <td width=50% class=isi2></td>
    </tr>
    <tr>
      <td><font size=2 face=Verdana>Kata kunci</font></td>
      <td>:<input type=text name=ktkunci size=20></td>
      <td><font size=2 face=Verdana>Tipe: </font>
          <select size=1 name=ptipe>
            <option value='Semua' selected>Semua</option>
";
   foreach ($arrtipe as $t) {
echo "            <option value='$t'>$t</option>\n";
   }
echo "
          </select></td>
    </tr>
    <tr>
      <td><font size=2 face=Verdana>Cari di bagian</font></td>
      <td><input type=checkbox name=filter1><font size=2 face=Verdana>Judul&nbsp;</font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type=checkbox name=filter2><font size=2 face=Verdana>Deskripsi</font><br>
      </td>
      <td><input type=button value='Cari !' name='cari' onclick='javascript:submitcari(document.frmcari)'></td>
    </tr>
    <tr>
      <td class=isi2 colspan=3><br>
      </td>
    </tr>
   </form>
  </table>
  </div>";

if (isset($cari)) {
	 $query  = "select distinct date_format(tgl_mulai, '%d/%m/%y'), waktu_mulai, ";
	 $query .= "waktu_selesai, agenda.kode_agenda, judul, pemilik ";
	 $query .= "from agenda, sharing_agenda_pengguna ";
	 $query .= "where ((agenda.kode_agenda = sharing_agenda_pengguna.kode_agenda ";
	 $query .= "and kode_pengguna = $kode_pengguna and sifat_sharing = 1) ";
	 $query .= "or (pemilik = $kode_pengguna)) ";
	 if ($filter1==1 or $filter2==1) {
	 		if ($filter1==1 and $filter2==1)
	 			 {$query .= "and (judul like '%$ktkunci%' or deskripsi like '%$ktkunci%') "; }
	 		if ($filter1==1 and $filter2<>1) { $query .= "and judul like '%$ktkunci%' "; }
	 		if ($filter1<>1 and $filter2==1) { $query .= "and deskripsi like '%$ktkunci%' "; }
	 }
	 if (isset($ptipe) and  $ptipe!=='Semua') { $query .= "and tipe = '$ptipe' "; }
	 $query .= "order by tgl_mulai, waktu_mulai, waktu_selesai, judul";
	 $hsl = mysql_query($query,$dbh);
	 if (!$hsl) {echo mysql_error(); echo "<br>Query: ".$query;}
echo "
<div align=center>
  <table width=100% border=0 cellpadding=2 cellspacing=0>
    <tr>
      <td colspan=4 class=judul1><font size=2>Hasil Pencarian</font></td>
    </tr>
    <tr>
      <td class=judul2><b><font size=2 face=Verdana>Tanggal</font></b></td>
      <td class=judul2><b><font size=2 face=Verdana>Waktu</font></b></td>
      <td class=judul2><b><font size=2 face=Verdana>Judul</font></b></td>
      <td class=judul2><b><font size=2 face=Verdana>Milik</font></b></td>
    </tr>
";
   while ($dat = @mysql_fetch_row($hsl)) {
			$hsl1 = mysql_query("select nama_pengguna from pengguna where kode_pengguna=$dat[5]",$dbh);
			if (!$hsl1) { echo mysql_error(); }
			else { $milik = mysql_fetch_row($hsl1); }
echo "
    <tr>
      <td class=isi1>$dat[0]</td>
      <td class=isi1>".substr($dat[1],0,5)." - ".substr($dat[2],0,5)."</td>
      <td class=isi1><a href='isi_agenda.php?kode_agenda=$dat[3]'>$dat[4]</a></td>
      <td class=isi1>$milik[0]</td>
    </tr>
";
   }
echo "
  </table>
</div>";
}
echo "
          <p>&nbsp;</td>
      </tr>
    </table>
  </div>
</body>

</html>
";
mysql_close($dbh);
?>