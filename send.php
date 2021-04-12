<?php
session_start();

if($_SESSION['folder'] != "" || $_SESSION['folder'] != null ){
    $target_dir = "uploads/".$_SESSION["username"]."/".$_SESSION['folder']."/";
}else{
    $target_dir = "uploads/".$_SESSION["username"]."/";
}
$target_file = $target_dir . basename($_FILES["upload"]["name"]);
$ext = pathinfo($_FILES["upload"]["name"], PATHINFO_EXTENSION);
$uploadOk = 1;


// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["upload"]["size"] > 1048576000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
/*
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}*/
// Check folder size 
$size = 0;
  foreach (new DirectoryIterator('uploads/'.$_SESSION["username"]) as $file) {
    if ($file->isFile()) {
        $size += $file->getSize();
    }
  }

    $mod = 1024;
    $units = explode(' ','B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
      $size /= $mod;
    }
//
if($size < 50000000 && strlen($_FILES["upload"]["name"]) < 27){
    // Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["upload"]["name"]). " has been uploaded.";
        
        
    } else {
        echo "Sorry, there was an error uploading your file.";

    }
}
}else {
    echo "The name is too long. \n".$_FILES["upload"]["name"]."\n";

/*    if(isset($_POST['button'])){
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], "uploads/".$_SESSION["username"]."/".$_POST["filename"])) {
            echo "The file ". basename( $_POST["filename"]." has been uploaded.");
        } else {
            echo "Sorry, there was an error uploading your file."."\n".$_POST["filename"];
        }
    }
    */
}
?>
<DOCTYPE HTML>
<html>
<head>
<meta http-equiv = "refresh" content = "1; url = https://fern.fun/en-us/drive/" />
</head>
<body>
<p>
<!--    <form action="" method="post">
        <label>Give name of file with format:</label><br><input type="text" name="filename" class="form-control" value=""><p>
        <input type="submit" name="button" class="btn btn-primary" value="Change">
    </form>
-->
</body>
</html>