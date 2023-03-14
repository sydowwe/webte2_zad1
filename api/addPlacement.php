<?php
require './config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personID = $_POST['personID'];
  $placement  = $_POST['placement'];
  $gamesID  = $_POST['gamesID'];
  $discipline = $_POST['discipline'];

  $stmt = $conn->prepare('INSERT INTO Placements (person_id, placement, games_id, discipline) VALUES (?, ?, ?)');
  $stmt->execute([$personID, $placement, $gamesID, $discipline]);
  $id = mysqli_insert_id($conn);

  exit();
}
?>