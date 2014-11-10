<?php

$html = '
<h2 align="center">FORMULIR SASARAN KERJA<br>PEGAWAI NEGERI SIPIL</h2><br>

<table border="1">

    <tbody>
    
  <tr>
    <th>NO</th>
    <th colspan="2">I. PEJABAT PENILAI</th>
    <th>NO</th>
    <th colspan="3">II. PEGAWAI NEGERI SIPIL YANG DINILAI</th>
  </tr>
  <tr>
    <td>1<br>2<br>3<br>4<br>5</td>
    <td>Nama<br>NIP<br>Pangkat/Golru<br>Jabatan<br>Unit Kerja</td>
    <td>tbl_pns</td>
    <td>1<br>2<br>3<br>4<br>5</td>
    <td>Nama<br>NIP<br>Pangkat/Golru<br>Jabatan<br>Unit Kerja</td>
    <td colspan="2">tbl_pns</td>
  </tr>
  <tr>
    <td rowspan="2">NO</td>
    <td rowspan="2">III. Kegiatan Tugas Jabatan</td>
    <td rowspan="2">Angkat Kredit</td>
    <td colspan="4" align="center">TARGET</td>
  </tr>
  <tr>
    <td>Kuant/Output</td>
    <td>Kual/Mutu</td>
    <td>Waktu</td>
    <td>Biaya</td>
  </tr>
  <tr>
    <td>1<br>2<br>3<br>4<br>5<br></td>
    <td>tbl_form_skp</td>
    <td>tbl_form_skp</td> 
    <td>tbl_form_skp</td> 
    <td>tbl_form_skp</td> 
    <td>tbl_form_skp</td>
    <td>tbl_form_skp</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" align="center">Pejabat Penilai<br><br><br><br><br>Nama<br>NIP..tbl_pns..</td>
    <td></td>
    <td colspan="3" align="center">Blora, ...Januari 20..<br>Pegawai Negeri Sipil Yang Dinilai<br><br><br><br><br>Nama<br>NIP..tbl_pns...</td>
  
  </tr>
            
    </tbody>

</table>

';

//==============================================================
//==============================================================
//==============================================================
include("../mpdf.php");
//mPDF($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P')
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
$stylesheet = file_get_contents('mpdfstyletables.css');
$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html,2);

$mpdf->Output('mpdf.pdf','I');
exit;
//==============================================================
//==============================================================
//==============================================================


?>