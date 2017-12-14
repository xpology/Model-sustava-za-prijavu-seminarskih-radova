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

	//PAGINACIJA
	$limit = 15;  
	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
	$start_from = ($page-1) * $limit;

	//SVE TEME
	$query = "SELECT * FROM topics ORDER BY id ASC LIMIT $start_from, $limit";
	$result = mysqli_query($db,$query);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Unos tema</title>
	<link rel="stylesheet" href="dist/simplePagination.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

	<div class="topnav" id="myTopnav">
	  <a class="active" href="topicAdmin.php">Teme</a>
	  <a href="datesAdmin.php">Termini</a>
	  <a href="usersAdmin.php">Studenti</a>
	  <a href="settingsAdmin.php">Postavke</a>
	  <a href="registerAdmin.php">Admin</a>
	  <?php  if (isset($_SESSION['username'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="topicAdmin.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header-admin" style="width: 700px;">
		<h2>Teme</h2>
	</div>
	
	<form method="post" action="topicAdmin.php?page=<?php echo $page;?>" style="width: 700px;">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Naziv teme:</label>
			<input type="text" name="title" value="">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="reg_topic">Spremi u bazu</button>
		</div>
	</form>

<!-- ISPIS TEMA IZ BAZE -->
<div class="content" style="width: 700px;">
	<p><h2 align="center">Teme u bazi</h2></p><br>
	<p align="center"> Potrebno je osloboditi temu u postavkama (<i>1. Timovi i teme</i>), zatim ju je moguće obrisati. </p>

	<form name="topic" action="topicAdmin.php?page=<?php echo $page;?>" method="post" style="display: table; background: transparent; border-color: transparent; width: auto;">

	<table>
		<thead>
			<tr>
				<th style="display: none;">#</th>
				<th>Naziv</th>
				<th style="text-align: center;">Odaberi <br><input type="checkbox" id="cbgroup1_master" onchange="togglecheckboxes(this, 'num[]')"></th>
			</tr>
		</thead>
		<tbody>
			<?php while($row = mysqli_fetch_array($result)) { ?>
			    <tr>
	    			<td style="display: none;"> </td>
			    	<td> <?php echo $row["title"]; ?> </td>
			    	<td style="text-align: center;"> <input type="checkbox" name="num[]" value="<?php echo $row["id"]; ?>" /> </td>
			    </tr>
			<?php } ?> 
		</tbody>
	</table>

	<div class="input-group">
	<button type="submit" class="delbtn" name="del_topic" onclick="return confirm('Sigurno želite obrisati odabrano?')">Ukloni</button>
	</div>

	</form>

	<?php  
		$query = "SELECT COUNT(id) FROM topics";  
		$result = mysqli_query($db, $query);  
		$row = mysqli_fetch_row($result);  
		$total_records = $row[0];  
		$total_pages = ceil($total_records / $limit);  
		$pagLink = "<nav><ul class='pagination'>";  
		for ($i=1; $i<=$total_pages; $i++) {  
		             $pagLink .= "<li><a href='topicAdmin.php?page=".$i."'>".$i."</a></li>";  
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
	        hrefTextPrefix : 'topicAdmin.php?page='
	    });
	    });
</script>
</body>
<footer>
    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
</footer>
</html>