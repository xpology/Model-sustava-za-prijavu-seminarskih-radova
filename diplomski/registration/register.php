<?php 
	include 'server.php'; 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registracija</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<a target="_blank" href="http://www.efos.unios.hr/informatika/">
	<img src="logo/efos-header-logo.png"></img>
	</a>
</head>
<body>
	<div class="header">
		<h2>Registracija</h2>
	</div>
	
	<form method="post" action="register.php">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Ime:</label>
			<input type="text" name="fname" placeholder="Unesite Vaše ime" value="<?php echo $fname; ?>">
		</div>
		<div class="input-group">
			<label>Prezime:</label>
			<input type="text" name="lname" placeholder="Unesite Vaše prezime" value="<?php echo $lname; ?>">
		</div>
		<div class="input-group">
			<label>Email:</label>
			<input type="email" name="email" placeholder="@efos.hr" value="<?php echo $email; ?>">
		</div>
		<div class="input-group">
			<label>Grupa: <a target="_blank" href="http://www.efos.unios.hr/wp-content/uploads/2013/03/Studenti-po-grupama-zima-2017.pdf">Provjerite koja ste grupa</a></label>
			<select required name="groups">
				 <option value="" disabled selected="">Odaberite Vašu grupu</option>
				 <option value="g1">g1</option>
				 <option value="g2">g2</option>
				 <option value="g3">g3</option>
				 <option value="g4">g4</option>
				 <option value="g5">g5</option>
				 <option value="g6">g6</option>
				 <option value="g7">g7</option>
			</select>
		</div>
				<div class="input-group">
			<label>Status:</label>
			<select required name="status">
				 <option value="" disabled selected="">Odaberite status</option>
				 <option value="Redovan">Redovan</option>
				 <option value="Izvanredan">Izvanredan</option>
			</select>
		</div>
		<div class="input-group">
			<label>Lozinka:</label>
			<input type="password" name="password_1" placeholder="Minimalno 6 znakova">
		</div>
		<div class="input-group">
			<label>Potvrdi lozinku:</label>
			<input type="password" name="password_2" placeholder="Ponovno unesite lozinku">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_user">Registriraj se</button>
		</div>
		<p>
			Već ste registrirani? <a href="login.php">Prijavite se</a>
		</p>
	</form>
</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>