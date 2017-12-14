<?php 
	include_once 'configuration.php';

	$teamname = $_POST["teamName"];
	$userId = $_SESSION["id"];

	$query = $con->prepare("SELECT groups FROM users WHERE id = :currentUserId");
	$query->bindParam(":currentUserId", $_SESSION["id"]);
	$query->execute();
	$groups = $query->fetch(PDO::FETCH_OBJ);
	$group = $groups->groups;

	$query = $con->prepare("SELECT * FROM teams WHERE name = :name");
	$query->bindParam(":name", $teamname);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);

	if($result != null){
		echo "Ime tima je zauzeto";
		exit;
	}

	$query = $con->prepare("SELECT * FROM teammembers WHERE userid = :userid");
	$query->bindParam(":userid", $userId);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);

	if($result != null){
		echo "Već se nalazite u jednome od timova";
		exit;
	}
	
	$query = $con->prepare("INSERT INTO teams(name, groups) VALUES (:teamname, :group)");
	$query->bindParam(":teamname", $teamname);
	$query->bindParam(":group", $group);
	$query->execute();
	$id = $con->lastInsertId();
	$_SESSION['teamid'] = $id;

	$query = $con->prepare("INSERT INTO teammembers (teamid, userid) VALUES (:id, :userid)");
	$query->bindParam(":id", $id);
	$query->bindParam(":userid", $userId);
	$query->execute();

	echo "OK";
?>