<?php
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con_users);
  $id = $_SESSION['user_id'];

	if($_SERVER['REQUEST_METHOD'] == "POST"){
	if (isset($_POST['course_name']) && isset($_POST['course_code']) && isset($_POST['enrolment_key']) && !empty($_POST['course_name']) && !empty($_POST['course_code']) && !empty($_POST['enrolment_key'])){
		$c_name = $_POST['course_name'];
		$c_code = $_POST['course_code'];
		$e_key = $_POST['enrolment_key'];
		$query_check = "select * from courses where course_code = '$c_code' limit 1";
		$result_check = mysqli_query($con_examination, $query_check);
		if($result_check && mysqli_num_rows($result_check) > 0){
			$course_data = mysqli_fetch_assoc($result_check);
			if ($course_data['instructor_id']!=NULL){
				echo '<script>alert("Course already registered by an academic staff.")</script>';
			}
			else{
				$query_update="UPDATE courses
				SET instructor_id = '$id',
				enrolment_key = '$e_key'
				WHERE course_code='$c_code'";
				$con_examination->query($query_update);
				echo '<script>alert("Your name was added to the course!")</script>';
			}
		}
		else{
			$sql = "INSERT INTO courses (course_name, course_code, instructor_id , students_count , enrolment_key)
			VALUES ('$c_name', '$c_code','$id', 0 , '$e_key')";
			if ($con_examination->query($sql) === TRUE) {
				echo '<script>alert("Course was added successfully!")</script>';
			} else {
				echo "Error: " . $sql . "<br>" . $con_examination->error;
			}
		}
	}
	else if (isset($_POST['arguments'])){
		$code = $_POST['arguments'];
		$sql="UPDATE courses
						SET instructor_id = Null
						WHERE course_code='$code'";
		$con_examination->query($sql);
	}
	}
  $query = "select * from courses where instructor_id = '$id'";
  $result = mysqli_query($con_examination, $query);

  if($result && mysqli_num_rows($result) > 0){
    $course_row_count = mysqli_num_rows($result);
    $course_fetched_rows = array();
    while($array = mysqli_fetch_assoc($result)){
      $course_fetched_rows[] = $array;
    }
    $course_col_arr = array('course_name','course_code','students_count');
    $course_col_count = sizeof($course_col_arr);
    for ($i = 0; $i < $course_row_count; $i++) {
      for ($j = 0; $j<$course_col_count; $j++){
        echo '<span id="courses.'.$i.'.'.$j.'">'.$course_fetched_rows[$i][$course_col_arr[$j]].'</span>';
      }
    }
  }
  else{
		$course_row_count = 0;
		$course_col_count = 0;
  }

  $con_users->close();
  $con_examination->close();
?>

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

  table{
    position: relative;
    display: block;
    padding-top: 2%;
    padding-left: 2%;
    border: 0px solid black;
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 15px;
  }
  .button{
    border: none;
    color: white;
    background-color: #333;
    padding: 10px 25px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    position: relative;
    font-size: 14px;
    margin-left:2%;
    cursor: pointer;
		border-radius: 5px;
	}
		.text{
      position: relative;
      top: 65px;
      display: block;
      margin-left: auto;
      margin-right: auto;
  		height: 40px;
  		border-radius: 5px;
  		border: solid thin #aaa;
  		width: 40%;
  	}
  }
</style>

<html>
  <head>
    <title>Courses</title>
    <ul>
      <li><a href="staff_main.php">Home</a></li>
      <li><a id="active" href="staff_courses.php">Courses</a></li>
      <li><a href="staff_exams.php">Exams</a></li>
      <li><a href="about.php">About</a></li>
      <li style="float:right;border-right: none;"><a href="logout.php">logout</a></li>
      <li style="float:right;" ><span id = "employee_name" >hello</span></li>
    </ul>
  </head>
  <body>
    <div id="white_box_1">
      <h class="blue_header">Your Courses </h>
      <table id="courses_table" border="2" cellpadding="8">
      <tr>
          <td>#</td>
          <td><b>Course Name</b></td>
          <td><b>Course Code</b></td>
          <td><b>N.O students</b></td>
      </tr>
    </table><br><br>
    <form method="post" action="staff_courses.php">
			<input class ="text"  type="text" id="course_name" name="course_name"  placeholder="Course Name">
			<input class ="text"  type="text" id="course_code" name="course_code"  placeholder="Course Code">
			<input class ="text"  type="text" id="enrolment_key" name="enrolment_key"  placeholder="Enrolment Key">
      <input class= "button" type="submit" value="Add course to your list">
    </form>
    </div>

		<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
		<script>
			function deleteRow(obj) {
				var index = obj.parentNode.parentNode.rowIndex;
				var table = document.getElementById("courses_table");
				var code = (document.getElementById("courses_table").rows[index].cells)[2].innerHTML;

			$.ajax({
					type: "POST",
					url: 'staff_courses.php',
					dataType: "text",
					data: {arguments:code}
					}).done(function(data) {
						table.deleteRow(index);
						alert('Course successfully removed.');
						window.location.href = "staff_courses.php";
					});
			}
			</script>
		<script>
      var course_row_count = parseInt('<?php echo $course_row_count; ?>') ;
      var course_col_count = parseInt('<?php echo $course_col_count; ?>') ;
      for(var i = 0; i < course_row_count; i++){
        var courses_table = document.getElementById("courses_table");
        var row = courses_table.insertRow(-1);
        var cell = row.insertCell(0);
        cell.innerHTML= '<input type="button" value = "Delete" onClick="deleteRow(this)">';
        for (var j = 0; j < course_col_count; j++){
          var cell = row.insertCell(j+1);
          cell.innerHTML=document.getElementById("courses."+i+'.'+j).innerHTML;
        }
      }
      for(var i = 0; i < course_row_count; i++){
        for (var j = 0; j < course_col_count; j++){
          var myobj = document.getElementById("courses."+i+'.'+j);
          myobj.remove();
        }
      }


      //------------------------------------------------------
      var first_name = '<?php echo $user_data["first_name"]; ?>';
      var last_name = '<?php echo $user_data["last_name"]; ?>';
      var employee_name = document.getElementById("employee_name");
      employee_name.innerHTML =  "Welcome "+first_name+" "+last_name;

  </script>
	<script>
	    if ( window.history.replaceState ) {
	        window.history.replaceState( null, null, window.location.href );
	    }
	</script>
  </body>

</html>
