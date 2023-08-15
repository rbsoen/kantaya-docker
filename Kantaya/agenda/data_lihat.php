<?php
echo "   <table class=tblputih width=100% border=0>";
// pengulangan
function jmlbaris($bln,$thn) {
	$mulai = date("w",mktime(0,0,0,$bln,1,$thn))-1;
	if ($mulai < 0) {$mulai = 6;}
	$jml_hari = jmlharidlmbulan ($bln, $thn);
	return ceil(($jml_hari+$mulai)/7);
}	

if ($diulg == 0) {
echo "
            <tr>
              <td width=100% valign=middle>&nbsp;-&nbsp;
									<font size=2 face=Verdana>Tanpa Pengulangan</font></td>
              </td>
            </tr><tr></tr>";
}
else {
	$chk1 = '';
	$chk2 = '';
	if ($diulg == 1) { $chk1='checked'; }
	if ($diulg == 2) { $chk2='checked'; }
	$chk3 = '';
	$chk4 = '';
	if ($tnpbts == 1) { $chk3 = 'checked'; }
	if ($tnpbts == 0) { $chk4 = 'checked'; }
echo "
    <tr>
      <td colspan=4 bgcolor=eeeeee>
        <table cellSpacing=0 cellPadding=4 width=100% border=0>
          <tbody>
            <tr>
              <td colspan=4 bgcolor=eeeeee><b>
              <font face=Verdana size=2>&nbsp;*&nbsp;Pengulangan :</font></b></td>
            </tr>
            <tr>
              <td width=30% bgcolor=eeeeee><input type=radio value=1 name=diulg $chk1>
              <font face=Verdana size=2>Diulang&nbsp;&nbsp;&nbsp;Setiap :</font></td>
              <td  colspan=3 bgcolor=eeeeee><select size=1 name=diulgstp onchange='document.isikgtn.diulg[1].click()'>
";
   $arrulgstp = array (array("1","Hari"), array("7","Minggu"), array("14","2 Minggu"), array("bln","Bulan"), array("thn","Tahun"));
   foreach ($arrulgstp as $a) {
		$slctd = '';
		if ($diulgstp == $a[0]) { $slctd = 'selected'; }
echo "                  <option ".$slctd." value=".$a[0].">".$a[1]."</option>\n";
}
echo "                </select></td>
            </tr>
            <tr>
              <td width=30% bgColor=eeeeee><input type=radio value=2 name=diulg $chk2>
               <font face=Verdana size=2>Diulang pada hari :</font></td>
              <td colspan=3 bgColor=eeeeee><select disabled size=1 name=hfsulg onchange='document.isikgtn.diulg[1].click()'>
";
   $hfsulg = date("w",mktime(0,0,0,$pbln,$ptgl,$pthn));
   for ($k=1;$k<8;$k++) {
		$i = $k;
		if ($i == 7) { $i = 0; }
		$slctd = '';
		if ($hfsulg == $i) { $slctd = 'selected'; }
		$nmhari = namahari("P",$i);
echo "                  <option ".$slctd." value=$i>$nmhari</option>\n";
   }
echo "                </select>
              <font face=Verdana size=2>&nbsp;&nbsp;minggu:</font>
                <select disabled size=1 name=kefsulg onchange='document.isikgtn.diulg[1].click()'>
";
   $haritgl1 = date("w",mktime(0,0,0,$pbln,1,$pthn));
   if ($haritgl1 == 0) {$haritgl1 = 7;}
   $x = $ptgl + $haritgl1 - 2;
   $kefsulg = ($x-$x%7)/7;
   $arrke = array(Pertama, Kedua, Ketiga, Keempat, Kelima, Keenam);
   $jmlmng = jmlbaris($pbln, $pthn);
   for ($i=0; $i<$jmlmng; $i++) {
		$slctd = '';
		if ($kefsulg == $i) { $slctd = 'selected'; }
echo "                  <option $slctd value=$i>".$arrke[$i]."</option>\n";
   }
echo "                </select>
              <font face=Verdana size=2>&nbsp;setiap:</font>
                <select size=1 name=D2>
                  <option selected>Bulan</option>
                </select></td>
            </tr>
            <tr>
              <td width=30% bgColor=ffffff>&nbsp;</td>
              <td colspan=3 bgColor=ffffff colSpan=2><input type=radio value=1 name=tnpbts $chk3><font face=Verdana size=2>Tanpa
                batas waktu</font></td>
            </tr>
            <tr>
              <td width=30% bgColor=ffffff>&nbsp;</td>
              <td colspan=3 bgColor=ffffff><input type=radio value=0 name=tnpbts $chk4><font face=Verdana size=2>sampai
                dengan&nbsp;</font><select size=1 name=sdtgl onfocus='document.isikgtn.tnpbts[1].click()'>";
				for ($i=1; $i<=31; $i++) {
						$slctd = '';
						if ($i==$sdtgl) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$i;
				}
echo"
                </select><select size=1 name=sdbln onchange='document.isikgtn.tnpbts[1].click()'>";
				for ($i=1; $i<=12; $i++) {
						$slctd = '';
						if ($i==$sdbln) {$slctd = 'selected';}
						$nmbln = namabulan("S", $i);
echo"					<option ".$slctd." value=".$i.">".$nmbln;
				}
echo"
                </select><select size=1 name=sdthn onchange='document.isikgtn.tnpbts[1].click()'>";
				for ($i=date("Y"); $i<=date("Y")+2; $i++) {
						$slctd = '';
						if ($i==$sdthn) {$slctd = 'selected';}
echo"					<option ".$slctd." value=".$i.">".$i;
				}
echo"
                </select></td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr><tr></tr>";
}

