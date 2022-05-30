<?php
  session_start();

	include("connection.php");
	include("functions.php");

  $user_data = check_login($con_users);
  $id = $_SESSION['user_id'];

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
      display: block;
      width: 95%;
      height: 150px;
      font-size: 16px;
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
</style>
<html>
  <head>
    <title>Desgin Exam</title>
    <ul>
      <li><a href="staff_main.php">Home</a></li>
      <li><a href="staff_courses.php">Courses</a></li>
      <li><a id="active" href="staff_exams.php">Exams</a></li>
      <li><a href="about.php">About</a></li>
      <li style="float:right;border-right: none;"><a href="logout.php">logout</a></li>
      <li style="float:right;" ><span id = "employee_name" >hello</span></li>
    </ul>
  </head>
  <body>
    <div id="white_box_1">
    <form id="Q_form" action="register_exam.php" method = "POST">
        <div id="questions"></div>
        <input type="submit" id="submit" value="  Finish  " >
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script language="javascript">
        var n = parseInt('<?php echo $_SESSION['numofq']; ?>');
        for(var i=1;i<=n;i++) {
            var new_q = document.createElement('div');
            new_q.id = "q_"+i;
            new_q.style="margin-bottom: 70px;";
            document.getElementById('questions').appendChild(new_q);
            var l = document.createElement("label");
            l.id = "choose_label_"+i;
            l.innerHTML = "Question " + i;
            l.style = ' font-size: 20px; font-weight: bolder;';
            new_q.appendChild(l);
            var select = document.createElement("select");
            select.id = 's_'+i;
            select.name = "SelextOption";
            array = ['','Write','Upload'];
            for (var k = 0; k < 3; k++) {
              var option = document.createElement("option");
              if (array[k] == ''){
                option.text = "Choose";
                option.value = null;
                option.setAttribute('selectd' , 'true');
                option.setAttribute('hidden' , 'true');
              } else{
                option.value = array[k];
                option.text = array[k];
              }
              select.options.add(option);
              }
            select.onchange = function () { change(this); };
            new_q.appendChild(select);
    }
    function change(ref){
      i = (ref.id).slice(2, );
      if (ref.value == 'Write'){
        document.getElementById(ref.id).remove();
        document.getElementById("choose_label_"+i).remove();
        var label_div = document.createElement("div");
        label_div.id = "q_"+i+"_label";
        document.getElementById("q_"+i).appendChild(label_div);
        var l = document.createElement("label");
        l.innerHTML = "Question " + i + ":";
        l.style = 'font-size: 20px; font-weight: bolder;';
        label_div.appendChild(l);
        var qtext_div = document.createElement("div");
        qtext_div.id = "q_"+i+"_text_div";
        qtext_div.style = 'margin-bottom: 20px; margin-top: 20px;';
        document.getElementById("q_"+i).appendChild(qtext_div);
        var q_text = document.createElement("textarea");
        q_text.id = "q_"+i+"_text";
        q_text.name = "q_"+i+"_text";
        q_text.rows = "5";
        q_text.cols = "150";
        q_text.placeholder = "Write a question prompt here.. ";
        q_text.className = 'Q_area';
        qtext_div.appendChild(q_text);
      }
      else{
        document.getElementById(ref.id).remove();
        document.getElementById("choose_label_"+i).remove();
        var label_div = document.createElement("div");
        label_div.id = "q_"+i+"_label";
        document.getElementById("q_"+i).appendChild(label_div);
        var l = document.createElement("label");
        l.innerHTML = "Question " + i + ":";
        l.style = 'font-size: 20px; font-weight: bolder;';
        label_div.appendChild(l);
        var q_div = document.createElement("div");
        q_div.id = "q_"+i+"_text_div";
        q_div.style = 'margin-bottom: 20px; margin-top: 20px;';
        document.getElementById("q_"+i).appendChild(q_div);
        var upload_form = document.createElement("form");
        upload_form.action = "";
        upload_form.id = 'form_'+i;
        upload_form.className = 'form';
        upload_form.method = "post";
        upload_form.enctype ="multipart/form-data";
        upload_form.innerHTML = 'Choose the image to upload';
        upload_form.style = 'font-size: 16px; margin-left: 16px;';
        q_div.appendChild(upload_form);
        var upload_div = document.createElement("div");
        upload_div.style = 'display: inline;'
        upload_form.appendChild(upload_div);
        var select_image = document.createElement("input");
        select_image.type = "file";
        select_image.name = "q_"+i+"_image";
        select_image.id = "q_"+i+"_image";
        select_image.style = 'display: inline; margin-left: 20px;'
        select_image.accept = "image/*";
        upload_div.appendChild(select_image);
        var upload_image = document.createElement("input");
        upload_image.type = "submit";
        upload_image.id = "upload_image";
        upload_image.name = "upload_image";
        upload_image.style = 'display: inline; margin-left: 0px;font-size: 15px; background-color: White; color: DodgerBlue;border: solid; ';
        upload_image.value = "upload";
        upload_div.appendChild(upload_image);
        var preview_div = document.createElement("div");
        preview_div.id ="preview_q_"+i;
        upload_form.appendChild(preview_div);
        var image_preview = document.createElement("img");
        image_preview.src = "";
        image_preview.id = "image_preview_q_"+i;
        image_preview.style= 'visibility : hidden;';
        preview_div.appendChild(image_preview);
      }
      for (var j = 1 ; j<=4 ; j++){
        var ans_div = document.createElement("div");
        ans_div.id = "q_"+i+"_a_div_"+j;
        ans_div.className = 'ans_div';
        document.getElementById("q_"+i).appendChild(ans_div);
        var container = document.createElement("label");
        container.className = 'container';
        container.innerHTML ="Choise " + j + " :  ";
        ans_div.appendChild(container);
        var ans_select = document.createElement("input");
        ans_select.type = "radio";
        ans_select.id = "q_"+i+"_a_se_"+j;
        ans_select.name = "q_"+i+"_a_se_";
        ans_select.value=j;
        container.appendChild(ans_select);
        var checkmark = document.createElement("span");
        checkmark.className = 'checkmark';
        container.appendChild(checkmark);
        var ans_in = document.createElement("textarea");
        ans_in.className = 'choise_area';
        ans_in.id = "q_"+i+"_a_"+j;
        ans_in.name = "q_"+i+"_a_"+j;
        ans_in.rows = "1";
        ans_in.cols = "50";
        ans_in.placeholder = "Write an answer here.. ";
        ans_div.appendChild(ans_in);
      }
      var grade_dev = document.createElement("div");
      grade_dev.className = 'grade_div';
      grade_dev.id = "q_"+i+"_g_div_"+j;
      document.getElementById("q_"+i).appendChild(grade_dev);
      var grade_label = document.createElement("label");
      grade_label.innerHTML = "Grade Percentage : ";
      grade_label.className = 'grade_label';
      grade_dev.appendChild(grade_label);
      var grade = document.createElement("input");
      grade.className = 'grade';
      grade.id = "q_"+i+"_g_"+j;
      grade.name = "q_"+i+"_g_"+j;
      grade.placeholder = "out of 100";
      grade_dev.appendChild(grade);
    }
    </script>

    <script>
    var uploads = {};

    function ajaxCallBack(response){
      if(response=='invalid')
      {
      alert('Invalid File!');
      }
      else
      {
        var id =  response.split('-path:')[0];
        var path = response.split('-path:')[1];
        document.getElementById("image_preview_q_"+id).src = path;
        document.getElementById("image_preview_q_"+id).style= 'visibility : visible;';
        var name_p = "image_preview_q_"+id;
        uploads[name_p]=path;
        for (const property in uploads) {
          console.log(`${property}: ${uploads[property]}`);
        }
      }
    }
      $('#questions').on('submit','.form',(function(e) {
        e.preventDefault();
        var form_data =  new FormData(this);
        for (let key of form_data.keys()) {
          var form_name = key;
        }
        var q_id = form_name.charAt(2);
        form_data.append('q_id', q_id);
        $.ajax({
         url: "ajaxupload.php",
         type: "POST",
         data:  form_data,
         contentType: false,
               cache: false,
         processData:false,
      success: ajaxCallBack,

      error: function(e)
       {
         alert(e);
       }
     });
  }));
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
  $(document).ready(function(){
   $("#Q_form").submit(function(e){
    e.preventDefault();
    var form_data =  new FormData(this);
    form_data.append('data_images',JSON.stringify(uploads));

      $.ajax({
      url: "register_exam.php",
      type: "POST",
      processData: false,
      contentType: false,
      data: form_data,
      success: function (a) {
                if (a.includes("1")){
                alert("Exam registered successfully!");
                location.href = 'staff_exams.php';}
                if (a.includes("2")){
                  alert("a question was not declared. Make sure you chose the type of question or to press the upload buttton if you chose an image.\n");
                }
                else if(a.includes("3")){
                  alert("Empty image. Please make sure you uploded correctly.\n");
                }
                else if (a.includes("4")){
                  alert("Empty question prompt!\n");
                }
                else if(a.includes("5")){
                  alert("Please fill in all the answer choises.\n");
                }
                else if (a.includes("6")){
                  alert("Please select the correct answers for your questions.\n");
                }
                else if(a.includes("7")){
                  alert("Please fill all grades.\n");
                }
                else if(a.includes("8")){
                  alert("Grades must sum up to 100%.\n");
                }
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
