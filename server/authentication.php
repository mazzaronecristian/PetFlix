<?php
    include('config.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query_string = "SELECT email, pwd from utenti WHERE email = '$email'";
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

	$result = $mysqli->query($query_string);

    $row = $result->fetch_array(MYSQLI_ASSOC);
    session_start();
    if ($row==null||$password!=$row['pwd']){
        $_SESSION['loginError'] = true;
        header('Location: ../login.php');
        exit();
    } 
    else {
        setcookie('email', $email, time() +60*60*24, '/');
        setcookie('password', $password, time() +60*60*24, '/');
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header('Location: ../index.php');
        exit();
    }
?>