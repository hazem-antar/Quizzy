<?php
  session_start();

	include("connection.php");
	include("functions.php");

  $user_data = check_login($con_users);
  $id = $_SESSION['user_id'];

  $quiz_id = $_SESSION['quiz_id'];
  $query_questions = "SELECT * FROM questions WHERE quiz_id = '$quiz_id'";
  $data = mysqli_query($con_examination, $query_questions);
  $questions_count = mysqli_num_rows($data);
  $questions_fetched_rows = array();
  while($array = mysqli_fetch_assoc($data)){
    $questions_fetched_rows[] = $array;
  }

  $query_time = "SELECT * FROM quizzes WHERE quiz_id = '$quiz_id'";
  $time_data = mysqli_query($con_examination, $query_time);
  $end_time = mysqli_fetch_assoc($time_data)['end_time'];

  $con_users->close();
  $con_examination->close();
  ?>

  <style>
  body {background-color: DodgerBlue;}
  #active {
    background-color: White;
    color: DodgerBlue;
    font-family:  Arial, Helvetica, sans-serif;
    font-size: 15px;
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
    #questions{
      color: black;
      text-align: left;
      margin-bottom: 30px;
      margin-left: 15px;
      font-family:  Arial, Helvetica, sans-serif;
      font-size: 20px;
    }
    select{
     position: relative;
     display: block;
     margin-left: 10px;
     margin-bottom: 30px;
     top: 25px;
     padding: 10px;
     width: 10%;
     color: DodgerBlue;
     font-family:  Helvetica, sans-serif;
     font-size: 15px;
   }
   .Q_area{
      resize: none;
      position: relative;
      display: inline-block;
      width: 95%;
      font-size: 20px;
   }
   .ans_div{
     position: relative;
     display: block;
     margin-left: 15px;
     margin-bottom: 10px;

   }
   .choise_area{
     position: relative;
     display: block;
     width: 600px;
     height: 50px;
     font-size: 16px;
   }
   .grade{
     position: relative;

     display: inline-block;
     margin-bottom: 30px;
     top: 25px;
     left:-5px;
     padding: 10px;
   }
   .grade_label{
     position: relative;
     display: inline;
     margin-bottom: 30px;
     top: 25px;
     left:-5px;
     padding: 10px;
   }
   .ans_select{
     position: relative;
     display: inline;
     margin-bottom: 30px;
     top: 26.5px;
     left:-5px;
     padding: 10px;
   }
   .container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  margin-top: 30px;
  cursor: pointer;
  font-size: 20px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
#clock_title{
display: block;
position: relative;
margin-left: auto;
margin-right: auto;
top:-5%;
color: black;
font-weight: 100;
font-size: 40px;
background-color: white;
text-align: center;
}

#clockdiv{
position: relative;
font-family: sans-serif;
color: #fff;
margin-left: 38%;
margin-right: auto;
top:3%;
background-color: white;
display: inline-block;
font-weight: 100;
text-align: center;
font-size: 30px;
}

#clockdiv > div{
padding: 10px;
border-radius: 3px;
background:DodgerBlue;
display: inline-block;
}

#clockdiv div > span{
padding: 15px;
border-radius: 3px;
background: white;
display: inline-block;
}

.smalltext{
padding-top: 5px;
font-size: 16px;
color: white;
}
.seconds{
  color: black;
  color:DodgerBlue;
}
.minutes{
  color: black;
  color:DodgerBlue;
}
.hours{
  color: black;
  color:DodgerBlue;
}
</style>
<html>
  <head>
    <title>Start Exam</title>
    <ul>
      <li><a href="students_main.php">Home</a></li>
      <li><a href="students_courses.php">Courses</a></li>
      <li><a id="active" href="students_exams.php">Exams</a></li>
      <li><a href="about.php">About</a></li>
      <li style="float:right;border-right: none;"><a href="logout.php">logout</a></li>
      <li style="float:right;" ><span id = "employee_name" >hello</span></li>
    </ul>
  </head>
  <body>
    <div id="white_box_1">
      <div id="clockdiv">
        <div>
          <span class="hours"></span>
          <div class="smalltext">Hours</div>
        </div>
        <div>
          <span class="minutes"></span>
          <div class="smalltext">Minutes</div>
        </div>
        <div>
          <span class="seconds"></span>
          <div class="smalltext">Seconds</div>
        </div>
      </div>
    <form id="Q_form" action="submit_exam.php" method = "POST">
        <div id="questions"></div>
        <input type="submit" id="submit" value="  Finish  " >
    </form>
  </div>

  <script>
  function getTimeRemaining(endtime) {
    const total = Date.parse(endtime) - Date.parse(new Date());
    const seconds = Math.floor((total / 1000) % 60);
    const minutes = Math.floor((total / 1000 / 60) % 60);
    const hours = Math.floor((total / (1000 * 60 * 60)) % 24);

    return {
      total,
      hours,
      minutes,
      seconds
    };
  }

  function initializeClock(id, endtime) {
    const clock = document.getElementById(id);
    const hoursSpan = clock.querySelector('.hours');
    const minutesSpan = clock.querySelector('.minutes');
    const secondsSpan = clock.querySelector('.seconds');

    function updateClock() {
      const t = getTimeRemaining(endtime);
      hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
      minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
      secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

      if (t.total <= 0) {
        var table = document.getElementById('Q_form');
        var form_data =  new FormData(table);
        form_data.append("ids" , ids)
          $.ajax({
          url: "correct_exam.php",
          type: "POST",
          processData: false,
          contentType: false,
          data: form_data,
          success: function (a) {
                    location.href = 'students_exams.php';
                 },
                 error: function (xhr, status, error) {
                     alert(status);
                     alert(xhr.responseText);
                 }
             });
      }
    }

    updateClock();
    const timeinterval = setInterval(updateClock, 1000);
  }
  var time_end = new Date();
  var time_start = new Date();
  var today = new Date();

  var value_end = '<?php echo $end_time; ?>';
  var value_end = value_end.split(':');
  time_end.setHours(value_end[0], value_end[1], value_end[2], 0);
  const deadline = new Date(Date.parse(new Date()) + 15 * 24 * 60 * 60 * 1000);
  initializeClock('clockdiv', time_end);
