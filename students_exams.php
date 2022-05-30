<?php
  session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con_users);
  $id = $_SESSION['user_id'];
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['quiz_id'])){
      $quiz_id = $_POST['quiz_id'];
      $_SESSION['quiz_id'] = $quiz_id;
      header("Location: start_exam.php");
      die;
    }
  }
  else{
    $query_exams = "SELECT quizzes.quiz_id, courses.course_name, courses.course_code, quizzes.date,
          quizzes.start_time, quizzes.end_time
    FROM quizzes INNER JOIN courses ON quizzes.course_id = courses.course_id
    INNER JOIN enrolment ON enrolment.course_id = courses.course_id
    WHERE enrolment.student_id = '$id'
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
      $grades = array();
      $quizzes = array();
      for ($i = 0; $i < $exam_row_count; $i++) {
        $temp_quiz_id = $exam_fetched_rows[$i]['quiz_id'];
        $quizzes[] = $temp_quiz_id;
        $query_grades = "SELECT * FROM grades WHERE student_id = '$id' AND quiz_id = '$temp_quiz_id' LIMIT 1";
        $result_grades = mysqli_query($con_examination, $query_grades);
        if($result_grades && mysqli_num_rows($result_grades) > 0){
          $grades[] = mysqli_fetch_assoc($result_grades)['percentage'];
        }
        else{
          $grades[] = "";
        }
        for ($j = 0; $j<$exam_col_count; $j++){
          echo '<span id="exams.'.$i.'.'.$j.'">'.$exam_fetched_rows[$i][$exam_col_arr[$j]].'</span>';
        }
      }
  }
    else{
  		$exam_row_count = 0;
  		$exam_col_count = 0;
    }
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
    <title>Exams</title>
    <ul>
      <li><a href="students_main.php">Home</a></li>
      <li><a href="students_courses.php">Courses</a></li>
      <li><a id="active" href="students_main.php">Exams</a></li>
      <li><a href="about.php">About</a></li>
      <li style="float:right;border-right: none;"><a href="logout.php">logout</a></li>
      <li style="float:right;" ><span id = "employee_name" >hello</span></li>
    </ul>
  </head>
  <body>
    <div id="white_box_1">
      <h class="blue_header">Exams Records</h>
      <table id="exams_table" border="2" cellpadding="8">
      <tr>
        <td></td>
        <td><b>Course Name</b></td>
        <td><b>Course Code</b></td>
        <td><b>Exam Date</b></td>
        <td><b>Start Time</b></td>
        <td><b>End Time</b></td>
        <td><b>Attempt</b></td>
      </tr>
    </table><br><br>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    function start(id){
      id = id.split('_')[1];
      var quiz_id = <?php echo '["' . implode('", "', $quizzes) . '"]' ?>;
      var myArray = [];
      for(var key in quiz_id) {
        myArray.push(quiz_id[key]);
      }
      $.ajax({
      url: "students_exams.php",
      type: "POST",
      data:{'quiz_id': myArray[id]},
      success: function (data) {
        location.href = 'start_exam.php';
             },
             error: function (xhr, status, error) {
                 alert(status);
                 alert(xhr.responseText);
             }
         });
    }
    </script>
		<script>
    var exam_row_count = parseInt('<?php echo $exam_row_count; ?>');
    var exam_col_count = parseInt('<?php echo $exam_col_count; ?>');

    var grades_data = <?php echo '["' . implode('", "', $grades) . '"]' ?>;
    var grade = [];
    for(var key in grades_data) {
      grade.push(grades_data[key]);
    }
    for(var i = 0; i < exam_row_count; i++){

      var exams_table = document.getElementById("exams_table");
      var row = exams_table.insertRow(-1);
      var cell = row.insertCell(0);
      cell.innerHTML= i+1;
      for (var j = 0; j < exam_col_count; j++){
        var cell = row.insertCell(j+1);
        cell.innerHTML=document.getElementById("exams."+i+'.'+j).innerHTML;
      }
      var cell = row.insertCell(6);
      if(grade[i] == ""){
        var date_time = new Date();
        var day = date_time.getDate();
        var hour = date_time.getHours();
        var min = date_time.getMinutes();
        var sec = date_time.getSeconds();
        var table = document.getElementById("exams_table");
        var exam_date = (table.rows[i+1].cells)[3].innerHTML;
        var exam_date = exam_date.split('-')[2];
        var hour_start = (table.rows[i+1].cells)[4].innerHTML;
        var hour_start = hour_start.split(':')[0];
        var min_start = (table.rows[i+1].cells)[4].innerHTML;
        var min_start = min_start.split(':')[1];
        var sec_start = (table.rows[i+1].cells)[4].innerHTML;
        var sec_start = sec_start.split(':')[2];
        var hour_end = (table.rows[i+1].cells)[5].innerHTML;
        var hour_end = hour_end.split(':')[0];
        var min_end = (table.rows[i+1].cells)[5].innerHTML;
        var min_end = min_end.split(':')[1];
        var sec_end = (table.rows[i+1].cells)[5].innerHTML;
        var sec_end = sec_end.split(':')[2];
        if (day == exam_date){
          if ( ((hour==hour_start) && (min==min_start) && (sec>=sec_start)) ||
               ((hour==hour_start) && (min>min_start)) ||
                (hour>hour_start) ){
            if ( (hour<hour_end) || ((hour==hour_end) && (min<min_end)) || ((hour==hour_end) && (min==min_end) && (sec<=sec_end)) ){
              var temp = "btn_"+i;
              cell.innerHTML= `<button id=${temp} name=${temp} onclick=start(this.id)>start now!</button>`;
            }
            else{
              cell.innerHTML= "Ended without attempts";
            }

          }
          else{
            cell.innerHTML= "Not time yet";
          }
        }
        else if (day < exam_date){
          cell.innerHTML= "Not time yet";
        }
        else{
          cell.innerHTML= "Ended without attempts";
        }
    }
    else{
      cell.innerHTML= grade[i]+"%";
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
      //console.log(quizzes[0]);
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
