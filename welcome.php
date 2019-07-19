<?php
    // Initialize the session
    session_start();

    require_once("admin/authorize-normal.php");
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome</title>
        <link rel="stylesheet" href="/ticketsystem/css/bootstrap.min.css">
        <style type="text/css">
            body{ font: 14px sans-serif; text-align: center; }
        </style>
    </head>
    <body>
        <div class="page-header">
            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome.</h1>
        </div>
        <p>
            <a href="auth/logout.php" class="btn btn-danger">Sign Out of Your Account</a>
        </p>
        <script src="/ticketsystem/js/jquery-3.4.1.min.js"></script>
        <script src="/ticketsystem/js/popper.min.js"></script>
        <script src="/ticketsystem/js/bootstrap.min.js"></script>
    </body>
</html>