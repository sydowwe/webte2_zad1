<?php
require './config/config.php';
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $personID = $_POST['personID'];
  $placement  = $_POST['placement'];
  $gamesID  = $_POST['gamesID'];
  $discipline = $_POST['discipline'];

  $stmt = $conn->prepare('UPDATE Placements person_id = ?, placement = ?, games_id = ?, discipline = ? WHERE id = ?');
  $stmt->execute([$personID, $placement, $gamesID, $discipline, $id]);
  $id = mysqli_insert_id($conn);

  exit();
}
?>