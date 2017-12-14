<?php 

include_once 'configuration.php';

$name = "maxTeamMembers";
$value = $_POST["maxTeamMembers"];

$query = $con -> prepare("UPDATE settings SET value = :value WHERE name = :name");
$query->bindParam(":value", $value);
$query->bindParam(":name", $name);
$query->execute();

header('location: settingsAdmin.php');
?>