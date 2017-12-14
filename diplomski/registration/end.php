<?php 
	include_once 'configuration.php';

	if (!isset($_SESSION['email'])) {
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['email']);
		header("location: login.php");
	}

	$query = $con->prepare("SELECT fname, lname
							FROM users
							WHERE id = :currentUserId");
	$query->bindParam(":currentUserId", $_SESSION["id"]);
	$query->execute();
	$name = $query->fetch(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Informatika</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="topnav" id="myTopnav">
	  <a href="home.php">Početna</a>
	  <a href="teams.php">Kreirajte tim</a>
	  <a href="topics.php">Odaberite temu</a>
	  <a href="dates.php">Odaberite termin izlaganja</a>
	  <?php  if (isset($_SESSION['email'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="end.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header" style="width: 700px;">
		<h2>Prijava uspješna!</h2>
	</div>
	<div class="content" style="width: 700px;">

		<p>Tim i tema uspješno prijavljeni!</p>
		<p>Termin za izlaganje seminara moguće je odabrati naknadno: <a href="dates.php"><b>Odaberite termin izlaganja</b></a></p><br>
		<p>Za više informacija o seminaru pogledajte <a target="_blank" href="http://www.efos.unios.hr/informatika/seminari/"><b>ovdje</b></a>.</p>
		<br>
		<p><a href="home.php">Povratak na početnu stranicu</a></p>
	</div>
</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>