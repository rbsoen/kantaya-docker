<?PHP

/**********************************************

Nama File : kalender.php

Fungsi    : Menyusun kalender masehi dalam 

            suatu pop-up window untuk diambil

            nilainya.

Dibuat    :	

 Tgl.     : 26-10-2001

 Oleh     : FB

 

Revisi 1	:	

 Tgl.     :

 Oleh     :

 Revisi   :



**********************************************/


include ('../lib/cek_sesi.inc');
include('fs_kalender.php');
$css = "../css/".$tampilan_css.".css";
?>



<HTML>

<HEAD>

<title>KALENDER</title>

<?php
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
?>

<SCRIPT LANGUAGE="JavaScript">

<!--

function pick(pfld,pval) {

  fld = pfld.split(",");

  val = pval.split("/");

  var idx =0;

  var wod = window.opener.document;

  if (window.opener && !window.opener.closed) {

    for (var i=0; i<wod.forms.length; i++) {

	if (wod.forms[i].name == fld[0]) {  	

	    for (var j=0; j<wod.forms[i].elements.length; j++) {

	      	if (wod.forms[i].elements[j].name == fld[1]) {

		         for (k=0;k<wod.forms[i].elements[j].options.length;k++){

			        if (wod.forms[i].elements[j].options[k].value == val[0]) {

				 wod.forms[i].elements[j].selectedIndex = k;

		         }

		    }

		}

      		if (wod.forms[i].elements[j].name == fld[2]) {

		    for (k=0;k<wod.forms[i].elements[j].options.length;k++){

			if (wod.forms[i].elements[j].options[k].value == val[1]) {

			    wod.forms[i].elements[j].selectedIndex = k;

			}

		    }

		}

      		if (wod.forms[i].elements[j].name == fld[3]) {

		    for (k=0;k<wod.forms[i].elements[j].options.length;k++){

			if (wod.forms[i].elements[j].options[k].text == val[2]) {

			    wod.forms[i].elements[j].selectedIndex = k;

			}

		    }

		}

	    }

    	}

    }

    window.close();

  }

};



function onsubmit(flag,fld,dflt,range)

{

  dfltval = dflt.split("/");

  var D = parseInt(dfltval[0]);

  var M = parseInt(dfltval[1]);

  var Y = parseInt(dfltval[2]);



  if (flag==1) 

    Y = Y - 1;

  if (flag==2) 

    M = M - 1;

  if (flag==3) 

    M = M + 1;

  if (flag==4) 

    Y = Y + 1;

  if (M==0) {

    M = 12;

    Y = Y - 1;

  }

  if (M==13) {

    M = 1;

    Y = Y + 1;

  }

  window.location.href = "kalender.php?pfld="+fld+"&pdflt="+D+"/"+M+"/"+Y+"&prange="+range;

//  return True;

};

// -->

</SCRIPT>



</HEAD>

<?PHP

    if ($pdflt == "") {

        $pdflt = date('d/m/Y');

    }

	list($tanggal,$bulan,$tahun) = split('/',$pdflt);

	list($thn_min,$thn_maks) = split(',',$prange);

	if ($bulan == "") {

		$bulan = date("n");

		$tahun = date("Y");

	}

	if ($thn_min == "") {

		$thn_min = $tahun-1;

	}

	if ($thn_maks == "") {

		$thn_maks = $tahun+1;

	}

?>



<body bgcolor="pink" text="#000000" link="blue" vlink="blue" alink="blue">

<form name="calendar" method="post" action="kalender.php">

<table width="250" Border="0">

  <tr bgcolor="red">

    <td class="judul2" colspan=7 align="center"><b>

	<?php

		if ($tahun == $thn_min) {

			print("<font size=2> << &nbsp;</font>\n");

		} else {

			print("<font size=2><a href=\"javascript:onsubmit(1, '$pfld', '$pdflt', '$prange')\"> << </a>&nbsp;</font>\n");

		}

		if (($bulan == 1) && ($tahun == $thn_min)) {

			print("<font size=2> < &nbsp;</font>\n");

		} else {

			print("<font size=2><a href=\"javascript:onsubmit(2, '$pfld', '$pdflt', '$prange')\"> < </a>&nbsp;</font>\n");

		}

		print("<font color=white size=2>".namabulan('P',$bulan)."&nbsp;$tahun&nbsp;</font>\n");

		if (($bulan == 12) && ($tahun == $thn_maks)) {

			print("<font size=2> > &nbsp;</font>\n");

		} else {

			print("<font size=2><a href=\"javascript:onsubmit(3, '$pfld', '$pdflt', '$prange')\"> > </a>&nbsp;</font>\n");

		}

		if ($tahun == $thn_maks) {

			print("<font size=2> >> &nbsp;</font>\n");

		} else {

			print("<font size=2><a href=\"javascript:onsubmit(4, '$pfld', '$pdflt', '$prange')\"> >> </a>&nbsp;</font>\n");

		}

	?>

    </b></td>

  </tr>

  <tr>

	<?php

		for ($i=1; $i<7; $i++) {

			print ("<td width=30 align=\"center\"><font size=2><b> " . namahari("S",$i) . " </b></font></td>\n\t");

		}

		print ("<td width=40 align=\"center\"><font size=2><b> " . namahari("S",0) . " </b></font></td>\n");

	?>

  </tr>

  <?php

	kalender($bulan,$tahun,$kalender);

	for ($i=0; $i<count($kalender); $i++) {

		print "   <tr>\n";

		for ($j=0; $j<7; $j++) {

			if ($kalender[$i][$j] == 0) {

				print "\t<td width=30 align=\"center\">&nbsp;</td>\n";	

			}

			else {

				$pval = $kalender[$i][$j]."/".$bulan."/".$tahun;

				print "\t<td width=30 align=\"center\">";

				print "<a href=\"javascript:pick('".$pfld."','".$pval."')\"><font size=2>".$kalender[$i][$j]."</font></td>\n";

			}

		}

		print "   </tr>\n";

	}

  ?>

</table>          





</BODY>

</HTML>

