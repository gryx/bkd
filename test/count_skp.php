
<?php
if (isset($_POST['calc']))
{
//target
$a=$_POST['aa'];
$b=$_POST['bb'];
$c=$_POST['cc'];
$d=$_POST['dd'];
//realisasi
$e=$_POST['a'];
$f=$_POST['b'];
$g=$_POST['c'];
$h=$_POST['d'];

//$count = ($a!=''?1:0) + ($b!=''?1:0) + ($c!=''?1:0) + ($d!=''?1:0)
//		+($e!=''?1:0) + ($f!=''?1:0) + ($g!=''?1:0) + ($h!=''?1:0);
//$nilai = ((($e/$a)*100)+(($f/$b)*100)+((1.76*$c-$g)/$c*100)+((1.76*$d-$h)/$d*100))/$count;

$kual = @($e/$a)*100;
$kuan = @($f/$b)*100;
//'@' symbol for disable warning divide by zero
$wak  = @((1.76*$c-$g)/$c)*100;
$bia  = @((1.76*$d-$h)/$d)*100;
$count = @($kual!=''?1:0) + ($kuan!=''?1:0) + ($wak!=''?1:0) + ($bia!=''?1:0);
$nilai = ($kual+$kuan+$wak+$bia)/$count;

 function ket(){
 	if ($nilai > 80)
 		echo "Sangat Baik";
 }

//echo "Hasil :".$nilai."(".ket().")";
echo "Hasil :".$nilai;
if ($nilai > 91) 
	echo " (Sangat Baik) <br>";
elseif ($nilai >76 && $nilai <90)
	echo " (Baik) <br>";
elseif ($nilai >61 && $nilai <75)
	echo " (Cukup) <br>";
elseif ($nilai >51 && $nilai <60)
	echo " (Kurang) <br>";
elseif ($nilai <50)
	echo " (Buruk) <br>";

echo "<a href='count_skp.php'>hitung lagi</a>";
}
?>

<form id="rata" name="form1" method="post" action="count_skp.php"> <pre>
Kuantitas	<input name="aa" type="text" id="aa" size="3" maxlength="4" /><br />
Kualitas	<input name="bb" type="text" id="bb" size="3" maxlength="3" /><br />
Waktu		<input name="cc" type="text" id="cc" size="2" maxlength="2" /><br />
Biaya		<input name="dd" type="text" id="dd" size="3" maxlength="4" /><br />

Kuantitas_real	<input name="a" type="text" id="a" size="3" maxlength="4" /><br />
Kualitas_real	<input name="b" type="text" id="b" size="3" maxlength="3" /><br />
Waktu_real		<input name="c" type="text" id="c" size="2" maxlength="2" /><br />
Biaya_real		<input name="d" type="text" id="d" size="3" maxlength="4" /><br />
<br />
<input name="calc" type="submit" id="calc" value="Hitung"/><br /><br /></pre>
</form>