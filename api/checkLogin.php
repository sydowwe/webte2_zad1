<?php
session_start();
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
  $isLoggedIn = $_SESSION['email'];
} else {
  $isLoggedIn = null;
}

header('Content-Type: application/json');
echo json_encode($isLoggedIn);