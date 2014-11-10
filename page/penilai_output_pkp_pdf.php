<?php
session_start();
include ('../nigol.php');

	include "../koneksi.php";
	include("../ext/mpdf/mpdf.php");
	$html .= '<h2 align="center">PENILAIAN PRESTASI KERJA<br>PEGAWAI NEGERI SIPIL</h2><br>';
        $nip = $_GET['dinilai'];
	$year = $_GET['tahun_pkp'];
        /*$hasil2  = mysql_query("select * from tbl_form_skp where penilai=".$_SESSION['userid']."");
	  if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());

		
	if($row = mysql_fetch_array($hasil2))*/
	    $hasil  = mysql_query("select * from tbl_pkp where tahun_pkp=$year AND dinilai='".$nip."' ORDER BY tahun_pkp");	
	
	$ambil = mysql_query("select nama_pns from tbl_pns where nip='".$nip."'");
	    if ($buaris = mysql_fetch_array($ambil))
		$html .= "<b>Nama Pegawai Dinilai : ".$buaris['nama_pns']."<br> NIP : ".$nip."</b><br><br>";
		$html .="<br><br>";
	$html .= "<center><table id='rounded-corner' summary='2007 Major IT Companies Profit' border=1>
   <tr align='center'>
    <th rowspan='2'>Tahun PKP</th>
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
    <th>Orientasi Pelayanan</th>
    <th>Integritas</th>
    <th>Komitmen</th>
    <th>Disiplin</th>
    <th>Kerjasama</th>
    <th>Kepemimpinan</th>
   </tr>";
		
	while($row = mysql_fetch_array($hasil))
	{
		$html .= "<tr>";
		$html .= "<td>" .$row['tahun_pkp']. "</td>";
		$html .= "<td>" .$row['orientasi_pelayanan']. "</td>";
		$html .= "<td>" .$row['integritas']. "</td>";
                $html .= "<td>" .$row['komitmen']. "</td>";
                $html .= "<td>" .$row['disiplin']. "</td>";
		$html .= "<td>" .$row['kerjasama']. "</td>";
	        $html .= "<td>" .$row['kepemimpinan']. "</td>";
		$html .= "<td>" .$row['jumlah']. "</td>";
	        if ($row['nilai_rata'] > 91) 
				 $html .= "<td>" .$row['nilai_rata']." (Sangat Baik) </td>";
			 elseif ($row['nilai_rata'] >76 && $row['nilai_rata'] <90)
				 $html .= "<td>" .$row['nilai_rata']. " (Baik) </td>";
			 elseif ($row['nilai_rata'] >61 && $row['nilai_rata'] <75)
				 $html .= "<td>" .$row['nilai_rata']. " (Cukup)</td>";
			 elseif ($row['nilai_rata'] >51 && $row['nilai_rata'] <60)
				 $html .= "<td>" .$row['nilai_rata']. " (Kurang)</td>";
			 elseif ($row['nilai_capaian_skp'] <50)
				 $html .= "<td>" .$row['nilai_rata']. " (Buruk)</td>";
	        $html .= "<td>" .$row['nilai_pkp']. "</td>";
		$html .= "<td>" .$row['tanggapan']. "</td>";
		$html .= "<td>" .$row['keputusan']. "</td>";
		$html .= "<td>" .$row['rekomendasi']. "</td>";
		$html .= "<td>" .$row['tgl_penilaian_pkp']. "</td>";
		$html .= "</tr>";
	}
	      
	mysql_free_result($result);
	$html .= "</table>";
		$html .="<br><br><br><br><br><br>";
		$html .="<b>Blora, 31 Desember</b> $year<br>";
		$html .="Pejabat Penilai,<br><br><br>";
		$html .="$_SESSION[name] <br>";
		$html .="NIP: $_SESSION[userid] <br>";


//==============================================================
//change your $html .=/print with $html.=""; to show in PDF view
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
$stylesheet = file_get_contents('../ext/mpdf/examples/mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('pkp_'.$buaris['nama_pns'].'_'.$nip.'_tahun_'.$year.'.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>