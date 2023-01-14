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
    $id = $_POST['id'];

    $query_string = "SELECT state FROM impostazioni WHERE id = '$id'";
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    $result = $mysqli->query($query_string);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if($row!=null){
        $state = array('state'=>$row['state']);
        echo json_encode($state);
    }
}

function insertData(){
    $id = $_POST['id'];
    $state = $_POST['state'];

    $query_string = "SELECT id FROM impostazioni WHERE  id = $id";
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    $result = $mysqli->query($query_string);

    $row = $result->fetch_array(MYSQLI_ASSOC);


    if ($row != null) {
        $query_string = "UPDATE impostazioni SET state = $state WHERE id = $id";
        $result = $mysqli->query($query_string);
    }
    else{
        $query_string = "INSERT INTO impostazioni values ($id, $state)";
        $result = $mysqli->query($query_string);
    } 

    $query_string = "SELECT * FROM impostazioni WHERE id = $id";
    $result = $mysqli->query($query_string);

    $states = array();

    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
        $row_id = $row['id'];
        $row_state = $row['state'];

        $time = array('id' => $row_id, 'state' => $row_state);
        array_push($states, $time);
    }

    $response = array('state' => $states);

    // encodo l'array in JSON
    echo json_encode($response);
}


?>