<?php
require './config/config.php';

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $json = file_get_contents('php://input');
  $formData = json_decode($json);

  $personId = $formData->personId;
  $placement  = $formData->placement;
  $gameId  = $formData->gameId;
  $discipline = $formData->discipline;

  $stmt = $conn->prepare('UPDATE Placements SET person_id = ?, placement = ?, game_id = ?, discipline = ? WHERE id = ?');
  $stmt->execute([$personId, $placement, $gameId, $discipline, $id]);
  $id = mysqli_insert_id($conn);
  
  echo(json_encode('edit'));
  exit();
}
?>