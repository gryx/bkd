<?php
        require_once('../ext/tcpdf/examples/lang/eng.php');
        require_once('../ext/tcpdf/tcpdf.php');
        // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('BKD');
            $pdf->SetTitle('PDF');
            $pdf->SetSubject('PDF');
            $pdf->SetKeywords('PDF');
        // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        //set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        //set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        //set some language-dependent strings
            $pdf->setLanguageArray($l);
        // ---------------------------------------------------------
        // set default font subsetting mode
            $pdf->setFontSubsetting(true);
        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
            $pdf->SetFont('dejavusans', '', 6, '', true);
        // Add a page
        // This method has several options, check the source code documentation for more information.
            $pdf->AddPage();
        // Set some content to print
        $tbl_header = '<table border="1">';
        $tbl_kol    = '<tr align="center"><th>NIP</th><th>NAMA</th><th>PANGKAT, GOLONGAN/RUANG</th><th>JABATAN</th>
                       <th>UNIT KERJA</th><th>JENIS KELAMIN</th><th>TMT</th><th>LEVEL</th></tr>';
        $tbl_footer = '</table>';
        $tbl ='';
        $con=mysqli_connect("localhost","root","","bkd_rev");
        // Check connection
	               
         $sql = "select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
                from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
                where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan ORDER BY a.level";                       
        $result = mysqli_query($con,$sql);
        
        if($result === FALSE) {
            die(mysqli_error());
        }
        
        while($row = mysqli_fetch_array($result))
        {
                        $id         = $row['nip'];
                        $nama_pns   = $row['nama_pns'];
                        $naru       = $row['nama_palru'];
                        $najab      = $row['nama_jabatan'];
                        $uker       = $row['unit_kerja'];;
                        $jekel      = $row['jekel'];
                        $tmt        = $row['tmt'];
                        $lev        = $row['level'];
                        
                $tbl .= '<tr> 
                        <td>'.$id.'</td><td>'.$nama_pns.'</td><td>'.$naru.'</td><td>'.$najab.'</td>
                        <td>'.$uker.'</td><td>'.$jekel.'</td><td>'.$tmt.'</td><td>'.$lev.'</td>
                        </tr>';
        }
        // Print text using writeHTMLCell()
            $pdf->writeHTML($tbl_header . $tbl_kol . $tbl . $tbl_footer, true, false, false, false, '');
        // ---------------------------------------------------------
        // Close and output PDF document
            $pdf->Output('print.pdf', 'I');

?>