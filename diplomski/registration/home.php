<?php 
	include_once 'configuration.php';
	include 'upload.php';

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

	//PRIKAŽI DATUM, GRUPU, TEMU, TIM I ČLANOVE
	$query = $con->prepare("SELECT b.name, d.dates 
							FROM teamdates a
							INNER JOIN teams b ON a.teamid = b.id
							INNER JOIN dates d ON a.dateid = d.id
							WHERE a.teamid = :currentTeamId");
	$query->bindParam(":currentTeamId", $_SESSION["teamid"]);
	$query->execute();
	$date = $query->fetch(PDO::FETCH_OBJ);

	$query = $con->prepare("SELECT groups
							FROM users
							WHERE id = :currentUserId");
	$query->bindParam(":currentUserId", $_SESSION["id"]);
	$query->execute();
	$groups = $query->fetch(PDO::FETCH_OBJ);

	$query = $con->prepare("SELECT c.title, b.name
							FROM teamtopics a
							INNER JOIN teams b ON a.teamid = b.id 
							INNER JOIN topics c ON a.topicid = c.id 
							WHERE a.teamid = :currentTeamId");
	$query->bindParam(":currentTeamId", $_SESSION["teamid"]);
	$query->execute();
	$teamAndTopicInfo = $query->fetch(PDO::FETCH_OBJ);

	$query = $con->prepare("SELECT b.fname, b.lname, b.groups 
							FROM teammembers a 
							INNER JOIN users b ON a.userid = b.id 
							WHERE a.teamid = :currentTeamId
							ORDER BY lname");
	$query->bindParam(":currentTeamId", $_SESSION["teamid"]);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);

	error_reporting(0); //UKLANJANJE NOTIFIKACIJSKIH PORUKA O POGREŠKAMA (UKOLIKO KORISNIK NEMA ODABRANU TEMU I TIM)
?>

<!DOCTYPE html>
<html>
<head>
	<title>Početna</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="topnav" id="myTopnav">
	  <a class="active" href="home.php">Početna</a>
	  <a href="teams.php">Kreirajte tim</a>
	  <a href="topics.php">Odaberite temu</a>
	  <a href="dates.php">Odaberite termin izlaganja</a>
	  <?php  if (isset($_SESSION['email'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="home.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header" style="width: 700px;">
		<h2>Početna</h2>
	</div>
	<div class="content" style="width: 700px;">
		<p>Za više informacija o seminaru pogledajte <a target="_blank" href="http://www.efos.unios.hr/informatika/seminari/"><b>ovdje</b></a>.</p>
	</div>

	<!-- TEMA, TIM, ČLANOVI -->
<div class="content" style="width: 700px;">
	<form enctype="multipart/form-data" action="home.php" method="POST" style="display: table; background: transparent; border-color: transparent; width: 50%; margin: auto; float: left; padding: 1px;">
    <p><b>Prenesite svoj seminar:</b></p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
	</form>
	<br><br><br><br>

	<p><b>Termin izlaganja:</b> <?php echo $date->dates ?> </p>
	<br>
	<p><b>Grupa:</b> <?php echo $groups->groups ?></p>
	<br>
	<p><b>Tema:</b> <?php echo $teamAndTopicInfo->title; ?></p>
	<br>
	<p><b>Ime tima:</b> <?php echo $teamAndTopicInfo->name; ?></p>
	<br>
	<p><b>Članovi tima:</b></p>
	<?php foreach($results as $result){
		echo "<p>" . $result->lname . " " . $result->fname . "</p>";
	}?>
</div>

</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>