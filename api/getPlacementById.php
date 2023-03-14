<?php
$id = $_GET['id'];
$id = 1;
$stmt = $conn->prepare("SELECT pl.placement, CONCAT(g.type, ' ', g.city, ', ', g.country, ' ', g.year) AS games, pl.discipline FROM Placements pl
JOIN Olympic_games g ON pl.game_id=g.id 
WHERE pl.id = ?");
$stmt->execute([$id]);
$results = $stmt->get_result();
$data = [];
if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc()) {
        $placements[] = $row;
    }
}   
header('Content-Type: application/json');
echo json_encode($placement);    