// fasilitas
if ($dgfas == 0 ) {
echo "
            <tr>
              <td width=100% valign=middle>&nbsp;-&nbsp;
									<font size=2 face=Verdana>Tanpa Fasilitas</font></td>
            </tr><tr></tr>";
}
else {
	 $slctfas = "select nama_fas from fasilitas where kode_fas = $fas";
	 $hsl = mysql_query($slctfas,$dbh); 
	 if (!$hsl1) {echo mysql_error();}
echo "
            <tr>
              <td valign=top width=40% ><b>&nbsp;*&nbsp;
							<font size=2 face=Verdana>Fasilitas yang akan digunakan :</font></b></td>
              <td width=60% >
                &nbsp;&nbsp;<b><font face=Verdana size=2>$dat[0]</font></b>
              </td>
            </tr><tr></tr>";
}

// ditampilkan
if ($sftshar == 0) {
echo "
            <tr>
              <td width=100% valign=middle>&nbsp;-&nbsp;
									<font size=2 face=Verdana>Tidak ditampilkan</font></td>
              </td>
            </tr><tr></tr>";
}
else {
$chk1 = '';
if ($sftshar == 1) { $chk1 = 'checked';}
$chk2 = '';
if ($sftshar == 2) { $chk2 = 'checked';}
if ($sharing_publik == 1) { $chkpub = 'checked'; }
else { $chkpub = '';}
echo "
    <tr>
      <td colspan=4 bgcolor=eeeeee>
			 <table border=0 cellpadding=2 cellspacing=0 width=100% bgcolor=eeeeee>
			  <tr>
						<td width=40% ><b><font size=2 face=Verdana>&nbsp;*&nbsp;Ditampilkan :</font></b></td>
				    <td width=30% ><font size=2 face=Verdana><input type=radio value=1 name=sftshar $chk1> 
						Secara Penuh</font></td>
						<td width=30% ><font size=2 face=Verdana><input type=radio value=2 name=sftshar $chk2> 
						Hanya Tanda Sibuk</font></td>
				</tr></table>
        <div align=center>
          <table border=0 cellpadding=2 cellspacing=0 width=100% bgcolor=eeeeee>
            <tr>
              <td width=5% class=judul2><b><font size=2 face=Verdana>&nbsp</font></b></td>
              <td width=20% class=judul2><b><font size=2 face=Verdana>Kepada</font></b></td>
              <td width=75% class=judul2><b><font size=2 face=Verdana>Pilih</font></b></td>
            </tr>
            <tr>
              <td width=5% bgcolor=dcdcdc><font size=2 face=Verdana>1</font></td>
              <td width=20% bgcolor=dcdcdc><font size=2 face=Verdana>Publik</font></td>
              <td width=75% bgcolor=dcdcdc><font size=2 face=Verdana><input type=checkbox name=sharing_publik value=1 $chkpub></font></td>
            </tr>
            <tr>
              <td width=5% bgcolor=d0d0d0><font size=2 face=Verdana>2</font></td>
              <td width=20% bgcolor=d0d0d0 valign=middle><font size=2 face=Verdana>Unit</font></td>
              <td width=75% bgcolor=d0d0d0><font size=1 face=Verdana>
							         <select name=untshar[] size=3 multiple>
";
$slctpgn = "select kode_unit, nama_unit from unit_kerja order by kode_unit";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctdunt = '';
			foreach ($untshar as $un) { if ($dat[0] == $un) {$slctdunt = 'selected';} }
echo "													<option value=$dat[0] $slctdunt>$dat[1]</option>\n";
}
echo "							    </select></font></td>
            </tr>
            <tr>
              <td width=5% bgcolor=CCCCCC><font size=2 face=Verdana>3</font></td>
              <td width=20% bgcolor=CCCCCC valign=middle><font size=2 face=Verdana>Grup</font></td>
              <td width=75% bgcolor=CCCCCC><font size=1 face=Verdana>
							         <select name=grpshar[] size=3 multiple>
";
$slctpgn = "select kode_grup, nama_grup from grup order by nama_grup";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctdgrp = '';
			foreach ($grpshar as $gr) { if ($dat[0] == $gr) {$slctdgrp = 'selected';} }
