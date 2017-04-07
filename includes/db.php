<?php

    session_start();

    $host = 'localhost';
    $dbname = 'ukgozemq_todo';
    $user = 'ukgozemq_todo';
    $pass = 'Worc-12345';

    

    try {
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e) {
    echo $e->getMessage();
}

?>