<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header('location: /ticketsystem/welcome.php');
    exit;
}
 
// Include config file
require_once('../config/connectvars.php');
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, username, password, role FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $user_id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role;

                            if($role === "admin"){
                                // Redirect user to admin dashboard
                                header("location: ../admin/users.php");
                            }else{
                                // Redirect user to welcome page
                                header("location: ../welcome.php");
                            }                                                    
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }else{
            echo "Something's wrong with the query: " . mysqli_error($link);
        }
    }
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="/ticketsystem/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../css/fonts/font-awesome-4.7.0/css/font-awesome.min.css">    
        <link rel="stylesheet" type="text/css" href="../css/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">    
        <link rel="stylesheet" type="text/css" href="../css/login/animate.css">    
        <link rel="stylesheet" type="text/css" href="../css/login/hamburgers.min.css">    
        <link rel="stylesheet" type="text/css" href="../css/login/animsition.min.css">    
        <link rel="stylesheet" type="text/css" href="../css/login/select2.min.css">    
        <link rel="stylesheet" type="text/css" href="../css/login/daterangepicker.css">    
        <link rel="stylesheet" type="text/css" href="../css/login/util.css">
        <link rel="stylesheet" type="text/css" href="../css/login/main.css">
    </head>
    <body>                
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-b-160 p-t-50">
                    <form id="login-form" class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <span class="login100-form-title p-b-43">
                            Account Login
                        </span>                        
                        <div class="wrap-input100 rs1 validate-input" data-validate="required">
                            <input class="input100" type="text" name="username">
                            <span class="label-input100">Username</span>
                        </div>                                                
                        <div class="wrap-input100 rs2 validate-input" data-validate="required">
                            <input class="input100" type="password" name="password">
                            <span class="label-input100">Password</span>
                        </div>
                        <div class="container-login100-form-btn">
                            <button type="submit" form="login-form" class="login100-form-btn" value="Submit">
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="/ticketsystem/js/jquery-3.4.1.min.js"></script>
        <script src="/ticketsystem/js/popper.min.js"></script>
        <script src="/ticketsystem/js/bootstrap.min.js"></script>      
        <script src="../js/login/animsition.min.js"></script>
        <script src="../js/login/select2.min.js"></script>
        <script src="../js/login/moment.min.js"></script>
        <script src="../js/login/daterangepicker.js"></script>
        <script src="../js/login/countdowntime.js"></script>
        <script src="../js/login/main.js"></script>
    </body>
</html>