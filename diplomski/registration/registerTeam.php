<?php 
	include_once 'configuration.php';

	$members = $_POST["members"];
	$teamname = $_POST["teamName"];
	$userId = $_SESSION["id"];

	array_push($members, $userId);

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

	foreach ($members as $member) {
		$query = $con->prepare("SELECT * FROM teammembers WHERE userid = :member");
		$query->bindParam(":member", $member);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);

		if($result != null){
			echo "Jedan od korisnika već je u drugom timu";
			exit;
		}
	}
	
	$query = $con->prepare("INSERT INTO teams(name, groups) VALUES (:teamname, :group)");
	$query->bindParam(":teamname", $teamname);
	$query->bindParam(":group", $group);
	$query->execute();
	$id = $con->lastInsertId();
	$_SESSION['teamid'] = $id;

	foreach ($members as $member) {
		$query = $con->prepare("INSERT INTO teammembers (teamid, userid) VALUES (:id, :member)");
		$query->bindParam(":id", $id);
		$query->bindParam(":member", $member);
		$query->execute();
	}

	echo "OK";
?>