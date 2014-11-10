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
$year = $_GET['tahun_pkp'];
$sqledit = "select * from tbl_pkp where dinilai = '$nip' AND tahun_pkp='$year'";
$hasil = mysql_query($sqledit);

if (!$hasil)
	die ("Gagal query untuk edit data karena..".mysql_error());
	
	$data = mysql_fetch_array($hasil);
	$tahun_pkp		=$data['tahun_pkp'];
        $penilai		=$data['penilai'];
	$dinilai		=$data['dinilai'];
	$atasan_penilai		=$data['atasan_penilai'];
        $orientasi_pelayanan	=$data['orientasi_pelayanan'];
	$integritas		=$data['integritas'];
	$komitmen		=$data['komitmen'];
	$disiplin		=$data['disiplin'];
	$kerjasama		=$data['kerjasama'];
        $kepemimpinan		=$data['kepemimpinan'];
	
	$tanggapan		=$data['tanggapan'];
	$keputusan	   	=$data['keputusan'];
	$rekomendasi		=$data['rekomendasi'];
	$tgl_penilaian_pkp	=$data['tgl_penilaian_pkp'];

	

	echo "<center><h1>Edit Data PKP</h1></center>";
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
			$a	= $_POST['tahun_pkp'];//datepicker
			$c	= $_POST['dinilai'];//textfield
			$o	= $_POST['keputusan'];//textarea
			$p	= $_POST['rekomendasi'];//textarea

			
                        $sql=" update tbl_pkp
				 set keputusan          	='$o',
				     rekomendasi          	='$p'
			      where dinilai='$c' AND tahun_pkp='$a'  ";             
                        $hasil=mysql_query($sql);
                        if(!$hasil)
			      die("Gagal Simpan Hasil Edit PKP Karena :".mysql_error());
                        
			header('Location: atasan_input_pkp.php?nip='.$_GET['dinilai']);exit;
	       }
    ?>
		<form action="<?php if (isset($_REQUEST['update'])) {update();} ?>" method="post" onsubmit="return update()">
<?php
echo "			<table border=1>
		     <tr><td>Tahun PKP</td> 		<td><input type='text' maxlength='4' size='4' class='reqname' name='tahun_pkp' readonly value='$tahun_pkp'/></td></tr>
		     <tr><td>Penilai</td> 		<td><input type='text' maxlength='30' size='30' class='reqname' name='penilai' disabled value='$penilai'/></td></tr>
		     <tr><td>Atasan Penilai</td> 	<td><input type='text' maxlength='30' size='30' class='reqname' name='atasan_penilai' disabled value='$atasan_penilai'/></td></tr>
		     <tr><td>Pegawai Dinilai</td> 	<td><input type='text' maxlength='30' size='30' class='reqname' name='dinilai' readonly value='$dinilai'/></td></tr>
		     
		     <tr><td>Orientasi Pelayanan*</td> 	<td><input disabled type='text' maxlength='3' size='3' class='reqname' name='orientasi_pelayanan' value='$orientasi_pelayanan'/></td></tr>
		     <tr><td>Integritas*</td> 		<td><input disabled type='text' maxlength='3' size='3' class='reqname' name='integritas' value='$integritas'/></td></tr>
		     <tr><td>Komitmen*</td> 		<td><input disabled type='text' maxlength='3' size='3' class='reqname' name='komitmen' value='$komitmen'/></td></tr>
		     <tr><td>Disiplin*</td> 		<td><input disabled type='text' maxlength='3' size='3' class='reqname' name='disiplin' value='$disiplin'/></td></tr>
		     <tr><td>Kerjasama*</td> 		<td><input disabled type='text' maxlength='3' size='3' class='reqname' name='kerjasama' value='$kerjasama'/></td></tr>
		     <tr><td>Kepemimpinan*</td> 	<td><input disabled type='text' maxlength='3' size='3' class='reqname' name='kepemimpinan' value='$kepemimpinan'/></td></tr>
		     
		     <tr><td>Tanggapan*</td> 		<td><textarea disabled rows='5' cols='50' class='reqname' name='tanggapan' value='$tanggapan'>$tanggapan</textarea></td></tr>
		     <tr><td>Keputusan*</td> 		<td><textarea rows='5' cols='50' class='reqname' name='keputusan' value='$keputusan'>$keputusan</textarea></td></tr>
		     <tr><td>Rekomendasi*</td> 		<td><textarea rows='5' cols='50' class='reqname' name='rekomendasi' value='$rekomendasi'>$rekomendasi</textarea></td></tr>
		     
		     <tr><td>Tanggal PKP*</td><td>        <input disabled type='text' name='tgl_penilaian_pkp' value='$tgl_penilaian_pkp'></td></tr>
				
    ";    
?>
				<tr>
				<td align="right" colspan=2>
				 <input action="action" type="button" value="Kembali" onclick="history.go(-1);" />
				 <input type="submit" name="update" value="Update" onclick="update()" ></td>
				</tr>
			
			</table></center>
		</form>