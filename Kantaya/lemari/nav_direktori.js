/******************************************
Nama File : nav_direktori.js (javascript)
Fungsi    : Merefresh navigasi berdasarkan
            direktori yang dipilih
Dibuat    :	
 Tgl.     : 28-11-2001
 Oleh     : KB
 
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


function printNavigasi() {
    
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

    document.open("text/html","navigasi");
    document.writeln("<html>");
    document.writeln("<head> ");
    document.writeln("<title>Navigasi Modul Dimana</title>");
    document.writeln("<link rel=stylesheet type='text/css' href='"+css+"'>");
    document.writeln("<meta http-equiv='Content-Style-Type' content='text/css'>");
    document.writeln("<script language='Javascript' src='nav_direktori.js'></script>");
    document.writeln("<script language='Javascript'>");
    
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

    document.writeln("</script>");
    document.writeln("</head>");
    document.writeln("<body >");

	document.writeln("<table width='100%'>");
		document.writeln("<tr><td class='judul1'>");
		document.writeln("<font size='+1'>Direktori Anda</font>");
		document.writeln("</td></tr></table>");
    printNavigasiunit();
 
		document.writeln("<hr size='1'>\n");
		
		//Buat Direktori Baru
		document.writeln("<font face='Verdana' size='2'>");
    document.writeln(">> <a href='direktori_baru.php' target='isi_dir'>Buat Direktori Baru</a><br>\n");
		document.writeln(">> <a href='direktori_sharing.php'>Direktori Bersama</a><br>\n");
    document.writeln("</font>");
		
		document.writeln("<hr size='1'>\n");
    document.writeln("</body>");
    document.writeln("</html>");
    document.close();
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
            		
           document.writeln("<a href='isi_direktori.php?pdirektorinav="+x[i][0]+"' target='isi_dir'>"+x[i][1]+"</a>");
           //document.writeln("+x[i][0]+");
					 document.writeln("<td><a href='hapus_dir.php?kode_direktori="+x[i][0]+"' target='isi_dir'><img src='../gambar/del.gif' border='0'></a>");
		       document.writeln("</td>");
           document.writeln("</tr>");
        }
    }
    document.writeln("<tr>");
    document.writeln("<td colspan=10>&nbsp;</td>");
    document.writeln("</tr>");
    document.writeln("</table>");
};




