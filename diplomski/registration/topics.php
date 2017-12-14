<?php 
	include 'server.php';

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
	
	//SVE DOSTUPNE TEME
	$query = $con->prepare("SELECT * FROM topics WHERE id NOT IN (SELECT DISTINCT topicid from teamtopics)");
	$query->bindParam(":title", $title);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Prijavljivanje tema</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="topnav" id="myTopnav">
	  <a href="home.php">Početna</a>
	  <a href="teams.php">Kreirajte tim</a>
	  <a class="active" href="topics.php">Odaberite temu</a>
	  <a href="dates.php">Odaberite termin izlaganja</a>
	  <?php  if (isset($_SESSION['email'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="topics.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header" style="width: 700px;">
		<h2>Odabir teme</h2>
	</div>

	<div class="content" style="width: 700px;">
		<p>Za više informacija o seminaru pogledajte <a target="_blank" href="http://www.efos.unios.hr/informatika/seminari/"><b>ovdje</b></a>.</p>
	</div>

<!-- ISPIS TEMA IZ BAZE -->
<div class="content" style="width: 700px;">
	<form method="post" action="topics.php" style="display: table; background: transparent; border-color: transparent; width: 90%; margin: auto; float: left; padding: 1px;">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label><b>Naziv teme:</b></label>
			<input type="text" placeholder="Unesite prijedlog teme" name="title" value="">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_topic">Spremi temu</button>
		</div>
		<br>
	</form>

	
	<table>
	<tr>
		<th style="text-align: center;">#</th>
		<th>Naziv</th>
		<th style="text-align: center;">Odaberi</th>
	</tr>

	<?php foreach ($results as $result) {?>
		<tr>
			<td> </td>
			<td><?php echo $result->title;?></td>
			<td style="text-align: center;"><input type='checkbox' name='checkbox' id="<?php echo $result->id;?>" class='js-Checkbox' /></td>
		</tr>
	<?php
	 	} 
	?>
	</table>
	<button type='submit' class='btn input-group js-SubmitTopic' name='make_team'>Odaberi temu</button>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/ChooseTopic.js"></script>
</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>