<?php 	
    //Authorization
    require_once("authorize-admin.php");

    // Include config file
    require_once("../config/connectvars.php");

    $valid['success'] = array('success' => false, 'messages' => array());

    // Define variables and initialize with empty values
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = trim($_POST["username"]);
        $role = $_POST["role"];

        // Validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
            $valid['messages']['username'] = $username_err;
            $valid['success'] = false;
        } else{
            /* Attempt to connect to MySQL database */
            $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Prepare a select statement
            $sql = "SELECT user_id FROM users WHERE username = ?";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = trim($_POST["username"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $username_err = "This username is already taken.";
                        $valid['messages']['username'] = $username_err;
                        $valid['success'] = false;
                    } else{
                        $username = trim($_POST["username"]);
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                // Close statement
                mysqli_stmt_close($stmt);
            }                            
        }
        
        // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password.";
            $valid['messages']['password'] = $password_err;
            $valid['success'] = false;
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";
            $valid['messages']['password'] = $password_err;
            $valid['success'] = false;
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";
            $valid['messages']['confirm_password'] = $confirm_password_err;
            $valid['success'] = false;
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
                $valid['messages']['confirm_password'] = $confirm_password_err;
                $valid['success'] = false;
            }
        }
        
        // Check input errors before inserting in database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            
            // Prepare an insert statement
            $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
            
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_role);
                
                // Set parameters
                $param_username = $username;
                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_role = $_POST["role"];
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $username = $password = $confirm_password = "";
                    $valid['success'] = true;
                } else{
                    echo "Something went wrong. Please try again later.";
                }
                // Close statement
                mysqli_stmt_close($stmt);
            }                 
        }    
        // Close connection
        mysqli_close($link);
    }
    echo json_encode($valid);