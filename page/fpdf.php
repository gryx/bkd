<?php
require('../ext/fpdf/fpdf17/fpdf.php');

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}
function AmbilData(){
        //$pdf->AddPage();
        // Set some content to print
        $tbl_header = '<table border="1">';
        $tbl_kol    = '<tr align="center"><th>NIP</th><th>NAMA JABATAN</th></tr>';
        $tbl_footer = '</table>';
        $tbl ='';
    $conn = mysqli_connect("localhost","root","","bkd_rev");
    $hasil = mysqli_query ($conn,"select * from tbl_jabatan");

    while ($row = mysqli_fetch_array($hasil)) {
                        $id         = $row['id_jabatan'];
                        $najab      = $row['nama_jabatan'];

                        $tbl .= '<tr> 
                        <td>'.$id.'</td><td>'.$najab.'</tr>';
      } 

}

function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40, 35, 40, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
// Data loading
//$data = $pdf->LoadData('../ext/fpdf/fpdf17/tutorial/countries.txt');
$data = $pdf->AmbilData();
$pdf->SetFont('Arial','',14);

//$pdf->writeHTML($tbl_header . $tbl_kol . $tbl . $tbl_footer, true, false, false, false, '');
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>