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
                    <div>
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
	    echo "<br>";
	  }
	?>
	
        <br><br>
        </div>
           <br/>
    <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel">
   
    
    <div id="spoiler" style="display:none">
        <br><br>
	
    </table>
    </div> 
<br><br>

<!-- MENAMPILKAN TABLE -->
    <!-- ########################################################################################################################################## -->

<?php
	include "../koneksi.php";
	

	  $hasil2  = mysql_query("select * from tbl_jabatan where id_jabatan=".$_SESSION['jab']."");
	  //$hasil  = mysql_query("select nama_jabatan from tbl_jabatan where id_jabatan=13");
	  if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());
		
	  if($row = mysql_fetch_array($hasil2))
	    $hasil  = mysql_query("select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
			       from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
			       where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan AND b.kode='".$row[kode]."' AND a.level='pegawai' ORDER BY a.level");
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
    <th colspan='2'>EDIT</th>
    <!--<th colspan='2'>PRINT</th>-->
  </tr>";

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
		echo "<td> <a href=penilai_input_skp.php?nip=$row[nip] target='_blank'>SKP</a></td>";
	        echo "<td> <a href=penilai_input_pkp.php?nip=$row[nip] target='_blank'>PKP</a></td>";
	        //echo "<td> <a href=penilai_output_skp.php?nip=$row[nip] target='_blank'>SKP</a></td>";
	        //echo "<td> <a href=penilai_output_pkp.php?nip=$row[nip] target='_blank'>PKP</a></td>";
		echo "</tr>";
            
	}
	mysql_free_result($result);
	echo "</table>";
?>
    <!--<input type="submit" name="print" value="Print" onclick="printDiv()">-->
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
					<li><a href="../panel_penilai.php">Home</a></li>
					<li style='color: red'>Input SKP dan PKP</li>
<!--					<li><a href='#'>Data Jabatan </a></li>
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

        
        
