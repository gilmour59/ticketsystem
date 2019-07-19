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
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <style type="text/css">
            body{ font: 14px sans-serif; }
        </style>
    </head>
    <body>
        <div class="container">     
            <div class="row my-3">
                <div class="col-md-8">
                    <h2>Users</h2>
                </div>                                      
                <div class="col-md-4">
                    <a class="float-right btn btn-info" href="add-users.php">Add User</a>
                </div>      
            </div>                   
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
        <script src="../js/jquery-3.4.1.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </body>
</html>