<?php 
	include 'server.php'; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Prijava</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<a target="_blank" href="http://www.efos.unios.hr/informatika/">
	<img src="logo/efos-header-logo.png"></img>
	</a>
	<a style= "float: right;" href="loginAdmin.php">
	<img src="logo/admin-logo.png"></img>
	</a>
</head>
<body>

	<div class="header">
		<h2>Prijava</h2>
	</div>
	
	<form method="post" action="login.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Email:</label>
			<input type="text" name="email" >
		</div>
		<div class="input-group">
			<label>Lozinka:</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_user">Prijava</button>
		</div>
		<p>
			Još niste registrirani? <a href="register.php">Registrirajte se</a>
		</p>
	</form>


</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>