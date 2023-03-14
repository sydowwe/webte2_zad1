<?php
require './config/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM People WHERE id = ?");
$stmt->execute([$id]);
$results = $stmt->get_result();
if ($results->num_rows > 0) {
  $row = $results->fetch_assoc();
}
// header('Content-Type: application/json');
// echo json_encode($row);
var_dump($row);