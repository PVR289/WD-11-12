<?php
// Initialize the session
session_start();
 
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username  = "";
$username_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    

    
    // Validate credentials
    if(empty($username_err) ){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
                {        
                    
                    if(mysqli_stmt_fetch($stmt))
                    {
                        session_start();
                            
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;                            
                        
                        // Redirect user to welcome page
                        header("location: welcome.php");
                    }
                } else
                {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username !!!";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
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
    <title>forget</title>
    <link rel="stylesheet" href="main.css">

</head>
<body>
<h1 style="text-align:center;color:#49C628">NEXT LINK</h1>
<div class="box-form">
    <div class="main">
    <h5 style="text-align:center;color:rgb(44, 212,
                        147);text-shadow: 2px 2px rgb(83, 214, 219), 2px 2px
                        green;">Reset</h5>
        
        <p>Please fill in your credentials to Reset Password.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
                <input type="text" name="username" placeholder="Username"  
                <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?> value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>          
                
                <br><br>
        
                <button type="submit" class="btn btn-primary" >REQUEST</button>  
            <p><a href="login.php"> Back to login</a></p>
            </div>
        </form>
    </div>
</div>
</body>
</html>