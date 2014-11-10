<head>

<title>PKP</title>
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
      
    $( "#datepicker" ).datepicker({ changeYear:true,changeMonth:true,changeDate:true });

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
           <br/><br/>
    
    <div id="spoiler" style="display:none">
        <br><br>
    <!-- ########################################################################################################################################## -->    
    <!-- ISI SPOILER -->    
  
    <!-- ENDING SPOILER -->
    <!-- ########################################################################################################################################## -->
    </div> 
<br><br>

<!-- MENAMPILKAN TABLE -->
    <!-- ########################################################################################################################################## -->

<?php
	include "../koneksi.php";
        $nip = $_GET['nip'];
        /*$hasil2  = mysql_query("select * from tbl_pkp where penilai=".$rowz['nip']."");
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
    <th>Orientasi Pelayanan</th>
    <th>Integritas</th>
    <th>Komitmen</th>
    <th>Disiplin</th>
    <th>Kerjasama</th>
    <th>Kepemimpinan</th>
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

		echo "<td> <a href=atasan_edit_pkp.php?tahun_pkp=$row[tahun_pkp]&dinilai=$row[dinilai]>Edit</a></td> ";
		echo "<td> <a href=atasan_output_pkp_pdf2.php?tahun_pkp=$row[tahun_pkp]&dinilai=$row[dinilai]&penilai=$rowz[nip] target='_blank'>Print</a></td> ";
		
		
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

        
        
