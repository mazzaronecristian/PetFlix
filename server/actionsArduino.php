<?php
header("Access-Controll-Allow-Methods: GET");
header('Content-Type: text/json');
include("config.php");
//* query orari

$device = $_GET['id'];
$query_string = "SELECT time_format(time, '%H:%i') as time FROM orari WHERE controlFlag = 0 AND scheda = '$device'";
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

//* query impostazioni
$query_string = "SELECT * FROM impostazioni";
$result = $mysqli->query($query_string);

$states = array();
$ids = array();
while($row = $result->fetch_array(MYSQLI_ASSOC)){
	$id = $row['id'];
	$state = $row['state'];
	
	array_push($ids, $id);
	array_push($states, $state);
}

for($i = 0; $i < count($states); $i++){
	$tmp = array("impostazione". $ids[$i] => $states[$i]);
	$response = array_merge($response, $tmp);
}
echo json_encode($response);
?>