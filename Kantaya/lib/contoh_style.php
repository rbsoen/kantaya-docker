<?php
$css = "kantaya.css";

echo "<html>\n";
echo "<head>\n";
echo "<title>Contoh Style kantaya.css</title>\n";
echo "<link rel=stylesheet type='text/css' href='$css'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "</head>\n";
echo "<body>\n";

echo "<h1><font color=red>Contoh style di file ../lib/kantaya.css :</font></h1>\n";

echo "<table>\n";

echo " <tr>\n";
echo "  <td class='judul1'>\n";
echo "    td class = judul1 -> utk. Judul Utama Tabel atau Judul Topik di Navigasi\n";
echo "  </td>\n";
echo " </tr>\n";

echo " <tr>\n";
echo "  <td class='judul2'>\n";
echo "    td class = judul2 -> utk. Judul Kolom Tabel atau Sub Topik di Navigasi\n";
echo "  </td>\n";
echo " </tr>\n";

echo " <tr>\n";
echo "  <td class='isi1'>\n";
echo "    td class = isi1 -> utk. isi di tabel\n";
echo "  </td>\n";
echo " </tr>\n";

echo " <tr>\n";
echo "  <td class='isi2'>\n";
echo "    td class = isi2 -> utk. isi di tabel dgn. background putih\n";
echo "  </td>\n";
echo " </tr>\n";

echo "</table>\n";

echo " isi biasa di body (diluar table)\n";

echo "<br><br><font color=red>Untuk selebihnya, jika diperlukan, bisa menambah sendiri class-class yg lainnya di file ../lib/kantaya.css, tetapi jangan mengubah class-class standar di atas.</font>\n";

echo "</body>\n";
echo "</html>\n";
?>
