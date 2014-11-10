<head>

<title>PKP</title>
<!--<link rel="stylesheet" type="text/css" href="css/panel.css" />-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="../css/panel_.css" rel="stylesheet" media="screen">
	 <link rel="stylesheet" type="text/css" href="../css/source/style.css">
	 <link rel="stylesheet" href="/resources/demos/style.css">
	 <link rel="stylesheet" href="../jq/jqval/css/validationEngine.jquery.css" type="text/css"/>
	 <link rel="stylesheet" href="../jqui/jquery-ui-1.10.3/themes/base/jquery-ui.css" />
      
	 <script src="../jq/jquery.min.js"></script>
	 <script src="../jqui/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
	 <script src="../jq/jqval/js/languages/jquery.validationEngine-id.js" type="text/javascript" charset="utf-8"></script>
	 <script src="../jq/jqval/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

<style type="text/css">
<!--
@import url("../css/style.css");
-->
</style>
</head>

<script>
   
         $(document).ready(function(){
            $("#formulir").validationEngine();
	    $("#datepicker" ).datepicker({ changeYear:true,changeMonth:true });
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

<div id="halamanpkp">

	<!-- header !-->
	<div id="headerpkp">
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
	  $hasil_lagi  = mysql_query("select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
			       from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
			       where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan AND b.kode='".$row['kode2']."' AND a.level='atasan' ORDER BY a.level");
	  if($rowz = mysql_fetch_array($hasil_lagi)){
	    echo "<b>Atasan Penilai :</b><br>";
	    echo "NIP : ".$rowz['nip'];
	    echo "<br>";
	    echo "Nama : ".$rowz['nama_pns'];
	    echo "<br>";
	    echo "Jabatan : ".$rowz['nama_jabatan'];
	    echo "<br>";
	    echo "Pangkat, golru : ".$rowz['nama_palru'];
	    echo "<br><br>";
	  }
	?>        
            Silahkan pilih tombol "TAMBAH SKP" untuk menambahkan DATA SKP PEGAWAI<br/><br/>
    <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel">
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
	    $a	= $_POST['tahun_pkp'];//datepicker
	    $b	= $_POST['penilai'];//textfield get
	    $c	= $_POST['dinilai'];//textfield
	    $d	= $_POST['atasan_penilai'];//textfield
	    $e	= $_POST['orientasi_pelayanan'];//textfield
	    $f	= $_POST['integritas'];//textfield
	    $g	= $_POST['komitmen'];//textfield
	    $h	= $_POST['disiplin'];//textfield
	    $i	= $_POST['kerjasama'];//textfield
	    $j	= $_POST['kepemimpinan'];//textfield
	    //$k	= $_POST['jumlah'];
	    //$l	= $_POST['nilai_rata'];
	    //$m	= $_POST['nilai_pkp'];
	    $jumlah = ($e+$f+$g+$h+$i+$j);
	    $rata = $jumlah/6;
	    $nilai = $rata*0.4;
	    $n	= $_POST['tanggapan'];//textarea
	    $o	= $_POST['keputusan'];//textarea
	    $p	= $_POST['rekomendasi'];//textarea
	    $q	= $_POST['tgl_penilaian_pkp'];//datepicker
	    
	    
	    
            $sql="insert into tbl_pkp values ('$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$jumlah','$rata','$nilai','$n','$o','$p','$q')";
            $hasil=mysql_query($sql);
	    
            if(!$hasil){
            die("Gagal Simpan Data PKP karena :".mysql_error());
	    }
	       else {
	       header('Location: penilai_input_pkp.php?nip='.$_GET['nip']);  
	    exit;}
	  }
?>
<?php
//include "../koneksi.php";
	
    if($_GET['mode'] == 'delete') {
       if($_GET['tahun_pkp'] && $_GET['dinilai']) {
          $query = "DELETE FROM tbl_pkp
		     WHERE tahun_pkp=" . mysql_real_escape_string($_GET['tahun_pkp']) . " AND
			   dinilai='" . mysql_real_escape_string($_GET['dinilai']) . "'
		     ";
          mysql_query($query);
       }
    }
	if($query)
            header('Location: penilai_input_pkp.php?nip='.$_GET['dinilai']);
?>
         <fieldset>   
	    <form id="formulir" action="<?php if (isset($_REQUEST['simpan'])) {simpan();} ?>" method="post" name="form_input" onsubmit="return simpan()">
                    <table border="1" >
		    <pre>
		     <tr><td>Tahun*</td>	        <td><select class="validate[required]" name="tahun_pkp" >
							<option value="#">=== Pilih Tahun ===</option>
							<option value="2014">2014</option>
						        <option value="2015">2015</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
						        <option value="2021">2021</option>
							<option value="2023">2022</option>
							<option value="2024">2023</option>
							<option value="2025">2024</option>
							<option value="2026">2025</option>
							</select></td></tr>
		     <tr><td>Penilai</td> 		<td><input type="text" maxlength="30" size="30" class="reqname" name="penilai" readonly value="<?php echo $_SESSION['userid']; ?>"/></td></tr>
		     <tr><td>Atasan Penilai</td> 	<td><input type="text" maxlength="30" size="30" class="reqname" name="atasan_penilai" readonly value="<?php echo $rowz['nip']; ?>"/></td></tr>
		     <tr><td>Pegawai Dinilai</td> 	<td><input type="text" maxlength="30" size="30" class="reqname" name="dinilai" readonly value="<?php echo $nip = $_GET['nip']; ?>"/></td></tr>
		     
		     <tr><td>Orientasi Pelayanan*</td> 	<td><input type="text" maxlength="3" size="3" class="validate[required,custom[onlyNumberSp],min[0],max[100]]" name="orientasi_pelayanan"/></td></tr>
		     <tr><td>Integritas*</td> 		<td><input type="text" maxlength="3" size="3" class="validate[required,custom[onlyNumberSp],min[0],max[100]]" name="integritas"/></td></tr>
		     <tr><td>Komitmen*</td> 		<td><input type="text" maxlength="3" size="3" class="validate[required,custom[onlyNumberSp],min[0],max[100]]" name="komitmen"/></td></tr>
		     <tr><td>Disiplin*</td> 		<td><input type="text" maxlength="3" size="3" class="validate[required,custom[onlyNumberSp],min[0],max[100]]" name="disiplin"/></td></tr>
		     <tr><td>Kerjasama*</td> 		<td><input type="text" maxlength="3" size="3" class="validate[required,custom[onlyNumberSp],min[0],max[100]]" name="kerjasama"/></td></tr>
		     <tr><td>Kepemimpinan*</td> 	<td><input type="text" maxlength="3" size="3" class="validate[required,custom[onlyNumberSp],min[0],max[100]]" name="kepemimpinan"/></td></tr>
		     
		     <tr><td>Tanggapan*</td> 		<td><textarea rows="5" cols="50" class="reqname" name="tanggapan"></textarea></td></tr>
		     <tr><td>Keputusan*</td> 		<td><textarea rows="5" cols="50" class="reqname" name="keputusan"></textarea></td></tr>
		     <tr><td>Rekomendasi*</td> 		<td><textarea rows="5" cols="50" class="reqname" name="rekomendasi"></textarea></td></tr>
		     
		     <tr><td>Tanggal PKP*</td><td>        <input type="text" class="validate[required]" id="datepicker" name="tgl_penilaian_pkp"></td></tr>


		     
		     
				
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
        /*$hasil2  = mysql_query("select * from tbl_pkp where penilai=".$_SESSION['userid']."");
	  if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());
	
	if($row = mysql_fetch_array($hasil2))*/
	    $hasil  = mysql_query("select * from tbl_pkp where dinilai='".$nip."' ORDER BY tahun_pkp");	
	 if (!$hasil)
		die("Gagal Query data karena : ".mysql_error());

	echo '<input type=button value="Refresh" onClick="window.location.reload()" /><br><br>';
	
	$ambil = mysql_query("select nama_pns from tbl_pns where nip='".$nip."'");
	    if ($buaris = mysql_fetch_array($ambil))
	       echo "<b>Nama Pegawai Dinilai : ".$buaris['nama_pns']."<br> NIP : ".$nip."</b>";
	
	echo "<center><table id='rounded-corner' summary='2007 Major IT Companies Profit' border=1>
   <tr align='center'>
    <th rowspan='2'>Tahun SKP</th>
    <th colspan='6'>UNSUR</th>
    <th rowspan='2'>Jumlah</th>
    <th rowspan='2'>Rata</th>
    <th rowspan='2'>Nilai(40%)</th>
    <th rowspan='2'>Tanggapan</th>
    <th rowspan='2'>Keputusan</th>
    <th rowspan='2'>Rekomendasi</th>
    <th rowspan='2'>Tanggal PKP</th>
    <th rowspan='2' colspan='2'>Event</th>
   </tr>  
   <tr> 
    <th><span title='Orieantasi Pelayanan adalah sikap dan perilaku kerja PNS dalam memberikan pelayanan terbaik kepada yang dilayani antara lain meliputi masyarakat, atasan, rekan sekerja, unit kerja terkait, dan/atau instansi lain. '>Orientasi Pelayanan</span></th>
    <th><span title='Integritas mewakili sikap pegawai seperti sifat atau keadaan yang menunjukkan kesatuan yang utuh sehingga memiliki potensi dan kemampuan yang memancarkan kewibawaan atau kejujuran, selain itu merupakan kemampuan untuk bertindak sesuai dengan nilai, norma dan etika dalam organisasi. '>Integritas</span></th>
    <th><span title='Komitmen adalah kemauan dan kemampuan untuk menyelaraskan sikap dan tindakan PNS untuk mewujudkan tujuan organisasi dengan mengutamakan kepentingan dinas daripada kepentingan diri sendiri, seseorang, dan/atau golongan.'>Komitmen</span></th>
    <th><span title='Kedisiplinan adalah kesanggupan Pegawai Negeri Sipil untuk menaati kewajiban dan menghindari larangan yang ditentukan dalam peraturan perundang-undangan dan/atau peraturan kedinasan yang apabila tidak ditaati atau dilanggar dijatuhi hukuman disiplin.'>Kedisiplinan</span></th>
    <th><span title='Kerjasama adalah kemauan dan kemampuan PNS untuk bekerja sama dengan rekan sekerja, atasan, bawahan dalam unit kerjanya serta instansi lain dalam menyelesaikan suatu tugas dan tanggung jawab yang ditentukan, sehingga mencapai daya guna dan hasil guna yang sebesar-besarnya. '>Kerjasama</span></th>
    <th><span title='Kepemimpinan adalah kemampuan dan kemauan PNS untuk memotivasi dan mempengaruhi bawahan atau orang lain yang berkaitan dengan bidang tugasnya demi tercapainya tujuan organisasi. '>Kepemimpinan</span></th>
   </tr>";


		
	while($row = mysql_fetch_array($hasil))
	{
           
		echo "<tr>";
		echo "<td>" .$row['tahun_pkp']. "</td>";
		echo "<td>" .$row['orientasi_pelayanan']. "</td>";
		echo "<td>" .$row['integritas']. "</td>";
                echo "<td>" .$row['komitmen']. "</td>";
                echo "<td>" .$row['disiplin']. "</td>";
		echo "<td>" .$row['kerjasama']. "</td>";
	        echo "<td>" .$row['kepemimpinan']. "</td>";
		echo "<td>" .$row['jumlah']. "</td>";
	        if ($row['nilai_rata'] > 91) 
				 echo "<td>" .$row['nilai_rata']." (Sangat Baik) </td>";
			 elseif ($row['nilai_rata'] >76 && $row['nilai_rata'] <90)
				 echo "<td>" .$row['nilai_rata']. " (Baik) </td>";
			 elseif ($row['nilai_rata'] >61 && $row['nilai_rata'] <75)
				 echo "<td>" .$row['nilai_rata']. " (Cukup)</td>";
			 elseif ($row['nilai_rata'] >51 && $row['nilai_rata'] <60)
				 echo "<td>" .$row['nilai_rata']. " (Kurang)</td>";
			 elseif ($row['nilai_capaian_skp'] <50)
				 echo "<td>" .$row['nilai_rata']. " (Buruk)</td>";
	        echo "<td>" .$row['nilai_pkp']. "</td>";
		echo "<td>" .$row['tanggapan']. "</td>";
		echo "<td>" .$row['keputusan']. "</td>";
		echo "<td>" .$row['rekomendasi']. "</td>";
		echo "<td>" .$row['tgl_penilaian_pkp']. "</td>";


		echo "<td> <a href=penilai_edit_pkp.php?dinilai=$row[dinilai]&tahun_pkp=$row[tahun_pkp]>Edit</a></td>";
		//echo "<td> <a class='del' href=penilai_input_pkp.php?mode=delete&tahun_pkp=$row[tahun_pkp]&dinilai=$row[dinilai]>Hapus</a></td> ";
		echo "<td> <a href=penilai_output_pkp_pdf.php?tahun_pkp=$row[tahun_pkp]&dinilai=$row[dinilai] target='_blank'>Print</a></td> ";
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

        
        
