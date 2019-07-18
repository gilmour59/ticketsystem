<?php
    /* Database credentials. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'ticketsystem');
    
    /* Attempt to connect to MySQL database */
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $check_admin = "SELECT * FROM users WHERE username = 'admin'";

    $result = mysqli_query($link, $check_admin);

    if(mysqli_num_rows($result) === 0){
        $admin_password = password_hash('Admin123', PASSWORD_DEFAULT);
        $create_admin = "INSERT INTO users (username, password, department, role) VALUES ('admin', '$admin_password', 'IT', 'admin')";

        mysqli_query($link, $create_admin);        
    }    
?>