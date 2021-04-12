<?php
require_once "config.php";

if(isset($_POST['button'])){

    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $sql = "SELECT * FROM `users` WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){
            if($row["username"] == $username && password_verify($_POST["password"],$row["password"])){
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username; 
                // Zabezpieczenia sesji
                $characters = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);

                header("location: index.php?session=".password_hash($characters, PASSWORD_DEFAULT));
            }elseif($row["username"] == $username && !password_verify($_POST["password"],$row["password"])){
                $span = "Wrong Password";
            }
            else{
                $span = "Account not exist";
                $_SESSION['loggedin'] = false;
            }
        }
    }else{
        $span = "Wrong user or password";
    }
}
            


?>
<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/borderRGB.css?v=<?php echo time(); ?>" />
    <meta name="viewport" content="width-device, initial-scale=0.8"/>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{
            width: auto;
            height: auto;
            padding: 30px;
        }
    </style>
</head>
<body>
<div class="wrapper">       
    <div class="form">
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
                <input class="button" type="submit" name="button" class="btn btn-primary" value="Login">
                <input id="reset" class="button" type="reset" class="btn btn-default" value="Reset">
            </div>
            <span id="warn"><?php echo $span;?></span><br>
            <p>Don't have an account? <a href="register.php" style="color: #24fe41;">Register here</a>.</p>
        </form>
        </div>
    </div>
</body>
</html>