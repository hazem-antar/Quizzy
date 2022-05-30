<?php
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con_users);

  $id = $_SESSION['user_id'];
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

  $query_exams = "SELECT courses.course_name, courses.course_code, quizzes.date,
	 			quizzes.start_time, quizzes.end_time
	FROM quizzes INNER JOIN courses ON quizzes.course_id = courses.course_id
  INNER JOIN enrolment ON enrolment.course_id = courses.course_id
	WHERE enrolment.student_id = '$id' AND quizzes.date>=DATE(NOW())
  ORDER BY quizzes.date , quizzes.start_time";

  $result_exams = mysqli_query($con_examination, $query_exams);

  if($result_exams && mysqli_num_rows($result_exams) > 0){
    $exam_row_count = mysqli_num_rows($result_exams);
    $exam_fetched_rows = array();
    while($array = mysqli_fetch_assoc($result_exams)){
      $exam_fetched_rows[] = $array;
    }
    $exam_col_arr = array('course_name','course_code','date','start_time','end_time');
    $exam_col_count = sizeof($exam_col_arr);
    for ($i = 0; $i < $exam_row_count; $i++) {
      for ($j = 0; $j<$exam_col_count; $j++){
        echo '<span id="exams.'.$i.'.'.$j.'">'.$exam_fetched_rows[$i][$exam_col_arr[$j]].'</span>';
      }
    }
  }
  else{
		$exam_row_count = 0;
		$exam_col_count = 0;
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
  #white_box_2{
    position: relative;
    display: inline-block;
    overflow:auto;
    background-color: White;
    margin-left:0%;
    padding-top: 0%;
    padding-bottom:8%;
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
  }
</style>

<html>
  <head>
    <title>Teaching Staff</title>
    <ul>
      <li><a id="active" href="students_main.php">Home</a></li>
      <li><a href="students_courses.php">Courses</a></li>
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
    <form action="students_courses.php">
      <input class= "button" type="submit" value="Modify Courses" />
    </form>
    </div>
    <div id="white_box_2">
      <h class="blue_header">Upcoming Exams</h>
      <table id="exams_table" border="2" cellpadding="8">
      <tr>
          <td>#</td>
          <td><b>Course Name</b></td>
          <td><b>Course Code</b></td>
          <td><b>Exam Date</b></td>
          <td><b>Start Time</b></td>
          <td><b>End Time</b></td>
      </tr>
      </table><br><br>
      <form action="students_exams.php">
        <input class= "button" type="submit" value="Go to your exams" />
      </form>
    </div>
    <script>
      var course_row_count = parseInt('<?php echo $course_row_count; ?>');
      var course_col_count = parseInt('<?php echo $course_col_count; ?>');
      for(var i = 0; i < course_row_count; i++){
        var courses_table = document.getElementById("courses_table");
        var row = courses_table.insertRow(-1);
        var cell = row.insertCell(0);
        cell.innerHTML= i+1;
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
      var exam_row_count = parseInt('<?php echo $exam_row_count; ?>');
      var exam_col_count = parseInt('<?php echo $exam_col_count; ?>');
      for(var i = 0; i < exam_row_count; i++){
        var exams_table = document.getElementById("exams_table");
        var row = exams_table.insertRow(-1);
        var cell = row.insertCell(0);
        cell.innerHTML= i+1;
        for (var j = 0; j < exam_col_count; j++){
          var cell = row.insertCell(j+1);
          cell.innerHTML=document.getElementById("exams."+i+'.'+j).innerHTML;
        }
      }
      for(var i = 0; i < exam_row_count; i++){
        for (var j = 0; j < exam_col_count; j++){
          var myobj = document.getElementById("exams."+i+'.'+j);
          myobj.remove();
        }
      }
      //------------------------------------------------------
      var first_name = '<?php echo $user_data["first_name"]; ?>';
      var last_name = '<?php echo $user_data["last_name"]; ?>';
      var employee_name = document.getElementById("employee_name");
      employee_name.innerHTML =  "Welcome "+first_name+" "+last_name;

  </script>
  </body>

</html>
