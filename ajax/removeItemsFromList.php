<?php
    require_once('../includes/db.php');

    

    if($_POST['itemid']) {
        
        $query = "DELETE FROM list_item WHERE list_item_id = :itemid";
        $result = $DBH->prepare($query);
        $result->bindParam(':itemid', $_POST['itemid']);
        $result->execute();
        
        echo "Done!";
    }

?>