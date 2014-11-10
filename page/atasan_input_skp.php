<head>

<title>SKP</title>
<!--<link rel="stylesheet" type="text/css" href="css/panel.css" />-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="../css/panel_.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="../css/source/style.css">
<link rel="stylesheet" href="../jqui/jquery-ui-1.10.3/themes/base/jquery-ui.css">
<script src="../jqui/jquery-ui-1.10.3/jquery-1.9.1.js"></script>
<script src="../jqui/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
   
   $(function() {
      
    $( "#datepicker" ).datepicker({ changeYear:true,changeMonth:false,changeDate:false });

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

//cek level user, jika user melakukan login
if(($_SESSION['level']!="admin") && ($_SESSION['level']!="atasan") && ($_SESSION['level']!="pegawai")&& ($_SESSION['level']!="penilai")){
     header("location:../index.php?error=6");

}
?>
<?php
    //echo "iki halaman panel penilai Aldy";
      echo "<br>";
?>

<body>

<div id="halamanskp">

	<!-- header !-->
	<div id="headerskp">
	</div>

	<!-- content !-->
<div id="content">
    <body id="bodyskp">
            <div id="tulis">
            <h3>Pengelolaan Data Penilaian Kinerja Pegawai</h3><br />
  	Akses   : <?php echo $_SESSION['level']; ?><br>
        NIP     : <?php echo $_SESSION['userid']; ?><br>
        Nama    : <?php echo $_SESSION['name']; ?><br/>          
	<?php
	  include "koneksi.php";
	  $nip = $_GET['nip'];
	  //$hasil  = mysql_query("select * from tbl_jabatan where id_jabatan=".$_SESSION['jab']."");
	  $hasil  = mysql_query("select a.kode2, a.nama_jabatan, b.nama_palru from tbl_jabatan a, tbl_pangkat_golru b
				where a.id_jabatan=".$_SESSION['jab']." AND b.id_palru=".$_SESSION['pal']."");
	  if (!$hasil)
		die("Gagal Query data karena : ".mysql_error());
		
	  if($row = mysql_fetch_array($hasil)){
	    echo "Jabatan : ".$row['nama_jabatan'];
	    echo "<br>";
	    echo "Pangkat, golru : ".$row['nama_palru'];
	    echo "<br>";echo "<br>";
	    //echo "Kode Atasan : ".$row['kode2'];
	    
	  }
	  $get_kasum = mysql_query("select * from tbl_pns, tbl_jabatan, tbl_pangkat_golru
				   where tbl_pns.id_jabatan = tbl_jabatan.id_jabatan AND
					  tbl_pns.id_palru = tbl_pangkat_golru.id_palru AND
					  tbl_pns.nip ='$nip'");
	       if (!$get_kasum)
		die("Gagal Query get kasum  karena : ".mysql_error());
		
	  /*if ($row_getkasum = mysql_fetch_array($get_kasum)){
	       echo "kasumnya : ".$row_getkasum['kode'];
	       }*/
	  if ($row_getkasum = mysql_fetch_array($get_kasum))
	  $hasil_lagi  = mysql_query("select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
			       from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
			       where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan AND b.kode='$row_getkasum[kode]' AND a.level='penilai' ORDER BY a.level");
	  if($rowz = mysql_fetch_array($hasil_lagi)){
	    echo "<b>Pejabat Penilai :</b><br>";
	    echo "NIP : ".$rowz['nip'];
	    echo "<br>";
	    echo "Nama : ".$rowz['nama_pns'];
	    echo "<br>";
	    echo "Jabatan : ".$rowz['nama_jabatan'];
	    echo "<br>";
	    echo "Pangkat, golru : ".$rowz['nama_palru'];
	    echo "<br>";
	  }
	?>
    <button title="Click untuk menampilkan/menyembunyikan form" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}">Tambah</button>
    <div id="spoiler" style="display:none">
        <br><br>
    <!-- ########################################################################################################################################## -->    
    <!-- ISI SPOILER -->
<?php
        function db(){ //handles database connection

        //connect to the database server or die and spit out connection error
        $conn = mysql_connect('localhost','root', '') or die("Cannot connect to the database server now". mysql_error());
        //select database table or die and spit out database selection error
        mysql_select_db('bkd_rev',$conn) or die("Error in selecting database now ".mysql_errno());
          return $conn;  
        }
        function simpan(){
           
	    $conn = db();					
	    $a	= $_POST['tahun_skp'];//datepicker
	    $b	= $_POST['dinilai'];//textfield get
	    $c	= $_POST['tugas'];//textfield
	    $y	= $_POST['kredit'];//textfield
	    $d	= $_POST['kuantitas'];//textfield
	    $e	= $_POST['kualitas'];//textfield
	    $f	= $_POST['waktu'];//textfield
	    $g	= $_POST['biaya'];//textfield
	    $x	= $_POST['penilai'];//textfield get
	    
            $sql="insert into tbl_form_skp (tahun_skp, dinilai, tugas, kredit, kuantitas, kualitas, waktu, biaya, penilai, time) 
                                    values ('$a','$b','$c','$y','$d','$e','$f','$g','$x',CURTIME())";
            $hasil=mysql_query($sql);
            if(!$hasil){
            die("Gagal Simpan Data Form SKP karena :".mysql_error());
	    }else {
	       header('Location: atasan_input_skp.php?nip='.$_GET['nip']);  
	    exit;}
	  }
?>
<?php
include "../koneksi.php";
	
    if($_GET['mode'] == 'delete') {
       if($_GET['tahun_skp'] && $_GET['dinilai'] && $_GET['time']) {
          $query = "DELETE FROM tbl_form_skp
		     WHERE tahun_skp=" . mysql_real_escape_string($_GET['tahun_skp']) . " AND
			   dinilai='" . mysql_real_escape_string($_GET['dinilai']) . "' AND
			   time='" . mysql_real_escape_string($_GET['time']) . "'
		     ";
          mysql_query($query);
       }
    }
	if($query)
            header('Location: atasan_input_skp.php?nip='.$_GET['dinilai']);
?>
         <fieldset>  
	    <form id="formulir" action="<?php if (isset($_REQUEST['simpan'])) {simpan();} ?>" method="post" name="form_input" onsubmit="return simpan()">
                  <table border="1" >
		    <pre>
		     <tr><td>Tahun*</td>	        <td><select class="validate[required]" name="tahun_skp" >
							<option value="#">=== Pilih Tahun ===</option>
							<option value="2014">2014</option>
						        <option value="2015">2015</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
						        <option value="2021">2021</option>
							<option value="2022">2022</option>
							<option value="2023">2023</option>
							<option value="2024">2024</option>
							<option value="2025">2025</option>
							</select></td></tr>
		     <tr><td>Penilai</td> 		<td><input type="text" maxlength="30" size="30" class="reqname" name="penilai" readonly value="<?php echo $_SESSION['userid']; ?>"/></td></tr>
		     
		     <tr><td>Pegawai Dinilai</td> 	<td><input type="text" maxlength="30" size="30" class="reqname" name="dinilai" readonly value="<?php echo $nip = $_GET['nip']; ?>"/></td></tr>
		     
		     <tr><td>Tugas*</td> 		<td><textarea rows="5" cols="50" class="validate[required]" name="tugas"></textarea></td></tr>
		     <tr><td><span title="Angka kredit adalah satuan nilai dari tiap butir kegiatan dan/atau akumulasi nilai butir-butir kegiatan yang harus dicapai oleh seorang PNS dalam rangka pembinaan karier dan jabatannya. Setiap PNS yang mempunyai jabatan fungsional tertentu diharuskan untuk mengisi angka kredit setiap tahun sesuai dengan ketentuan yang telah ditetapkan.">Kredit</span></td> 		<td><input type="text" maxlength="3" size="3" class="validate[custom[onlyNumberSp],max[100]]" name="kredit"/></td></tr>
		     <tr><td><span title="Dalam menentukan target kuantitas/output (TO) dapat berupa dokumen, konsep, naskah, surat keputusan, laporan dan sebagainya.">Kuantitas</span></td> 		<td><input type="text" maxlength="4" size="4" class="validate[custom[onlyNumberSp],maxSize[4]" name="kuantitas"/></td></tr>
		     <tr><td><span title="Dalam menetapkan target kualitas (TK) harus memprediksi pada mutu hasil kerja yang terbaik, dalam hal ini nilai yang diberikan adalah 100 dengan sebutan Sangat Baik, misalnya target kualitas harus 100.">Kualitas</span></td> 		<td><input type="text" maxlength="3" size="3" class="validate[custom[onlyNumberSp],max[100]" name="kualitas"/></td></tr>
		     <tr><td><span title="Dalam menetapkan target waktu (TW) harus memperhitungkan berapa waktu yang dibutuhkan untuk menyelesaikan suatu pekerjaan, misalnya satu bulan, triwulan, caturwulan, semester, 1 (satu) tahun dan lain-lain.">Waktu</span></td> 		<td><select class="validate[required]" name="waktu" >
							<option value="#">=== Pilih Waktu ===</option>
							<option value="1">1</option>
						        <option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
						        <option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							</select></td></tr>
		     <tr><td><span title="Dalam menetapkan target biaya ( TB) harus memperhitungkan berapa biaya yang dibutuhkan untuk menyelesaikan suatu pekerjaan dalam 1 (satu) tahun, misalnya jutaan, dan lain-lain.">Biaya</span></td> 		<td><input type="text" maxlength="6" size="6" class="validate[custom[onlyNumberSp]" name="biaya"/></td></tr>
		     
		     
				
                    <tr> <th colspan="2"><input type="submit" name="simpan" value="Simpan" onclick="simpan()"/><input type="reset" value="Reset"/></th></tr>
		    <tr><td colspan="2"><i>Ket: </i>* =<i style="color: red"> wajib diisi</i></td></tr>
                    </pre>
            
	    </table>
	 </form>
      </fieldset>  
    <!-- ENDING SPOILER -->
    <!-- ########################################################################################################################################## -->
    </div> 
<br><br>

<!-- MENAMPILKAN TABLE -->
    <!-- ########################################################################################################################################## -->

<?php
	include "../koneksi.php";
        $nip = $_GET['nip'];
	
	    echo "<select onchange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);' name='tahun_skp'><option>Cetak Formulir SKP</option>";
		  $ngeprint = mysql_query("select distinct (tahun_skp) from tbl_form_skp where dinilai='$nip'");
		  while ($ngeprint_row = mysql_fetch_array($ngeprint)){
		  echo "  <option value='atasan_output_skp-form_pdf.php?tahun_skp=$ngeprint_row[tahun_skp]&dinilai=$nip&penilai=$rowz[nip]'>$ngeprint_row[tahun_skp]</option>";
		  }
	    echo "</select>&nbsp;";
	    
	    echo "<select onchange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);' name='tahun_skp'><option>Cetak Penilaian SKP</option>";
		  $ngeprint = mysql_query("select distinct (tahun_skp) from tbl_form_skp where dinilai='$nip'");
		  while ($ngeprint_row = mysql_fetch_array($ngeprint)){
		  echo "  <option value='atasan_output_skp_pdf.php?tahun_skp=$ngeprint_row[tahun_skp]&dinilai=$nip&penilai=$rowz[nip]'>$ngeprint_row[tahun_skp]</option>";
		  }
	    echo "</select><br>";
        /*$hasil2  = mysql_query("select * from tbl_form_skp where penilai=".$rowz['nip']."");
	  if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());
	
	if($row = mysql_fetch_array($hasil2))*/
	    $hasil  = mysql_query("select * from tbl_form_skp where dinilai='".$nip."' ORDER BY tahun_skp");	
	
	$ambil = mysql_query("select nama_pns from tbl_pns where nip='".$nip."'");
	    if ($buaris = mysql_fetch_array($ambil))
	       echo "<br><b>Nama Pegawai Dinilai : ".$buaris['nama_pns']."<br> NIP : ".$nip."</b><br><br>";
	echo '<input type=button value="Refresh" onClick="window.location.reload()" /><br><br>';

	echo "<center><table id='rounded-corner' summary='2007 Major IT Companies Profit' border=1>
   <tr align='center'>
    <th rowspan='2'>Tahun SKP</th>
    <!--<th rowspan='2'>Penilai</th>
    <th rowspan='2'>Dinilai</th>-->
    <th rowspan='2'>Tugas</th>
    <th colspan='5'>TARGET</th>
    <th colspan='5'>REALISASI</th>
    <th rowspan='2'>Count</th>
    <th rowspan='2'>Capaian SKP</th>
    <!--<th rowspan='2' colspan='2'>Event</th>-->
   </tr>  
   <tr> 
    <th>Kredit</th>
    <th>Kuantitas</th>
    <th>Kualitas</th>
    <th>Waktu</th>
    <th>Biaya</th>
    <th>Kredit</th>
    <th>Kuantitas</th>
    <th>Kualitas</th>
    <th>Waktu</th>
    <th>Biaya</th>
   </tr>";


		
	while($row = mysql_fetch_array($hasil))
	{
           
		echo "<tr>";
		echo "<td>" .$row['tahun_skp']. "</td>";
		echo "<td>" .$row['tugas']. "</td>";
		echo "<td>" .$row['kredit']. "</td>";
                echo "<td>" .$row['kuantitas']. "</td>";
                echo "<td>" .$row['kualitas']. "</td>";
		echo "<td>" .$row['waktu']. "</td>";
	        echo "<td>" .$row['biaya']. "</td>";
		echo "<td>" .$row['kredit_real']. "</td>";
		echo "<td>" .$row['kuantitas_real']. "</td>";
		echo "<td>" .$row['kualitas_real']. "</td>";
		echo "<td>" .$row['waktu_real']. "</td>";
                echo "<td>" .$row['biaya_real']. "</td>";
                echo "<td>" .$row['penghitungan']. "</td>";
		if ($row['nilai_capaian_skp'] > 91) 
				 echo "<td>" .$row['nilai_capaian_skp']." (Sangat Baik) </td>";
			 elseif ($row['nilai_capaian_skp'] >76 && $row['nilai_capaian_skp'] <90)
				 echo "<td>" .$row['nilai_capaian_skp']. " (Baik) </td>";
			 elseif ($row['nilai_capaian_skp'] >61 && $row['nilai_capaian_skp'] <75)
				 echo "<td>" .$row['nilai_capaian_skp']. " (Cukup)</td>";
			 elseif ($row['nilai_capaian_skp'] >51 && $row['nilai_capaian_skp'] <60)
				 echo "<td>" .$row['nilai_capaian_skp']. " (Kurang)</td>";
			 elseif ($row['nilai_capaian_skp'] <50)
				 echo "<td>" .$row['nilai_capaian_skp']. " (Buruk)</td>";
		//echo "<td> <a href=atasan_output_skp_pdf.php?tahun_skp=$row[tahun_skp]&dinilai=$row[dinilai]&penilai=$rowz[nip] target='_blank'>Print</a></td> ";
		//echo "<td> <a href=atasan_output_skp-form_pdf.php?tahun_skp=$row[tahun_skp]&dinilai=$row[dinilai]&penilai=$rowz[nip] target='_blank'>Print Form</a></td> ";
		echo "</tr>";
            
	}
	mysql_free_result($result);
	echo "</table>";
?>
    
        </div>
	 </body>
      </div>
    </div> 
    <div id="footerskp"> BKD. KABUPATEN BLORA &copy; th 2013 </div>
</div>
</body>

        
        
