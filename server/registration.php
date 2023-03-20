<?php
    include("config.php");
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $query_string = "INSERT INTO utenti (email, pwd) values('$email', '$password')";
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

    $result = $mysqli->query($query_string);

    echo json_encode($result);
?>