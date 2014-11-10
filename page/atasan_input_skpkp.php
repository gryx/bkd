<head>

<title>Penilaian Kinerja Pegawai BKD Blora</title>
<!--<link rel="stylesheet" type="text/css" href="css/panel.css" />-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="../css/panel_.css" rel="stylesheet" media="screen">
    
<link rel="stylesheet" href="../jqui/jquery-ui-1.10.3/themes/base/jquery-ui.css">
<script src="../jqui/jquery-ui-1.10.3/jquery-1.9.1.js"></script>
<script src="../jqui/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
   
   $(function() {
      
    $( "#datepicker" ).datepicker({ changeYear:true,changeMonth:true });

   });
   
$(document).ready(function(){
   $("a.del").click(function() {
       return confirm("Are you sure you want to delete this?");
   });
});
	  function printDiv()
	  {
	    var divToPrint=document.getElementById('rounded-corner');
	    newWin= window.open("");
	    newWin.document.write(divToPrint.outerHTML);
	    newWin.print();
	    newWin.close();
	  }
	  
	  var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,',
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function (s) {
            return window.btoa(unescape(encodeURIComponent(s)))
        }, format = function (s, c) {
            return s.replace(/{(\w+)}/g, function (m, p) {
                return c[p];
            })
        }
    return function (table, name) {
        if (!table.nodeType) table = document.getElementById('rounded-corner')
        var ctx = {
            worksheet: name || 'Worksheet',
            table: table.innerHTML
        }
        window.location.href = uri + base64(format(template, ctx))
    }
})()
	  
</script>
<style type="text/css">
<!--
@import url("../css/style.css");
-->
</style>
</head>
<?php
session_start();
include ('../nigol.php');

//require_once 'config/logout_auto.php';


//cek level user, jika user melakukan keluar
if(($_SESSION['level']!="admin") && ($_SESSION['level']!="atasan") && ($_SESSION['level']!="pegawai")&& ($_SESSION['level']!="penilai")){
     header("location:../index.php?error=6");

}
?>
<?php
    //echo "iki halaman panel penilai Aldy";
      echo "<br>";
?>

<body>

<div id="halaman">

	<!-- header !-->
	<div id="header">
	</div>

	<!-- content !-->
<div id="content">
    <body>
            <div id="tulis">
            <h3>Pengelolaan Data Penilaian Kinerja Pegawai</h3><br />
            
           <br/><br/>
    <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel">
   
    
    <div id="spoiler" style="display:none">
        <br><br>
    <!-- ########################################################################################################################################## -->    
    <!-- ISI SPOILER -->    
    <table border="1" >
    
<?php
        function db(){ //handles database connection

        //connect to the database server or die and spit out connection error
        $conn = mysql_connect('localhost','root', '') or die("Cannot connect to the database server now". mysql_error());
        //select database table or die and spit out database selection error
        mysql_select_db('bkd_rev',$conn) or die("Error in selecting database now ".mysql_errno());
          return $conn;  
        }
        function simpan(){
           // include "../koneksi.php";
	    $conn = db();					
            $a		    = $_POST['nip'];
	    $b		    = $_POST['nama'];
	    $c		    = $_POST['pangkat'];
	    $d	    	    = $_POST['jabatan'];
	    $e	            = $_POST['unit_kerja'];
	    $f		    = $_POST['jekel'];
	    $g		    = $_POST['tmt'];
	    $h		    = $_POST['level'];
	    
            $sql="insert into tbl_pns (nip, nama_pns, id_palru, id_jabatan, unit_kerja, jekel, tmt, level) 
                                    values ('$a','$b','$c','$d','$e','$f','$g','$h')";
            $hasil=mysql_query($sql);
            if(!$hasil){
            die("Gagal Simpan Data Pegawai karena :".mysql_error());
	    }else {
            header('Location: admin_input_pegawai.php');
	    exit;}
	  }
?>
<?php
include "../koneksi.php";
	
    if($_GET['mode'] == 'delete') {
       //Check if there is something in $_GET['id'].
       if($_GET['nip']) {
          $query = "DELETE FROM tbl_pns WHERE nip='" . mysql_real_escape_string($_GET['nip']) . "'";
          mysql_query($query);
       }
    }
	if($query)
		header("location:admin_input_pegawai.php");
