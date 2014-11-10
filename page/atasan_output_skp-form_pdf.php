<?php
session_start();
include ('../nigol.php');

		
	include "../koneksi.php";
	
	include("../ext/mpdf/mpdf.php");
	$html .= '<h2 align="center">FORMULIR SASARAN KERJA<br>PEGAWAI NEGERI SIPIL</h2><br>';
	//======LEFT=====
	$year 	= $_GET['tahun_skp'];
	$nip 	= $_GET['dinilai'];
	$penilai = $_GET['penilai'];
		$get_penilai  = mysql_query("select * from tbl_pns where nip='$penilai'");	
		if($row_get_penilai = mysql_fetch_array($get_penilai))
		$html .="<div style='float: left; alignment-adjust: middle; width: 28%; margin-bottom: 0pt;'>";
		$html .="	<b>I. PEJABAT PENILAI</b> <br>
				1. Nama		 : $row_get_penilai[nama_pns]<br>
				2. NIP     	 : $penilai<br>";
		$get_golrujab = mysql_query("select * from tbl_jabatan, tbl_pangkat_golru
						where tbl_jabatan.id_jabatan=$row_get_penilai[id_jabatan]
						AND tbl_pangkat_golru.id_palru=$row_get_penilai[id_palru]");
		if($row_get_golrujab = mysql_fetch_array($get_golrujab))
		$html .="	3. Pangkat/golru : $row_get_golrujab[nama_palru]<br>
				4. Jabatan	 : $row_get_golrujab[nama_jabatan]<br>";
		$html .="		</div>";
	//===============
	
        /*$hasil2  = mysql_query("select * from tbl_form_skp where penilai='$penilai'");
	if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());
	if($row = mysql_fetch_array($hasil2))*/
	    $hasil  = mysql_query("select * from tbl_form_skp where tahun_skp=$year AND dinilai='".$nip."' ORDER BY tahun_skp");	
	
	$ambil = mysql_query("select * from tbl_pns where nip='".$nip."'");
	
	
	    if ($buaris = mysql_fetch_array($ambil))
		$ambil2 = mysql_query("select * from tbl_pangkat_golru where id_palru='".$buaris['id_palru']."'");
		$ambil3 = mysql_query("select * from tbl_jabatan where id_jabatan='".$buaris['id_jabatan']."'");
		echo "<b>Nama Pegawai Dinilai : ".$buaris['nama_pns']."<br> NIP : ".$nip."</b><br><br>";
	//======RIGHT=====
			
		$html .="<div style='float: right; alignment-adjust: middle; width: 30%; margin-bottom: 0pt; '>
				<b>II. PEGAWAI NEGERI SIPIL YANG DINILAI</b> <br>
				1. Nama		 : $buaris[nama_pns]<br>
				2. NIP     	 : $nip<br>";
	    if ($buarisz = mysql_fetch_array($ambil2))
		$html .="	3. Pangkat/golru : $buarisz[nama_palru]<br>";
	    if ($buariszs = mysql_fetch_array($ambil3))
		$html .="	4. Jabatan	 : $buariszs[nama_jabatan]<br>
				</div>";
	//===============
		$html .="<br><br><br><br><br><br><br><br>";
		$html .= "<center><table id='rounded-corner' summary='2007 Major IT Companies Profit' border=1>
   <tr align='center'>
    <th rowspan='2'>Tahun SKP</th>
    <!--<th rowspan='2'>Penilai</th>
    <th rowspan='2'>Dinilai</th>-->
    <th rowspan='2'>Tugas</th>
    <th colspan='5' align='center'>TARGET</th>


   </tr>  
   <tr> 
    <th>Kredit</th>
    <th>Kuantitas</th>
    <th>Kualitas</th>
    <th>Waktu</th>
    <th>Biaya</th>
   </tr>";
   
	while($row = mysql_fetch_array($hasil))
	{
           
		$html .= "<tr>";
		$html .= "<td>" .$row['tahun_skp']. "</td>";
		$html .= "<td>" .$row['tugas']. "</td>";
		$html .= "<td>" .$row['kredit']. "</td>";
                $html .= "<td>" .$row['kuantitas']. "</td>";
                $html .= "<td>" .$row['kualitas']. "</td>";
		$html .= "<td>" .$row['waktu']. "</td>";
	        $html .= "<td>" .$row['biaya']. "</td>";
		$html .= "</tr>";
	}
	 $tahun = $_GET['tahun_skp'];
	 $nip = $_GET['dinilai'];

	      
	mysql_free_result($result);
	$html .= "</table>";
	$html .="<br><br><br><br>";
	
		$html .="<div style='float: left; alignment-adjust: middle; width: 28%; margin-bottom: 0pt;'>
		Pejabat Penilai,<br><br><br><br><br>
		($row_get_penilai[nama_pns]) <br>
		NIP: $penilai</div> ";
		
		$html .="<div style='float: right; width: 28%; margin-bottom: 0pt;'><b>Blora, 31 Desember</b> $tahun<br>
		Pegawai Negeri Sipil Yang Dinilai,<br><br><br><br>
		($buaris[nama_pns]) <br>
		NIP: $nip </div>";

		
//==============================================================
//change your echo/print with $html.=""; to show in PDF view
//==============================================================


$mpdf=new mPDF('c','A4-L','','',15,15,27,25,16,13); 

$mpdf->mirrorMargins = 1; // Use different Odd/Even headers and footers and mirror margins
$mpdf->defaultheaderfontsize = 10; /* in pts */
$mpdf->defaultheaderfontstyle = B; /* blank, B, I, or BI */
$mpdf->defaultheaderline = 1; /* 1 to include line below header/above footer */
$mpdf->defaultfooterfontsize = 12; /* in pts */
$mpdf->defaultfooterfontstyle = B; /* blank, B, I, or BI */
$mpdf->defaultfooterline = 1; /* 1 to include line below header/above footer */
$mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}| Badan Kepegawaian Daerah Kabupaten Blora');
$mpdf->SetFooter('{PAGENO}'); /* defines footer for Odd and Even Pages - placed at Outer margin */
        $mpdf->SetFooter(array(
                'L' => array(
                'content' => 'Text to go on the left',
                'font-family' => 'sans-serif',
                'font-style' => 'B', /* blank, B, I, or BI */
                'font-size' => '10', /* in pts */
                ),
                'C' => array(
                'content' => '- {PAGENO} -',
                'font-family' => 'serif',
                'font-style' => 'BI',
                'font-size' => '18', /* gives default */
                ),
                'R' => array(
                'content' => 'Printed @ {DATE j-m-Y H:m}',
                'font-family' => 'monospace',
                'font-style' => '',
                'font-size' => '10',
                ),
                'line' => 1, /* 1 to include line below header/above footer */
                ), 'E' /* defines footer for Even Pages */
        );
$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

// LOAD a stylesheet
$stylesheet = file_get_contents('../ext/mpdf/examples/mpdfstyletables_form_skp.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);


$mpdf->Output('form_skp_'.$buaris['nama_pns'].'_'.$nip.'_tahun_'.$year.'.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>