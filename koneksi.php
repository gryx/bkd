<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "bkd_rev";
	
	$kon = mysql_connect($host, $user, $pass);

        
	if(!$kon)
				die ("Gagal koneksi karena ".mysql_error());
				
	$dbKon = mysql_select_db($dbname, $kon);
	
	if(!$dbKon) 
				die ("Gagal membuka database $dbname karena".mysql_error());

?>