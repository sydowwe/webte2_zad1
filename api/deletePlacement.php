<?php
require './config/config.php';
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM Placement WHERE id = ?");
$stmt->execute([$id]);
echo "OK";