
<script src="js/list.js"></script>
<?php
    if(!$_SESSION['loggedin']){
        echo "<h1>Access Denied</h1>";
        echo "<script>window.location.assign('index.php?p=login'); </script>";
    }
?>
<div id="mainContainer">
  <ul id="toDoList">
      <?php
        $listid = $_GET['id'];
        $query = "SELECT * FROM list_item WHERE lists_id = :listid";
        $pdo = $DBH->prepare($query);
        $pdo->bindParam(':listid', $listid);
        $pdo->execute();
        
        
        while($row = $pdo->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>".$row['list_item_name']."<span data-itemid=\"".$row['list_item_id']."\"class=\"glyphicon glyphicon-remove deleteItem\"></span></li>";
        }
      ?>
  </ul>
  <form class="form-inline">
    <div class="form-group">
      <input type="text" class="form-control" id="productName" placeholder="Bread">
      
    </div>
    <input type="hidden" class="form-control" id="listid" value="<?php echo $_GET['id']; ?>">
    <button type="button" class="btn btn-primary" id="addProduct"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button>
  </form>
</div>

<div class="review-form-container">
    <?php
        $rating = (int)$_POST['review_rating'];
        if(!empty($rating)){
            $query = "INSERT INTO reviews (list_id, review_score) VALUES (:list_id, :review_score)";
            $result = $DBH->prepare($query);
            $result->bindParam(':list_id', $listid);
            $result->bindParam(':review_score', $rating);
            if($result->execute()){
                echo "<strong>Your review has been added!</strong>";
            }
        }
    ?>
    
    <form class="form-inline" method="post" action="#">
        <div class="form-group">
            <select name="review_rating" class="form-control">
                <option value="1">1 Star</option>
                <option value="2">2 Star</option>
                <option value="3">3 Star</option>
                <option value="4">4 Star</option>
                <option value="5">5 Star</option>
                <option value="6">6 Star</option>
                <option value="7">7 Star</option>
                <option value="8">8 Star</option>
                <option value="9">9 Star</option>
                <option value="10">10 Star</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" id="addreview">Add Review</button>
    </form>
    
    <?php
    
        $query = "SELECT AVG(review_score) AS score_average FROM reviews WHERE list_id = :list_id";
        $result = $DBH->prepare($query);
        $result->bindParam(':list_id', $listid);
        $result->execute();
        $reviewData = $result->fetch(PDO::FETCH_ASSOC);
    
        echo "<h3>Average Rating: ".round($reviewData['score_average'], 1)."</h3>";
    ?>
</div>