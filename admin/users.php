<?php
    session_start();

    //Authorization
    require_once("authorize-admin.php");

    // Include config file
    require_once("../config/connectvars.php");
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Users</title>
        <link rel="stylesheet" href="/ticketsystem/css/bootstrap.min.css">
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Users</h2>
            <table class="table table-bordered">
                <thead>
                    <th>Department</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Created At</th>
                </thead>
            <?php                
                $query = "SELECT * FROM users ORDER BY role ASC, department ASC";            
                $data = mysqli_query($link, $query);

                if (mysqli_num_rows($data) > 0){
                    while ($row = mysqli_fetch_assoc($data)) {
                        echo '<tr>';
                        echo '<td>' . $row['department'] . '</td>';
                        echo '<td>' . $row['username'] . '</td>';
                        echo '<td>' . $row['role'] . '</td>';
                        echo '<td>' . $row['created_at'] . '</td>';
                        echo '</tr>';
                    }
                }
                mysqli_close($link);
            ?>
            </table>
        </div>
        <script src="/ticketsystem/js/jquery-3.4.1.min.js"></script>
        <script src="/ticketsystem/js/popper.min.js"></script>
        <script src="/ticketsystem/js/bootstrap.min.js"></script>
    </body>
</html>