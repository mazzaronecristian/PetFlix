<?php
    include("config.php");
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query_string = "INSERT INTO utenti (email, pwd) values('$email', '$password')";
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

    session_start();
    $result = $mysqli->query($query_string);
    if($result == false)
        echo json_encode($result);
    else {
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        echo json_encode($result);
    }
 ?>