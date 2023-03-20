<?php
    include("config.php");
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $query_string = "INSERT INTO utenti (email, nome, pwd) values('$email','$username', '$password')";
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

    $result = $mysqli->query($query_string);

    if(!$result) echo json_encode('email già in uso');
    else echo json_encode('registrazione avvenuta con successo');

?>