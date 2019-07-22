<?php
    session_start();
    
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header('location: /ticketsystem/auth/login.php');
        exit;
    }
?>