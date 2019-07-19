<?php
    // Include config file
    require_once("../config/connectvars.php");

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                
    $query = "SELECT department, username, role, created_at FROM users ORDER BY role ASC, department ASC";            
    $result = mysqli_query($link, $query);

    $data = array();
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    mysqli_close($link);
    
    echo json_encode($data);
?>