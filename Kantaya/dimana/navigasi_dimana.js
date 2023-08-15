/******************************************
Nama File : navigasi_dimana.js (javascript)
Fungsi    : Merefresh navigasi berdasarkan
            level unit kerja yang dipilih,
            mengirim pilihan keberadaan dan
            pencarian keberadaan pengguna.
Dibuat    :	
 Tgl.     : 02-10-2001
 Oleh     : AS
 
Revisi 1	:	
 Tgl.     :
 Oleh     :
 Revisi   :

******************************************/

function expandUnit(k) {
    x[k][3] = 1;
    printNavigasi();
};

function collapseUnit(k) {
    x[k][3] = 0;
    printNavigasi();
};

function expandGrup(k) {
    g[k][3] = 1;
    printNavigasi();
};

function collapseGrup(k) {
    g[k][3] = 0;
    printNavigasi();
};

function printNavigasi() {
    var adm = admin;
    var css = cssfile;
    var z = new Array(x.length);
    for (var i=0; i<x.length; i++) {
        z[i] = new Array(4);
    }
    for (var i=0; i<x.length; i++) {
        for (var j=0; j<4; j++) {
            z[i][j] = x[i][j];
        }
    }
    var y = new Array(g.length);
    for (var i=0; i<g.length; i++) {
        y[i] = new Array(4);
    }
    for (var i=0; i<g.length; i++) {
        for (var j=0; j<4; j++) {
            y[i][j] = g[i][j];
        }
    }
    document.open("text/html","navigasi");
    document.writeln("<html>");
    document.writeln("<head> ");
    document.writeln("<title>Navigasi Modul Dimana</title>");
    document.writeln("<link rel=stylesheet type='text/css' href='"+css+"'>");
    document.writeln("<meta http-equiv='Content-Style-Type' content='text/css'>");
    document.writeln("<script language='Javascript' src='navigasi_dimana.js'></script>");
    document.writeln("<script language='Javascript'>");
    document.writeln("var admin = "+adm+";");
    document.writeln("var cssfile = '"+css+"';");
    document.writeln("x = new Array("+z.length+");");
    document.writeln("for (var i=0; i<"+z.length+"; i++) {");
    document.writeln("    x[i] = new Array(4);");
    document.writeln("}");
    for (var i=0; i<z.length; i++) {
        for (var j=0; j<4; j++) {
            document.writeln("x["+i+"]["+j+"] = '"+z[i][j]+"';");
        }
    }
    document.writeln("g = new Array("+y.length+");");
    document.writeln("for (var i=0; i<"+y.length+"; i++) {");
    document.writeln("    g[i] = new Array(4);");
    document.writeln("}");
    for (var i=0; i<y.length; i++) {
        for (var j=0; j<4; j++) {
            document.writeln("g["+i+"]["+j+"] = '"+y[i][j]+"';");
        }
    }
    document.writeln("</script>");
    document.writeln("</head>");
    document.writeln("<body >");

		printNavigasidimana();
    printNavigasiunit();
    printNavigasicari();

    document.writeln("</body>");
    document.writeln("</html>");
    document.close();
};

