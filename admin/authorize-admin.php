<?php
  if (isset($_SESSION['ROLE']) !== 'admin') {
    // The user name/password are incorrect so send the authentication headers
    header('HTTP/1.1 401 Unauthorized');
    header("location: /ticketsystem/welcome.php");
    exit('Sorry, you must be authorized to access this page.');
  }
?>