</script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script language="javascript">
        var ids = [];
        var n = parseInt('<?php echo $questions_count; ?>');
        var questions = <?php echo json_encode($questions_fetched_rows); ?>;
        for(var i=0;i<n;i++) {
            var new_q = document.createElement('div');
            new_q.id = "q_"+i;
            new_q.style="margin-bottom: 70px;";
            document.getElementById('questions').appendChild(new_q);
            var question = [];
            for(var key in questions[i]) {
              question.push(questions[i][key]);
            }
            ids.push(parseInt(questions[i]["question_id"]));
            var label_div = document.createElement("div");
            label_div.id = "q_"+i+"_label";
            document.getElementById("q_"+i).appendChild(label_div);
            var l = document.createElement("label");
            l.innerHTML = "Question " + (i+1) + ":";
            l.style = 'font-size: 22px; font-weight: bolder; margin-top:10px;';
            label_div.appendChild(l);
            var qtext_div = document.createElement("div");
            qtext_div.id = "q_"+i+"_text_div";
            qtext_div.style = 'margin-bottom: 20px; margin-top: 20px;';
            document.getElementById("q_"+i).appendChild(qtext_div);

            if(question[9] == "" && question[2] !=""){
              var q_text = document.createElement("p");
              var node = document.createTextNode(question[2]);
              node.className = 'Q_area';
              q_text.appendChild(node);
              q_text.id = "q_"+i+"_text";
              q_text.name = "q_"+i+"_text";
              q_text.className = 'Q_area';
              qtext_div.appendChild(q_text);
            }
            else{
              var img = document.createElement("IMG");
              img.src=question[9];
              qtext_div.appendChild(img);
            }
            for (var j = 0 ; j<=3 ; j++){
              var ans_div = document.createElement("div");
              ans_div.id = "q_"+i+"_a_div_"+j;
              ans_div.className = 'ans_div';
              document.getElementById("q_"+i).appendChild(ans_div);
              var container = document.createElement("label");
              container.className = 'container';
              container.innerHTML = question[2+j+1];
              ans_div.appendChild(container);
              var ans_select = document.createElement("input");
              ans_select.type = "radio";
              ans_select.id = "q_"+i+"_a_se_"+j;
              ans_select.name = "q_"+i+"_a_se_";
              ans_select.value=j+1;
              container.appendChild(ans_select);
              var checkmark = document.createElement("span");
              checkmark.className = 'checkmark';
              container.appendChild(checkmark);
            }
          }

    </script>
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
   $("#Q_form").submit(function(e){
    e.preventDefault();
    var form_data =  new FormData(this);
    form_data.append("ids" , ids)
      $.ajax({
      url: "correct_exam.php",
      type: "POST",
      processData: false,
      contentType: false,
      data: form_data,
      success: function (a) {
                alert(a);
                location.href = 'students_exams.php';
             },
             error: function (xhr, status, error) {
                 alert(status);
                 alert(xhr.responseText);
             }
         });
       });
     });
     var first_name = '<?php echo $user_data["first_name"]; ?>';
     var last_name = '<?php echo $user_data["last_name"]; ?>';
     var employee_name = document.getElementById("employee_name");
     employee_name.innerHTML =  "Welcome "+first_name+" "+last_name;
  </script>
  </body>
</html>
