<?php
        function db(){ 
        $conn = mysql_connect('localhost','root', '') or die("Cannot connect to the database server now". mysql_error());
        
        mysql_select_db('bkd_rev',$conn) or die("Error in selecting database now ".mysql_errno());
          return $conn;  
        }
			function hasil(){
				$conn = db();
					
						$q1  = mysql_query("select sum(nilai_capaian_skp)/count(tahun_skp)*0.6 AS Nilai_SKP from tbl_form_skp where tahun_skp=".$_POST['tahun_skp']." AND dinilai='197411222008011004'");
						if (!$q1)
							die("Gagal Query data karena : ".mysql_error());

							if($row = mysql_fetch_array($q1))
							echo "Nilai SKP : ".$row['Nilai_SKP']."<br>";

						$q2  = mysql_query("select nilai_pkp AS Nilai_PKP from tbl_pkp where tahun_pkp=".$_POST['tahun_skp']." AND dinilai='197411222008011004'");	
						if (!$q2)
							die("Gagal Query data karena : ".mysql_error());

							if($rowz = mysql_fetch_array($q2))
							echo "Nilai SKP : ".$rowz['Nilai_PKP'];

						$nilai_pk = $row['Nilai_SKP']+$rowz['Nilai_PKP'];

						echo "<br>";echo "<br>";echo "<br>";
						echo "NILAI PK: ".$nilai_pk;echo "<br>";echo "<br>";

						if ($nilai_pk >25 && $nilai_pk <50)
							echo "<h3 style='color=red'>Punishment :</h3> <br>1. Penundaan Kenaikan Gaji Selama 1 Tahun<br>
						                           2. Penundaan Kenaikan Pangkat Selama 1 Tahun<br>
						                           3. Penurunan Pangkat Setingkat Lebih Rendah Selama 1 Tahun<br>";
					    elseif ($nilai_pk < 25)
							echo "<h3 style='color=red'>Punishment :</h3> <br>1. Penurunan Pangkat Setingkat Lebih Rendah Selama 3 Tahun<br>
						                           2. Pemindahan dalam rangka penurunan pangkat setingkat lebih rendah<br>
						                           3. Pembebasan dari jabatan<br>
						                           4. Pemberhendtian dengan hormat atas permintaan sendiri sebagai PNS<br>
						                           5. Pemberhentian tidak dengan hormat sebagai PNS";
						elseif ($nilai_pk > 50)
							echo "<h3 style='color=green'>Reward :</h3> <br>    1. Kenaikan Pangkat<br>
						                           2. Penempatan dalam jabatan<br>
						                           3. Pemindahan<br>
						                           4. Pendidikan dan pelatihan<br>
						                           5. Tugas belajar<br>
						                           6. Kenaikan Gaji Berkala<br>
						                           7. Lain-lain";

			}
?>


<form method="post" name="form_input" onsubmit="return hasil()">
	<select class="reqname" name="tahun_skp" >
							<option value="#">=== Pilih Tahun ===</option>
							<option value="2014">2014</option>
						    <option value="2015">2015</option>
							<option value="2016">2016</option>
	</select>
	<input type="submit" name="hasil" value="Post"/>
</form>

<?php echo hasil(); ?>
