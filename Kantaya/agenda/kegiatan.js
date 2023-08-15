<SCRIPT language=javascript>
<!--
function validasi(form) {
  var field = form.judul;  
  var jdl = field.value; 
	var jamml = form.pjammulai.value;
	var mntml = form.pmntmulai.value;
	var jamsl = form.pjamakhir.value;
	var mntsl = form.pmntakhir.value;
  var ok = 0;
	if (jdl == "") {
		 alert("Judul tidak boleh kosong!");
		 field.focus();
		 field.select();
		 ok++;
  }
	if ((jamsl < jamml) || (jamsl == jamml && mntsl <= mntml )) {  
      alert("Waktu mulai harus lebih dulu daripada waktu selesai!");
      ok++;
  }
	if (ok > 0) {return false;} else {return true;}
}

function buka(x) {
   switch (x) {
	 				case 0 : document.isikgtn.action = 'isi_agenda.php'; break;
	 				case 1 : document.isikgtn.action = 'isi_pengulangan_kegiatan.php'; break;
					case 2 : document.isikgtn.action = 'isi_fasilitas_kegiatan.php'; break;
					case 3 : document.isikgtn.action = 'isi_publikasi_kegiatan.php'; break;
					case 4 : document.isikgtn.action = 'isi_undangan_kegiatan.php'; break;
	 }
	 document.isikgtn.submit();
}

//-->
</SCRIPT>
