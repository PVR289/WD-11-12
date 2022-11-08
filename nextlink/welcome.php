<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<h1 style="text-align:center;color:#49C628">NEXT LINK</h1>
    <h1 class="my-5">User:- <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h1>
    <div class="box-form">
    <div class="main">
   
        <form action="register/index.php">
        <button type="submit" class="btn btn-primary" >Register</button><br><br>
        </form>

        <form action="upload/index.php">
        <button type="submit" class="btn btn-primary" > Upload Document</button><br><br>
        </form>

        <form action="reset-password.php">
        <button type="submit" class="btn btn-primary" > Reset Your Password </button><br><br>
        </form>

        <form action="logout.php">
        <button type="submit" class="btn btn-primary" >Sign Out</button><br><br>
      
</div>
    </div>
</body>
</html>