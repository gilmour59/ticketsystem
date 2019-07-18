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
        <?php
            include_once('/ticketsystem/css.php');
        ?>
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
        <?php
            include_once('/ticketsystem/js.php');
        ?>
    </body>
</html>