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

$hsl = mysql_query("select * from segera_dikerjakan where kode_dikerjakan = '$kode_dikerjakan';");
if (!$hsl) {echo mysql_error();}
$dat = @mysql_fetch_row($hsl);
$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
echo"
<body>

<div align=center>
</div>&nbsp;
<div align=center>
 <form name=form1 method=post action='olah_sgr_dikrj.php'>
   <input type=hidden name='tanggal' value='$tanggal'>
   <input type=hidden name='hmb' value='$hmb'>
	 <input type=hidden name='kode_dikerjakan' value=$dat[1]>
   <input type=hidden name='pemilik' value=$dat[2]>
  <center>
  <table border=1 width=100% cellpadding=4 cellspacing=0>
    <tr>
      <td class=judul1><b><font size=2 face=Verdana color='#FFFFFF'>Tugas Segera
        Dikerjakan</font></b></td>
    </tr>
    <tr>
      <td>
        <div align=center>
          <table border=0 width=100% >
            <tr>
              <td><font size=2 face=Verdana>Judul: </font><font face=Verdana size=1 color='#000080'><i>maksimum
                80 karakter</i></font></td>
              <td width=50% ><font size=2 face=Verdana>Status:</font></td>
            </tr>
            <tr>
              <td>
<input type=text name=judul value='$dat[3]' size=35></td>
              <td><select size=1 name='status'>";
										$slctd = ''; if ($dat[4]=='Selesai') {$slctd = 'selected';}
echo "       				<option ".$slctd.">Selesai</option>";
										$slctd = ''; if ($dat[4]=='Dalam Pengerjaan') {$slctd = 'selected';}
echo "       				<option ".$slctd.">Dalam Pengerjaan</option>
                </select></td>
            </tr>
            <tr>
              <td><font size=2 face=Verdana>Tanggal batas akhir pengerjaan:</font></td>
              <td></td>
            </tr>
            <tr>
              <td>";
							if ($dat[5]=='') {$dgnbatas = ''; $tnpbatas = 'checked';}
							else {$dgnbatas = 'checked'; $tnpbatas = '';}
echo"
		 					<input type=radio value=ON $dgnbatas name='batas_akhir'>
										<select size=1 name='ptgl'>";
				for ($i=1; $i<=31; $i++) {
						$slctd = ''; 
						if ($i==substr($dat[5],8,2)) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$i;
				}
echo"
			</select>
			<select name='pbln'>
		";
				for ($i=1; $i<=12; $i++) {
						$slctd = '';
						if ($i==substr($dat[5],5,2)) {$slctd = 'selected';}
						$nmbln = namabulan("S", $i);
echo"					<option ".$slctd." value=".$i.">".$nmbln;
				}
echo"
			</select>
			<select name='pthn'>
";
				for ($i=date("Y"); $i<=date("Y")+1; $i++) {
						$slctd = '';
						if ($i==substr($dat[5],0,4)) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$i;
				}
echo"
			</select></td>
              <td><font size=2 face=Verdana>Deskripsi: </font><font face=Verdana size=1 color='#000080'><i>maksimum
                120 karakter</i></font></td>
            </tr>
            <tr>
              <td valign=top>
                  <input type=radio value=OFF $tnpbatas name='batas_akhir'><font size=2 face=Verdana>Tidak
                  ada batas waktu<br>
                  </font>
             
              </td>
              <td>
                  <p><textarea rows=5 name='deskripsi' cols=30>$dat[6]</textarea></p>
  
                <p>&nbsp;</td>
            </tr>
          </table>
        </div>
      </td>
    </tr>
  </table>
  </center>
</div><br>
<div align=center>
  <table border=0 width=100% cellspacing=0 cellpadding=4>
    <tr>
      <td>
        <p align=lefrt>";
echo "		 <input type=button value='Kembali' name='kembali' onclick='javascript:history.go(-1)'>\n";
echo "
			</td><td>
        <p align=right>
					 <input type=submit value='Ubah' name='modus'> 
					 <input type=submit value='Hapus' name='modus'>
      </td>
    </tr>
  </table>
 </form>
</div>
<div>&nbsp;&nbsp;</div>
</body>

</html>
";
?>
