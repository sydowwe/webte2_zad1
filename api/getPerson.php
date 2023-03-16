<?php
require './config/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM People WHERE id = ?");
$stmt->execute([$id]);
$results = $stmt->get_result();
if (mysqli_num_rows($results) > 0) {
  $row = $results->fetch_assoc();
}
header('Content-Type: application/json');
echo json_encode($row);