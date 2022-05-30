<?php
session_start();

include("connection.php");
include("functions.php");
$user_data = check_login($con_users);
$id = $_SESSION['user_id'];

if (isset($_POST['ids'])){
  $ids =  $_POST['ids'];
  $ids =  explode(",",$ids);
  $total_grade = 0;
  for ($i = 0 ; $i < sizeof($ids); $i++){
    $query = "SELECT * FROM questions WHERE question_id = '$ids[$i]' LIMIT 1";
    $question_data = mysqli_fetch_assoc(mysqli_query($con_examination, $query));
    $worth_grade = $question_data['grade_worth'];
    $correct_ans = $question_data['correct_answer_number'];
    $user_ans = $_POST["q_{$i}_a_se_"];
    if ($user_ans == $correct_ans){
      $total_grade = $total_grade+$worth_grade;
    }
  }
  $quiz_id = $question_data['quiz_id'];
  $sql = "INSERT INTO grades (student_id, quiz_id, percentage)
  VALUES ('$id', '$quiz_id','$total_grade')";
  if ($con_examination->query($sql) === TRUE) {
    echo 'Your answers has been received';
  } else {
    echo "Error: " . $sql . "<br>" . $con_examination->error;
  }
}
?>
