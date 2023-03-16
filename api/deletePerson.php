<?php
require './config/config.php';
$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM People WHERE id = ?");
$stmt->execute([$id]);
echo "OK";