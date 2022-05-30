<?php

  session_start();

	include("connection.php");
	include("functions.php");

  $user_data = check_login($con_users);
  $id = $_SESSION['user_id'];

  $query_courses = "select course_code from courses where instructor_id = '$id'";

  $result_courses = mysqli_query($con_examination, $query_courses);

  if($result_courses && mysqli_num_rows($result_courses) > 0){
    $course_row_count = mysqli_num_rows($result_courses);
    $course_fetched_rows = array();
    while($array = mysqli_fetch_assoc($result_courses)){
      $course_fetched_rows[] = $array;
    }
    for ($i = 0; $i < $course_row_count; $i++) {
        echo '<span id="courses.'.$i.'">'.$course_fetched_rows[$i]['course_code'].'</span>';
       }
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      $course_code = $_POST['course'];
      $date = $_POST['date'];
  		$start_time = $_POST['start_time'];
      $end_time = $_POST['end_time'];
      $numofq = $_POST['numof'];
      if(empty($course_code) || empty($date) ||empty($start_time) || empty($end_time) ||  empty($numofq)){
        echo '<script>alert("Please fill all fields!")</script>';}
      else{
          $_SESSION['course_code'] = $course_code;
          $_SESSION['date'] = $date;
          $_SESSION['start_time'] = $start_time;
          $_SESSION['end_time'] = $end_time;
          $_SESSION['numofq'] = $numofq;
          header("Location: design_exam.php");
          $con_users->close();
          $con_examination->close();
          die;
        }
      }
      $con_users->close();
      $con_examination->close();
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
  		width: auto;
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
      top: 12%;
      width: 400px;
      height: 400px;
  	}

    #title{
    position: relative;
    top: 85px;
    text-align: center;
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 30px;
    color: White;
    }
    #Register{
      position: relative;
      top: 30px;
      text-align: center;
      font-family:  Helvetica, sans-serif;
      font-size: 12px;
      color: White;
    }
     select{
      position: relative;
      display: block;
      margin-left: auto;
      margin-right: auto;
      top: 35px;
  		padding: 10px;
  		width: 60%;
      padding-right: 30px;
  		color: DodgerBlue;
      font-family:  Helvetica, sans-serif;
      font-size: 15px;
  		border: none;
    }
    span{
      position: relative;
      display: inline;
      margin-left: -40px;
      top:2px;
      font-family:  Helvetica, sans-serif;
      font-size: 17px;
      color: white;
  		border: none;
    }
</style>


<html>
  <head>
    <title>New Exam</title>
  </head>

  <body>

    <div id = "title">New Quiz!</div>
    <div id="box">
      <form method="post">
        <select name="course" id="course">
        </select><br>
        <input class ="text" type="date" name="date"><br><br>
        <span>Exam date</span><input class ="text" type="time" name="start_time"><br><br>
        <span>Start time</span><input class ="text" type="time" name="end_time" ><br><br>
        <span>End time</span><input class ="text" type="text" name="numof" placeholder="Number of Questions"><br><br>
        <input id ="button" type="submit" value= "Design Questions"><br><br>
        <div id="Register"><a id="Register" href="staff_exams.php">go back</a></div><br><br>
      </form>
    </div>
    <script>
    var course_row_count = parseInt('<?php echo $course_row_count; ?>') ;
    var courses = [''];
    for(var i = 0; i < course_row_count; i++){
      courses.push(document.getElementById("courses."+i).innerHTML);
    }
    for(var i = 0; i < course_row_count; i++){
        var myobj = document.getElementById("courses."+i);
        myobj.remove();
    }
    var select = document.getElementById("course");
    var y  = course_row_count+1;
    console.log(y);
    for (var k = 0; k < y; k++) {
      console.log(k);
      var option = document.createElement("option");
      if (courses[k] == ''){
        option.text = "Choose from your courses";
        option.value = null;
        option.setAttribute('selectd' , 'true');
        option.setAttribute('hidden' , 'true');
      } else{
        option.value = courses[k];
        option.text = courses[k];
      }
      select.options.add(option);
      }
    </script>
    <script>
  	    if ( window.history.replaceState ) {
  	        window.history.replaceState( null, null, window.location.href );
  	    }
  	</script>
  </body>
</html>
