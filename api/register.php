<?php
require './config/config.php';
require_once './PHPGangsta/GoogleAuthenticator.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $json = file_get_contents('php://input');
  $formData = json_decode($json);

  $name  = $formData->name;
  $surname  = $formData->surname;
  $username = $formData->username;
  $email  = $formData->email;
  $password = password_hash($formData->password, PASSWORD_BCRYPT, ['cost' => 13]);

  $g2fa = new PHPGangsta_GoogleAuthenticator();
  $user_secret = $g2fa->createSecret();
  $codeURL = $g2fa->getQRCodeGoogleUrl('Olympic Games', $user_secret);

  $result = mysqli_query($conn,"SELECT username,email FROM User WHERE username='$username' OR email='$email'");
  if (mysqli_num_rows($result) > 0) {      
    $errorData = ['error' => true, 'body' => $result->fetch_assoc()];
    echo(json_encode($errorData));
  }
  else{
    $stmt = $conn->prepare('INSERT INTO User (name, surname, username, email, password, method, code) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $surname, $username, $email, $password, 'Registration', $user_secret]);
    $id = mysqli_insert_id($conn);
    echo(json_encode(['error' => false,'body'=>$codeURL]));
  }  
  exit();
}