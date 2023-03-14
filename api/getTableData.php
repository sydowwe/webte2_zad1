<?php
require './config/config.php';

$sql = "SELECT p.id, p.name, p.surname, g.type, g.year, g.city, pl.discipline FROM Placements pl
JOIN People p ON pl.person_id=p.id
JOIN Olympic_games g ON pl.game_id=g.id 
WHERE pl.placement = 1";

$results = mysqli_query($conn, $sql);
$data = [];
if ($results->num_rows > 0) {
  while ($row = $results->fetch_assoc()) {
    $data[] = $row;
  }
}
header('Content-Type: application/json');
echo json_encode($data);
$conn->close();