?>
            <form action="<?php if (isset($_REQUEST['simpan'])) {simpan();} ?>" method="post" name="form_input" onsubmit="return simpan()">
                    <pre>
                                <tr><td>NIP*</td> <td>
				<input type="text" maxlength="18" size="20" class="reqname" name="nip" id="nip"/></td></tr>
                                <tr><td>Nama*</td> <td>     <input type="text" maxlength="30" size="30" class="reqname" name="nama"/></td></tr>
				<tr><td>Pangkat, Golru*</td> <td> <select class="reqname" name="pangkat" >
							<option value="#">=== Pilih Pangkat ===</option>
							<option value="18">-</option>
  							<option value="1">Pembina Utama, IV/e</option>
  							<option value="2">Pembina Utama Madya, IV/d</option>
  							<option value="3">Pembina Utama Muda, IV/c</option>
  							<option value="4">Pembina Tingkat I, IV/b</option>
  							<option value="5">Pembina, IV/a</option>
							
							<option value="6">Penata Tingkat I, III/d</option>
							<option value="7">Penata, III/c</option>
							<option value="8">Penata Muda Tingkat I, III/b</option>
							<option value="9">Penata Muda, III/a</option>
							
							<option value="10">Pengatur Tingkat I, II/d</option>
							<option value="11">Pengatur, II/c</option>
							<option value="12">Pengatur Muda Tingat I, II/b</option>
							<option value="13">Pengatur Muda, II/a</option>
							
							<option value="14">Juru Tingat I, I/d</option>
							<option value="15">Juru, I/c</option>
							<option value="16">Juru Muda Tingkat I, I/b</option>
							<option value="17">Juru Muda, I/a</option>
							</select></td></tr>
                                <tr><td>Jabatan*	</td> <td>
					<select class="reqname" name="jabatan" >
					  <option value="#">=== Pilih jabatan ===</option>
					  <option value="1">KEPALA BADAN KEPEGAWAIAN DAERAH</option>
					  <option value="2">KEPALA BIDANG UMUM KEPEGAWAIAN</option>
					  <option value="3">KEPALA BIDANG PENDIDIKAN DAN PELATIHAN</option>
					  <option value="4">KEPALA BIDANG MUTASI PEGAWAI</option>
					  <option value="5">KEPALA BIDANG PERENCANAAN DAN PENGEMBANGAN</option>
					  <option value="6">KEPALA SUB BIDANG PENGOLAHAN DATA DAN INFORMASI</option>
					  <option value="7">KEPALA SUB BAGIAN KEUANGAN</option>
					  <option value="8">KEPALA SUB BAGIAN PROGRAM</option>
					  <option value="9">KEPALA SUB BIDANG PELAYANAN ADMINISTRASI DAN KESEJAHTERAAN PEGAWAI</option>
					  <option value="10">KEPALA SUB BIDANG PENGANGKATAN DAN KEPANGKATAN</option>
					  <option value="11">KEPALA SUB BIDANG FORMASI DAN JABATAN</option>
					  <option value="12">KEPALA SUB BIDANG PEMBINAAN DISIPLIN DAN PERATURAN PERUNDANG-UNDANGAN</option>
					  <option value="13">KEPALA SUB BAGIAN UMUM</option>
					  <option value="14">KEPALA SUB BIDANG PEMINDAHAN PEMBERHENTIAN DAN PENSIUN</option>
					  <option value="15">KEPALA SUB BIDANG PENDIDIKAN DAN PELATIHAN STRUKTURAL</option>
					  <option value="16">KEPALA SUB BIDANG PENDIDIKAN DAN PELATIHAN TEKNIK FUNGSIONAL</option>
					  <option value="17">KELOMPOK JABATAN FUNGSIONAL</option>
					  <option value="18">STAF SUB BIDANG PENGOLAHAN DATA DAN INFORMASI</option>
					  <option value="19">STAF SUB BAGIAN KEUANGAN</option>
					  <option value="20">STAF SUB BAGIAN PROGRAM</option>
					  <option value="21">STAF SUB BIDANG PELAYANAN ADMINISTRASI DAN KESEJAHTERAAN PEGAWAI</option>
					  <option value="22">STAF SUB BIDANG PENGANGKATAN DAN KEPANGKATAN</option>
					  <option value="23">STAF SUB BIDANG FORMASI DAN JABATAN</option>
					  <option value="24">STAF SUB BIDANG PEMBINAAN DISIPLIN DAN PERATURAN PERUNDANG-UNDANGAN</option>
					  <option value="25">STAF SUB BAGIAN UMUM</option>
					  <option value="26">STAF SUB BIDANG PEMINDAHAN PEMBERHENTIAN DAN PENSIUN</option>
					  <option value="27">STAF SUB BIDANG PENDIDIKAN DAN PELATIHAN STRUKTURAL</option>
					  <option value="28">STAF SUB BIDANG PENDIDIKAN DAN PELATIHAN TEKNIK FUNGSIONAL</option>
					  <option value="29">SEKRETARIS BADAN KEPEGAWAIAN DAERAH</option>  
					</select>
				
				</td></tr>
                                
                                <tr><td>Unit Kerja</td> <td>         <input type="text" maxlength="30" size="30" class="reqname" name="unit_kerja"/>
		
				</td></tr>
				<tr><td>Jenis Kelamin* 	</td> <td> <input type="radio" class="reqname" name="jekel" value="Laki-laki"/>Laki-laki
								   <input type="radio" class="reqname" name="jekel" value="Perempuan"/>Perempuan</td></tr>
                                <tr><td>TMT*</td><td>        <input type="text" id="datepicker" name="tmt"></td></tr>
				<tr><td>Hak Akses*</td> <td> 	<input type="radio" class="reqname" name="level" value="penilai"/>Penilai
							    <input type="radio" class="reqname" name="level" value="pegawai"/>Pegawai
							    <input type="radio" class="reqname" name="level" value="atasan"/>Atasan</td></tr>
                    <tr> <th colspan="2"><input type="submit" name="simpan" value="Simpan" onclick="simpan()"/><input type="reset" value="Reset"/></th></tr>
		    <tr><td colspan="2"><i>Ket: </i>* =<i style="color: red"> wajib diisi</i></td></tr>
                    </pre>
            

    </table>
    <!-- ENDING SPOILER -->
    <!-- ########################################################################################################################################## -->
    </div> 
