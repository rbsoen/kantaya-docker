FILE : INSTALL.TXT

Software Kantaya bekerja di system operasi berplatform LINUX, telah di tes dengan menggunakan LINUX MANDRAKE 7.2

Sebelum menginstal software kantaya terlebih dahulu harus tersedia :
1.	Web Server 		: Seperti halnya Apache web server.
2.	PHP Modul 		: Modul PHP 
3.	Database Server 	: MYSQL

Ketiga modul diatas dapat kita dapatkan secara gratis melalui Internet :
1.	Apache Web server di alamat  http://www.apache.org
2.	PHP Modul dialamat http://www.PHP.net
3.	MYSQL  dialamat dialamat http://www.mysql.com

Apabila kesulitan mendapatkan aplikasi diatas , CD Kantaya menyediakan 
1.	Apache version di direktori WebServer
2.	PHP Version di direktori PHP
3.	MYSQL version di direktori Database     

Setelah semua aplikasi diatas telah terinstal didalam sistem Anda mulai kita dapat menempatkan aplikasi Kantaya kedalam system kita

1.	Ekstrak file modul_kantaya.zip atau modul_kantaya.tar.gz kedalam direktori yang Anda inginkan di bawah root homepage / web server.

2.	Jalankan file setup.php di direktori SETUP melalui browser, isi konfigurasi yang sesuai dengan identitas web, database server yang Anda miliki. Dalam setup  file ini Anda dapat membuat Database dan informasi user baik nama maupun password dari MYSQL yang Anda miliki.

3.	Seting konfigurasi surat Web dengan membuka file konfig_surat.php pada direktori surat_web. Buat direktori baru di /tmp (linux) untuk lokasi penyimpanan email.  Rubah permission dari direktori sehingga bisa untuk menulis atau menyimpan  file ( chmod 777  direktori_baru).

4.	Untuk merubah logo perusahaan atau instansi, simpan logo yang Anda miliki kedalam direktori gambar. Besar Gambar  Max (Lebar:150px  - Tinggi : 70 px). Buka file config_kepala.php di direktori lib, rubah isi variabel didalamnya sesuai dengan informasi dari perusahaan atau Instansi Anda ( Nama Perusahaan, Alamat, Nomor telepon, Nomor Fax, Alamat Email dan Alamat URL).

Demikian Anda sekarang bisa mencoba  mengakses aplikasi Kantaya di Sistem Anda…
Selamat Bekerja !!!!!

