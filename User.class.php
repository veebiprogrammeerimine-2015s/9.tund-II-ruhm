<?php
class User {
	
	//privaatne muutuja, saan kasutada klassi sees
	private $connection;
	
	//funktsioon, mis k�ivitub siis kui
	// on ! NEW User();
	function __construct($mysqli){
		
		// selle klassi muutuja
		$this->connection = $mysqli;
	}
	
	function createUser($create_email, $password_hash){
		
		//teen objekti, et saata tagasi kas errori (id, message) v�i successi (message) 
		$response = new StdClass();

		//kas selline email on juba olemas?
		$stmt = $this->connection->prepare("SELECT email FROM user_sample WHERE email = ?");
		$stmt->bind_param("s", $create_email);
		$stmt->execute();
		
		//kas oli 1 rida andmeid
		if($stmt->fetch()){
			
			// saadan tagasi errori
			$error = new StdClass();
			$error->id = 0;
			$error->message = "Sellise e-postiga kasutaja juba olemas!";
			
			//panen errori responsile k�lge
			$response->error = $error;
			
			// p�rast returni enam koodi edasi ei vaadata funktsioonis
			return $response;
			
		}
	
		//*************************
		//******* OLULINE *********
		//*************************
		//panen eelmise k�su kinni
		$stmt->close();
	
		$stmt = $this->connection->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		$stmt->bind_param("ss", $create_email, $password_hash);
		
		if($stmt->execute()){
			// edukalt salvestas
			$success = new StdClass();
			$success->message = "Kasutaja edukalt salvestatud";
			
			$response->success = $success;
			
		}else{
			// midagi l�ks katki
			$error = new StdClass();
			$error->id =1;
			$error->message = "Midagi l�ks katki!";
			
			//panen errori responsile k�lge
			$response->error = $error;
		}
		
		$stmt->close();
		
		//saada tagasi vastuse, kas success v�i error
		return $response;
	
	}
	
	function loginUser($email, $password_hash){
		
		$stmt = $this->connection->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $password_hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			echo "kasutaja id=".$id_from_db;
		}else{
			echo "Wrong password or email!";
		}
		$stmt->close();
	}
	
} ?>