<?php 
	include_once 'configuration.php';

	$dateId = $_POST["dateid"];
	$teamId = $_SESSION["teamid"];
	$userId = $_SESSION["id"];

	$query = $con->prepare("SELECT * FROM teams WHERE id = :teamid");
	$query->bindParam(":teamid", $teamId);
	$query->execute();
	$groups = $query->fetch(PDO::FETCH_OBJ);
	$group = $groups->groups;
	
	$query = $con->prepare("SELECT * FROM settings WHERE id = 2");
	$query->execute();
	$value = $query->fetch(PDO::FETCH_OBJ);
	$limit = $value->value;

	//PROVJERA JE LI TAJ TIM VEĆ IMA PRIJAVLJENU TERMIN
	$query = $con->prepare("SELECT * FROM teamdates WHERE teamid = :team");
	$query->bindParam(":team", $teamId);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);

	if($result != null){
		echo "Već ste odabrali termin";
		exit;
	}

	//PROVJERI KOLIKO GRUPA JE PRIJAVILO TERMIN
	$query = $con->prepare("SELECT count(*) FROM teamdates WHERE dateid = :dateid AND groups = :group");
	$query->bindParam(":dateid", $dateId);
	$query->bindParam(":group", $group);
	$query->execute();
	$match = $query->fetchColumn();
	
	if($match < $limit){
		//UKOLIKO NEMA PROBLEMA SPREMI U BAZU
		$query = $con->prepare("INSERT INTO teamdates (teamid, dateid, groups) VALUES (:teamid, :dateid, :group)");
		$query->bindParam(":teamid", $teamId);
		$query->bindParam(":dateid", $dateId);
		$query->bindParam(":group", $group);
		$query->execute();
		echo "OK";
	}
	
	else{
		echo "Termin popunjen, molimo odaberite drugi.";
	}
?>