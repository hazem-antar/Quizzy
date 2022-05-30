<?php

session_start();

if(isset($_SESSION['user_id']))
{
	unset($_SESSION['user_id']);

}
if(isset($_SESSION['type']))
{
	unset($_SESSION['type']);

}

header("Location: login.php");
die;
