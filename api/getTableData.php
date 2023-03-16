<?php
require './config/config.php';

$sql = "SELECT p.id, p.name, p.surname, g.type, g.year, g.city, pl.discipline FROM Placements pl
JOIN People p ON pl.person_id=p.id
JOIN Olympic_games g ON pl.game_id=g.id 
WHERE pl.placement = 1";

$results = mysqli_query($conn, $sql);
if (!$results) {
  // Handle query error
  die("Error executing query: " . mysqli_error($conn));
}

$data = array();
if (mysqli_num_rows($results) > 0) {
  while ($row = mysqli_fetch_assoc($results)) {
    $data[] = $row;
  }
}

header('Content-Type: application/json');
echo json_encode($data);