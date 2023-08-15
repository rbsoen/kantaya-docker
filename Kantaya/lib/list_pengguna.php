<?php

/**********************************************

Nama File : list_pengguna.php

Fungsi    : Menampilkan list pengguna dlm.

            suatu pop-up window untuk diambil

            nilainya.

Dibuat    :	

 Tgl.     : 23-10-2001

 Oleh     : FB

 

Revisi 1	:	

 Tgl.     :

 Oleh     :

 Revisi   :



**********************************************/



include ('../lib/cek_sesi.inc'); 
require("../lib/kantaya_cfg.php");

$css = "../css/".$tampilan_css.".css";



$db = mysql_connect($host, $root);

mysql_select_db($database, $db);

$punit = split(",",$pfltr);

$sqltext = "Select a.kode_pengguna, a.nama_pengguna, a.unit_kerja, b.nama_unit from pengguna a, unit_kerja b ";

$sqltext = $sqltext."where a.unit_kerja = b.kode_unit ";

$sqltext = $sqltext."and a.nama_pengguna like '$pnama%' ";

for ($i=0; $i<count($punit); $i++){

    if ($i == 0) {

        $sqltext = $sqltext."and (a.unit_kerja like concat(trim(trailing '0' from '".$punit[$i]."'), '%') ";

    } else {

        $sqltext = $sqltext."or a.unit_kerja like concat(trim(trailing '0' from '".$punit[$i]."'), '%') ";

    }

    if ($i == count($punit)-1) {

        $sqltext = $sqltext.") ";

    }

}

if ($porder == "U") {

    $sqltext = $sqltext."order by unit_kerja";

} else {

    $sqltext = $sqltext."order by nama_pengguna";

}

//echo "$sqltext<br>\n";



$pengguna = mysql_query($sqltext, $db);



echo "<html>\n";

echo "<head>\n";

echo "<title>Daftar List Pengguna</title>\n";

echo "<link rel=stylesheet type='text/css' href='$css'>\n";

echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";

echo "<SCRIPT LANGUAGE=\"JavaScript\">\n";

echo "<!--\n";

echo "function pick(pfld,pval) {\n";

echo "    fld = pfld.split(',');\n";

echo "    val = pval.split(','); \n";

echo "    var wod = window.opener.document;\n";

echo "    if (window.opener && !window.opener.closed) {\n";

echo "        for (var i=0; i<wod.forms.length; i++) {\n";

echo "            if (wod.forms[i].name == fld[0]) {\n";

echo "                for (var j=0; j<wod.forms[i].elements.length; j++) {\n";

echo "                    if (wod.forms[i].elements[j].name == fld[1]) {\n";

echo "                        wod.forms[i].elements[j].value = val[0];\n";

echo "                    }\n";

echo "                    if (wod.forms[i].elements[j].name == fld[2]) {\n";

echo "                        wod.forms[i].elements[j].value = val[1];\n";

echo "                    }\n";

echo "                } \n";

echo "            }\n";

echo "        }\n";

echo "    } \n";

echo "    window.close();\n";

echo "};\n";

echo "// -->  \n";

echo "</SCRIPT>  \n";

echo "</head>\n";

echo "<body>\n";



echo "<table width='45%' border='0'>\n";

echo "<tr>\n";

echo "<td class='judul1'>List Pengguna</td>\n";

echo "</tr>\n";

echo "<tr>\n";

echo "<td>\n";

     echo "<table width='100%'>\n";

     echo "<tr>\n";

     echo "<td class=isi2><a href='list_pengguna.php?pfld=".$pfld."&pfltr=".$pfltr."'>Semua</a></td>\n";

     for ($i=0; $i<25; $i++) {

         echo "<td class=isi2><a href='list_pengguna.php?pfld=".$pfld."&pfltr=".$pfltr."&pnama=".chr($i+65)."'>".chr($i+65)."</a></td>\n";

     }

     echo "</tr>\n";

     echo "</table>\n";

echo "</td>\n";

echo "</tr>\n";

echo "<tr>\n";

echo "<td>\n";

     echo "<form name='caripengguna'>\n";

     echo "<table width='100%'>\n";

     echo "<tr>\n";

     echo "<td width='20%'>Cari :</td>\n";

     echo "<td width='60%'><input type=text size=20 name=katakunci></td>\n";

     echo "<td width='20%'><input type=button value='Cari!' onClick=window.open('list_pengguna.php?pfld='+'$pfld'+'&pfltr='+'$pfltr'+'&pnama='+katakunci.value,'_self')></td>\n";

     echo "</tr>\n";

     echo "</table>\n";

     echo "</form>\n";

echo "</td>\n";

echo "</tr>\n";

echo "<tr>\n";

echo "<td>\n";

     echo "<table width='100%'>\n";

     echo "<tr class='judul'>\n";

     echo "<td class=judul2 width='60%'><a href='list_pengguna.php?pfld=".$pfld."&pfltr=".$pfltr."&pnama=$pnama&porder=N'>Nama</a></td>\n";

     echo "<td class=judul2 width='40%'><a href='list_pengguna.php?pfld=".$pfld."&pfltr=".$pfltr."&pnama=$pnama&porder=U'>Unit Kerja</a></td>\n";

     echo "</tr>\n";

     while ($row = mysql_fetch_array($pengguna)) {

         $pval = $row["kode_pengguna"].",".$row[nama_pengguna];

         echo "<tr>\n";

         echo "<td class=isi2 width='60%'><a href=\"javascript:pick('".$pfld."','".$pval."')\">".$row["nama_pengguna"]."</td>\n";

         echo "<td class=isi2 width='40%'>".$row["nama_unit"]."</td>\n";

         echo "</tr>\n";

     }

     echo "</table>\n";

echo "</td>\n";

echo "</tr>\n";

echo "<tr>\n";

echo "<td>&nbsp;</td>\n";

echo "</tr>\n";

echo "</table>\n";

echo "</body>\n";

echo "</html>\n";



