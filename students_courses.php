<?php
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con_users);
  $id = $_SESSION['user_id'];

	if($_SERVER['REQUEST_METHOD'] == "POST"){
	if (isset($_POST['course_code']) && isset($_POST['enrolment_key']) && !empty($_POST['course_code']) &&  !empty($_POST['enrolment_key'])){
		$c_code = $_POST['course_code'];
		$e_key = $_POST['enrolment_key'];
		$sql_3 = "SELECT course_id, students_count FROM courses WHERE course_code = '$c_code' LIMIT 1";
		$result_course_id = mysqli_fetch_assoc(mysqli_query($con_examination, $sql_3));
		$course_id = $result_course_id['course_id'];
		$stu_count = (int)$result_course_id['students_count'];
		$query_check ="SELECT * FROM enrolment
		WHERE student_id = '$id' and course_id = '$course_id' LIMIT 1";
		$result_check = mysqli_query($con_examination, $query_check);
		if($result_check && mysqli_num_rows($result_check) > 0){
			echo '<script>alert("Course already in your list.")</script>';
		}
		else{
			$query_key ="SELECT enrolment_key FROM courses
			WHERE course_code = '$c_code' LIMIT 1";
			$result_query_key = mysqli_query($con_examination, $query_key);
			if ($result_query_key && mysqli_num_rows($result_query_key) > 0){
				$key = mysqli_fetch_assoc($result_query_key)['enrolment_key'];
				if ($e_key == $key ){
					$sql_1 = "INSERT INTO enrolment (course_id, student_id)
					VALUES ('$course_id', '$id')";
					if ($con_examination->query($sql_1) === TRUE) {
						$sql_2 = "UPDATE courses SET students_count = '$stu_count'+1 WHERE course_code='$c_code'";
						$con_examination->query($sql_2);
						echo '<script>alert("Course added successfully!")</script>';
					} else {
						echo "Error: " . $sql . "<br>" . $con_examination->error;
					}
				}
				else{
					echo '<script>alert("Wrong enrolment key!")</script>';
				}
			}
			else{
				echo '<script>alert("Wrong course code!")</script>';
			}

		}
	}
	else if (isset($_POST['arguments'])){
		$course_code = $_POST['arguments'];
		$sql_4 = "SELECT  course_id, students_count FROM courses WHERE course_code = '$course_code' LIMIT 1";
	  $result_course_id = mysqli_fetch_assoc(mysqli_query($con_examination, $sql_4));
	  $course_id = $result_course_id['course_id'];
		$stu_count = (int)$result_course_id['students_count'];
		$stu_count = $stu_count-1;
		$con_examination->query("DELETE FROM enrolment WHERE course_id ='$course_id'");
		$con_examination->query("UPDATE courses SET students_count = '$stu_count' WHERE course_code='$course_code'");
	}
	else{
		echo '<script>alert("Please fill all fields")</script>';
	}
	}
  $query = "SELECT * FROM courses
  INNER JOIN enrolment ON enrolment.course_id = courses.course_id
	WHERE enrolment.student_id = '$id'";
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
		top:10px;
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
      <li><a href="students_main.php">Home</a></li>
      <li><a id="active" href="students_courses.php">Courses</a></li>
      <li><a href="students_exams.php">Exams</a></li>
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
    <form method="post" action="students_courses.php">
			<input class ="text"  type="text" id="course_code" name="course_code"  placeholder="Course Code">
			<input class ="text"  type="password" id="enrolment_key" name="enrolment_key"  placeholder="Enrolment Key">
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
					url: 'students_courses.php',
					dataType: "text",
					data: {arguments:code}
					}).done(function(data) {
						table.deleteRow(index);
						alert('Course successfully removed.');
						window.location.href = "students_courses.php";
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
