<?php
session_start();
include ('../lib/cek_sesi.inc');
include('../lib/koneksi_db.inc');
include('../lib/fs_kalender.php');
$css = "../css/".$tampilan_css.".css";
echo "
<html>

<head>
<title>Tambah Segera Dikerjakan</title>
<link rel=stylesheet type='text/css' href='$css'>
</head>

<body>

<div align=center>
</div>&nbsp;
<div align=center>
 <form name=form1 method=post action='olah_sgr_dikrj.php'>
   <input type=hidden name='tanggal' value='$tanggal'>
   <input type=hidden name='hmb' value='$hmb'>
   <input type=hidden name='pemilik' value=$kode_pengguna>
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
<input type=text name=judul size=35></td>
              <td><select size=1 name='status'>";
echo "       				<option>Selesai</option>";
echo "       				<option selected>Dalam Pengerjaan</option>
                </select></td>
            </tr>
            <tr>
              <td><font size=2 face=Verdana>Tanggal batas akhir pengerjaan:</font></td>
              <td></td>
            </tr>
            <tr>
              <td>";
				$expr = "document.form1.batas_akhir[0].click()";
echo"
		 					<input type=radio value=ON name='batas_akhir'>
										<select size=1 name='ptgl' onChange=$expr>";
				for ($i=1; $i<=31; $i++) {
						$slctd = '';
						if ($i==date("j")) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$i;
				}
echo"
			</select>
			<select name='pbln' onChange=$expr>
		";
				for ($i=1; $i<=12; $i++) {
						$nmbln = namabulan("S", $i);
						$slctd = '';
						if ($i==date("n")) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$nmbln;
				}
echo"
			</select>
			<select name='pthn' onChange=$expr>
";
				for ($i=date("Y"); $i<=date("Y")+1; $i++) {
						$slctd = '';
						if ($i==date("Y")) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$i;
				}
echo"
			</select></td>
              <td><font size=2 face=Verdana>Deskripsi: </font><font face=Verdana size=1 color='#000080'><i>maksimum
                120 karakter</i></font></td>
            </tr>
            <tr>
              <td valign=top>
                  <input type=radio value=OFF name='batas_akhir'><font size=2 face=Verdana>Tidak
                  ada batas waktu<br>
                  </font>
             
              </td>
              <td>
                  <p><textarea rows=5 name='deskripsi' cols=30></textarea></p>
  
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
					 <input type=submit value='Simpan' name='modus'> 
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