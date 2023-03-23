<?php
require './config/config.php';
session_start();
if (empty($_SESSION["id"])) {
    header("Location: https://site215.webte.fei.stuba.sk/zad1/api/login.php");
}
$email=$_SESSION['email'];
$id=$_SESSION['id'];

$loggedOutTime = date('Y-m-d H:i:s');
$sql = "UPDATE User_log SET logout_time = '$loggedOutTime' WHERE user_id='$id'";
mysqli_query($conn, $sql);

if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}
header("Location: https://site215.webte.fei.stuba.sk/zad1");