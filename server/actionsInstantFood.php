<?php

$id = $_POST['id'];
$state = $_POST['state'];

$query_string = "SELECT id FROM impostazioni WHERE  id = $id";
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$result = $mysqli->query($query_string);

$row = $result->fetch_array(MYSQLI_ASSOC);


if ($row != null) $query_string = "UPDATE impostazioni SET state = $state WHERE id = $id";
else $query_string = "INSERT INTO impostazioni values ($id, $state)";

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

?>