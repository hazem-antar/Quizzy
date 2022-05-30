<?php

function check_login($con_users){

	if(isset($_SESSION['user_id'])){

		$id = $_SESSION['user_id'];
		$query = "select * from students where student_id = '$id' limit 1";
		$result = mysqli_query($con_users,$query);
		if($result && mysqli_num_rows($result) > 0){
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
		$query = "select * from employees where employee_id = '$id' limit 1";
		$result = mysqli_query($con_users,$query);
		if($result && mysqli_num_rows($result) > 0){
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	header("Location: login.php");
	die;

}

?>
