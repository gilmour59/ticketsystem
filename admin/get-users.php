<?php
    require_once('authorize-admin.php');

    // Include config file
    require_once("../config/connectvars.php");

    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                
    $query = "SELECT user_id, division, username, role, created_at 
            FROM users
            INNER JOIN division ON users.division_id = division.division_id 
            ORDER BY created_at DESC, role ASC, division ASC";

    $result = mysqli_query($link, $query);

    $output = array('data' => array());

    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)) {
            $user_id = $row[0];
            $username = $row[2];

            $button_edit = '<button type="button" class="btn btn-sm btn-info" data-toggle="modal" id="editUserModalBtn" data-target="#editUserModal" onclick="editUser(' . $user_id . ')">Edit</button>';
            $button_delete = '<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" id="deleteUserModalBtn" data-target="#deleteUserModal" onclick="deleteUser(' . $user_id . ',\'' . $username . '\')">Delete</button>';
                
            $output['data'][] = array($row[1], $row[2], $row[3], $row[4], $button_edit, $button_delete);
        }
    }
    mysqli_close($link);
    
    echo json_encode($output);
?>