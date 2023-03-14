<?php
require './config/config.php';

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = $_POST['name'];
  $surname  = $_POST['surname'];
  $birth_day = $_POST['birth_day'];
  $birth_place  = $_POST['birth_place'];
  $birth_country  = $_POST['birth_country'];
  $death_day  = $_POST['death_day'];
  $death_place  = $_POST['death_place'];
  $death_country  = $_POST['death_country'];

  $stmt = $conn->prepare('UPDATE People SET name = ?, surname = ?, birth_day = ?, birth_place = ?, birth_country = ?, death_day = ?, death_place = ?, death_country = ? WHERE id = ?');
  $stmt->execute([$name, $surname, $birth_day, $birth_place, $birth_country, $death_day, $death_place, $death_country, $id]);
  exit();
}
?>