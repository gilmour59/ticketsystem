<?php
    require_once('authorize-admin.php');

    // Include config file
    require_once("../config/connectvars.php");

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $user_id = $_POST['edit_user_id'];

    $query = "SELECT user_id, division_id, username, role FROM users WHERE user_id = $user_id";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
    }else{
        $row = array();
    }
    mysqli_close($link);
    
    echo json_encode($row);
?>