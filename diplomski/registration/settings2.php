<?php 

include_once 'configuration.php';

$name = "MaxTeamsPerGroup";
$value = $_POST["maxTeamsPerGroup"];

$query = $con -> prepare("UPDATE settings SET value = :value WHERE name = :name");
$query->bindParam(":value", $value);
$query->bindParam(":name", $name);
$query->execute();

header('location: settingsAdmin.php');
?>