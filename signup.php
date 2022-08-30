<?php
  session_start();
  include("connection.php");
  include("functions.php");

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['user_id'])
        && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['type'])){
    		//something was posted
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
    		$user_id = $_POST['user_id'];
        $email = $_POST['email'];
    		$password = $_POST['password'];
        $type = $_POST['type'];

    		if(!empty($first_name) && !empty($last_name) && !empty($user_id) && !empty($email) && !empty($type)
         && !empty($password) && !is_numeric($first_name) && !is_numeric($last_name) && !is_numeric($email))
         {
            if ($type == 'student'){
               $query_check = "select * from students where (student_id = '$user_id') or (email = '$email') limit 1";
           		 $result = mysqli_query($con_users,$query_check);
           	   if($result && mysqli_num_rows($result) > 0)
           		 {
                 echo '<script>alert("This user is already registered.")</script>';
           		 }
              else{
          		 	 $query = "insert into students (student_id,first_name,last_name,email,password)
                    values ('$user_id','$first_name','$last_name','$email','$password')";
          			 mysqli_query($con_users, $query);
                 echo '<script>alert("Successfully Signed Up!")</script>';
                 echo "<script>setTimeout(\"location.href = 'login.php';\",500);</script>";
                 die;
              }
            }
            else{
              $query_check = "select * from employees where (employee_id = '$user_id') or (email = '$email') limit 1";
              $result = mysqli_query($con_users,$query_check);
              if($result && mysqli_num_rows($result) > 0)
              {
                echo '<script>alert("This user is already registered.")</script>';
              }
              else{
                $query = "insert into employees (employee_id,first_name,last_name,email,password)
                   values ('$user_id','$first_name','$last_name','$email','$password')";
                mysqli_query($con_users, $query);
                echo '<script>alert("Successfully Signed Up!")</script>';
                echo "<script>setTimeout(\"location.href = 'login.php';\",500);</script>";
                die;
             }
            }
    		}
        else
    		{
          echo '<script>alert("Please enter correct informations!")</script>';
    		}
      }
      else{
        echo '<script>alert("Please fill all reqired feilds!")</script>';
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
      top: 70px;
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
      left: 36%;
      padding: 20px;
      top: 8%;
      width: 400px;
      height: 400px;
  	}

    #signup{
    position: relative;
    top: 30px;
    text-align: center;
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 30px;
    color: White;
    }
    #login{
      position: relative;
      text-align: center;
      top: 35px;
      font-family:  Helvetica, sans-serif;
      font-size: 12px;
      color: White;
    }
    .titels{
      position: relative;
      top: 88px;
      left: -50px;
      font-family:  Helvetica, sans-serif;
      font-size: 16px;
      color: White;
    }
    #type_div{
      position: relative;
      top: 60px;
      left: 90px;
      font-family:  Helvetica, sans-serif;
      font-size: 16px;
      color: White;
    }
</style>
<html>
  <head>
    <title>Signup</title>
  </head>

  <body>

    <di id="box">
      <form method="post">
        <div id = "signup">Signup</div>
        <input class ="text" type="text" name="first_name" placeholder="First Name*"><br><br>
        <input class ="text" type="text" name="last_name" placeholder="Last Name*"><br><br>
        <input class ="text" type="text" name="user_id" placeholder="University ID*"><br><br>
        <input class ="text" type="text" name="email" placeholder="University Email*"><br><br>
        <input class ="text" type="password" name="password" placeholder="Password*"><br><br>
        <div id="type_div">
          <input type="radio" id="student" name="type" value="student">
          <label for="student">Student</label>
          <input type="radio" id="staff" name="type" value="staff">
          <label for="staff">Teaching Staff</label>
        </div><br><br>
        <input id ="button" type="submit" value= "Signup"><br><br>
        <div id="login"><a id="login" href="login.php">Login instead</a></div><br><br>
      </form>
    </div>


  </body>
</html>
