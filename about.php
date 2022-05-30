<?php
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con_users);
  $id = $_SESSION['user_id'];
?>
<HTML>
  <head>
    <title>About</title>

  </head>
  <body>
    <div id="white_box_1">
      <p id='p'>This entire website from scripts and databases were made from scratch by as a project for the Software Engineering</p>
			<p id='p2'>Riga Technical University</p><br><br>
      <p id='p2'>Under Supervision of Professor: Jānis Amoliņš </p><br><br>
      <p id='p2'>Team Members: </p>
			<p id='p2'>Hazem Antar Taha 220ADB040</p>
			<p id='p2'>Ahmed Elsayed 220ADB041</p>
			<p id='p2'>Shorouk Alalem 220ADB042</p>
			<p id='p2'>Marah Hussein 201ADB052</p>
			<p id='p2'>Bashar Alayoub 220ADB043</p>
    </div>
  </body>
</HTML>

<style>
body {background-color: DodgerBlue;}

.blue_header{
  position: relative;
  font-family:  Arial, Helvetica, sans-serif;
  font-size: 30px;
  margin-left:2%;
  margin-top: 2%;
  color: DodgerBlue;
}
ul {
list-style-type: none;
margin: 0;
padding: 0;
overflow: hidden;
background-color: #333;
}
li {
  float: left;
  border-right: 1px solid #bbb;
}


li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-family:  Arial, Helvetica, sans-serif;
  font-size: 15px;
}
li span {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-family:  Arial, Helvetica, sans-serif;
  font-size: 15px;
}
li a:hover:not(.active) {
  background-color: #111;
}

#active {
  background-color: White;
  color: DodgerBlue;
  font-family:  Arial, Helvetica, sans-serif;
  font-size: 15px;
}
#white_box_1{
  position: relative;
  display: inline-block;
  overflow:auto;
  background-color: White;
  margin-left:0%;
  padding-top: 3%;
  padding-bottom:5%;
  padding-left: 2%;
  width:98%;
  height: auto;
}
#p{
  position: relative;
  font-family:  Arial, Helvetica, sans-serif;
  font-size: 20px;
  align-content: center;
  padding: 10%;
  margin-left: -2%;
  margin-right: auto;
  text-align: center;
}
#p2{
  position: relative;
  font-family:  Arial, Helvetica, sans-serif;
  font-size: 20px;
  align-content: center;
  padding: 10%;
  margin-top: -20%;
  margin-left: -2%;
  margin-right: auto;
  text-align: center;
}
</style>
<script>
var first_name = '<?php echo $user_data["first_name"]; ?>';
var last_name = '<?php echo $user_data["last_name"]; ?>';
var employee_name = document.getElementById("employee_name");
employee_name.innerHTML =  "Welcome "+first_name+" "+last_name;

</script>
