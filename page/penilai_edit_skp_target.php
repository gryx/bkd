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

$nip = $_GET['dinilai'];
$time = $_GET['time'];
$sqledit = "select * from tbl_form_skp where dinilai = '$nip' AND time='$time'";
$hasil = mysql_query($sqledit);

if (!$hasil)
	die ("Gagal query untuk edit data karena..".mysql_error());
	
	$data = mysql_fetch_array($hasil);
	$tahun_skp		=$data['tahun_skp'];
        $penilai		=$data['penilai'];
	$dinilai		=$data['dinilai'];
	$tugas			=$data['tugas'];
        $kredit			=$data['kredit'];
	$kredit_real		=$data['kredit_real'];
	$kuantitas		=$data['kuantitas'];
	$kuantitas_real		=$data['kuantitas_real'];
        $kualitas		=$data['kualitas'];
	$kualitas_real		=$data['kualitas_real'];
	$waktu			=$data['waktu'];
	$waktu_real		=$data['waktu_real'];
	$biaya			=$data['biaya'];
	$biaya_real		=$data['biaya_real'];
	$penghitungan		=$data['penghitungan'];
	$nilai_capaian_skp	=$data['nilai_capaian_skp'];
	$nilai_skp		=$data['nilai_skp'];
	$tgl_form		=$data['tgl_form'];
	$tgl_penilaian_skp	=$data['tgl_penilaian_skp'];
	$time			=$data['time'];
	

	echo "<center><h1>Edit Data SKP</h1></center>";
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
                        $a	= $_POST['tahun_skp'];
                        $b	= $_POST['dinilai'];
			$c	= $_POST['tugas'];
                        $d	= $_POST['kredit'];
			$f	= $_POST['kuantitas'];
			$h	= $_POST['kualitas'];
                        $j	= $_POST['waktu'];
			$l	= $_POST['biaya'];
			$x	= $_POST['penilai'];
			$y	= $_POST['time'];
			
                        $sql=" update tbl_form_skp
				 set tahun_skp 	    ='$a',
				     tugas 	    ='$c',
				     kredit 	    ='$d',
				     kuantitas 	    ='$f',
				     kualitas       ='$h',
				     waktu          ='$j',
				     biaya          ='$l'
			      where dinilai='$b' AND time='$y'  ";             
                        $hasil=mysql_query($sql);
                        if(!$hasil)
			      die("Gagal Simpan Hasil Edit SKP Karena :".mysql_error());
                        
			header('Location: penilai_input_skp.php?nip='.$_GET['dinilai']);exit;
	       }
    ?>
		<form action="<?php if (isset($_REQUEST['update'])) {update();} ?>" method="post" onsubmit="return update()">
<?php
echo "			<table border=1>
				<tr>
				<!-- use readonly for input value to save editing, it doesn't work with disabled -->
					<td>Penilai</td><td><input class='reqname' type='text' size=20 name='penilai' value='$penilai' readonly></td>
				</tr>
				
				<tr><td>Pegawai Dinilai</td><td><input class='reqname' type='text' size=35 name='dinilai' value='$dinilai' readonly></td></tr>
				<tr><td>Time</td><td><input class='reqname' type='text' size=35 name='time' value='$time' readonly></td></tr>
			        <tr><td>Tahun*</td><td><select class='reqname' name='tahun_skp' value='$tahun_skp' >
							<option value='#'>=== Pilih Tahun ===</option>
							<option value='2014'>2014</option>
						        <option value='2015'>2015</option>
							<option value='2016'>2016</option>
							<option value='2017'>2017</option>
							<option value='2018'>2018</option>
							<option value='2019'>2019</option>
							<option value='2020'>2020</option>
						        <option value='2021'>2022</option>
							<option value='2023'>2023</option>
							<option value='2024'>2024</option>
							<option value='2025'>2025</option>
							<option value='2026'>2026</option>
						      </select></td></tr>
		     <tr><td>Tugas*</td> 		<td><textarea rows='5' cols='50' class='reqname' name='tugas' value='$tugas'>$tugas</textarea></td></tr>
		     <tr><td>Kredit*</td> 		<td><input type='text' maxlength='3' size='3' class='reqname' name='kredit' value='$kredit'/></td></tr>
		     <tr><td>Kuantitas*</td> 		<td><input type='text' maxlength='4' size='4' class='reqname' name='kuantitas' value='$kuantitas'/></td></tr>
		     <tr><td>Kualitas*</td> 		<td><input type='text' maxlength='3' size='3' class='reqname' name='kualitas' value='$kualitas'/></td></tr>
		     <tr><td>Waktu*</td> 		<td><select class='reqname' name='waktu' value='$waktu' >
							<option value='#'>=== Pilih Waktu ===</option>
							<option value='1'>1</option>
						        <option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
							<option value='6'>6</option>
							<option value='7'>7</option>
						        <option value='8'>8</option>
							<option value='9'>9</option>
							<option value='10'>10</option>
							<option value='11'>11</option>
							<option value='12'>12</option>
							</select></td></tr>
		     <tr><td>Biaya*</td> 		<td><input type='text' maxlength='6' size='6' class='reqname' name='biaya' value='$biaya'/></td></tr>
				
    ";    
?>
				<tr>
				<td align="right" colspan=2>
				 <input action="action" type="button" value="Kembali" onclick="history.go(-1);" />
				 <input type="submit" name="update" value="Update" onclick="update()" ></td>
				</tr>
			
			</table></center>
		</form>