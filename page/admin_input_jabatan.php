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
<!-- //
function popWin(url){
 	newwindow=window.open(url,'name','height=500,width=500');
	if (window.focus) {newwindow.focus()}
	return header('Location: admin_input_jabatan.php');
}
// -->
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
            
            Silahkan pilih tombol "TAMBAH JABATAN" untuk menambahkan DATA JABATAN<br/><br/>
    <input type="button" onclick="tableToExcel('testTable', 'W3C Example Table')" value="Export to Excel">
    <!-- <button title="Click untuk menampilkan/menyembunyikan form" type="button"
	    onclick="if(document.getElementById('spoiler')
			.style.display=='none') {document.getElementById('spoiler')
			.style.display=''}else{document.getElementById('spoiler')
			.style.display='none'}">Tambah</button>-->
    
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
            $a		    = $_POST['nama_jabatan'];

	    
            $sql="insert into tbl_jabatan (nama_jabatan) values ('$a')";
            $hasil=mysql_query($sql);
            if(!$hasil){
            die("Gagal Simpan Data Pegawai karena :".mysql_error());
	    }else {
            header('Location: admin_input_jabatan.php');
	    exit;}
	  }
?>
            <form action="<?php if (isset($_REQUEST['simpan'])) {simpan();} ?>" method="post" name="form_input" onsubmit="return simpan()">
                    <pre>
                                <tr><td>INPUT JABATAN BARU</td> <td>
				<input type="text" maxlength="70" size="70" class="reqname" name="nama_jabatan" id="nama_jabatan"/></td></tr>
 
                    <tr> <th colspan="2"><input type="submit" name="simpan" value="Simpan" onclick="simpan()"/><input type="reset" value="Reset"/></th></tr>
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
        //$nip = $_GET['username'];
	$hasil = mysql_query("SELECT * FROM tbl_jabatan");

	if (!$hasil)
		die("Gagal Query data karena : ".mysql_error());

        /*if ($row = mysql_fetch_array($hasil)){
	echo "Nama : ".$row['penilai']."<br>";
	echo "Dinilai : ".$row['dinilai']."<br>";
	
	  }*/
	echo '<input type=button value="Refresh" onClick="window.location.reload()" />';
	
	echo "<center><table id='rounded-corner' summary='2007 Major IT Companies Profit' border=1>
  <tr align='center'>
    <th>ID JABATAN</th>
    <th>NAMA JABATAN</th>
    <th>ACTION</th>
  </tr>";

	while($row = mysql_fetch_array($hasil))
	{
           
		echo "<tr>";
		echo "<td>" .$row['id_jabatan']. "</td>";
		echo "<td>" .$row['nama_jabatan']. "</td>";
		echo "<td> <a href=admin_edit_jabatan.php?id_jabatan=$row[id_jabatan]>Edit</a></td>";
		//echo '<td> <a href="javascript:popWin(\'admin_edit_jabatan.php?id_jabatan='.$row[id_jabatan].'\');">Edit</a></td>';
	        //echo "<td> <a class='del' href=form_admin.php?mode=delete&nip=$row[nip]>Hapus</a></td> ";
		echo "</tr>";
	}
	mysql_free_result($result);
	echo "</table>";
?>
    <input type="submit" name="print" value="Print" onclick="printDiv()"/>
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
					<li><a href="../panel_admin.php">Home</a></li>
					<li><a href="admin_input_pegawai.php">Data Pegawai</a></li>
					<li style='color: red'>Data Jabatan</li>
					<li><a href="admin_input_pwd.php">Set Pass</a></li>
					<!--<li><a href='#'>Report</a></li>	-->
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

        
        
