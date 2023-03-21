<?php
    require './config/config.php'; 
  
    $results = mysqli_query($conn, "SELECT id, CONCAT(type, ' ', city, ', ', country, ' ', year) AS games FROM Olympic_games");
    $games = [];
    if (mysqli_num_rows($results) > 0) {
        while ($row = $results->fetch_assoc()) {
            $games[] = $row;
        }
    }   
    header('Content-Type: application/json');
    echo json_encode($games);    
?>