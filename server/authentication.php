<?php
    include('config.php');
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query_string = "SELECT nome, pwd from utenti WHERE email = '$username'";
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
        setcookie('username', $username, time() +60*60*24, '/');
        setcookie('password', $password, time() +60*60*24, '/');
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header('Location: ../index.php');
        exit();
    }
?>