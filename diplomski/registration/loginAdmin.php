<?php 
	include 'server.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<a target="_blank" href="http://www.efos.unios.hr/informatika/">
	<img src="logo/efos-header-logo.png"></img>
	</a>
	<a style= "float: right;" href="login.php">
	<img src="logo/user-logo.png"></img>
	</a>
</head>
<body>

	<div class="header-admin">
		<h2>ADMIN</h2>
	</div>
	
	<form method="post" action="loginAdmin.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Korisničko ime:</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group">
			<label>Lozinka:</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_admin">Prijava</button>
		</div>

	</form>


</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>