<?php
  global $flag,$sql_q;
  session_start();

	include("connection.php");
	include("functions.php");

  $user_data = check_login($con_users);
  $id = $_SESSION['user_id'];

  $course_code = $_SESSION['course_code'];
  $sql_3 = "SELECT course_id FROM courses WHERE course_code = '$course_code' LIMIT 1";
  $result_course_id = mysqli_fetch_assoc(mysqli_query($con_examination, $sql_3));
  $course_id = $result_course_id['course_id'];

    $date = $_SESSION['date'];
    $start_time = $_SESSION['start_time'];
    $end_time = $_SESSION['end_time'];
    $numofq = $_SESSION['numofq'];
    $imgs = $_POST['data_images'];
    $obj=json_decode($imgs);
    $flag = 1;
    $sql_q = "";
    $sum = 0;
    for($i = 1 ; $i<=$numofq ; $i++){
        $url =null;
        $text = null;
        $correct_a = null;
        $grade = null;
        $answers = array_fill(0, 4, null);
        if (!isset($_POST["q_{$i}_text"])){
          if(!isset($obj->{"image_preview_q_".$i})){
            $flag = 2;
            echo $flag;
          }
          else{
            if(empty($obj->{"image_preview_q_".$i})){
              $flag = 3;
              echo $flag;
            }
            else{
            $url = $obj->{"image_preview_q_".$i};
            }
          }
        }
        else{
          if(empty($_POST["q_{$i}_text"])){
            $flag = 4;
            echo $flag;
          }
          else{
            $text = $_POST["q_{$i}_text"];
          }
        }
        for ($j=1; $j<=4;$j++){
          if (empty($_POST["q_{$i}_a_{$j}"])){
            $flag = 5;
            echo $flag;
          }
          else{
             $answers[$j-1] = $_POST["q_{$i}_a_{$j}"];
          }
        }
        if(empty($_POST["q_{$i}_a_se_"])){
            $flag = 6;
            echo $flag;
        }
        else{
          $correct_a = $_POST["q_{$i}_a_se_"];
        }
        if (empty($_POST["q_{$i}_g_{$j}"])){
            $flag = 7;
            echo $flag;
        }
        else{
          $grade =  $_POST["q_{$i}_g_{$j}"];
          $sum += $grade;
        }
        $sql_q .=";INSERT INTO questions (quiz_id,question_text, answer_1, answer_2 , answer_3, answer_4, correct_answer_number, grade_worth, URL)
        VALUES ('q_id','$text', '$answers[0]','$answers[1]', '$answers[2]' , '$answers[3]', '$correct_a', '$grade', '$url')";
      }
      if ($sum != 100){
        $flag = 8;
        echo $flag;
      }
      if ($flag == 1){
        $sql = "INSERT INTO quizzes (course_id, date, start_time , end_time, questions_count)
        VALUES ('$course_id', '$date','$start_time', '$end_time' , '$numofq')";
        $con_examination->query($sql);
        $sql_2 = "SELECT quiz_id FROM quizzes WHERE course_id = '$course_id' AND date ='$date' AND start_time = '$start_time' LIMIT 1";
        $result_data = mysqli_fetch_assoc(mysqli_query($con_examination, $sql_2));
        $exam_id = $result_data['quiz_id'];
        $sql_q= substr($sql_q, 1);
        $sql_q = str_replace('q_id', $exam_id, $sql_q);
        if(mysqli_multi_query($con_examination, $sql_q)){
          echo $flag;
        }
      }
  $con_users->close();
  $con_examination->close();
  ?>
