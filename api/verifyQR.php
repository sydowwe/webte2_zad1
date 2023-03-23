<?php
require './config/config.php';
require_once './PHPGangsta/GoogleAuthenticator.php';


session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $personData = json_decode($json);

    $secret = $personData->secret;
    $personId = $personData->personId;
    $personEmail = $personData->personEmail;
    $code = $personData->code;

    $g2fa = new PHPGangsta_GoogleAuthenticator();

    if ($g2fa->verifyCode($secret, $code, 2)) {
        $loggedInTime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO User_log (user_id, login_time) VALUES ('$personId', '$loggedInTime')";
        mysqli_query($conn, $sql);
        
        $_SESSION["login"] = true;
        $_SESSION["id"] = $personId;
        $_SESSION["email"] = $personEmail;

        echo(json_encode(['error' => false,'body'=>'logged in']));
    } else {
        echo(json_encode(['error' => true,'body'=>'Incorrect QR code']));
    }
    exit();
}
