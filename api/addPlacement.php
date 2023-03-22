<?php
require './config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $json = file_get_contents('php://input');
  $formData = json_decode($json);

  $personId = $formData->personId;
  $placement  = $formData->placement;
  $gameId  = $formData->gameId;
  $discipline = $formData->discipline;

  $stmt = $conn->prepare('INSERT INTO Placements (person_id, placement, game_id, discipline) VALUES (?, ?, ?, ?)');
  $stmt->execute([$personId, $gameId, $placement, $discipline]);

  echo(json_encode('add'));
  exit();
}
?>