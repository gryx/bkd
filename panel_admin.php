<head>

<title>Penilaian Kinerja Pegawai BKD Blora</title>
<!--<link rel="stylesheet" type="text/css" href="css/panel.css" />-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap -->
<link href="css/panel_.css" rel="stylesheet" media="screen">
     
</head>
<?php
session_start();
include ('nigol.php');

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
	Hai, <?php echo $_SESSION['level']; ?><br /><br />
	Silahkan pilih menu yang di sebelah untuk mengelola Kepegawaian kabupaten Blora<br />
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	<br /><br /><br /><br /><br />
    
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
                                        <li style='color: red'>Home</li>
					<li><a href="page/admin_input_pegawai.php">Data Pegawai</a></li>
					<li><a href='page/admin_input_jabatan.php'>Data Jabatan</a></li>
					<li><a href='page/admin_input_pwd.php'>Set Pass</a></li>
					<!--<li><a href='#'>Report</a></li>-->
					
				</ul>
			</div>
    	</div>



    	<div id="sidebar_title">
			<div id="sidebar_name">
			  Logout
			</div>

			<div id="sidebar_isi">
				<ul>
					<li><a href="nigol.php?op=out">Keluar</a></li>
				</ul>
			</div>
    	</div>
    </div>

    <!-- footer !-->
    <div id="footer"> BKD. KABUPATEN BLORA &copy; th 2013 </div>
</div>
</body>

        
        
