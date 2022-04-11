<?php
    session_start();
    
    $_SESSION['adminUsername'] = "";
    $_SESSION['adminLogin'] = false;
    session_destroy();
    header('location: ../admin/adminLogin.php');
?>