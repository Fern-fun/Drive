<?php 
  require_once "config.php";
  session_start();
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }


  if(isset($_POST['button'])){
      if($_POST['msg'] != null){
        $msg = htmlentities($_POST['msg']);
        $name = $_SESSION["username"];
        $data = date("Y-m-d g:i a");
        $ip = $_SERVER['REMOTE_ADDR'];
  
        $sql = "INSERT INTO `chat` (`name`, `msg`, `dataSend`, `ip`) VALUES ('$name','$msg','$data','$ip')";
        
        if ($conn->query($sql) === TRUE) {
          
        } else {
          
        }
      }
  }?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="css/css.css">
</head>
<body tyle='overflow:hidden'>
    <script>window.scrollTo(0,document.body.scrollHeight);</script>
    <div class="chat">
    <?php 

    $sql = "SELECT * FROM `chat` WHERE 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          

          if($row['msg'] == ":wiggle:"){
            echo "<msg><h5>".$row['name']." | ".$row['dataSend']."</h5><hr/><span class='msg'>".'<img src="https://cdn.discordapp.com/emojis/644407772989095967.gif?v=1" class="emoji">'."</span></msg>";
          }else{// NORMAL MESSAGE
            echo "<msg><h5>".$row['name']." | ".$row['dataSend']."</h5><hr/><span class='msg'>".$row['msg']."</span></msg>";
          }
            
        }
    } else {
        
    }?>
    <form action="" method="post">
        <textarea name="msg" id="msg" cols="30"></textarea>
        <input class="button" type="submit" name="button" value="Send">
    </form>
    </div>

    
</body>
</html>