function printNavigasidimana() {
				 document.writeln("<form name='keberadaan' method=post action='keberadaan.php'  target='isi'>");
				 document.writeln("<table width=100% border='0'>");
				 document.writeln("<tr>");
				 document.writeln("<td colspan=2 class='judul1'>Keberadaan</td>");
				 document.writeln("</tr>");
				 document.writeln("<tr>");
				 document.writeln("<td width=30% ></td><td><input type=radio name=pdimana value='1' checked>Di Dalam Kantor</td>");
				 document.writeln("</tr>");
				 document.writeln("<tr>");
				 document.writeln("<td width=30% ></td><td><input type=radio name=pdimana value='2'>Di Luar Kantor</td>");
				 document.writeln("</tr>");
				 document.writeln("<tr>");
				 document.writeln("<td width=30% ></td><td><input type=radio name=pdimana value='3'>Rapat</td>");
				 document.writeln("</tr>");
				 document.writeln("<tr>");
				 document.writeln("<td width=30% ></td><td><input type=radio name=pdimana value='0'>Tidak Masuk</td>");
				 document.writeln("</tr>");
				 document.writeln("<tr>");
				 document.writeln("<td colspan=2 >Keterangan :</td>");
				 document.writeln("</tr>");
				 document.writeln("<tr>");
				 document.writeln("<td></td><td class ='isi1' width=50% ><input type=text name=pket></td>");
				 document.writeln("</tr>");
				 document.writeln("<tr>");
				 document.writeln("<td colspan=2 align=center><input type=submit  name=psubmit value='Simpan')></td>");
				 document.writeln("</tr>");
				 document.writeln("<tr>");
				 document.writeln("</tr>");
				 document.writeln("</table>");
				 document.writeln("</form>");

				 document.writeln("<table width='100%' Border='0'>\n");
    		 document.writeln("<tr>");
    		 document.writeln("<td class='judul1' align='left'>List Unit</td>");
    		 document.writeln("</tr>");
				 document.writeln("</table>");				 
};


function printNavigasiunit() {
    document.writeln("<table width='100%' Border='0'>\n");
    var plevel = 0;
    var expand = true;
    var imgOpen = "<img src='../gambar/folder_open.gif' border=0>";
    var imgClosed = "<img src='../gambar/folder_closed.gif' border=0>";
    for (var i=0; i<x.length; i++) {
        if (expand || x[i][2] <= plevel) {
           document.writeln("<tr>");
           unitlevel = x[i][2];
           for (var j=0; j<unitlevel-1; j++) {
               document.writeln("<td width='8%'>&nbsp;</td>");
           }
           if (i < (x.length-1)) {
              if (x[i+1][2] > x[i][2]) {
                 if (x[i][3] == 0) {
                    document.writeln("<td class='isi1' width='8%' align='right'><a href=\"javascript:expandUnit("+i+")\">"+imgClosed+"</a></td>");
                    expand = false;
                    plevel = x[i][2];
                 } else {
                   document.writeln("<td class='isi1' width='8%' align='right'><a href=\"javascript:collapseUnit("+i+")\">"+imgOpen+"</a></td>");
                   expand = true;
                   plevel = x[i][2];
                 }
								 seunit = "tidak";
              } else {
                   document.writeln("<td width='8%'>&nbsp;</td>");
									 seunit = "ya";
              }
           } else {
             document.writeln("<td width='8%'>&nbsp;</td>");
           }

           document.writeln("<td colspan="+(10-unitlevel)+">");
           document.writeln("<a href='keberadaan.php?punitnav="+x[i][0]+"&pseunit="+seunit+"&pabjad=Semua' target='isi'>"+x[i][1]+"</a><br>");
           document.writeln("</td>");
           document.writeln("</tr>");
        }
    }
    document.writeln("<tr>");
    document.writeln("<td colspan=10>&nbsp;</td>");
    document.writeln("</tr>");
    document.writeln("</table>");
};


function printNavigasicari() {
    document.writeln("<table width='100%' Border='0'>");
    document.writeln("<form name='caripengguna' method=post action='keberadaan.php'  target='isi'>");
    document.writeln("<form name='caripengguna'>");		
    document.writeln("<tr>");
    document.writeln("<td class='judul1' align='left'>Pencarian (Nama)</td>");
    document.writeln("</tr>");
    document.writeln("<tr>");
    document.writeln("<td height=50 class='isi1' align='center'><input type=text name=pkatakunci></td>");
    document.writeln("</tr>");
    document.writeln("<tr>");
    document.writeln("<input type=hidden name=pseunit value='tidak'>");
    document.writeln("<input type=hidden name=punitnav value='0100000000'>");
    document.writeln("<td align='center'><input type=submit name=pcari value='Cari!'></td>");
    document.writeln("</tr>");
    document.writeln("</form>");
    document.writeln("</table>");
    document.writeln("<p>");
};