<br><br>

<!-- MENAMPILKAN TABLE -->
    <!-- ########################################################################################################################################## -->

<?php
	include "../koneksi.php";
	
/*
	$hasil2  = mysql_query("select * from tbl_jabatan where id_jabatan=".$_SESSION['jab']."");
	
	  if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());
		
	  if($row = mysql_fetch_array($hasil2))
	    $hasil  = mysql_query("select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
			       from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
			       where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan AND b.kode2='".$row[kode2]."' AND a.level='pegawai' ORDER BY a.level");
	  if (!$hasil)
		die("Gagal Query data karena : ".mysql_error());
*/
	$hasil  = mysql_query("select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
			       from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
			       where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan AND a.level='pegawai' ORDER BY b.nama_jabatan");
	if (!$hasil)
		die("Gagal Query data karena : ".mysql_error());


	echo '<input type=button value="Refresh" onClick="window.location.reload()" />';
	
	echo "<center><table id='rounded-corner' summary='2007 Major IT Companies Profit' border=1>
  <tr align='center'>
    <th>NIP</th>
    <th>NAMA</th>
    <th>PANGKAT, GOLRU</th>
    <th>JABATAN</th>
    <th>UNIT KERJA</th>
    <th>JENIS KELAMIN</th>
    <th>TMT</th>
    <th>HAK AKSES</th>
    <th colspan='2'>ACTION</th>
  </tr>";


        //while(mysql_fetch_assoc($hasil))
	//while(mysql_num_rows($hasil)==$hitung)
	while($row = mysql_fetch_array($hasil))
	{
           
		echo "<tr>";
		echo "<td>" .$row['nip']. "</td>";
		echo "<td>" .$row['nama_pns']. "</td>";
		echo "<td>" .$row['nama_palru']. "</td>";
		echo "<td>" .$row['nama_jabatan']. "</td>";
		echo "<td>" .$row['unit_kerja']. "</td>";
                echo "<td>" .$row['jekel']. "</td>";
                echo "<td>" .$row['tmt']. "</td>";
		echo "<td>" .$row['level']. "</td>";
		echo "<td> <a href=atasan_input_skp.php?nip=$row[nip] target='_blank'>SKP</a></td>";
	        echo "<td> <a href=atasan_input_pkp.php?nip=$row[nip] target='_blank'>PKP</a></td>";
		echo "</tr>";
            
	}
	mysql_free_result($result);
	echo "</table>";
?>
  
        </div>
    </body>

    </div>


    <!-- sidebar kiri !-->
    <div id="sidebar_kiri">
	 <div id="sidebar_title">
			<div id="sidebar_name">
				KELOLA KEPEGAWAIAN
			</div>
			<div id="sidebar_isi">
				<ul>
					<li><h3>Sebagai <?php echo $_SESSION['level']; ?></h3></li>
					<li><a href="../panel_atasan.php">Home</a></li>
					<li style='color: red'>SKP dan PKP</li>
					<!--<li><a href='#'>Data Jabatan </a></li>
					<li><a href='#'>Set Pass </a></li>
					<li><a href='#'>Report</a></li>	-->
				</ul>
			</div>
    	</div>

    	<div id="sidebar_title">
			<div id="sidebar_name">
			 Logout
			</div>
			<div id="sidebar_isi">
				<ul>
					<li><a href="../nigol.php?op=out">Keluar</a></li>
				</ul>
			</div>
    	</div>

    </div> <!-- footer !-->
    <div id="footer"> BKD. KABUPATEN BLORA &copy; th 2013 </div>
</div>
</body>

        
        
