<?php
require './config/config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM Placements WHERE id = ?");
$stmt->execute([$id]);
echo "OK";