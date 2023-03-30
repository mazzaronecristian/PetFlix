<?php 
    include('config.php');
    if(isset($_GET['id'])){
        session_start();
        $_SESSION['device'] = $_GET['id'];
        header('Location: ../index.php');
        exit();
    }
?>