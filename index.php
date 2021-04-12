<?php
  error_reporting(E_ERROR | E_PARSE);
  require_once "config.php";
  session_start();
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }
  // Logout
  if(isset($_POST['button'])){
      $_SESSION = array();
      // Destroy the session.
      session_destroy();
      // Redirect to login page
      header("location: login.php");
      exit;
  }
// Account life time *****************************
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM `users` WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $data = $row["created_at"];
      }
  } else {
      
  }
    $actualData = date("Y-m-d");
    $a = explode(" ",$data);

    $dateTime1 = new DateTime(''.$actualData.'');
    $dateTime2 = new DateTime(''.$a[0].'');

    $c = date_diff($dateTime2,$dateTime1);
    $conn->close();
    // Delete *****************************
    $warn = "Delete";
    if(isset($_POST['del'])){
      if($_GET['folder'] != "" || $_GET['folder'] != null){
        if (file_exists("uploads/".$_SESSION["username"]."/".$_GET['folder']."/".$_POST["fileDelete"])){
          unlink("uploads/".$_SESSION["username"]."/".$_GET['folder']."/".$_POST["fileDelete"]);
          rmdir("uploads/".$_SESSION["username"]."/".$_GET['folder']."/".$_POST["fileDelete"]);
          header("Refresh:0");

        }
      }else{
        if (file_exists("uploads/".$_SESSION["username"]."/".$_POST["fileDelete"])){
          unlink("uploads/".$_SESSION["username"]."/".$_POST["fileDelete"]);
          rmdir("uploads/".$_SESSION["username"]."/".$_POST["fileDelete"]);
          header("Refresh:0");

        }
      }

    }

    // Create Folder
    if(isset($_POST['mkdir'])){
        if(strlen($_POST["dirName"]) >= 3){
          if($_GET['folder'] != "" || $_GET['folder'] != null){
            mkdir("uploads/".$_SESSION["username"]."/".$_GET['folder']."/".$_POST["dirName"]);
            header("Refresh:0");

          }else{
            mkdir("uploads/".$_SESSION["username"]."/".$_POST["dirName"]);
            header("Refresh:0");

          }
          
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drive</title>
    <meta content="IE=8" http-equiv="X-UA-Compatible">
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/css.css?v=<?php echo time(); ?>" />
    <meta name="viewport" content="width-device, initial-scale=1.0"/>

</head>
<body>

<div class="send">
    <form action="send.php" method="POST" enctype="multipart/form-data">
    <div class="uploadFile">
      <input type="file" name="upload" id="upload-photo" multiple >
      <input id="upload" type="submit" value="Choose File" name="submit">   
    </div>
    <input type="submit" value="Upload File" name="submit" class="button">
    </form>
  <div class="logout">
    <form action="" method="post">
      <input id="logout" type="submit" class="button" name="button" class="btn btn-primary" value="Logout">
    </form>
  </div>
  <div class="delete">
    <form action="" method="post" autocomplete="off">
      <input id="textbox" type="text" name="fileDelete" placeholder="Delete a file here">
      <input id="delete" type="submit" class="button" name="del" class="btn btn-primary" value="<?php echo $warn;?>">
    </form>
  </div>
  <div class="delete">
    <form action="" method="post" autocomplete="off">
      <input id="textbox" type="text" name="dirName" placeholder="Add a folder here">
      <input id="delete" type="submit" class="button" name="mkdir" value="Create folder">
    </form>
  </div>
      <!-- show disk limit to use for users-->
    <div class="lifeTime">
      <a id="lifeTime">Account life time: <?php $d = $c->format('%R%a'); $f = explode("+",$d); echo $f[1]." Days";?></a>
    </div>

</div>
<embed type="text/html" src="chat.php" width="500" height="200">

<!-- Pliki , system plików , itp , don't touch this or i kill you -->
<div class="files">
<?php 
  $allowed = array('html','php','png','pdf','jpg','js','rar','zip','txt','JPG','mp3','mp4','MP3','MP4','gif','pages','numbers',"key","apk",'css', 'docx', 'PNG','rtf','xlsx', 'pkt');
  $allowedOpen = array('png','JPG','jpg');
  if($_GET['folder'] == null || $_GET['folder'] == "" ){
  if ($handle = opendir('uploads/'.$_SESSION["username"].'')) {
  while (false !== ($entry = readdir($handle))) {
      if($entry != "." && $entry != ".."){

          $ext = pathinfo($entry, PATHINFO_EXTENSION);
          if ( in_array( $ext, $allowedOpen ) ){                                                                                                                                                                          
            echo '<div id="container"><a id="text">'.$entry. '</a> <a href="uploads/'.$_SESSION["username"].'/'.$entry.'" download><img id="img" src="img/download.png"></a> </div>'; 
          }
          else if( ! in_array( $ext, $allowed ) ){
              echo '<div id="container"><a href="index.php?folder='.$entry.'" id="text">'.$entry. '</a></div>';
              $folder[] = $entry;
          } else{
              echo '<div id="container"><a id="text">'.$entry. '</a> <a href="uploads/'.$_SESSION["username"].'/'.$entry.'" download><img id="img" src="img/download.png"></a></div>'; 
          }
      }
      
 
  }
  closedir($handle);
 }
}
      //Open folder
      if($_GET['folder'] != null || $_GET['folder'] != "" ){
        if ($handle = opendir('uploads/'.$_SESSION["username"]."/".$_GET['folder']."/")) {
          $_SESSION['folder'] = $_GET['folder'];
          while (false !== ($entry = readdir($handle))) {
              if($entry != "." && $entry != ".."){
        
                  $ext = pathinfo($entry, PATHINFO_EXTENSION);
                  if ( in_array( $ext, $allowedOpen ) ){                                                                                                                                                                          
                    echo '<div id="container"><a id="text">'.$entry. '</a> <a href="uploads/'.$_SESSION["username"].'/'.$_GET['folder']."/".$entry.'" download><img id="img" src="img/download.png"></a> </div>'; 
                  }
                  else if( ! in_array( $ext, $allowed ) ){
                      echo '<div id="container"><a href="index.php?folder='.$entry.'" id="text">'.$entry. '</a></div>';
                  } else{
                      echo '<div id="container"><a id="text">'.$entry. '</a> <a href="uploads/'.$_SESSION["username"].'/'.$_GET['folder']."/".$entry.'" download><img id="img" src="img/download.png"></a></div>'; 
                  }
              }
              
          }
        }
        closedir($handle);
      } 
?>
</div>
</body>
</html>