<?php
	require_once("functions.php");
	
	if(!isset($_SESSION["id_from_db"])){
		header("Location: login.php");
	}
	
	if(isset($_GET["logout"])){
		session_destroy();
		
		header("Location: login.php");
	}
	
	// FILE upload
	//http://www.w3schools.com/php/php_file_upload.asp
	
	$target_dir = "profile_pics/";
	//profile_pics/kasutaja_id.jpg
	$target_file = $target_dir .$_SESSION["id_from_db"].".jpg";
	
	if(isset($_POST["submit"])) {
	
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
	
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	
		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 1024000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				
				header("Location: data.php");
				exit();
				//see koht kus fail pannakse meie kausta
				
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
		
	} // isset post submit end
	
	
	//kustuta pilt
	if(isset($_GET["delete_image"])){
		
		//kustutan faili
		unlink($target_file);
		
		header("Location: data.php");
		exit();
		
	}
	
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

<h2>Profiilipilt</h2>

<?php if(file_exists($target_file)): ?>
	
	<div style="
			width:250px;
			height:250px;
			background-image: url(<?=$target_file;?>);
			background-position: center center;
			background-size: cover;
	"></div>
	<a href="?delete_image" >Kustuta</a>
	
<?php else: ?>
	<form action="data.php" method="post" enctype="multipart/form-data">
		Select image to upload:
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Upload Image" name="submit">
	</form>
<?php endif; ?>

