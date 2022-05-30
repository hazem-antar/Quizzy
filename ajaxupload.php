<?php
  session_start();

  include("connection.php");
  include("functions.php");

  $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp' , 'pdf' , 'doc' , 'ppt');
  $path = 'uploads/';
  if(isset($_POST['q_id'])){
      $q_id = $_POST['q_id'];
      $img = $_FILES["q_".$q_id."_image"]['name'];
      $tmp = $_FILES["q_".$q_id."_image"]['tmp_name'];
      $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
      $final_image = rand(1000,1000000).$img;
    if(in_array($ext, $valid_extensions)){
      $path = $path.strtolower($final_image);
      if(move_uploaded_file($tmp,$path)){
        echo $q_id ."-path:".$path;
      }
    }
    else{
        echo 'invalid';
      }
  }
?>
