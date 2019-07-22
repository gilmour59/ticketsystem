<?php
    require_once('authorize-admin.php');

    // Include config file
    require_once("../config/connectvars.php");

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                
    $query = "SELECT user_id, department, username, role, created_at FROM users ORDER BY role ASC, department ASC";            
    $result = mysqli_query($link, $query);

    $output = array('data' => array());

    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)) {
            $user_id = $row[0];

            $button = '<button type="button" class="btn btn-sm btn-info">test</button>';
            $output['data'][] = array($row[1], $row[2], $row[3], $row[4], $button);
        }
    }
    mysqli_close($link);
    
    echo json_encode($output);
?>