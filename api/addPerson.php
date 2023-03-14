<?php
require './config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = $_POST['name'];
  $surname  = $_POST['surname'];
  $birth_day = $_POST['birth_day'];
  $birth_place  = $_POST['birth_place'];
  $birth_country  = $_POST['birth_country'];
  $death_day  = $_POST['death_day'];
  $death_place  = $_POST['death_place'];
  $death_country  = $_POST['death_country'];

  $stmt = $conn->prepare('INSERT INTO People (name, surname, birth_day, birth_place, birth_country, death_day, death_place, death_country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
  $stmt->execute([$name, $surname, $birth_day, $birth_place, $birth_country, $death_day, $death_place, $death_country]);
  $id = mysqli_insert_id($conn);

  header('Location: /editPerson.html?id='.$id);
  exit();
}
?>
