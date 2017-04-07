<div class="container">
    <ul id="userList">
        <?php
        
            $query = "SELECT forename FROM users";
            $pdo = $DBH->prepare($query);
            $pdo->execute();
        
            while($row = $pdo->fetch(PDO::FETCH_ASSOC)) {
                echo "<li>".$row['forename']."</li>";
            }
        
        ?>
    </ul>
</div>