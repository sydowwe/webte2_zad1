<?php
require './config/config.php';
$results = mysqli_query($conn, "SELECT * FROM People");
$people = [];
if (mysqli_num_rows($results) > 0) {
    while ($row = $results->fetch_assoc()) {
        $people[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($people);