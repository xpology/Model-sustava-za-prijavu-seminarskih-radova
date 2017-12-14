<?php 
	include_once 'configuration.php';

	$topicId = $_POST["topicid"];
	$teamId = $_SESSION["teamid"];
	$userId = $_SESSION["id"];

	//PROVJERA JE LI TA TEMA VEĆ ZAUZETA U MEĐUVREMENU
	$query = $con->prepare("SELECT * FROM teamtopics WHERE topicid = :id");
	$query->bindParam(":id", $topicId);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);

	if($result != null){
		echo "Tema je zauzeta, odaberite drugu";
		exit;
	}

	//PROVJERA JE LI TAJ TIM VEĆ IMA PRIJAVLJENU TEMU
	$query = $con->prepare("SELECT * FROM teamtopics WHERE teamid = :team");
	$query->bindParam(":team", $teamId);
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);

	if($result != null){
		echo "Već ste odabrali temu";
		exit;
	}
	
	//UKOLIKO NEMA PROBLEMA SPREMI U BAZU
	$query = $con->prepare("INSERT INTO teamtopics (teamid, topicid) VALUES (:teamid, :topicid)");
	$query->bindParam(":teamid", $teamId);
	$query->bindParam(":topicid", $topicId);
	$query->execute();
	
	echo "OK";
?>