<?php 
    $cookie_name = "username";
    $cookie_value = "pippo";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

    $cookie_name = "password";
    $cookie_value = "password";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

    if(isset($_COOKIE["username"])&&isset($_COOKIE["password"])){
        session_start();
        $_SESSION['name'] = $_COOKIE["username"];
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('commonHeader.php') ?>

    <title>PetFlix</title>
</head>

<body>

    <h2>prova prova</h2>
</body>

</html>