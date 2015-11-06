<?php

$user1 = new User("Romil");
$user2 = new User("Juku");


class User {
	
	//funktsioon, mis käivitub siis kui
	// on ! NEW User();
	function __construct($user_name){
		echo "Tere ".$user_name."<br>";
	}
	
} ?>