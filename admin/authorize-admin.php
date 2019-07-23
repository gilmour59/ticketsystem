<?php
  session_start();
  
  $_SESSION['url'] = $_SERVER['REQUEST_URI'];

  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header('location: /ticketsystem/auth/login.php');
      exit;
  }
  if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    // The user name/password are incorrect so send the authentication headers
    header('HTTP/1.1 401 Unauthorized');
    exit('Sorry, you must be authorized to access this page. <a href="/ticketsystem/welcome.php">Go Back</a>');
  }
?>
