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

$nip = $_GET['nip'];
$sqledit = "select * from tbl_pns where nip = '$nip'";
$hasil = mysql_query($sqledit);

if (!$hasil)
	die ("Gagal query untuk edit data karena..".mysql_error());
	
	$data = mysql_fetch_array($hasil);
	
	$nip=$data['nip'];
        $nama_pns=$data['nama_pns'];
        $pangkat=$data['id_palru'];
        $jab=$data['id_jabatan'];
        $unit=$data['unit_kerja'];
        $jk=$data['jekel'];
        $tmt=$data['tmt'];
        $lvl=$data['level'];
        
	echo "<center><h1>Edit Data Pegawai</h1></center>";
	
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
                        $a	= $_POST['nip'];
                        $b	= $_POST['nama_pns'];
                        $c	= $_POST['pangkat'];
                        $d	= $_POST['jabatan'];
                        $e	= $_POST['unit_kerja'];
                        $f	= $_POST['jekel'];
                        $g	= $_POST['tmt'];
                        $h	= $_POST['level'];
                            $sql=" update tbl_pns set   nama_pns ='$b',
                                                        id_palru = '$c',
                                                        id_jabatan='$d',
                                                        unit_kerja = '$e',
                                                        jekel ='$f',
                                                        tmt = '$g',
                                                        level	='$h',
							pwd = md5(md5('$h'))
                                    where nip='$a' ";             
                        $hasil=mysql_query($sql);
                        if(!$hasil)
                        die("Gagal Simpan Hasil Edit Pegawai Karena :".mysql_error());
			
                        header('Location: admin_input_pegawai.php');exit;
	       }
    ?>
		<form action="<?php if (isset($_REQUEST['update'])) {update();} ?>" method="post" onsubmit="return update()">
