<?php
require './config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $json = file_get_contents('php://input');
  $formData = json_decode($json);

  $name  = $formData->name;
  $surname  = $formData->surname;
  $birthDay = $formData->birthDay;
  $birthPlace  = $formData->birthPlace;
  $birthCountry  = $formData->birthCountry;
  $deathDay = ($formData->deathDay !== '') ? $formData->deathDay : null;
  $deathPlace = ($formData->deathPlace !== '') ? $formData->deathPlace : null;
  $deathCountry = ($formData->deathCountry !== '') ? $formData->deathCountry : null;

  $stmt = $conn->prepare('INSERT INTO People (name, surname, birth_day, birth_place, birth_country, death_day, death_place, death_country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
  $stmt->execute([$name, $surname, $birthDay, $birthPlace, $birthCountry, $deathDay, $deathPlace, $deathCountry]);
  $id = mysqli_insert_id($conn);
  echo($id);
  exit();
}
