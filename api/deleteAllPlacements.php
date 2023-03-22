<?php
require './config/config.php';

$personId = $_GET['person_id'];
$stmt = $conn->prepare("DELETE FROM Placements WHERE person_id = ?");
$stmt->execute([$personId]);
echo "OK";