<?php
require './config/config.php';

if (!empty($_SESSION["id"])) {
    header("Location: https://site215.webte.fei.stuba.sk/zad1");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $formData = json_decode($json);

    $login = $formData->login;
    $password = $formData->password;

    $personResult = mysqli_query($conn, "SELECT * FROM User WHERE username = '$login' OR email = '$login'");
 
    
    if (mysqli_num_rows($personResult) > 0) {
        $person = mysqli_fetch_assoc($personResult);
        if (password_verify($password, $person['password'])) {
            $currentId = $person['id'];
            $codeResult = mysqli_query($conn, "SELECT code FROM User WHERE id=$currentId");

            if (mysqli_num_rows($codeResult) > 0) {
                $secret = mysqli_fetch_assoc($codeResult);
                echo(json_encode(['error' => false,'body'=>["personId"=>$currentId,"personEmail"=>$person['email'],"secret"=>$secret['code']]]));
            }
        } 
        else 
        {
            echo(json_encode(['error' => true,'body'=>'Wrong password or username']));
        }
    } 
    else 
    {
        echo(json_encode(['error' => true,'body'=>'User is not registered']));
    }
    exit();
}
