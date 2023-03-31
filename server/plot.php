<?php
header("Access-Controll-Allow-Origin: null");
header("Access-Controll-Allow-Methods: POST");
header('Content-Type: text/json');
include("config.php");
$action = $_POST['action'];

/* conterrà la stringa di query al database */
$query_string = "";

/* smista secondo il tipo di richiesta */
switch ($action) {
	case "load":
		loadData();
		break;
	case "insert":
		//echo($action);
		insertData();
		break;
	case "update":
		updateData();
		break;
	case "remove":
		removeData();
		break;
}

function loadData(){
    session_start();
	if( isset($_SESSION['device']) )
		$device = $_SESSION['device'];
	else{
		echo 'device non impostato';
		return;
	}
    $query_string = "SELECT weight, date FROM pesi WHERE scheda = $device order by date";
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

    $result = $mysqli->query($query_string);
    $weights = array();
    
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$row_weight = $row['weight'];
		$row_date = $row['date'];

		$weight = array('weight' => $row_weight, 'date' => $row_date);
		array_push($weights, $weight);
	}

    $response = array('weights' => $weights);
    
    // encodo l'array in JSON
	echo json_encode($response);
}

function insertData(){

	session_start();
	if( isset($_SESSION['device']) )
		$device = $_SESSION['device'];
	else{
		echo 'device non impostato';
		return;
	}
	
    $weight = $_POST['weight'];
    $date = $_POST['date'];

    $query_string = "INSERT INTO pesi (weight, scheda,date) values ($weight, $device , '" . htmlspecialchars($date) . "')";
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

    $result = $mysqli->query($query_string);

    $query_string = "SELECT * FROM pesi WHERE scheda = $device order by date asc";
	$result = $mysqli->query($query_string);

    $weights = array();
    
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$row_id = $row['id'];
		$row_weight = $row['weight'];
		$row_date = $row['date'];

		$weight = array('id' => $row_id, 'weight' => $row_weight, 'date' => $row_date);
		array_push($weights, $weight);
	}

    $response = array('weights' => $weights);

	// encodo l'array in JSON
	echo json_encode($response);
}
?>