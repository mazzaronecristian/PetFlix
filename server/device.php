<?php
include('config.php');

$action = $_POST['action'];
switch ($action) {
    case "load":
        loadData();
        break;
    case "insert":
        //echo($action);
        insertData();
        break;
}

function loadData(){
    session_start();
    $email = $_SESSION["email"];
    $query_string = "SELECT * FROM schede JOIN utenti_schede on schede.id = utenti_schede.scheda 
                    WHERE utenti_schede.utente = '$email'";

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    $result = $mysqli->query($query_string);

    $devices = array();

	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$row_id = $row['id'];
		$row_nome = $row['nome'];

		$device = array('id' => $row_id,'nome' => $row_nome);
		array_push($devices, $device);
	}
    
	$response = array('devices' => $devices);

	// encodo l'array in JSON
	echo json_encode($response);
}

function insertData(){
    session_start();
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

    $query_string = "SELECT * FROM schede WHERE id = '$id'";
    
    $result = $mysqli->query($query_string);

    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row == null) {
        echo json_encode(false);
        return;
	}
    $query_string = "UPDATE schede SET nome = '$nome' WHERE id = '$id'";
    $result = $mysqli->query($query_string);
    echo json_encode($result);

    $email = $_SESSION['email'];

    $query_string = "INSERT INTO utenti_schede (utente, scheda) values ('$email','$id')";
    $result = $mysqli->query($query_string);

}

?>