<?
echo "			<table border=1>
				<tr>
				<!-- use readonly for input value to save editing, it doesn't work with disabled -->
					<td>NIP</td><td><input class='reqname' type='text' size=20 name='nip' value='$nip' readonly ></td>
				</tr>
				<tr>
					<td>Nama</td><td><input class='reqname' type='text' size=35 name='nama_pns' value='$nama_pns' ></td>
				</tr>
				<tr><td>Jenis Kelamin 	:</td> <td>
                                        <input type='radio' class='reqname' name='jekel' value='Laki-laki'/>Laki-laki
                                        <input type='radio' class='reqname' name='jekel' value='Perempuan'/>Perempuan</td></tr>								<tr>
	
				</tr>
                                <tr><td>Pangkat, Golru</td> <td>
                                            <select selected='$pangkat' class='reqname' name='pangkat' >
							<option value='#'>=== Pilih Pangkat ===</option>
							<option value='18'>-</option>
  							<option value='1'>Pembina Utama, IV/e</option>
  							<option value='2'>Pembina Utama Madya, IV/d</option>
  							<option value='3'>Pembina Utama Muda, IV/c</option>
  							<option value='4'>Pembina Tingkat I, IV/b</option>
  							<option value='5'>Pembina, IV/a</option>
							
							<option value='6'>Penata Tingkat I, III/d</option>
							<option value='7'>Penata, III/c</option>
							<option value='8'>Penata Muda Tingkat I, III/b</option>
							<option value='9'>Penata Muda, III/a</option>
							
							<option value='10'>Pengatur Tingkat I, II/d</option>
							<option value='11'>Pengatur, II/c</option>
							<option value='12'>Pengatur Muda Tingat I, II/b</option>
							<option value='13'>Pengatur Muda, II/a</option>
							
							<option value='14'>Juru Tingat I, I/d</option>
							<option value='15'>Juru, I/c</option>
							<option value='16'>Juru Muda Tingkat I, I/b</option>
							<option value='17'>Juru Muda, I/a</option>
					    </select>
                                </td></tr>
                                
                                <tr><td>Jabatan	</td> <td>
					<select class='reqname' name='jabatan' >
					  <option value='#'>=== Pilih jabatan ===</option>
					  <option value='1'>KEPALA BADAN KEPEGAWAIAN DAERAH</option>
					  <option value='2'>KEPALA BIDANG UMUM KEPEGAWAIAN</option>
					  <option value='3'>KEPALA BIDANG PENDIDIKAN DAN PELATIHAN</option>
					  <option value='4'>KEPALA BIDANG MUTASI PEGAWAI</option>
					  <option value='5'>KEPALA BIDANG PERENCANAAN DAN PENGEMBANGAN</option>
					  <option value='6'>KEPALA SUB BIDANG PENGOLAHAN DATA DAN INFORMASI</option>
					  <option value='7'>KEPALA SUB BAGIAN KEUANGAN</option>
					  <option value='8'>KEPALA SUB BAGIAN PROGRAM</option>
					  <option value='9'>KEPALA SUB BIDANG PELAYANAN ADMINISTRASI DAN KESEJAHTERAAN PEGAWAI</option>
					  <option value='10'>KEPALA SUB BIDANG PENGANGKATAN DAN KEPANGKATAN</option>
					  <option value='11'>KEPALA SUB BIDANG FORMASI DAN JABATAN</option>
					  <option value='12'>KEPALA SUB BIDANG PEMBINAAN DISIPLIN DAN PERATURAN PERUNDANG-UNDANGAN</option>
					  <option value='13'>KEPALA SUB BAGIAN UMUM</option>
					  <option value='14'>KEPALA SUB BIDANG PEMINDAHAN PEMBERHENTIAN DAN PENSIUN</option>
					  <option value='15'>KEPALA SUB BIDANG PENDIDIKAN DAN PELATIHAN STRUKTURAL</option>
					  <option value='16'>KEPALA SUB BIDANG PENDIDIKAN DAN PELATIHAN TEKNIS STRUKTURAL</option>
					  <option value='17'>KELOMPOK JABATAN FUNGSIONAL</option>
					  <option value='18'>STAF SUB BIDANG PENGOLAHAN DATA DAN INFORMASI</option>
					  <option value='19'>STAF SUB BAGIAN KEUANGAN</option>
					  <option value='20'>STAF SUB BAGIAN PROGRAM</option>
					  <option value='21'>STAF SUB BIDANG PELAYANAN ADMINISTRASI DAN KESEJAHTERAAN PEGAWAI</option>
					  <option value='22'>STAF SUB BIDANG PENGANGKATAN DAN KEPANGKATAN</option>
					  <option value='23'>STAF SUB BIDANG FORMASI DAN JABATAN</option>
					  <option value='24'>STAF SUB BIDANG PEMBINAAN DISIPLIN DAN PERATURAN PERUNDANG-UNDANGAN</option>
					  <option value='25'>STAF SUB BAGIAN UMUM</option>
					  <option value='26'>STAF SUB BIDANG PEMINDAHAN PEMBERHENTIAN DAN PENSIUN</option>
					  <option value='27'>STAF SUB BIDANG PENDIDIKAN DAN PELATIHAN STRUKTURAL</option>
					  <option value='28'>STAF SUB BIDANG PENDIDIKAN DAN PELATIHAN TEKNIS STRUKTURAL</option>  	  
					</select>
				</td></tr>
                                <tr><td>Unit Kerja</td> <td>         <input type='text' maxlength='30' size='30' class='reqname' name='unit_kerja' value='$unit'/></td></tr>
				
                                <tr><td>TMT</td><td>            <input type='text' id='datepicker' name='tmt' value='$tmt'></td></tr>
				<tr><td>Hak Akses</td> <td> 	<input type='radio' class='reqname' name='level' value='penilai'/>Penilai
							    <input type='radio' class='reqname' name='level' value='pegawai'/>Pegawai
							    <input type='radio' class='reqname' name='level' value='atasan'/>Atasan</td></tr>

                                
    ";    
?>
				<tr>
				<td align="right" colspan=2>
				 <input action="action" type="button" value="Kembali" onclick="history.go(-1);" />
				 <input type="submit" name="update" value="Update" onclick="update()" ></td>
				</tr>
			
			</table></center>
		</form>