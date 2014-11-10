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
	    
<!-- ##### SPOILER BEGIN ##### -->  
Silahkan pilih tombol "Set Password" untuk mengganti Password sesuai hak akses yang dimiliki<br/><br/>
   
    <button title="Click untuk menampilkan/menyembunyikan form" type="button"
	    onclick="if(document.getElementById('spoiler')
			.style.display=='none') {document.getElementById('spoiler')
		        .style.display=''}else{document.getElementById('spoiler')
			.style.display='none'}">Set Password</button>
    
    <div id="spoiler" style="display:none">
        <br><br>
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
		  //===========================
		  function simpanAtasan(){
		     // include "../koneksi.php";
		      $conn = db();					
		      $a    = $_POST['atasan_'];
	  
		      
		      $sql="update tbl_pns set pwd=md5(md5('$a')) where level='atasan'";
		      $hasil=mysql_query($sql);
		      if(!$hasil){
		      die("Gagal Simpan Data Pegawai karena :".mysql_error());
		      }else {
		      header('Location: admin_input_pwd.php');
		      exit;}
	         }
		  //===========================
		  function simpanPenilai(){
		     // include "../koneksi.php";
		      $conn = db();					
		      $b    = $_POST['penilai_'];
	  
		      
		      $sql="update tbl_pns set pwd=md5(md5('$b')) where level='penilai'";
		      $hasil=mysql_query($sql);
		      if(!$hasil){
		      die("Gagal Simpan Data Pegawai karena :".mysql_error());
		      }else {
		      header('Location: admin_input_pwd.php');
		      exit;}
	         }
		  function simpanPegawaiDinilai(){
		     // include "../koneksi.php";
		      $conn = db();					
		      $c    = $_POST['dinilai_'];
	  
		      
		      $sql="update tbl_pns set pwd=md5(md5('$c')) where level='pegawai'";
		      $hasil=mysql_query($sql);
		      if(!$hasil){
		      die("Gagal Simpan Data Pegawai karena :".mysql_error());
		      }else {
		      header('Location: admin_input_pwd.php');
		      exit;}
	         }

	  ?>
            <form action="<?php if (isset($_REQUEST['simpan_a'])) {simpanAtasan();} ?>" method="post" name="form_input" onsubmit="return simpanAtasan()">
                    <pre>
                    <tr><td>Set Password Atasan</td> <td>
		        <input type="text" maxlength="10" size="10" class="reqname" name="atasan_" id="atasan_" /></td></tr>
 
                    <tr><th colspan="2"><input type="submit" name="simpan_a" value="Simpan" onclick="simpanAtasan()"/><input type="reset" value="Reset"/></th></tr>
                    </pre>
		    
            <form action="<?php if (isset($_REQUEST['simpan_b'])) {simpanPenilai();} ?>" method="post" name="form_input" onsubmit="return simpanPenilai()">
                    <pre>
                    <tr><td>Set Password Penilai</td> <td>
		        <input type="text" maxlength="10" size="10" class="reqname" name="penilai_" id="penilai_"/></td></tr>
 
                    <tr><th colspan="2"><input type="submit" name="simpan_b" value="Simpan" onclick="simpanPenilai()"/><input type="reset" value="Reset"/></th></tr>
                    </pre>
		    
            <form action="<?php if (isset($_REQUEST['simpan_c'])) {simpanPegawaiDinilai();} ?>" method="post" name="form_input" onsubmit="return simpanPegawaiDinilai()">
                    <pre>
                    <tr><td>Set Password Pegawai Dinilai</td> <td>
		        <input type="text" maxlength="10" size="10" class="reqname" name="dinilai_" id="dinilai_"/></td></tr>
 
                    <tr><th colspan="2"><input type="submit" name="simpan_c" value="Simpan" onclick="simpanPegawaiDinilai()"/><input type="reset" value="Reset"/></th></tr>
                    </pre>
		    
	   
	   
            

    </table>
<!-- ##### SPOILER END ##### -->  
    
    </div>
    
<br><br>

<!-- MENAMPILKAN TABLE -->
    <!-- ########################################################################################################################################## -->

    
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
					<li><a href="admin_input_jabatan.php">Data Jabatan</a></li>
					<li style='color: red'>Set Pass</li>
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

        
        
