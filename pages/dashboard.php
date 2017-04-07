<?php
    if(!$_SESSION['loggedin']){
        echo "<h1>Access Denied</h1>";
        echo "<script>window.location.assign('index.php?p=login'); </script>";
    }
?>

<?php
    
    if(isset($_POST['name'])){
        if(!$_POST['name']){
            $error = "Please enter name of list";
        }
        
        if(!$error){
            
            $query = "INSERT INTO lists (list_name, user_id) VALUES (:name, :userid)";
            $result = $DBH->prepare($query);
            $result->bindParam(':name', $_POST['name']);
            $result->bindParam(':userid', $_SESSION['userData']['user_id']);
            $result->execute();
        }
    }
?>

<div class="container">
    <h1>Dashboard</h1>
    <p>Below are you active todo lists:</p>
    
    <form class="form-inline" action="" method="post">
        <div class="form-group">
            <label for="name">Search your lists</label>
            <input type="text" class="form-control" id="search" name="search">
        </div>
        <button type="submit" class="btn btn-default">Search</button>
    </form>
    
    <form class="form-inline" action="" method="post">
        <button type="submit" name="showall" class="btn btn-default">Show All</button>
    </form>
    
    <ul>
    <?php
        /*$query = "SELECT * FROM lists WHERE user_id = :userid";
        $result = $DBH->prepare($query);
        $result->bindParam(':userid', $_SESSION['userData']['user_id']);
        $result->execute();*/
        
        if(isset($_POST['search'])){
            $search = '%'.$_POST['search'].'%';
            $query = "SELECT * FROM lists WHERE user_id = :userid AND list_name LIKE :search";
            
            $result = $DBH->prepare($query);
            $result->bindParam(':userid', $_SESSION['userData']['user_id']);
            $result->bindParam(':search', $search);
            $result->execute();
        }else{
            $query = "SELECT * FROM lists WHERE user_id = :userid";
            $result = $DBH->prepare($query);
            $result->bindParam(':userid', $_SESSION['userData']['user_id']);
            $result->execute();
        }
        
        if(isset($_POST['showall'])){
            $query = "SELECT * FROM lists WHERE user_id = :userid";
            $result = $DBH->prepare($query);
            $result->bindParam(':userid', $_SESSION['userData']['user_id']);
            $result->execute();
        }
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            echo '<li><a href="index.php?p=list&id='.$row['list_id'].'">'.$row['list_name'].'</a></li>';
        }
    ?>
    </ul>
    
    <form style="margin-top:45px;" class="form-inline" action="index.php?p=dashboard" method="post">
        <?php if($error){
            echo '<div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                '.$error.'
                </div>';
    
                } ?>
        <div class="form-group">
            <label for="name">Add List</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Shopping List">
        </div>
        <button type="submit" class="btn btn-default">Add</button>
    </form>
</div>