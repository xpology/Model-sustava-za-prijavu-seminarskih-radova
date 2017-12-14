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

	$query = "SELECT * FROM settings WHERE name = 'maxTeamMembers'";
	$value = mysqli_query($db,$query)or die(mysqli_error()); 

	$query = "SELECT * FROM settings WHERE name = 'maxTeamsPerGroup'";
	$teams = mysqli_query($db,$query)or die(mysqli_error()); 

	//PAGINACIJA
	$limit = 15;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;

	$query = "SELECT users.fname, users.lname, users.groups, teams.name, teammembers.id 
		      FROM teammembers 
		      INNER JOIN users ON teammembers.userid = users.id  
		      INNER JOIN teams ON teammembers.teamid = teams.id
		      ORDER BY users.groups, teams.id, users.lname ASC LIMIT $start_from, $limit";
	$names = mysqli_query($db,$query)or die(mysqli_error());
?>

<!DOCTYPE html>
<html>
<head>
	<title>Postavke</title>
	<link rel="stylesheet" href="dist/simplePagination.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

	<div class="topnav" id="myTopnav">
	  <a href="topicAdmin.php">Teme</a>
	  <a href="datesAdmin.php">Termini</a>
	  <a href="usersAdmin.php">Studenti</a>
	  <a class="active" href="settingsAdmin.php">Postavke</a>
	  <a href="registerAdmin.php">Admin</a>
	  <?php  if (isset($_SESSION['username'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="settingsAdmin.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header-admin" style="width: 650px;">
		<h2>Postavke</h2>
	</div>
	
	<form method="post" action="settings.php" style="width: 650px;">
		<?php include('errors.php'); ?>

		<label>Trenutni maksimalan broj članova tima:</label>
		<?php 
			while ($row = mysqli_fetch_array($value)) {
				echo "<p>"; echo $row["value"]; echo "</p>"; 
			}
		?>

		<div class="input-group">
			<label>Odaberite novi maksimalan broj članova u timu:</label>
		</div>
		<div class="input-num">
			<input type="number" id="maxTeamMembers" name="maxTeamMembers" min="1" max="10" value="4" />
		</div>
		<div class="input-group">
			<button type="submit" class="btn">Spremi</button>
		</div>
	</form>

	<form method="post" action="settings2.php" style="width: 650px;">
		<?php include('errors.php'); ?>

		<label>Trenutni maksimalan broj timova iz grupe po terminu:</label>
		<?php 
			while ($row = mysqli_fetch_array($teams)) {
				echo "<p>"; echo $row["value"]; echo "</p>"; 
			}
		?>

		<div class="input-group">
			<label>Odaberite novi maksimalan broj timova iz grupe po terminu:</label>
		</div>
		<div class="input-num">
			<input type="number" id="maxTeamsPerGroup" name="maxTeamsPerGroup" min="1" max="15" value="6" />
		</div>
		<div class="input-group">
			<button type="submit" class="btn">Spremi</button>
		</div>
	</form>

<div class="content" style="width: 650px;">

	<div class="topnav" id="myTopnav">
	  <a href="settingsAdmin.php">1. Timovi i teme</a>
	  <a href="settingsAdmin2.php">2. Timovi i termini</a>
	  <a class="active" href="settingsAdmin3.php">3. Članovi timova</a>
	  <a href="settingsAdmin4.php">4. Timovi</a>
	</div>
	
	<!-- ISPIS TIMOVA I ČLANOVA -->
	<br>
	<p><h2 align="center">3. Članovi timova</h2></p><br>
	<p align="center"> Odaberite člana kojeg želite ukloniti iz odabranog tima. </p>

	<form name="teammember" action="settingsAdmin3.php?page=<?php echo $page;?>" method="post" style="display: table; background: transparent; border-color: transparent; width: auto;">

		<table>
			<thead>
				<tr>
					<th style="display:none;">#</th>
					<th>Korisnik</th>
					<th>Tim</th>
					<th>Grupa</th>
					<th style="text-align: center;">Odaberi <br><input type="checkbox" id="cbgroup1_master" onchange="togglecheckboxes(this, 'teammembers[]')"> </th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = mysqli_fetch_array($names)) { ?>
				    <tr>
					    <td style="display:none;"> </td>
					    <td> <?php echo $row["lname"]; echo " "; echo $row["fname"]; ?> </td>
			    		<td> <?php echo $row["name"]; ?> </td>
			    		<td style="text-align: center;"> <?php echo $row["groups"] ?> </td>		    
					    <td style="text-align: center;"> <input type="checkbox" name="teammembers[]" value="<?php echo $row["id"]; ?>" /> </td>
				    </tr>
				<?php } ?>
			</tbody>
		</table>

	<div class="input-group">
	<button type="submit" class="delbtn" name="del_teammembers" onclick="return confirm('Sigurno želite obrisati odabrano?')">Ukloni člana iz tima</button>
	</div>

	</form>
	
	<?php  
		$query = "SELECT COUNT(id) FROM teammembers";  
		$names = mysqli_query($db, $query);  
		$row = mysqli_fetch_row($names);  
		$total_records = $row[0];  
		$total_pages = ceil($total_records / $limit);  
		$pagLink = "<nav><ul class='pagination'>";  
		for ($i=1; $i<=$total_pages; $i++) {  
		             $pagLink .= "<li><a href='settingsAdmin3.php?page=".$i."'>".$i."</a></li>";  
		};  
		echo $pagLink . "</ul></nav>";  
	?>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="js/ToggleAll.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.0.3.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="dist/jquery.simplePagination.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	$('.pagination').pagination({
	        items: <?php echo $total_records;?>,
	        itemsOnPage: <?php echo $limit;?>,
	        cssStyle: 'light-theme',
	        currentPage : <?php echo $page;?>,
	        hrefTextPrefix : 'settingsAdmin3.php?page='
	    });
	    });
</script>
</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>