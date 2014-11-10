<?php

error_reporting(0);
session_start();


include "koneksi.php";

$username 	= $_POST['username'];
$password 	= $_POST['password'];


 
$op = $_GET['op'];


if($op=="in"){
	
	if (empty($username) && empty($password)) {
		header('location:index.php?error=1');
		break;
	} else if (empty($username)) {
		header('location:index.php?error=2');
		break;
	} else if (empty($password)) {
		header('location:index.php?error=3');
		break;
	}
	else {
	//$pewede = md5(kepegawaian($password));
    	$cek = mysql_query("SELECT * FROM tbl_pns WHERE nip='$username' AND pwd=md5(md5('$password'))");
	//$cek = mysql_query("SELECT * FROM tbl_pns WHERE nip='$_POST[username]' AND pwd='$_POST[password]'");
    		if(mysql_num_rows($cek)==1){
        		$c = mysql_fetch_array($cek);
        		$_SESSION['userid'] = $c['nip'];
        		$_SESSION['level'] = $c['level'];
			$_SESSION['name'] = $c['nama_pns'];
			$_SESSION['jab'] = $c['id_jabatan'];
			$_SESSION['pal'] = $c['id_palru'];
			        
        		if($c['level']=="admin"){
                            header("location:panel_admin.php");
        		}
                        else if($c['level']=="atasan"){
                            header("location:panel_atasan.php");
        		}
        		else if($c['level']=="pegawai") {
        		    header("location:panel_pegawai.php");	
        		}
			else if($c['level']=="penilai") {
        		    header("location:panel_penilai.php");	
        		}
    		}
    		else{
    			if(!$c['nip'] && !$c['level']){
    					header('location:index.php?error=4');
    				break;
    				}
    			else{
    	  			header('location:index.php?error=5');
					break;
				}
    		}
 	}

}else if($op=="out"){
    unset($_SESSION['userid']);
    unset($_SESSION['level']);
    mysql_close();
    header("location:index.php");
    session_destroy();
    exit();
    
}
?>
