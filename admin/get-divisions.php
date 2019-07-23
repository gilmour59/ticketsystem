<?php
    require_once('authorize-admin.php');

    // Include config file
    require_once("../config/connectvars.php");

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                
    $query = "SELECT division_id, name FROM divisions ORDER BY name ASC";            
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)) {                    
            $output[] = array('division_id' => $row['division_id'], 'name' => $row['name']);
        }
    }
    mysqli_close($link);
    
    echo json_encode($output);
?>