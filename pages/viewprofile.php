<?php

    if(isset($_POST['private'])){
        
    }

    if($_GET['id']){
        
        $query = "SELECT * FROM users WHERE user_id = :userid";
        $result = $DBH->prepare($query);
        $result->bindParam(':userid', $_GET['id']);
        $result->execute();
        $userProfile = $result->fetch(PDO::FETCH_ASSOC);
        
    }else{
        $error = "No user id defined";
    }
?>

<div class="container">
    <?php
        if($error){
            echo "<h1>Error!</h1>";
            echo "<p>".$error."</p>";
        }else{
            
    ?>
    
    <h1><?php echo $userProfile['forename']; ?></h1>
    
    <img class="profileImage" src="./user_images/<?php echo $userProfile['profile_image'];?>"/>
    
    <p><strong>Gender:</strong> <?php echo $userProfile['gender']; ?></p>
    <p><strong>Country:</strong> <?php echo $userProfile['country']; ?></p>
    <p><strong>Favourite Quote:</strong> <?php echo $userProfile['favorite_quote']; ?></p>
    <p><strong>Favourite Colour:</strong> <?php echo $userProfile['favorite_color']; ?></p>
    <p><strong>Hobbies:</strong> <?php echo $userProfile['hobbies']; ?></p>
    <input type="checkbox" name="private" value="private" />Hide user
    
    <?php } ?>
</div>