<?php
    session_start();
    $_SESSION = array();
    unset($_COOKIE['email']);
    setcookie('email', null, -1, '/'); 
    unset($_COOKIE['password']);
    session_destroy();
    header('Location: ../login.php');
    exit();
?>