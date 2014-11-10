<head>
<meta charset="utf-8">
<title>Penilaian Kinerja Pegawai BKD Blora</title>
<link rel="stylesheet" type="text/css" href="css/index.css" />
<script>
function bantuan()
{
alert("NIP should be Nomor Induk Pegawai, Password stored by Administrator, Please contact the Admin for forgotten password ");
}
</script>
</head>
	<?php

		error_reporting(0);
			$error = $_GET['error'];
	
			if ($error == 1) {
	?>
			<div class="error">Username dan Password belum diisi.</div>
			<?php }
			else if ($error == 2) {?>
				<div class="error">Username belum diisi.</div>
			<?php }
			else if ($error == 3) {?>
				<div class="error">Password belum diisi.</div>
			<?php }
			else if ($error == 4) {?>
				<div class="error">Username dan Password tidak valid ...</div>
			<?php }
			else if ($error == 5){?>
				<div class="error">Username dan Password tidak terdaftar ...</div>
			<?php }
			else if ($error == 6){?>
				<div class="error">Anda belum Login, Silahkan login terlebih dahulu ...!!</div>
	<?php
			}
	?>
<form action="nigol.php?op=in" method="post" >
  <h1>Login</h1>
  <div class="inset">
  <p>
    <label for="email">NIP</label>
    <input type="text" name="username" id="username" autocomplete="off">
  </p>
  <p>
    <label for="password">PASSWORD</label>
    <input type="password" name="password" id="password" autocomplete="off">
  </p>

  </div>
  <p class="p-container">
    <span><a href="#" onclick="bantuan()" >Petunjuk</a></span>
    <input type="submit" name="go" id="go" value="Log in">
  </p>
</form>
