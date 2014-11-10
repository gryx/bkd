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
$( "#datepicker" ).datepicker();
});
</script>

</head>
<?php
session_start();
include ('../nigol.php');

//require_once 'config/logout_auto.php';


//cek level user, jika user melakukan keluar
if(($_SESSION['level']!="admin") && ($_SESSION['level']!="atasan") && ($_SESSION['level']!="pegawai")&& ($_SESSION['level']!="penilai")){
     header("location:index.php?error=6");

}
?>
<?php
    echo "iki halaman panel penilai Aldy";
?>

<body>

<div id="halaman">

	<!-- header !-->
	<div id="header"> <BR><CENTER> <H1>SISTEM PENILAIAN KINERJA KARYAWAN<br></H1>
	</div>

	<!-- content !-->
<div id="content">
    <body>
            <div id="tulis">
            <h3>Pengelolaan Data Penilaian Kinerja Pegawai</h3><br />
            
            Silahkan pilih tombol "TAMBAH" untuk menambahkan formulir Penilaian Kinerja<br/><br/>
            
    <button title="Click untuk menampilkan/menyembunyikan form" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}">Tambah</button>
    
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
        mysql_select_db('bkd',$conn) or die("Error in selecting database now ".mysql_errno());
          return $conn;  
        }
        function simpan(){
           // include "../koneksi.php";

           
	    $conn = db();					
            $penilai		    = $_POST['nama_pns_penilai'];
            $nip_penilai	    = $_POST['nip'];
            $tg	                    = $_POST['tugas'];
            $kr		            = $_POST['kredit'];
            $kn		            = $_POST['kuantitas'];
            $kl		            = $_POST['kualitas'];
            $wt		            = $_POST['waktu'];
            $by	                    = $_POST['biaya'];
            $dt		            = $_POST['date'];
            $dinilai	            = $_POST['nama_pns_dinilai'];


            $sql="insert into tbl_form (id_form, tugas, kredit, kuantitas, kualitas, waktu, biaya, tgl_form, penilai, dinilai) 
                                    values ('$nip_penilai','$tg','$kr','$kn','$kl','$wt','$by','$dt','$penilai','$dinilai')";
            $hasil=mysql_query($sql);
            if(!$hasil)
            die("Gagal Simpan Data Siswa karena :".mysql_error());
            
            echo "Penyimpanan data siswa berhasil";
    }
