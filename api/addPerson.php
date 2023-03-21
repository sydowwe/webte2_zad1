<?php
require './config/config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $json = file_get_contents('php://input');
  $formData = json_decode($json);

  $name  = $formData->name;
  $surname  = $formData->surname;
  $birth_day = $formData->birth_day;
  $birth_place  = $formData->birth_place;
  $birth_country  = $formData->birth_country;
  $death_day  = $formData->death_day ?? null;
  $death_place  = $formData->death_place ?? null;
  $death_country  = $formData->death_country ?? null;

  error_log(var_export($formData, true));
  $stmt = $conn->prepare('INSERT INTO People (name, surname, birth_day, birth_place, birth_country, death_day, death_place, death_country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
  $stmt->execute([$name, $surname, $birth_day, $birth_place, $birth_country, $death_day, $death_place, $death_country]);
  $id = mysqli_insert_id($conn);
  exit();
}
