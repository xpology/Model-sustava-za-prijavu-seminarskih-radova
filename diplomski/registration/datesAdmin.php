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


	//SVE TEME
	$query = "SELECT * FROM dates";
	$result = mysqli_query($db,$query)or die(mysqli_error());
?>

<!DOCTYPE html>
<html>
<head>
	<title>Termini</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div class="topnav" id="myTopnav">
	  <a href="topicAdmin.php">Teme</a>
	  <a class="active" href="datesAdmin.php">Termini</a>
	  <a href="usersAdmin.php">Studenti</a>
	  <a href="settingsAdmin.php">Postavke</a>
	  <a href="registerAdmin.php">Admin</a>
	  <?php  if (isset($_SESSION['username'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="topicAdmin.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header-admin" style="width: 550px;">
		<h2>Termini izlaganja</h2>
	</div>
	
	<form method="post" action="datesAdmin.php" style="width: 550px;">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Termin izlaganja:</label>
			<input type="text" name="dates" value="">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="save_dates">Spremi u bazu</button>
		</div>
	</form>

<!-- ISPIS TERMINA IZ BAZE -->
<div class="content" style="width: 550px;">
	<p><h2 align="center">Termini za izlaganje:</h2></p><br>
	<p align="center"> Potrebno je osloboditi termin u postavkama (<i>2. Timovi i termini izlaganja</i>), zatim ga je moguće obrisati. </p>

	<form name="topic" action="datesAdmin.php" method="post" style="display: table; background: transparent; border-color: transparent; width: auto;">

	<table>
		<tr>
			<th style="text-align: center;">#</th>
			<th>Datum</th>
			<th style="text-align: center;">Odaberi <br><input type="checkbox" id="cbgroup1_master" onchange="togglecheckboxes(this, 'num[]')"></th>
		</tr>

		<?php while($row = mysqli_fetch_array($result)) { ?>
		    <tr>
    			<td> </td>
		    	<td> <?php echo $row["dates"]; ?> </td>
		    	<td style="text-align: center;"> <input type="checkbox" name="num[]" value="<?php echo $row["id"]; ?>" /> </td>
		    </tr>
		<?php } ?> 

	</table>

	<div class="input-group">
	<button type="submit" class="delbtn" name="del_dates" onclick="return confirm('Sigurno želite obrisati odabrano?')">Ukloni</button>
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