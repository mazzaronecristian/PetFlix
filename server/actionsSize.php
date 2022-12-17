<?php
header("Access-Controll-Allow-Methods: POST");
header('Content-Type: text/json');
include("config.php");

if (isset($_POST['state']) && isset($_POST['id']) && isset($_POST['description'])) {
    $state = $_POST['state'];
    $id = $_POST['id'];
    $description = $_POST['description'];
}
 else {
    echo "you didn't specify a text";
    return;
}
$query_string = "INSERT INTO impostazioni values ($id, $state)";
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$result = $mysqli->query($query_string);

$query_string = "SELECT state FROM impostazioni";
$result = $mysqli->query($query_string);

$row = $result->fetch_array(MYSQLI_ASSOC);

$response = array("value" => $row);

echo json_encode($response);
?>