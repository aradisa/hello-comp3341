<?php
    if(!$_SESSION['loggedin']){
        echo "<h1>Access Denied!</h1>";
        echo "<script>window.location.assign('index.php?p=login');</script>";
        exit;
    }
?>

<div class="container">
    <h1>Edit your profile</h1>
    <p>Complete the form below to edit your public profile.</p>
    
    <?php

		if(isset($_POST['submit'])){

			if($_FILES['profile_image']["tmp_name"]){
				//Let's add a random string of numbers to the start of the filename to make it unique!

				$newFilename = md5(uniqid(rand(), true)).$_FILES["profile_image"]["name"];
				$target_file = "./user_images/" . basename($newFilename);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

				// Check if image file is a actual image or fake image
			    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
			    if($check === false) {
			        echo "File is not an image!";
			        $uploadError = true;
			    }

			    //Check file already exists - It really, really shouldn't!
				if (file_exists($target_file)) {
					echo "Sorry, file already exists.";
					$uploadError = true;
				}

				// Check file size
				if ($_FILES["profile_image"]["size"] > 500000) {
				    echo "Sorry, your file is too large.";
				    $uploadError = true;
				}

				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				    $uploadError = true;
				}

				// Did we hit an error?
				if ($uploadError) {
				    echo "Sorry, your file was not uploaded.";
				} else {
					//Save file
				    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
				        //Success!
				    } else {
				        echo "Sorry, there was an error uploading your file.";
				    }
				}
			}

			if($target_file){
				$query = "UPDATE users SET forename = :forename, country = :country, hobbies = :hobbies, gender = :gender, favorite_quote = :favorite_quote, favorite_color = :favorite_color, profile_image = :profile_image WHERE user_id = :userid";
			}else{
				$query = "UPDATE users SET forename = :forename, country = :country, hobbies = :hobbies, gender = :gender, favorite_quote = :favorite_quote, favorite_color = :favorite_color WHERE user_id = :userid";
			}
		    $result = $DBH->prepare($query);
		    $result->bindParam(':forename', $_POST['name']);
		    $result->bindParam(':country', $_POST['country']);
		    $result->bindParam(':hobbies', $_POST['hobbies']);
		    $result->bindParam(':gender', $_POST['gender']);
		    $result->bindParam(':favorite_quote', $_POST['quote']);
		    $result->bindParam(':favorite_color', $_POST['colour']);
		    if($target_file){
				$result->bindParam(':profile_image', $newFilename);
			}
		    $result->bindParam(':userid', $_SESSION['userData']['user_id']);
		    if($result->execute()){
		    	echo '<p class="bg-success">Your profile has been updated!</p>';
		    }
		}

		//Get current values
		$query = "SELECT * FROM users WHERE user_id = :userid";
	    $result = $DBH->prepare($query);
	    $result->bindParam(':userid', $_SESSION['userData']['user_id']);
	    $result->execute();

	    $userProfile = $result->fetch(PDO::FETCH_ASSOC);

	?>

	<form method="post" action="" enctype="multipart/form-data">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" value="<?php echo $userProfile['forename']; ?>">
		</div>
		<div class="form-group">
			<label for="profile_image">Profile Photo</label>
			<input type="file" name="profile_image" id="profile_image">
			<p class="help-block">Upload a photo of yourself for your profile.</p>
		</div>
		<div class="form-group">
			<label for="gender">Gender</label>
			<input type="text" class="form-control" id="gender" name="gender" value="<?php echo $userProfile['gender']; ?>">
		</div>
		<div class="form-group">
			<label for="country">Country</label>
			<input type="text" class="form-control" id="country" name="country" value="<?php echo $userProfile['country']; ?>">
		</div>
		<div class="form-group">
			<label for="quote">Favorite Quote</label>
			<input type="text" class="form-control" id="quote" name="quote" value="<?php echo $userProfile['favorite_quote']; ?>">
		</div>
		<div class="form-group">
			<label for="colour">Favorite Colour</label>
			<input type="text" class="form-control" id="colour" name="colour" value="<?php echo $userProfile['favorite_colour']; ?>">
		</div>
		<div class="form-group">
			<label for="hobbies">Hobbies</label>
			<input type="text" class="form-control" id="hobbies" name="hobbies" value="<?php echo $userProfile['hobbies']; ?>">
		</div>
		<button type="submit" name="submit" class="btn btn-default">Update Profile</button>
	</form>
    
</div>