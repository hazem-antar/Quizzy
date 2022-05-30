<?php

  session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$user_id = $_POST['user_id'];
		$password = $_POST['password'];

	if(!empty($user_id) && !empty($password)){
	   $query = "select * from students where student_id = '$user_id' limit 1";
	   $result = mysqli_query($con_users, $query);

     if($result && mysqli_num_rows($result) > 0){
		     $user_data = mysqli_fetch_assoc($result);
				 if($user_data['password'] === $password){
				       $_SESSION['user_id'] = $user_id;
               $_SESSION['type'] = "student";
						   header("Location: index.php");
						   die;
				 }
          echo '<script>alert("Wrong username or password!")</script>';
        }
    else{
        $query = "select * from employees where employee_id = '$user_id' limit 1";
        $result = mysqli_query($con_users, $query);
        if($result && mysqli_num_rows($result) > 0){
          $user_data = mysqli_fetch_assoc($result);
          if($user_data['password'] === $password){
            $_SESSION['user_id'] = $user_id;
            $_SESSION['type'] = "staff";
            header("Location: index.php");
            die;
          }
          echo '<script>alert("Wrong username or password!")</script>';
          }
        else{
          echo '<script>alert("User not registered!")</script>';
       }
  	}
  }
  else{
    echo '<script>alert("Please enter a valid information!")</script>';
  }
}

?>

<style type="text/css">

    body {background-color: DodgerBlue;}

  	.text{
      position: relative;
      top: 65px;
      display: block;
      margin-left: auto;
      margin-right: auto;
  		height: 30px;
  		border-radius: 5px;
  		border: solid thin #aaa;
  		width: 60%;
  	}

  	#button{
      position: relative;
      display: block;
      margin-left: auto;
      margin-right: auto;
      top: 60px;
  		padding: 10px;
  		width: 100px;
  		color: DodgerBlue;
  		background-color: white;
  		border: none;
  	}

  	#box{
  		background-color: DodgerBlue;
      position: relative;
      display: block;
      margin-left: auto;
      margin-right: auto;
      padding: 20px;
      top: 10%;
      left:-25;
      width: 400px;
      height: 400px;
  	}

    #login{
    position: relative;
    top: 30px;
    text-align: center;
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 30px;
    color: White;
    }
    #signup{
      position: relative;
      top: 30px;
      text-align: center;
      font-family:  Helvetica, sans-serif;
      font-size: 12px;
      color: White;
    }
    #logo{
      position: relative;
      left:25%;
      top:5%;
    }
</style>


<html>
  <head>
    <title>Login</title>
  </head>

  <body>

    <div id="box">
      <img src="\Quizzy\uploads\Logo.PNG"  width="205" height="184" id='logo'>
      <form method="post">
        <div id = "login">Quizzy</div>
        <input class ="text" type="text" name="user_id" placeholder="University ID"><br><br>
        <input class ="text" type="password" name="password"  placeholder="Password"><br><br>
        <input id ="button" type="submit" value= "login"><br><br>
        <div id="signup"><a id="signup" href="signup.php">Sign-Up instead</a></div><br><br>
      </form>
    </div>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

  </body>
</html>
