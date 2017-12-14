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

	$sql = "SELECT * FROM users ORDER BY lname ASC LIMIT $start_from, $limit";  
	$rs_result = mysqli_query($db, $sql);  
	?> 

<!DOCTYPE html>
<html>
	<head>
		<title>Studenti</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="dist/simplePagination.css" />
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
	<div class="topnav" id="myTopnav">
      <a href="topicAdmin.php">Teme</a>
      <a href="datesAdmin.php">Termini</a>
      <a class="active" href="usersAdmin.php">Studenti</a>
      <a href="settingsAdmin.php">Postavke</a>
      <a href="registerAdmin.php">Admin</a>
      <?php  if (isset($_SESSION['username'])) : ?>
	  	<a style="float: right; background-color: #ce0606;" href="settingsAdmin.php?logout='1'">Odjava</a>
	  	<p style="float: right; color: #f2f2f2; text-align: center; padding: 14px 16px; font-size: 17px;"><?php echo $name->fname; echo " "; echo $name->lname;  ?></p>
	  <?php endif ?>
	</div>

	<div class="header-admin" style="width: 900px;">
		<h2>Registrirani studenti</h2>
	</div>
	<div class="content" style="width: 900px;">
		<p align="center"> Potrebno je ukloniti studenta iz tima u postavkama (<i>3. Članovi tima</i>), zatim ga je moguće obrisati. </p><br>
	<div class="container" style="padding-top:20px;">
	<form name="users" action="usersAdmin.php?page=<?php echo $page;?>" method="post" style="display: table; background: transparent; border-color: transparent; padding: 1px; width: 900px;">
	<table>  
		<thead>  
			<tr>
				<th style="display:none;">#</th> 
				<th>Status</th>  
				<th>Prezime</th>
				<th>Ime</th> 
				<th>Email</th>
				<th>Grupa</th>
				<th style="text-align: center;">Odaberi <br><input type="checkbox" id="cbgroup1_master" onchange="togglecheckboxes(this, 'users[]')"> </th>   
			</tr>  
		</thead>  
		<tbody>  
			<?php  
			while ($row = mysqli_fetch_assoc($rs_result)) {	?>  
	            <tr>
		            <td style="display:none;"> </td>  
		            <td><?php echo $row["status"]; ?></td>  
		            <td><?php echo $row["lname"]; ?></td>  
					<td><?php echo $row["fname"]; ?></td>
					<td><?php echo $row["email"]; ?></td> 
					<td style="text-align: center;"><?php echo $row["groups"]; ?></td>
		            <td style="text-align: center;"> <input type="checkbox" name="users[]" value="<?php echo $row["id"]; ?>" /> </td>   
	            </tr>  
			<?php } ?>  
		</tbody>  
	</table>

	    <div class="input-group" style="float: right;">
	    	<button type="submit" class="delbtn" name="del_users" onclick="return confirm('Sigurno želite obrisati odabrano?')">Ukloni</button>
	    </div>
	</form>
	  
		<?php  
		$sql = "SELECT COUNT(id) FROM users";  
		$rs_result = mysqli_query($db, $sql);  
		$row = mysqli_fetch_row($rs_result);  
		$total_records = $row[0];  
		$total_pages = ceil($total_records / $limit);  
		$pagLink = "<nav><ul class='pagination'>";  
		for ($i=1; $i<=$total_pages; $i++) {  
		             $pagLink .= "<li><a href='usersAdmin.php?page=".$i."'>".$i."</a></li>";  
		};  
		echo $pagLink . "</ul></nav>";  
		?>
	</div>
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
			        hrefTextPrefix : 'usersAdmin.php?page='
			    });
			    });
		</script>
	</body>
	<footer>
	    <p class="copyright">Copyright &copy; <?php echo date("Y"); ?> Mateo Debeljak</p>
	</footer>
</html>
