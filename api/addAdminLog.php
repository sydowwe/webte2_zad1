<?php
require './config/config.php';
if (empty($_SESSION["id"])) {
    header("Location: https://site215.webte.fei.stuba.sk/zad1/api/login.php");
}
session_start();
$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $changedData = json_decode($json);

    $operation = $changedData->operation;
    $table = $changedData->table;
    $recordId = $changedData->recordId;
   
    $results = mysqli_query($conn, "SELECT log FROM User_log WHERE user_id='$id' ORDER BY login_time DESC LIMIT 1");
    if (mysqli_num_rows($results) > 0) {
        $oldLog = $results->fetch_assoc();
    }
    $log = $oldLog . "; " . "[OPERACIA: " . $operation . ", TABULKA: " . $table . ", ID_ZAZNAMU: " . $recordId . "]";


    $loggedOutTime = date('Y-m-d H:i:s');
    $sql = "UPDATE User_log SET log = '$log' WHERE user_id='$id' ORDER BY login_time DESC LIMIT 1";
    mysqli_query($conn, $sql);

    echo(json_encode('Done'));
    exit();
}
