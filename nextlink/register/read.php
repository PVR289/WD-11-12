<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM registration WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $Name = $row["Name"];
                $Address = $row["Address"];
                $Mobile = $row["Mobile"];
                $Enroll = $row["Enroll"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile
    </title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<h1 style="text-align:center;color:#49C628">NEXT LINK</h1>
<div class="box-form">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <h5 style="text-align:center;color:rgb(44, 212,
                        147);text-shadow: 2px 2px rgb(83, 214, 219), 2px 2px
                        green;">Profile</h5>
                        <br><br><br>
                    <div class="form-group">
                        <label>Name</label>
                        <p><b><?php echo $row["Name"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p><b><?php echo $row["Address"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Mobile</label>
                        <p><b><?php echo $row["Mobile"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Enroll</label>
                        <p><b><?php echo $row["Enroll"]; ?></b></p>
                    </div><br><br>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
            
            </div>        
        </div>
    </div>
</div> 
</div>
</body>
</html>
