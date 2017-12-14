<?php 
	include_once 'configuration.php';

	//PROVJERI JE LI KORISNIK PRIJAVLJEN, AKO NIJE - PREUSMJERI NA STRANICU ZA LOGIRANJE
	if (!isset($_SESSION['email'])) {
		header('location: login.php');
	}

	//PROVJERI JE LI SE KORISNIK ODJAVIO, AKO JE - PREUSMJERI NA STRANICU ZA LOGIRANJE
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['email']);
		header("location: login.php");
	}

	//TRENUTNI KORISNIK
	$email = $_SESSION['email'];

	$query = $con->prepare("SELECT fname, lname
							FROM users
							WHERE id = :currentUserId");
	$query->bindParam(":currentUserId", $_SESSION["id"]);
	$query->execute();
	$name = $query->fetch(PDO::FETCH_OBJ);

	//SVI OSIM TRENUTNOG KORISNIKA I KORISNIKA KOJI SU VEĆ U TIMOVIMA
	$query = $con->prepare("SELECT * FROM users 
							WHERE id NOT IN (SELECT DISTINCT userid FROM teammembers) 
							AND email != :email
							ORDER BY lname");
	$query->bindParam(":email", $email);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);

	//MAKSIMALNI BROJ ČLANOVA
	$query = $con->prepare("SELECT value 
							FROM settings 
							WHERE name = 'maxTeamMembers'");
	$query->execute();
	$maxTeamMembers = $query->fetch(PDO::FETCH_OBJ);

	//GRUPA TRENUTNOG KORISNIKA
	$query = $con->prepare("SELECT groups
							FROM users
							WHERE id = :currentUserId");
	$query->bindParam(":currentUserId", $_SESSION["id"]);
	$query->execute();
	$groups = $query->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Prijavljivanje timova</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="topnav" id="myTopnav">
	  <a href="home.php">Početna</a>
	  <a class="active" href="teams.php">Kreirajte tim</a>
	  <a href="topics.php">Odaberite temu</a>
	  <a href="dates.php">Odaberite termin izlaganja</a>
	  <?php  if (isset($_SESSION['email'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="teams.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header" style="width: 700px;">
		<h2>Kreiranje timova</h2>
		<p>Odaberite još <?php echo $maxTeamMembers->value - 1;?> člana iz svoje grupe (<?php echo $groups->groups ?>)</p>
	</div>

	<div class="content" style="width: 700px;">
		<p>Za više informacija o seminaru pogledajte <a target="_blank" href="http://www.efos.unios.hr/informatika/seminari/"><b>ovdje</b></a>.</p>
	</div>

<!-- ISPIS IMENA IZ BAZE -->
<div class="content" style="width: 700px;">
	<div class="input-group">
		<label for="teamname"><b>Ime tima:</b></label>
		<input type="text" placeholder="Unesite naziv Vašeg tima" class="js-TeamName" name="teamname" id="teamname" />
	</div>
	<br>
	<br>

	<table>
	<tr>
		<th style="text-align: center;">#</th>
		<th>Student</th>
		<th>Email</th>
		<th>Grupa</th>
		<th style="text-align: center;">Odaberi</th>
	</tr>

	<?php foreach ($results as $result) {
		if ($result->groups == $groups->groups) {
		?>
		<tr>
			<td> </td>
			<td><?php echo $result->lname; echo " "; echo $result->fname;?></td>
			<td><?php echo $result->email;?></td>
			<td style="text-align: center;"><?php echo $result->groups;?></td>
			<td style="text-align: center;"><input type='checkbox' name='checkbox' id="<?php echo $result->id;?>" class='js-Checkbox' /></td>
		</tr>
	<?php
	 		}
	 	} 
	?>
	</table>
	<button type='submit' class='btn input-group js-CreateTeam' name='make_team'>Kreiraj tim</button>
</div>

<script>
	var maxTeamMembers = parseInt(<?php echo $maxTeamMembers->value-1;?>);
</script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/ChooseTeam.js"></script>
</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>