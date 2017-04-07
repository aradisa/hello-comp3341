<?php
    require_once('../includes/db.php');

    if($_POST['listid'] && $_POST['itemName']){
        $query = "INSERT INTO list_item (list_item_name, lists_id) VALUES (:itemName, :listid)";
        $result = $DBH->prepare($query);
        $result->bindParam(':itemName', $_POST['itemName']);
        $result->bindParam(':listid', $_POST['listid']);
        $result->execute();
        
        echo $DBH->lasInsertID();
    }
?>