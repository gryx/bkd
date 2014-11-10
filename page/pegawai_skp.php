<head>

<title>SKP</title>
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
<?php
session_start();
include ('../nigol.php');

//require_once 'config/logout_auto.php';


//cek level user, jika user melakukan keluar
if(($_SESSION['level']!="admin")
   && ($_SESSION['level']!="atasan")
   && ($_SESSION['level']!="pegawai")
   && ($_SESSION['level']!="penilai")){
     header("location:index.php?error=6");

}


?>

<?php
    //echo "iki halaman panel ADMIN Aldy";
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
	<h3>Selamat Datang </h3><br />
        <div>
	Akses   : <?php echo $_SESSION['level']; ?><br>
        NIP     : <?php echo $_SESSION['userid']; ?><br>
        Nama    : <?php echo $_SESSION['name']; ?><br/>
	<?php
	  include "../koneksi.php";
	  $hasil  = mysql_query("select a.kode, a.nama_jabatan, b.nama_palru from tbl_jabatan a, tbl_pangkat_golru b
				where a.id_jabatan=".$_SESSION['jab']." AND b.id_palru=".$_SESSION['pal']."");
	  if (!$hasil)
		die("Gagal Query data karena : ".mysql_error());
		
	  if($row = mysql_fetch_array($hasil)){
	    echo "Jabatan : ".$row['nama_jabatan'];
	    echo "<br>";
	    echo "Pangkat, golru : ".$row['nama_palru'];
	    echo "<br>";echo "<br>";
	  }
	  
	  $hasil_lagi  = mysql_query("select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
			       from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
			       where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan AND b.kode='".$row['kode']."' AND a.level='penilai' ORDER BY a.level");
	  if($rowz = mysql_fetch_array($hasil_lagi)){
	    echo "<b>Penilai :</b><br>";
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
	
        <br><br>
        </div>
    
    <?php
	include "../koneksi.php";
        $nip = $_SESSION['userid'];
        
        /*$hasil2  = mysql_query("select * from tbl_form_skp where penilai=".$_SESSION['userid']."");
	  if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());*/
	
	//iki ngeprint laporan  
	    //echo "<form method='get' action='penilai_output_skp-form_pdf.php?tahun_skp=$_POST[tahun_skp]&dinilai=$nip'>";
	    echo "<select onchange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);' name='tahun_skp'><option>Cetak Formulir SKP</option>";
		  $ngeprint = mysql_query("select distinct (tahun_skp) from tbl_form_skp where dinilai='$nip'");
		  while ($ngeprint_row = mysql_fetch_array($ngeprint)){
		  echo "  <option value='pegawai_output_skp-form_pdf.php?tahun_skp=$ngeprint_row[tahun_skp]&dinilai=$nip'>$ngeprint_row[tahun_skp]</option>";
		  }
	    echo "</select>&nbsp;";
	    
	    //echo "<input formtarget='_blank' type='image' src='../img/printer.png' alt='Submit' name='dinilai' value='$nip' >";
	    //echo "<input formtarget='_blank' type='submit' name='dinilai' value='$nip' />";
//echo "<button formtarget='_blank' type='submit' formmethod='get' value='$nip' formaction='penilai_output_skp-form_pdf.php?tahun_skp=$_POST[tahun_skp]&dinilai=$nip'>Cetak</button>";
	    //echo "</form>";
	    
	    echo "<select onchange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);' name='tahun_skp'><option>Cetak Penilaian SKP</option>";
		  $ngeprint = mysql_query("select distinct (tahun_skp) from tbl_form_skp where dinilai='$nip'");
		  while ($ngeprint_row = mysql_fetch_array($ngeprint)){
		  echo "  <option value='pegawai_output_skp_pdf.php?tahun_skp=$ngeprint_row[tahun_skp]&dinilai=$nip'>$ngeprint_row[tahun_skp]</option>";
		  }
	    echo "</select><br>";
	
	//if($row = mysql_fetch_array($hasil2))
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
    <th colspan='5'><span title='Target merupakan jumlah beban kerja yang akan dicapai oleh setiap PNS dalam kurun waktu tertentu.'>TARGET</span></th>
    <th colspan='5'>REALISASI</th>
    <th rowspan='2'>Count</th>
    <th rowspan='2'>Capaian SKP</th>
    <!--<th rowspan='2'>Nilai SKP</th>
     <th rowspan='2'>Tgl. Form</th>
    <th rowspan='2'>Tgl. Penilaian SKP</th>
    <th rowspan='2' colspan='2'>Edit</th>-->
    <!--<th rowspan='2' colspan='2'>Cetak</th>-->
   </tr>  
   <tr> 
    <th><span title='Angka kredit adalah satuan nilai dari tiap butir kegiatan dan/atau akumulasi nilai butir-butir kegiatan yang harus dicapai oleh seorang PNS dalam rangka pembinaan karier dan jabatannya. Setiap PNS yang mempunyai jabatan fungsional tertentu diharuskan untuk mengisi angka kredit setiap tahun sesuai dengan ketentuan yang telah ditetapkan.'>Kredit</span></th>
    <th><span title='Dalam menentukan target kuantitas/output (TO) dapat berupa dokumen, konsep, naskah, surat keputusan, laporan dan sebagainya.'>Kuantitas</span></th>
    <th><span title='Dalam menetapkan target kualitas (TK) harus memprediksi pada mutu hasil kerja yang terbaik, dalam hal ini nilai yang diberikan adalah 100 dengan sebutan Sangat Baik, misalnya target kualitas harus 100.'>Kualitas</span></th>
    <th><span title='Dalam menetapkan target waktu (TW) harus memperhitungkan berapa waktu yang dibutuhkan untuk menyelesaikan suatu pekerjaan, misalnya satu bulan, triwulan, caturwulan, semester, 1 (satu) tahun dan lain-lain.'>Waktu</span></th>
    <th><span title='Dalam menetapkan target biaya ( TB) harus memperhitungkan berapa biaya yang dibutuhkan untuk menyelesaikan suatu pekerjaan dalam 1 (satu) tahun, misalnya jutaan, dan lain-lain.'>Biaya</span></th>
    <th>Kredit</th>
    <th>Kuantitas</th>
    <th>Kualitas</th>
    <th>Waktu</th>
    <th>Biaya</th>
   </tr>";


		
	while($rowet = mysql_fetch_array($hasil))
	{
           
		echo "<tr>";
		echo "<td>" .$rowet['tahun_skp']. "</td>";
		echo "<td>" .$rowet['tugas']. "</td>";
		echo "<td>" .$rowet['kredit']. "</td>";
                echo "<td>" .$rowet['kuantitas']. "</td>";
                echo "<td>" .$rowet['kualitas']. "</td>";
		echo "<td>" .$rowet['waktu']. "</td>";
	        echo "<td>" .$rowet['biaya']. "</td>";
		echo "<td>" .$rowet['kredit_real']. "</td>";
		echo "<td>" .$rowet['kuantitas_real']. "</td>";
		echo "<td>" .$rowet['kualitas_real']. "</td>";
		echo "<td>" .$rowet['waktu_real']. "</td>";
                echo "<td>" .$rowet['biaya_real']. "</td>";
                echo "<td>" .$rowet['penghitungan']. "</td>";
		if ($rowet['nilai_capaian_skp'] > 91) 
				 echo "<td>" .$rowet['nilai_capaian_skp']." (Sangat Baik) </td>";
			 elseif ($rowet['nilai_capaian_skp'] >76 && $rowet['nilai_capaian_skp'] <90)
				 echo "<td>" .$rowet['nilai_capaian_skp']. " (Baik) </td>";
			 elseif ($rowet['nilai_capaian_skp'] >61 && $rowet['nilai_capaian_skp'] <75)
				 echo "<td>" .$rowet['nilai_capaian_skp']. " (Cukup)</td>";
			 elseif ($rowet['nilai_capaian_skp'] >51 && $rowet['nilai_capaian_skp'] <60)
				 echo "<td>" .$rowet['nilai_capaian_skp']. " (Kurang)</td>";
			 elseif ($rowet['nilai_capaian_skp'] <50)
				 echo "<td>" .$rowet['nilai_capaian_skp']. " (Buruk)</td>";

		//echo "<td> <a href=penilai_edit_skp_target.php?dinilai=$rowet[dinilai]&time=$rowet[time]>Target</a></td>";
	        //echo "<td> <a href=penilai_edit_skp_realisasi.php?dinilai=$rowet[dinilai]&time=$rowet[time]>Realisasi</a></td>";
		//echo "<td> <a class='del' href=penilai_input_skp.php?mode=delete&tahun_skp=$rowet[tahun_skp]&dinilai=$rowet[dinilai]&time=$rowet[time]>Hapus</a></td> ";
	        //echo "<td> <a href=penilai_output_skp-form_pdf.php?tahun_skp=$rowet[tahun_skp]&dinilai=$rowet[dinilai] target='_blank'>Formulir</a></td> ";	
		//echo "<td> <a href=penilai_output_skp_pdf.php?tahun_skp=$rowet[tahun_skp]&dinilai=$rowet[dinilai] target='_blank'>Penilaian</a></td> ";
		echo "</tr>";
            
	}
	mysql_free_result($result);
	echo "</table>";
?>
    
    
   </div>
   </body>
		<?php
			include "case.php";
		?>
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
                                        <li><a href="../panel_pegawai.php">Home</a></li>
                                        <li style='color: red'>SKP</li>
					<li><a href='pegawai_pkp.php'>PKP</a></li>
<!--					<li><a href='#'>Set Pass</a></li>
					<li><a href='#'>Report</a></li>-->
					
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
    </div>

    <!-- footer !-->
    <div id="footer"> BKD. KABUPATEN BLORA &copy; th 2013 </div>
</div>
</body>    
