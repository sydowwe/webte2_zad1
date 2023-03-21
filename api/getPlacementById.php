<?php
require './config/config.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT pl.placement, CONCAT(g.type, ' ', g.city, ', ', g.country, ' ', g.year) AS games, g.id as gamesId, pl.discipline FROM Placements pl
JOIN Olympic_games g ON pl.game_id=g.id 
WHERE pl.id = ?");
$stmt->execute([$id]);
$results = $stmt->get_result();
if (mysqli_num_rows($results) > 0) {    
    while ($row = $results->fetch_assoc()) {
        $placement = $row;
    }
}   
header('Content-Type: application/json');
echo json_encode($placement);    