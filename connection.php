<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";

if (! $con_users = mysqli_connect($dbhost, $dbuser, $dbpass, "users")){
  die("Connection failed: " . $con_users->connect_error);
}
if (!$con_examination = mysqli_connect($dbhost, $dbuser, $dbpass, "examination")){
  die("Connection failed: " . $con_examination->connect_error);
}
?>
