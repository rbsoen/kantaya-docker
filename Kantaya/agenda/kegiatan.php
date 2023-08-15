<?php
echo "
<div align=center>
  <table border=0 width=100% >
    <tr>
";
switch ($mode) {
			 case 0: echo "      <td class=judul1 colspan=2><p>Detail Kegiatan</p></td>"; break;
			 case 1: echo "      <td class=judul1 colspan=2><p>Kegiatan Baru</p></td>"; break;
			 case 2: echo "      <td class=judul1 colspan=2><p>Detail Kegiatan <font size=2><i>(dapat diubah)</i><font></p></td>"; break;
}
if (!isset($ptipe) or $ptipe=='') { $ptipe = "Pertemuan"; }
echo "
    </tr>
    <tr>
      <td>
        <div align=center>
          <table width=100% border=0>
            <tr>
              <td width=40% colspan=3><font size=2 face=Verdana>Judul Kegiatan: </font><font face=Verdana size=1 color=000080><i>maks.
                80 karakter</i></font></td>
              <td>&nbsp</td>
            </tr>
            <tr>
              <td width=40% colspan=3>
                <input  type=text name='judul' size=30 value=\"".htmlspecialchars(stripslashes($judul))."\"></td>
              <td align=center valign=middle>Tipe:&nbsp;
                <select  size=1 name='ptipe'>
";
		 		foreach ($arrtipe as $t) {
								$slctd = '';
								if ($t==$ptipe) {$slctd = 'selected';}
echo "                      <option ".$slctd." value='$t'>$t</option>\n";
		 							}
echo "          </select></td>
            </tr>
            <tr>
              <td width=40% colspan=3><font size=2 face=Verdana>Tanggal:</font></td>
              <td></td>
            </tr>
            <tr>
              <td width=40% colspan=3>
			<select  name=ptgl>
";
				for ($i=1; $i<=31; $i++) {
						$slctd = '';
						if ($i==$ptgl) {$slctd = 'selected';}
echo"					<option  ".$slctd." value=".$i.">".$i."</option>\n";
				}
echo"			</select>
			<select  name=pbln>
";
				for ($i=1; $i<=12; $i++) {
						$slctd = '';
						if ($i==$pbln) {$slctd = 'selected';}
						$nmbln = namabulan("S", $i);
echo"					<option  ".$slctd." value=".$i.">".$nmbln."</option>\n";
				}
echo"			</select>
			<select  name=pthn>
";
				for ($i=date("Y"); $i<=date("Y")+2; $i++) {
						$slctd = '';
						if ($i==$pthn) {$slctd = 'selected';}
echo"					<option  ".$slctd." value=".$i.">".$i."</option>\n";
				}
echo"      </select></td>
              <td><font size=2 face=Verdana>Deskripsi: </font><font face=Verdana size=1 color=000080><i>maksimum
                120 karakter</i></font></td>
            </tr>
            <tr>
              <td width=40% colspan=3>
                  <input  type=radio value=1 name=spjhari $chk1><font size=2 face=Verdana>Sepanjang
                  hari</font>
              </td>
              <td rowspan=3>
                  <p><textarea  rows=5 name='deskripsi' cols=35>".stripslashes($deskripsi)."</textarea></p>
              </td>
            </tr>
            <tr>
              <td width=5% >
                  <font size=2 face=Verdana><input  type=radio value=0 name=spjhari $chk2>Waktu</font>
              </td>
              <td width=7% >
                  <font size=2 face=Verdana>&nbsp;mulai</font>
              </td>
              <td width=28% valign=top>
                  : <select  size=1 name=pjammulai onchange=document.isikgtn.spjhari[1].click()>";
			for ($i=0; $i<=23; $i++) {
					$slctd = '';
					if ($i==$pjammulai) {$slctd = 'selected';}
					if (strlen($i)==1) { $i="0".$i; }
echo"					<option  ".$slctd." value=".$i.">".$i."</option>\n";
					}
echo"        </select>:<select  size=1 name=pmntmulai onchange=document.isikgtn.spjhari[1].click()>
";
			for ($i=00; $i<=45; $i+=15) {
					$slctd = '';
					if ($i==$pmntmulai) {$slctd = 'selected';}
					if (strlen($i)==1) { $i="0".$i; }
echo"					<option  ".$slctd." value=".$i.">".$i."</option>\n";
					}
echo"        </select>
              </td>
            </tr>
            <tr>
              <td width=5% >
              </td>
              <td width=7% >
                  <font size=2 face=Verdana>&nbsp;selesai</font>
              </td>
              <td width=28% valign=top>
                  : <select  size=1 name=pjamakhir onchange=document.isikgtn.spjhari[1].click()>";
			for ($i=0; $i<=23; $i++) {
					$slctd = '';
					if ($i==$pjamakhir) {$slctd = 'selected';}
					if (strlen($i)==1) { $i="0".$i; }
echo"					<option  ".$slctd." value=".$i.">".$i."</option>\n";
					}
echo"        </select>:<select  size=1 name=pmntakhir onchange=document.isikgtn.spjhari[1].click()>\n";
			for ($i=00; $i<=45; $i+=15) {
					$slctd = '';
					if ($i==$pmntakhir) {$slctd = 'selected';}
					if (strlen($i)==1) { $i="0".$i; }
echo"					<option  ".$slctd." value=".$i.">".$i."</option>\n";
					}
echo"        </select>
              </td>
            </tr>
          </table>";
?>
