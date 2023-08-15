<?php
mysql_connect ("localhost", "root");
mysql_select_db ("kantaya");
$kode_direktori='87';

$sql=mysql_query("SELECT kode_direktori, nama_direktori, direktori_induk FROM direktori WHERE kode_direktori='$kode_direktori'");
if ($data=mysql_fetch_row($sql)) {
  $induk=$data[2];
  print $data[1]. "/";
	
	
  $eksekusi=true;
  while ($eksekusi) {
	  $sql_induk=mysql_query("SELECT kode_direktori, nama_direktori, direktori_induk FROM direktori WHERE kode_direktori='$induk'");
	  if ($data_induk=mysql_fetch_row($sql_induk)){ 
		  $induk=$data_induk[2]; 
			if ($data_induk[2]=='0') {
			  $eksekusi=false;
				}			  	  
	    print $data_induk[1]. " /";
		  }
    }
		
  
	}
	
?>
