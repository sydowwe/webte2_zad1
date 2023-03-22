<?php
require './config/config.php';

$id = $_GET['id'];

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

  $stmt = $conn->prepare('UPDATE People SET name = ?, surname = ?, birth_day = ?, birth_place = ?, birth_country = ?, death_day = ?, death_place = ?, death_country = ? WHERE id = ?');
  $stmt->execute([$name, $surname, $birthDay, $birthPlace, $birthCountry, $deathDay, $deathPlace, $deathCountry, $id]);
  
  echo(json_encode('edit'));
  exit();
}