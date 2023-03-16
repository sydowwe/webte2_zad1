<?php
    require './config/config.php';
 
    $person_id = $_GET['person_id'];  
    $stmt = $conn->prepare("SELECT pl.id, pl.placement, CONCAT(g.type, ' ', g.city, ', ', g.country, ' ', g.year) AS games, pl.discipline FROM Placements pl
    JOIN Olympic_games g ON pl.game_id=g.id 
    WHERE pl.person_id = ?");
    $stmt->execute([$person_id]);
    $results = $stmt->get_result();
    if (mysqli_num_rows($results) > 0) {
        while ($row = $results->fetch_assoc()) {
            $placements[] = $row;
        }
    }   
    header('Content-Type: application/json');
    echo json_encode($placements);    
?>