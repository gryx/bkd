<?php
session_start();
include ('../nigol.php');

	include "../koneksi.php";
	include("../ext/mpdf/mpdf.php");
	$html .= '<h2 align="center">PENILAIAN PRESTASI KERJA<br>PEGAWAI NEGERI SIPIL YANG MELAKSANAKAN TUGAS BELAJAR</h2><br>';
	//======LEFT=====
        $nip = $_GET['dinilai'];
	$year = $_GET['tahun_pkp'];
        /*$hasil2  = mysql_query("select * from tbl_form_skp where penilai=".$_SESSION['userid']."");
	if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());
	if($row = mysql_fetch_array($hasil2))*/
	    $hasil  = mysql_query("select * from tbl_pkp where tahun_pkp=$year AND dinilai='".$nip."' ORDER BY tahun_pkp");
		$html .="<div style='float: left; alignment-adjust: middle; width: 50%; margin-bottom: 0pt;'>
		BADAN KEPEGAWAIAN DAERAH  <br><br><br><br>
				<b>I. PEJABAT PENILAI </b> <br>
					a. Nama		  	<br>
					b. NIP     	  	<br>
					c. Pangkat/golru  	<br>
					d. Jabatan	  	<br>
					e. Unit Organisasi	<br><br>
				<b>YANG DINILAI </b> <br>
					a. Nama		  	<br>
					b. NIP     	  	<br>
					c. Pangkat/golru  	<br>
					d. Jabatan	  	<br>
					e. Unit Organisasi	<br><br>
				<b>ATASAN PEJABAT PENILAI </b> <br>
					a. Nama		  	<br>
					b. NIP     	  	<br>
					c. Pangkat/golru  	<br>
					d. Jabatan	  	<br>
					e. Unit Organisasi	<br><br><br><br>
				<b>UNSUR YANG DINILAI </b> <br><br>
					a. <i>Perilaku Kerja</i>  	<br><br>
						&nbsp;&nbsp;&nbsp;1. Orientasi Pelayanan  <br>
						&nbsp;&nbsp;&nbsp;2. Integritas  	<br>
						&nbsp;&nbsp;&nbsp;3. Komitmen	  	<br>
						&nbsp;&nbsp;&nbsp;4. Disiplin		<br>
						&nbsp;&nbsp;&nbsp;5. Kerjasama		<br>
						&nbsp;&nbsp;&nbsp;6. Kepemimpinan	<br><br>
						&nbsp;&nbsp;&nbsp;Jumlah		<br>
						&nbsp;&nbsp;&nbsp;Nilai Rata-rata	<br>
						&nbsp;&nbsp;&nbsp;Nilai Perilaku Kerja(40%)	<br>
					<br><br><br><br>";
			while($rowt = mysql_fetch_array($hasil)){		
			$html .="	<b>TANGGAPAN PEJABAT PENILAI ATAS KEBERATAN </b><br>";
			$html .="	$rowt[tanggapan]<br>";
			$html .="		<br><br><br><br><br>
					<b>KEPUTUSAN ATASAN PEJABAT PENILAI ATAS KEBERATAN </b><br>";
			$html .="	$rowt[keputusan]<br>";
			$html .="		<br><br><br><br><br><br><br><br><br>
					<b>REKOMENDASI </b><br>";
			$html .="	$rowt[rekomendasi]<br>";}
			$html .="		<br><br><br><br><br>";
                $hasil  = mysql_query("select a.kode, a.nama_jabatan, b.nama_palru from tbl_jabatan a, tbl_pangkat_golru b
				where a.id_jabatan=".$_SESSION['jab']." AND b.id_palru=".$_SESSION['pal']."");
		if($row = mysql_fetch_array($hasil))
		$hasil_lagi  = mysql_query("select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
			       from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
			       where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan AND b.kode='".$row['kode']."' AND a.level='penilai' ORDER BY a.level");
		if($rowza = mysql_fetch_array($hasil_lagi))
			$html .="Dibuat Tanggal, 31 Desember $year<br>
					Pejabat Penilai,<br><br><br><br>
					<u>$rowza[nama_pns]</u><br>NIP: $rowza[nip]";
			$html .="	</div>";
	//===============
	
        $nip = $_GET['dinilai'];
	$year = $_GET['tahun_pkp'];
        /*$hasil2  = mysql_query("select * from tbl_form_skp where penilai=".$_SESSION['userid']."");
	if (!$hasil2)
		die("Gagal Query data karena : ".mysql_error());
	if($row = mysql_fetch_array($hasil2))*/
	    $hasilnya  = mysql_query("select * from tbl_pkp where tahun_pkp=$year AND dinilai='".$nip."' ORDER BY tahun_pkp");	
	
	$ambil = mysql_query("select * from tbl_pns where nip='".$nip."'");
	    if ($buaris = mysql_fetch_array($ambil))
	    	$ambil2 = mysql_query("select * from tbl_pangkat_golru where id_palru='".$buaris['id_palru']."'");
		$ambil3 = mysql_query("select * from tbl_jabatan where id_jabatan='".$buaris['id_jabatan']."'");
		
	//======RIGHT=====
		$html .="<div style='float: right; alignment-adjust: middle; width: 40%; margin-bottom: 0pt;'>
		JANGKA WAKTU PENILAIAN<br>1 JANUARI $year s.d. 31 DESEMBER $year  <br><br>";
		$golru  = mysql_query("select a.kode2, a.nama_jabatan, b.nama_palru from tbl_jabatan a, tbl_pangkat_golru b
					where a.id_jabatan=".$_SESSION['jab']." AND b.id_palru=".$_SESSION['pal']."");
		if($roww = mysql_fetch_array($golru))
                

		//PENILAI
		$html .="	 	<br>
					$rowza[nama_pns]		<br>
					$rowza[nip]  	<br>
					$rowza[nama_palru]  	<br>
					$rowza[nama_jabatan]	<br>
						<br><br>";
                                                
		//DINILAI
		$html .="		<br>
					$buaris[nama_pns]  	<br>
					$nip     	  	<br>";
		if ($buarisz = mysql_fetch_array($ambil2))
		$html .="		$buarisz[nama_palru]  	<br>";
		if ($buariszs = mysql_fetch_array($ambil3))
		$html .="		$buariszs[nama_jabatan]	  	<br>";
		$html .="			<br><br>";
                
		//ATASAN PENILAI
		$hasil_lagi  = mysql_query("select a.nip, a.nama_pns, c.nama_palru, b.nama_jabatan, a.unit_kerja, a.jekel, a.tmt, a.level
			       from tbl_pns a, tbl_jabatan b, tbl_pangkat_golru c
			       where a.id_palru=c.id_palru AND a.id_jabatan=b.id_jabatan AND b.kode='".$roww['kode2']."' AND a.level='atasan' ORDER BY a.level");
		if($rowz = mysql_fetch_array($hasil_lagi))
		$html .="		<br>
					$rowz[nama_pns]		<br>
					$rowz[nip]     	  	<br>
					$rowz[nama_palru]  	<br>
					$rowz[nama_jabatan]	<br>
						<br><br>
		<br><br><br><br><br><br>";
		while($row = mysql_fetch_array($hasilnya)){
		$html .="			&nbsp;&nbsp;&nbsp;$row[orientasi_pelayanan]  	<br>
						&nbsp;&nbsp;&nbsp;$row[integritas] 		<br>
						&nbsp;&nbsp;&nbsp;$row[komitmen]	  	<br>
						&nbsp;&nbsp;&nbsp;$row[disiplin]		<br>
						&nbsp;&nbsp;&nbsp;$row[kerjasama]		<br>
						&nbsp;&nbsp;&nbsp;$row[kepemimpinan]		<br><br>
						&nbsp;&nbsp;&nbsp;$row[jumlah]			<br>";
		if ($row[nilai_rata] > 91)
			$html .="		&nbsp;&nbsp;&nbsp;$row[nilai_rata] (Sangat Baik)<br>";
		elseif ($row[nilai_rata] > 76 && $row[nilai_rata] < 90)
			$html .="		&nbsp;&nbsp;&nbsp;$row[nilai_rata] (Baik)<br>";
		elseif ($row[nilai_rata] > 61 && $row[nilai_rata] < 75)
			$html .="		&nbsp;&nbsp;&nbsp;$row[nilai_rata] (Cukup)<br>";
		elseif ($row[nilai_rata] > 51 && $row[nilai_rata] < 60)
			$html .="		&nbsp;&nbsp;&nbsp;$row[nilai_rata] (Kurang)<br>";
		elseif ($row[nilai_rata] < 50)
			$html .="		&nbsp;&nbsp;&nbsp;$row[nilai_rata] (Buruk)<br>";
			
			
			$html .="			&nbsp;&nbsp;&nbsp;($row[nilai_pkp])	<br><br><br>";
		}
		$html .="		<b></b><br>
						<br><br>&nbsp;&nbsp;<br><br>&nbsp;&nbsp;<br>&nbsp;<br>
						
					<br><br><br>Tanggal, .............................<br>";
		$html .="		<b></b><br>
						<br><br>&nbsp;&nbsp;<br><br>&nbsp;&nbsp;<br>
						
					<br><br><br>Tanggal, .............................<br><br><br><br><br><br><br><br><br><br>";
		$html .="Diterima Tanggal, .... ,.................. $year<br>
					Pegawai Negeri Sipil Yang Dinilai,<br><br><br><br>
					<u>$buaris[nama_pns]</u><br>NIP: $nip<br><br><br><br><br><br>";
		$html .="Diterima Tanggal, .... ,.................. $year<br>
					Atasan Pejabat Penilai,<br><br><br><br>
					<u>$rowz[nama_pns]</u><br>NIP: $rowz[nip]";
		$html .="</div>";
		
		
	//===============
	
        $html .="<div style='alignment-adjust: middle; width: 100%; margin-bottom: 0pt;'><br><br><br><br><br><br><br>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><center>TABEL LAPORAN PENILAIAN KERJA</div>";
        $html .="<center><table id='rounded-corner' summary='2007 Major IT Companies Profit' border=1>
  <tr>
    <th align='center'>NO</th>
    <th  colspan='2' align='center'>PEJABAT PENILAI</th>
    <th  colspan='2' align='center'>PEGAWAI NEGERI SIPIL YANG DINILAI</th>
  </tr>
  <tr>
    <td align='center'>1</td>
    <td >Nama</td>
    <td >$rowza[nama_pns]</td>
    <td >Nama</td>
    <td >$buaris[nama_pns]</td>
  </tr>
  <tr>
    <td align='center'>2</td>
    <td >NIP</td>
    <td >$rowza[nip]</td>
    <td >NIP</td>
    <td >$nip</td>
  </tr>
  <tr>
    <td align='center'>3</td>
    <td >Pangkat</td>
    <td >$rowza[nama_palru]</td>
    <td >Pangkat</td>
    <td >$buarisz[nama_palru]</td>
  </tr>
  <tr>
    <td align='center'>4</td>
    <td >Jabatan</td>
    <td >$rowza[nama_jabatan]</td>
    <td >Jabatan</td>
    <td >$buariszs[nama_jabatan]</td>
  </tr>
  <tr>
    <td align='center'>5</td>
    <td >Unit Kerja</td>
    <td ></td>
    <td >Unit Kerja</td>
    <td ></td>
  </tr>
  <tr>
    <th align='center'>NO</th>
    <th  colspan='2' align='center'>UNSUR PENILAIAN</th>
    <th  colspan='2' align='center'>NILAI CAPAIAN</th>
  </tr>";
  $pk_skp  = mysql_query("select sum(nilai_capaian_skp)/count(tahun_skp)*0.6 AS NilaiSKP from tbl_form_skp where tahun_skp=$year AND dinilai='".$nip."'");
  if($row_pk_skp = mysql_fetch_array($pk_skp))
  $html .="<tr>
    <td align='center'>1</td>
    <td  colspan='2'>Penilaian Sasaran Kerja (60%)</td>
    <td  colspan='2'>$row_pk_skp[NilaiSKP]</td>
  </tr>";
  $pk_pkp  = mysql_query("select * from tbl_pkp where tahun_pkp=$year AND dinilai='".$nip."' ORDER BY tahun_pkp");
  if($row_pk_pkp = mysql_fetch_array($pk_pkp))
  $html .="<tr>
    <td align='center'>2</td>
    <td  colspan='2'>Penilaian Perilaku Kerja (40%)</td>
    <td  colspan='2'>$row_pk_pkp[nilai_pkp]</td>
  </tr>";
  $hasile = $row_pk_skp['NilaiSKP']+$row_pk_pkp['nilai_pkp'];
  $html .="<tr>
    <td align='center'>3</td>
    <td  colspan='2'>Penilaian Kinerja</td>
    <td  colspan='2'>$hasile</td>
  </tr>";
  
  $html .="<tr>
    <th align='center'>NO</th>
    <th  colspan='2'>REWARD/PUNISHMENT</th>
    <th  colspan='2'>JENIS REWARD/PUNISHMENT</th>
  </tr>";
  if ($hasile > 50){
  $html .="<tr>
    <td align='center'>1</td>
    <td  colspan='2'>Reward</td>
    <td  colspan='2'><input type='checkbox' name='QPC' value='OFF'> Pengevaluasian kenaikan pangkat<br>
                    <input type='checkbox' name='QPC' value='ON'> Penempatan dalam jabatan<br>
                    <input type='checkbox' name='QPC' value='ON'> Pemindahan<br>
                    <input type='checkbox' name='QPC' value='ON'> Pendidikan dan Pelatihan<br>
                    <input type='checkbox' name='QPC' value='ON'> Tugas Belajar<br>
                    <input type='checkbox' name='QPC' value='ON'> Kenaikan gaji berkala<br>
                    <input type='checkbox' name='QPC' value='ON'> dan lain-lain<br>
    </td>
  </tr>";}
  
  elseif ($hasile > 25 && $hasile < 50){
  $html .="<tr>
    <td align='center'>1</td>
    <td  colspan='2'>Punishment 25-50</td>
    <td  colspan='2'><input type='checkbox' name='QPC' value='OFF'> Penundaan kenaikan gaji berkala selama 1 tahun<br>
                    <input type='checkbox' name='QPC' value='ON'> Penundaan kenaikan pangkat selama 1 tahun<br>
                    <input type='checkbox' name='QPC' value='ON'> penurunan pengkat setingkat lebih rendah selama 1 tahun<br></td>
  </tr>";}
  
  elseif ($hasile < 25){
  $html .="<tr>
    <td align='center'>1</td>
    <td  colspan='2'>Punishment < 25</td>
    <td  colspan='2'><input type='checkbox' name='QPC' value='OFF'> Penurunan pangkat setingkat lebih rendah selama 3 tahun<br>
                    <input type='checkbox' name='QPC' value='ON'> Pemindahan dalam rangka penurunan pangkat setingkat lebih rendah<br>
                    <input type='checkbox' name='QPC' value='ON'> Pembebasan dari jabatan<br>
                    <input type='checkbox' name='QPC' value='ON'> Pemberhentain dengan hormat atas permintaan sendiri sebagai PNS<br>
                    <input type='checkbox' name='QPC' value='ON'> Pemberhentain dengan tidak hormat sebagai PNS<br>
    </td>
  </tr>";}
  
  $html .="<tr>
    <td align='center'>Keterangan</td>
    <td  colspan='4'><br><br><br><br><br><br><br><br></td>
  </tr>
</table></center>";

		/*$html .="<br><br><br><br><br><br><br><br>";
		$html .="<b>Blora, 31 Desember</b> $year<br>";
		$html .="Pejabat Penilai,<br><br><br>";
		$html .="$_SESSION[name] <br>";
		$html .="NIP: $_SESSION[userid] <br>";*/


//==============================================================
//change your $html .=/print with $html.=""; to show in PDF view
//==============================================================


$mpdf=new mPDF('c','A4','','',15,15,27,25,16,13); 

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
                'content' => '',
                'font-family' => 'sans-serif',
                'font-style' => 'B', /* blank, B, I, or BI */
                'font-size' => '10', /* in pts */
                ),
                'C' => array(
                //'content' => '- {PAGENO} -',
                'font-family' => 'serif',
                'font-style' => 'BI',
                'font-size' => '15', /* gives default */
                ),
                'R' => array(
                'content' => 'Dicetak pada tanggal @ {DATE j-m-Y H:m}',
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