?>

            <form action="<?php if (isset($_REQUEST['simpan'])) {simpan();} ?>" method="post" name="form_input" onsubmit="return simpan()">
                    <pre>
                    <tr><td>Nama </td> <td> 
                                <?
                                    // Load field datas into List box
                                    $cn=mysql_connect("localhost","root") or die("Note: " . mysql_error());
                                    $res=mysql_select_db("bkd",$cn) or die("Note: " . mysql_error());
                                    $sql = "select nip, nama_pns from tbl_pns where level='penilai';";
                                    $res=mysql_query($sql) or die("Note: " . mysql_error());
                                ?>
                                    <select onChange="document.getElementById('combo').value=this.value" name="nama_pns_penilai">
                                <?
                                        while($ri = mysql_fetch_array($res))
                                        {
                                            echo "<option value=" .$ri['nip']. ">" . $ri['nama_pns']. "</option>";
                                        }
                                            echo "</select> ";
                                            echo "NIP : <input class='reqname' name='nip' disabled type='text' id='combo'>";
                                ?>
                                <tr><td>Tugas</td> <td>         <textarea rows="3" cols="30" class="reqname" name="tugas"> </textarea></td></tr>
                                <tr><td>Angka Kredit</td> <td>  <input type="text" maxlength="2" size="2" class="reqname" name="kredit"/></td></tr>
                                <tr><td>Kuantitas</td> <td>     <input type="text" maxlength="4" size="4" class="reqname" name="kuantitas"/></td></tr>
                                <tr><td>Kualitas</td> <td>      <input type="text" maxlength="3" size="3" class="reqname" name="kualitas"/></td></tr>
                                <tr><td>Waktu</td> <td>         <input type="text" maxlength="2" size="2" class="reqname" name="waktu"/></td></tr>
                                <tr><td>Biaya</td> <td>         <input type="text" maxlength="11" size="11" class="reqname" name="biaya"/></td></tr>
                                <tr><td>Tanggal</td><td>        <input type="text" id="datepicker" name="date"></td></tr>
                                <tr><td>Pegawai Dinilai </td> <td> 
                                <?
                                        // Load field datas into List box
                                        $cn=mysql_connect("localhost","root") or die("Note: " . mysql_error());
                                        $res=mysql_select_db("bkd",$cn) or die("Note: " . mysql_error());
                                        $sql = "select nip, nama_pns from tbl_pns where level='pegawai';";
                                        $res=mysql_query($sql) or die("Note: " . mysql_error());
                                ?>
                                        <select class="reqname" name="nama_pns_dinilai">
                                <?
                                        while($ri = mysql_fetch_array($res))
                                        {
                                        echo "<option value=" .$ri['nama_pns'] . ">" . $ri['nama_pns'] . "</option>";
                                        }
                                        echo "</select> ";
                                    ?>
                                </td></tr>
                    <tr> <th colspan="2"><input type="submit" name="simpan" value="Simpan" onclick="simpan()"/><input type="reset" value="Reset"/></th></tr>
                    </pre>
            </form>

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
	//$hasil = mysql_query("SELECT * FROM tbl_form WHERE penilai='".$nip."'");
	
        //$hasil  = mysql_query("SELECT * FROM tbl_form WHERE penilai=1057;");
	$hasil  = mysql_query("SELECT * FROM tbl_form ");
	if (!$hasil)
		die("Gagal Query data karena : ".mysql_error());

        /*if ($row = mysql_fetch_array($hasil)){
	echo "Nama : ".$row['penilai']."<br>";
	echo "Dinilai : ".$row['dinilai']."<br>";
	
	  }*/
	echo '<input type=button value="Refresh" onClick="window.location.reload()" />';
	echo '<center><table border=1>
  <tr>
    <th>ID FORM</th>
    <th>TUGAS</th>
    <th>KREDIT</th>
    <th>KUANTITAS</th>
    <th>KUALITAS</th>
    <th>WAKTU</th>
    <th>BIAYA</th>
    <th>TANGGAL FORM</th>
    <th>PENILAI</th>
    <th>DINILAI</th>
    <th>ACTION</th>
  </tr>';


        //while(mysql_fetch_assoc($hasil))
	//while(mysql_num_rows($hasil)==$hitung)
	while($row = mysql_fetch_array($hasil))
	{
           
		echo "<tr>";
		echo "<td>" .$row['id_form']. "</td>";
		echo "<td>" .$row['tugas']. "</td>";
		echo "<td>" .$row['kredit']. "</td>";
		echo "<td>" .$row['kuantitas']. "</td>";
		echo "<td>" .$row['kualitas']. "</td>";
                echo "<td>" .$row['waktu']. "</td>";
                echo "<td>" .$row['biaya']. "</td>";
                echo "<td>" .$row['tgl_form']. "</td>";
                echo "<td>" .$row['penilai']. "</td>";
                echo "<td>" .$row['dinilai']. "</td>";
		echo "<td> <a  target='_blank' href=form_edit.php?penilai=$row[penilai]&id_form=$row[id_form]>Edit</a></td>";

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
				<img src="images/male_users.png" align="left">KELOLA KEPEGAWAIAN</a>
			</div>
			<div id="sidebar_isi">
				<ul>
					<li><h3>Sebagai <?php echo $_SESSION['level']; ?></h3></li>
					<li>Input FORM SK</li>
					<li><a href='page/skp.php'>Manage SKP </a></li>
					<li><a href='page/pkp.php'>Manage PKP</a></li>
					<li><a href='page/report.php'>Report</a></li>	
				</ul>
			</div>
    	</div>

    	<div id="sidebar_title">
			<div id="sidebar_name">
			 <img src="images/exit_user.png" align="center">Logout</a>
			</div>
			<div id="sidebar_isi">
				<ul>
					<li><a href="nigol.php?op=out">Keluar</a></li>
				</ul>
			</div>
    	</div>

    </div> <!-- footer !-->
    <div id="footer"> BKD. KABUPATEN BLORA &copy; th 2013 </div>
</div>
</body>

        
        
