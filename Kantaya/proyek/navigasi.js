/******************************************
Nama File : navigasi.js
Fungsi    : Menampilkan menu navigasi modul proyek (javascript)
Dibuat    :	
 Tgl.     : 19-10-2001
 Oleh     : FB
 
Revisi 1	:	
 Tgl.     : 05-11-2001
 Oleh     : AS
 Revisi   : navigasi Pencarian proyek beserta
            unit pengelolanya, style css.
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
    document.writeln("<title>Navigasi Modul Proyek</title>");
    document.writeln("<link rel=stylesheet type='text/css' href='"+css+"'>");		
    document.writeln("<meta http-equiv='Content-Style-Type' content='text/css'>");
    document.writeln("<script language='Javascript' src='navigasi.js'></script>");
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

    document.writeln("<table width='100%' Border='0'>\n");
    document.writeln("<tr>");
    document.writeln("<td class='judul1' align='left'>List Unit</td>");
    document.writeln("</tr>");
    document.writeln("<tr>");
    document.writeln("<td>&nbsp;</td>");
    document.writeln("</tr>");
    document.writeln("</table>");

    printNavigasiunit();
   // printNavigasigrup();
    printNavigasicari();
    printNavigasiadmin();

    document.writeln("</body>");
    document.writeln("</html>");
    document.close();
};

function printNavigasiunit() {

    document.writeln("<table width='100%' Border='0'>\n");
/*		
    document.writeln("<tr>");
    document.writeln("<td class='judul2' colspan=10><b>Unit Struktural</b></td>");
    document.writeln("</tr>");
*/		
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
                    document.writeln("<td width='8%' align='right'><a href=\"javascript:expandUnit("+i+")\">"+imgClosed+"</a></td>");
                    expand = false;
                    plevel = x[i][2];
                 } else {
                   document.writeln("<td width='8%' align='right'><a href=\"javascript:collapseUnit("+i+")\">"+imgOpen+"</a></td>");
                   expand = true;
                   plevel = x[i][2];
                 }
              } else {
                   document.writeln("<td width='8%'>&nbsp;</td>");
              }
           } else {
             document.writeln("<td width='8%'>&nbsp;</td>");
           }

           document.writeln("<td colspan="+(10-unitlevel)+">");
           document.writeln("<a href='list_proyek.php?p1=U;"+x[i][0]+"' target='isi'>"+x[i][1]+"</a><br>");
           document.writeln("</td>");
           document.writeln("</tr>");
        }
    }
    document.writeln("<tr>");
    document.writeln("<td colspan=10>&nbsp;</td>");
    document.writeln("</tr>");
    document.writeln("</table>");
};

function printNavigasigrup() {
    document.writeln("<table width='100%' Border='0'>\n");
    document.writeln("<tr>");
    document.writeln("<td class='judul2' colspan=10><b>Grup</b></td>");
    document.writeln("</tr>");
    var plevel = 0;
    var expand = true;
    var imgOpen = "<img src='../gambar/folder_open.gif' border=0>";
    var imgClosed = "<img src='../gambar/folder_closed.gif' border=0>";
    var j = 0;
    for (var i=0; i<g.length; i++) {
        if (expand || g[i][2] <= plevel) {
           document.writeln("<tr>");
           gruplevel = g[i][2];
           for (var j=0; j<gruplevel-1; j++) {
               document.writeln("<td width='8%'>&nbsp;</td>");
           }
           if (i < (g.length-1)) {
              if (g[i+1][2] > g[i][2]) {
                 if (g[i][3] == 0) {
                    document.writeln("<td width='8%' align='right'><a href=\"javascript:expandGrup("+i+")\">"+imgClosed+"</a></td>");
                    expand = false;
                    plevel = g[i][2];
                 } else {
                   document.writeln("<td width='8%' align='right'><a href=\"javascript:collapseGrup("+i+")\">"+imgOpen+"</a></td>");
                   expand = true;
                   plevel = g[i][2];
                 }
              } else {
                   document.writeln("<td width='8%'>&nbsp;</td>");
              }
           } else {
             document.writeln("<td width='8%'>&nbsp;</td>");
           }

           document.writeln("<td colspan="+(10-gruplevel)+">");
           if (g[i][2] == 1) {
               document.writeln(g[i][1]);
               j++;
           } else {
               document.writeln("<a href='list_proyek.php?p1=G;"+g[i][0]+"' target='isi'>"+g[i][1]+"</a><br>");
           }
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
    document.writeln("<form name='cariproyek'>");
    document.writeln("<table width='100%' Border='0'>");
    document.writeln("<tr>");
    document.writeln("<td class='judul1' align='left'>Pencarian Proyek</td>");
    document.writeln("</tr>");
    document.writeln("<tr>");
    document.writeln("<td class='isi1' align='center'><input type=text name=katakunci></td>");
    document.writeln("</tr>");
    document.writeln("<tr>");
    document.writeln("<td align='center'><input type=button value='Cari!' onClick=window.open('cari_proyek.php?ktkunci='+katakunci.value,'isi')></td>");
    document.writeln("</tr>");
    document.writeln("</table>");
    document.writeln("</form>");
    document.writeln("<p>");
};

function printNavigasiadmin() {
    document.writeln("<table width='100%' Border='0'>");
    document.writeln("<tr>");
    document.writeln("<td class='judul1' align='left'>Administrator</td>");
    document.writeln("</tr>");
    document.writeln("<tr>");
    document.writeln("<td><ul>");
    document.writeln("<a href='kd_jnsproyek.php' target='isi'>Kode Jenis Proyek</a><br>");
    document.writeln("<a href='kd_jnskjsama.php' target='isi'>Kode Jenis Kerjasama</a><br>");
    document.writeln("<a href='kd_jnslembaga.php' target='isi'>Kode Jenis Lembaga</a><br>");
    document.writeln("<a href='kd_jbtnproyek.php' target='isi'>Kode Jabatan Proyek</a><br>");
    document.writeln("</ul></td>");
    document.writeln("</tr>");
    document.writeln("</table>");
};


