<?php
    $_SESSION = [];

    session_destroy();
    echo "<script>window.location.assign('index.php?p=login'); </script>";
?>