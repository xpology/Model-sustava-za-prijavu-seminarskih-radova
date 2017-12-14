<?php

$server="localhost";
$base="registration";
$user="root";
$pass="";
$put="";

$con = new PDO("mysql:dbname=" . $base . 
		";host=" . $server . 
		"", 
			$user, $pass);
$con->exec("SET CHARACTER SET utf8");
$con->exec("SET NAMES utf8");

session_start();
