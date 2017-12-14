<?php 
	include 'server.php'; 

	if (!isset($_SESSION['username'])) {
		header('location: loginAdmin.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: loginAdmin.php");
	}

	$query = $con->prepare("SELECT fname, lname
							FROM admins
							WHERE id = :currentUserId");
	$query->bindParam(":currentUserId", $_SESSION["id"]);
	$query->execute();
	$name = $query->fetch(PDO::FETCH_OBJ);

	//SVI ADMINISTRATORI OSIM PRVOG
	$query = "SELECT * FROM admins WHERE id != 1 ORDER BY lname";
	$result = mysqli_query($db,$query)or die(mysqli_error());

	//SKRIVENI ADMINISTRATOR
	$query = $con->prepare("SELECT * FROM admins WHERE id = 1");
	$query->execute();
	$admin = $query->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Administratori</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="topnav" id="myTopnav">
	  <a href="topicAdmin.php">Teme</a>
	  <a href="datesAdmin.php">Termini</a>
	  <a href="usersAdmin.php">Studenti</a>
	  <a href="settingsAdmin.php">Postavke</a>
	  <a class="active" href="registerAdmin.php">Admin</a>
	  <?php  if (isset($_SESSION['username'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="registerAdmin.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header-admin" style="width: 550px;">
		<h2>Registracija administratora</h2>
	</div>


	<form method="post" action="registerAdmin.php" style="width: 550px;">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Ime:</label>
			<input type="text" name="fname" placeholder="Unesite ime" value="<?php echo $fname; ?>">
		</div>
		<div class="input-group">
			<label>Prezime:</label>
			<input type="text" name="lname" placeholder="Unesite prezime" value="<?php echo $lname; ?>">
		</div>
		<div class="input-group">
			<label>Korisničko ime:</label>
			<input type="text" name="username" placeholder="Unesite željeno korisničko ime" value="<?php echo $username; ?>">
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
			<button type="submit" class="btn" name="reg_admin">Registriraj</button>
		</div>

	</form>

<!-- SVI ADMINISTRATORI -->
	<div class="content" style="width: 550px;">
	<p><h2 align="center">Administratori</h2></p><br>
	<p align="center">NAPOMENA: <i>"<?php echo $admin->username; ?>" skriveni je administrator iz sigurnosnih razloga kako bi se spriječilo brisanje svih administratora.</i></p><br>

	<form name="admins" action="registerAdmin.php" method="post" style="display: table; background: transparent; border-color: transparent; padding: 1px;">
	
		<table>
			<tr>
				<th style="text-align: center;">#</th>
				<th>Prezime</th>
				<th>Ime</th>
				<th>Korisničko ime</th>
				<th style="text-align: center;">Odaberi</th>
			</tr>

		<?php while($row = mysqli_fetch_array($result)) { ?>
		    <tr>
		   		<td> </td>
		   		<td> <?php echo $row["lname"]; ?> </td>
		    	<td> <?php echo $row["fname"]; ?> </td>
		    	<td> <?php echo $row["username"]; ?> </td>
		    	<td style="text-align: center;"> <input type="checkbox" name="admins[]" value="<?php echo $row["id"]; ?>" /> </td>
		    </tr>
		<?php } ?>

		</table>

	<div class="input-group">
	<button type="submit" class="delbtn" name="del_admin" onclick="return confirm('Sigurno želite obrisati odabranog administratora?')">Ukloni</button>
	</div>

	</form>

</div>

<!-- AŽURIRANJE ADMINISTRATORA -->
<div class="content" style="width: 550px;">
	<p><h2 align="center">Ažuriranje skrivenog administratora</h2></p><br>

	<p><b>Trenutno korisničko ime:</b> <?php echo $admin->username; ?> </p>

	<form method="post" action="registerAdmin.php" style="width: 500px; border: none;">

		<div class="input-group">
			<label>Novo Korisničko ime:</label>
			<input type="text" name="username" placeholder="Unesite novo korisničko ime" value="<?php echo $username; ?>">
		</div>
		<div class="input-group">
			<label>Stara lozinka:</label>
			<input type="password" name="password_old" placeholder="Unesite staru lozinku">
		</div>
		<div class="input-group">
			<label>Nova lozinka:</label>
			<input type="password" name="password_1" placeholder="Minimalno 6 znakova">
		</div>
		<div class="input-group">
			<label>Potvrdi novu lozinku:</label>
			<input type="password" name="password_2" placeholder="Ponovno unesite novu lozinku">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="update_admin">Ažuriraj</button>
		</div>

	</form>
		

</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/ToggleAll.js"></script>

</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>