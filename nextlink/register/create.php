<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Name = $Address = $Mobile = $Enroll ="";
$Name_err = $Address_err = $Mobile_err = $Enroll_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate Name
    $input_Name = trim($_POST["Name"]);
    if(empty($input_Name)){
        $Name_err = "Please enter a Name.";
    } elseif(!filter_var($input_Name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $Name_err = "Please enter a valid Name.";
    } else{
        $Name = $input_Name;
    }
    
    // Validate Address
    $input_Address = trim($_POST["Address"]);
    if(empty($input_Address)){
        $Address_err = "Please enter an Address.";     
    } else{
        $Address = $input_Address;
    }
    
    // Validate Mobile
    $input_Mobile = trim($_POST["Mobile"]);
    if(empty($input_Mobile)){
        $Mobile_err = "Please enter the Mobile amount.";     
    } elseif(!ctype_digit($input_Mobile)){
        $Mobile_err = "Please enter a positive integer value.";
    } else{
        $Mobile = $input_Mobile;
    }

     
    // Validate Enroll
    $input_Enroll = trim($_POST["Enroll"]);
    if(empty($input_Enroll)){
        $Enroll_err = "Please enter the Enroll amount.";     
    } elseif(!ctype_digit($input_Enroll)){
        $Enroll_err = "Please enter a positive integer value.";
    } else{
        $Enroll = $input_Enroll;
    }
    
    // Check input errors before inserting in database
    if(empty($Name_err) && empty($Address_err) && empty($Mobile_err) && empty($Enroll_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO registration (Name, Address, Mobile, Enroll) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_Name, $param_Address, $param_Mobile, $param_Enroll);
            
            // Set parameters
            $param_Name = $Name;
            $param_Address = $Address;
            $param_Mobile = $Mobile;
            $param_Enroll = $Enroll;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<h1 style="text-align:center;color:#49C628">NEXT LINK</h1>
<div class="box-form">
   
    </div>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add student record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" Name="Name" class="form-control <?php echo (!empty($Name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Name; ?>">
                            <span class="invalid-feedback"><?php echo $Name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea Name="Address" class="form-control <?php echo (!empty($Address_err)) ? 'is-invalid' : ''; ?>"><?php echo $Address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $Address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="text" Name="Mobile" class="form-control <?php echo (!empty($Mobile_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Mobile; ?>">
                            <span class="invalid-feedback"><?php echo $Mobile_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Enroll</label>
                            <input type="text" Name="Enroll" class="form-control <?php echo (!empty($Enroll_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $Enroll; ?>">
                            <span class="invalid-feedback"><?php echo $Enroll_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>