echo "													<option value=$dat[0] $slctdgrp>$dat[1]</option>\n";
}
echo "							    </select></font></td>
            </tr>
            <tr>
              <td width=5% bgcolor=C0C0C0><font size=2 face=Verdana>4</font></td>
              <td width=20% bgcolor=C0C0C0><font size=2 face=Verdana>Pengguna Lain</font></td>
              <td width=75% bgcolor=C0C0C0>
									<select name=pgnshar[] size=3 multiple>
";
$slctpgn  = "select kode_pengguna, nama_pengguna from pengguna ";
$slctpgn .= "where kode_pengguna <> $kode_pengguna order by nama_pengguna";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctdpgn = '';
			foreach ($pgnshar as $pg) { if ($dat[0] == $pg) {$slctdpgn = 'selected';} }
echo "													<option value=$dat[0] $slctdpgn>$dat[1]</option>\n";
}
echo "							    </select></td>
            </tr>
          </table>
        </div>
      </td>
    </tr><tr></tr>";
}

// undangan
if ($undgn == 0) {
echo "
            <tr>
              <td width=100% valign=middle>&nbsp;-&nbsp;
									<font size=2 face=Verdana>Tidak Kirim Undangan</font></td>
              </td>
            </tr>";
}
else {
		 $chk1 = '';
		 if ($undgn == 1) { $chk1 = 'checked'; }
		 if ($undgn == 0) { $chk0 = 'checked'; }
echo "
    <tr>
      <td colspan=4>
        <div align=center>
          <table cellSpacing=0 cellPadding=4 width=100% border=0>
            <tbody>
						  <tr><td colspan=3><b><font face=Verdana size=2>&nbsp;*&nbsp;Undangan :</font></b></td></tr>
              <tr>
                <td width=5% class=judul2><b><font face=Verdana size=2>&nbsp</font></b></td>
                <td width=20% class=judul2><b><font face=Verdana size=2>Kepada</font></b></td>
                <td width=80% class=judul2><b><font face=Verdana size=2>Pilih</font></b></td>
              </tr>
              <tr>
                <td width=5% bgColor=d0d0d0><font face=Verdana size=2>1</font></td>
                <td width=20% bgColor=d0d0d0><font face=Verdana size=2>Unit</font></td>
                <td width=80% bgColor=d0d0d0>
							         <select name=untundgn[] size=3 multiple onfocus='document.isikgtn.undgn[1].click()'>
";
$slctpgn = "select kode_unit, nama_unit from unit_kerja order by kode_unit";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctdunt = '';
			foreach ($untundgn as $un) { if ($dat[0] == $un) {$slctdunt = 'selected';} }
echo "													<option value=$dat[0] $slctdunt>$dat[1]</option>\n";
}
echo "							    </select></font></td>
              </tr>
              <tr>
                <td width=5% bgColor=cccccc><font face=Verdana size=2>2</font></td>
                <td width=20% bgColor=cccccc><font face=Verdana size=2>Grup</font></td>
                <td width=80% bgColor=cccccc>
									<select name=grpundgn[] size=3 multiple>
";
$slctpgn = "select kode_grup, nama_grup from grup order by nama_grup";
$hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctgrp = '';
			if (count($grpundgn)>0) { 
				 foreach ($grpundgn as $gr) { if ($dat[0] == $gr) {$slctgrp = 'selected';} }
			}
echo "													<option value=$dat[0] $slctgrp>$dat[1]</option>\n";
}
echo "								  </select></td>
              </tr>
              <tr>
                <td width=5% bgColor=c0c0c0><font face=Verdana size=2>3</font></td>
                <td width=20% bgColor=c0c0c0><font face=Verdana size=2>Pengguna Lain</font></td>
                <td width=80% bgColor=c0c0c0><font face=Verdana size=2>
									<select name=pgnundgn[] size=3 multiple>
";
   $slctpgn  = "select kode_pengguna, nama_pengguna from pengguna ";
   $slctpgn .= "where kode_pengguna <> $kode_pengguna order by nama_pengguna";
   $hsl = mysql_query($slctpgn,$dbh); if (!$hsl) {echo mysql_error();}
   while ($dat = @mysql_fetch_row($hsl)) {
			$dat = explode("·",ereg_replace("'","&#39;",htmlspecialchars(implode("·",$dat))));
			$slctpgn = '';
			if (count($pgnundgn)>0) { 
				 foreach ($pgnundgn as $pg) { if ($dat[0] == $pg) {$slctpgn = 'selected';} }
			}
echo "													<option value=$dat[0] $slctpgn>$dat[1]</option>\n";
   }
echo "								  </select></td>
              </tr>
            </tbody>
          </table>
        </div>
      </td>
    </tr>
";
}
echo "
   </table>
  </table>
</div>
";
?>
