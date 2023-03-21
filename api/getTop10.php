<?php
require './config/config.php';
$sql = "SELECT p.id, CONCAT( p.name, ' ', p.surname ) as name_surname, COUNT(pl.placement) AS no_of_wins, GROUP_CONCAT(g.year ORDER BY g.year SEPARATOR ', ') AS years FROM Placements pl
JOIN People p ON pl.person_id=p.id
JOIN Olympic_games g ON pl.game_id=g.id 
GROUP BY p.id,pl.placement
HAVING pl.placement=1
LIMIT 10";

$results = mysqli_query($conn, $sql);
if (!$results) {
  die("Error executing query: " . mysqli_error($conn));
}

$data = [];
if (mysqli_num_rows($results) > 0) {
  while ($row = mysqli_fetch_assoc($results)) {
    $data[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($data);