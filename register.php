<?php
require_once "config.php";
$span = "";

if(isset($_POST['button'])){
if(strlen($_POST["username"]) < 5 || strlen($_POST["password"]) < 5){
    $span = "Username and password need to be 5 characters or longer";
}else{
    if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $span = "";
        $username = $_POST["username"];
        $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $email = $_POST["email"];
        $data = date("Y-m-d");

        //mysql connect and query
        $sql = "SELECT * FROM `users` WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $span = "Account exists";
            }
        } else {
            $sql1 = "INSERT INTO `users` (`username`, `password`, `email`, `created_at`) VALUES ('$username','$hashed_password','$email','$data')";
            $result1 = $conn->query($sql1);

            $sql2 = "SELECT * FROM `users` WHERE username='$username'";
            $result2 = $conn->query($sql2);

            if ($result2->num_rows > 0) {
                $span = "Register succesfull";
                mkdir("uploads/$username");
            }else{
                $span = "Try again later ...";
            }
        }
        
    }else{
        $span = $_POST["email"] ." is a not valid email address";
    }
    

}
    
$conn->close();

}?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/borderRGB.css?v=<?php echo time(); ?>" />
    <meta name="viewport" content="width-device, initial-scale=0.8"/>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: auto; padding: auto; padding: 30px; }
    </style>
</head>
<body>
<div class="wrapper">
        <form action="" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="" value="" autocomplete="off" placeholder=" ">
                
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="" value="" autocomplete="off" placeholder=" ">
                
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="" value="" autocomplete="off" placeholder=" ">
                
            </div>
            <div class="form-group">
                <input class="button" type="submit" name="button" class="btn btn-primary" value="Register">
                <input id="reset" class="button" type="reset" class="btn btn-default" value="Reset">
            </div>
            <span id="warn"><?php echo $span;?></span><br>
            <p>Already have an account? <a href="login.php" style="color: #24fe41;">Login here</a>.</p>
        </form>
    </div>
</body>
</html>