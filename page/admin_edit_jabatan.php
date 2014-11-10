<head>
<link href="../css/panel_.css" rel="stylesheet" media="screen">
    
<link rel="stylesheet" href="../jqui/jquery-ui-1.10.3/themes/base/jquery-ui.css">
<script src="../jqui/jquery-ui-1.10.3/jquery-1.9.1.js"></script>
<script src="../jqui/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
   
<script>

$(function() {
$( "#datepicker" ).datepicker();
});

function validateForm(){
var elements =document.getElementsByClassName("reqname");
for(var i = 0, l = elements.length; i < l; i++) {
   var x = elements[i].value;
   if(x == null || x == '') {
      alert("Mohon lengkapi data masukkan");
      return false;
      }
   }
}


</script>
</head>
<?php
include "../koneksi.php";

$nip = $_GET['id_jabatan'];
$sqledit = "select * from tbl_jabatan where id_jabatan = '$nip'";
$hasil = mysql_query($sqledit);

if (!$hasil)
	die ("Gagal query untuk edit data karena..".mysql_error());
	
	$data = mysql_fetch_array($hasil);
	$nip=$data['id_jabatan'];
        $nama_pns=$data['nama_jabatan'];
	echo "<center><h1>Edit Data Jabatan</h1></center>";
	echo "
		<center>";
?>
                
    <?php

	    function db(){ 
	    $conn = mysql_connect('localhost','root', '') or die("Cannot connect to the database server now". mysql_error());
	    mysql_select_db('bkd_rev',$conn) or die("Error in selecting database now ".mysql_errno());
	    return $conn;  
	    }
                function update(){
                        
                        $conn = db();
                        $a	= $_POST['id_jabatan'];
                        $b	= $_POST['nama_jabatan'];
  
                        $sql=" update tbl_jabatan set nama_jabatan ='$b' where id_jabatan='$a' ";             
                        $hasil=mysql_query($sql);
                        if(!$hasil)
			      die("Gagal Simpan Hasil Edit Jabatan Karena :".mysql_error());
                        
			header('Location: admin_input_jabatan.php');exit;     
	       }
    ?>
		<form action="<?php if (isset($_REQUEST['update'])) {update();} ?>" method="post" onsubmit="return update()">
<?
echo "			<table border=1>
				<tr>
				<!-- use readonly for input value to save editing, it doesn't work with disabled -->
					<td>ID Jabatan</td><td><input class='reqname' type='text' size=20 name='id_jabatan' value='$nip' readonly></td>
				</tr>
				<tr>
					<td>Nama Jabatan</td><td><input class='reqname' type='text' size=35 name='nama_jabatan' value='$nama_pns' ></td>
				</tr>
				
    ";    
?>
				<tr>
				<td align="right" colspan=2>
				 <input action="action" type="button" value="Kembali" onclick="history.go(-1);" />
				 <input type="submit" name="update" value="Update" onclick="update()" ></td>
				</tr>
			
			</table></center>
		</form>