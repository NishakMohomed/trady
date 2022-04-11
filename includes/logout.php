<?php
    session_start();
    
    $_SESSION['email'] = "";
    $_SESSION['login'] = false;
    session_destroy();
    header('location: ../pages/login.php');
?>