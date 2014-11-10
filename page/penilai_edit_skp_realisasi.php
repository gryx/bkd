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
                        $d	= $_POST['kredit_real'];//in
			$f	= $_POST['kuantitas_real'];//in
			$h	= $_POST['kualitas_real'];//in
                        $j	= $_POST['waktu_real'];//in
			$l	= $_POST['biaya_real'];//in
			$x	= $_POST['penilai'];
			$y	= $_POST['time'];
			
			//jupuk dab
			$nip = $_GET['dinilai'];
			$time = $_GET['time'];
			$sqledit = "select * from tbl_form_skp where dinilai = '$nip' AND time='$time'";
			$hasil = mysql_query($sqledit);
			
			if (!$hasil)
				die ("Gagal query untuk edit data karena..".mysql_error());
				
				$data = mysql_fetch_array($hasil);	
				$kredit			=$data['kredit'];	
				$kuantitas		=$data['kuantitas'];	
				$kualitas		=$data['kualitas'];	
				$waktu			=$data['waktu'];		
				$biaya			=$data['biaya'];
			
			//hitung nilai capaian skp
			$kual_real = @($h/$kualitas)*100;
			$kuan_real = @($f/$kuantitas)*100;
			
			if ($j > 0){
			   $wak_real  = @((1.76*$waktu-$j)/$waktu)*100;
			   }
			elseif ($j > 12){
			   $wak_real  = 76 - @(((1.76*$waktu-$j)/$waktu)*100)-100;
			   }
			else {
			   $wak_real  = @((1.76*$waktu-$j)/$waktu)*0*100;
			   }
			   
			if ($l > 0 && $l < $biaya){
			   $bia_real  = @((1.76*$biaya-$l)/$biaya)*100;
			}
			elseif ($l > $biaya){
			   $bia_real  = 76 - @(((1.76*$biaya-$l)/$biaya)*100)-100;
			}
			else {
			   $bia_real  = @((1.76*$biaya-$l)/$biaya)*0*100;
			}
			
			
			$count 	      = @($kual_real!=''?1:0) + @($kuan_real!=''?1:0) + @($wak_real!=''?1:0) + @($bia_real!=''?1:0);
			$penghitungan = ($kual_real+$kuan_real+$wak_real+$bia_real);
			$ncs          = ($kual_real+$kuan_real+$wak_real+$bia_real)/$count;
			
                        $sql=" update tbl_form_skp
				 set kredit_real 	 ='$d',
				     kuantitas_real 	 ='$f',
				     kualitas_real       ='$h',
				     waktu_real          ='$j',
				     biaya_real          ='$l',
				     penghitungan        ='$penghitungan',
				     nilai_capaian_skp   ='$ncs'
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
					<td>Penilai</td><td><input class='reqname' type='text' size=20 name='penilai' value='$penilai' disabled></td>
				</tr>
				
				<tr><td>Pegawai Dinilai</td><td><input class='reqname' type='text' size=35 name='dinilai' value='$dinilai' readonly></td></tr>
				<tr><td>Time</td><td><input class='reqname' type='text' size=35 name='time' value='$time' readonly></td></tr>
			        <tr><td>Tahun</td><td><input class='reqname' type='text' size=35 name='tahun_skp' value='$tahun_skp' disabled></td></tr>
		     <tr><td>Tugas</td> 		<td><input class='reqname' type='text' size=35 name='tugas' value='$tugas' disabled></td></tr>
		     <tr><td>Kredit [target]</td> 	<td><input type='text' maxlength='3' size='3' class='reqname' name='kredit' value='$kredit' disabled/></td></tr>
		     <tr><td>Kredit*</td> 		<td><input type='text' maxlength='3' size='3' class='reqname' name='kredit_real' value='$kredit_real'/></td></tr>
		     <tr><td>Kuantitas [target]</td> 	<td><input type='text' maxlength='3' size='3' class='reqname' name='kuantitas' value='$kuantitas' disabled/></td></tr>
		     <tr><td>Kuantitas*</td> 		<td><input type='text' maxlength='4' size='4' class='reqname' name='kuantitas_real' value='$kuantitas_real'/></td></tr>
		     <tr><td>Kualitas [target]</td> 	<td><input type='text' maxlength='3' size='3' class='reqname' name='kualitas' value='$kualitas' disabled/></td></tr>
		     <tr><td>Kualitas*</td> 		<td><input type='text' maxlength='3' size='3' class='reqname' name='kualitas_real' value='$kualitas_real'/></td></tr>
		     <tr><td>Waktu [target]</td> 	<td><input type='text' maxlength='3' size='3' class='reqname' name='waktu' value='$waktu' disabled/></td></tr>
		     <tr><td>Waktu*</td> 		<td><input type='text' maxlength='6' size='6' class='reqname' name='waktu_real' value='$waktu_real'/></td></tr>
		     <tr><td>Biaya [target]</td> 	<td><input type='text' maxlength='6' size='6' class='reqname' name='biaya' value='$biaya' disabled/></td></tr>
		     <tr><td>Biaya*</td> 		<td><input type='text' maxlength='6' size='6' class='reqname' name='biaya_real' value='$biaya_real'/></td></tr>
				
    ";    
?>
				<tr>
				<td align="right" colspan=2>
				 <input action="action" type="button" value="Kembali" onclick="history.go(-1);" />
				 <input type="submit" name="update" value="Update" onclick="update()" ></td>
				</tr>
			
			</table></center>
		</form>