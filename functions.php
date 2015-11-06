<?php

	require_once("../configglobal.php");
	require_once("User.class.php");
	
	$database = "if15_romil_2";
	
	session_start();
	
	//loome ab'i ühenduse
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);
	
	//Uus instants klassist User
	$User = new User($mysqli);
	
	//var_dump($User->connection);
	
	
?>