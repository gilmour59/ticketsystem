<?php
    require_once('authorize-admin.php');

    // Include config file
    require_once("../config/connectvars.php");

    $valid = array('success' => false, 'messages' => '');

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $user_id = $_POST['user_id'];

    $query = "DELETE FROM users WHERE user_id = $user_id";

    if (mysqli_query($link, $query)){
        $valid['success'] = true;
        $valid['messages'] = 'User Successfully Deleted!';
    }else{
        $valid['success'] = false;
        $valid['messages'] = 'Something went wrong!';
    }
    mysqli_close($link);
    
    echo json_encode($valid);
?>