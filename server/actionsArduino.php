<?php
header("Access-Controll-Allow-Methods: GET");
header('Content-Type: text/json');
include("config.php");

$query_string = "SELECT time FROM orari WHERE controlFlag=0";
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$result = $mysqli->query($query_string);

$times = array();
$response = array();
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
	$time = $row['time'];

	array_push($times, $time);
}

for ($i = 0; $i < count($times); $i++) {
	$tmp = array("tempo" . $i => $times[$i]);
	$response = array_merge($response, $tmp);
}

echo json_encode($response);
?>