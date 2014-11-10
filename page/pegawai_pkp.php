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
	    echo "<b>Atasan Penilai :</b><br>";
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
	       echo "<b>Nama Pegawai Dinilai : ".$buaris['nama_pns']."<br> NIP : ".$nip."</b><br><br>";
               
        	    echo "<select onchange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);' name='tahun_skp'><option>Cetak PKP</option>";
		  $ngeprint = mysql_query("select distinct (tahun_pkp) from tbl_pkp where dinilai='$nip'");
		  while ($ngeprint_row = mysql_fetch_array($ngeprint)){
		  echo "  <option value='pegawai_output_pkp_pdf.php?tahun_pkp=$ngeprint_row[tahun_pkp]&dinilai=$nip'>$ngeprint_row[tahun_pkp]</option>";
		  }
	    echo "</select>&nbsp;";
	
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


		//echo "<td> <a href=penilai_edit_pkp.php?dinilai=$row[dinilai]&tahun_pkp=$row[tahun_pkp]>Edit</a></td>";
		//echo "<td> <a class='del' href=penilai_input_pkp.php?mode=delete&tahun_pkp=$row[tahun_pkp]&dinilai=$row[dinilai]>Hapus</a></td> ";
		//echo "<td> <a href=penilai_output_pkp_pdf.php?tahun_pkp=$row[tahun_pkp]&dinilai=$row[dinilai] target='_blank'>Print</a></td> ";
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
					<li><a href="pegawai_skp.php">SKP</a></li>
                                        <li style='color: red'>PKP</li>
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
