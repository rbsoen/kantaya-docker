<?php
//Coded by Sainttex (www.STX.cc) | (odsource.com)
$filepointer = fopen("forum.php", "w+");

fputs($filepointer, "$var_awal \n var $var_naper '$naper';\n var $var_alamat '$alamat'; \n var $var_telepon '$telepon'; \n var $var_fax '$fax'; \n var $var_email '$email'; \n var $var_url '$url'; \n var $var_akhir");
fclose($filepointer);
?>
