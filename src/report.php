<?php

$con = mysqli_connect('localhost','root','');

mysqli_select_db($con, 'chat');

session_start();

$user = $_SESSION['username'];

?><!DOCTYPE html>
<html>
    <head>
        <title>Circle Of Life</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <link rel="stylesheet" href="./CSS/feedback.css" type="text/css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -120px;
  background-color: black;
  color: white;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 10000;
  left: 50%;
   top: 30px;
 display: inline-block;
   font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein12 0.5s, fadeout12 0.5s 2.5s;
  animation: fadein12 0.5s, fadeout12 0.5s 2.5s;
}

@-webkit-keyframes fadein12 {
  from { top: 0; opacity: 0;} 
  to { top: 30px; opacity: 1;}
}

@keyframes fadein12 {
  from {top: 0; opacity: 0;}
  to {top: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout12 {
  from {top: 30px; opacity: 1;} 
  to {top: 0; opacity: 0;}
}

@keyframes fadeout12 {
  from {top: 30px; opacity: 1;}
  to {top: 0; opacity: 0;}
}
</style> 
</head>
    <body>
    <div id="snackbar">Please enter a valid username</div>
    <script>
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";

  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
function other() {
  var x = document.getElementById("snackbar");
  x.textContent=x.textContent.replace("Please enter a valid username","The report has been submitted");
  x.className = "show";
  setTimeout(function(){ x.textContent=x.textContent.replace("The report has been submitted","Please enter a valid username");x.className = x.className.replace("show", ""); }, 3000);
}
function other1() {
  var x = document.getElementById("snackbar");
  x.textContent=x.textContent.replace("Please enter a valid username","You cannot report the same user twice!");
  x.className = "show";
  setTimeout(function(){ x.textContent=x.textContent.replace("You cannot report the same user twice!","Please enter a valid username");x.className = x.className.replace("show", ""); }, 3000);
}
</script>
    <div class="nav-section" >
    <nav>
    <img src="./images/image-removebg-preview (3).png" alt="@COL" class="im">
    <h1 class="company"><?php echo $_SESSION['username'];  ?> </h1> 

    <ul style="height:2.5cm;padding-top:0cm;">
          <li style="float:right;"><a href="./logout.php">LOGOUT</a></li>
          <li style="float:right;"><a href="./feedback.php">FEEDBACK</a></li>
          <li style="float:right;"><a href="./index.php">SOULS</a></li>
          <li style="float:right;"><a href="./groups.php" id="circles1">CIRCLES</a></li>

      </ul>
   </nav>
    </div>   
        <div class="container" style="padding-top:3cm;">
            <div class="row" style="padding-top:5%;">
            <center><h1 style="font-size:2cm;color:white;padding:0px;">Report</h1></center><br>
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    
                       <center> <textarea id="report" name="improve" class="form-control" value="" rows="5" cols="100" style="border-radius: 1cm;padding:1cm 1cm 1cm 1cm;color:white;font-family:Quicksand;"></textarea><br>
                        <button name="feeds" type="submit" class="btn btn-info send_chat" value="" style="background-color :#1aace188;width:7cm; border-radius:1cm; height:2cm;border-color:transparent;font-size:0.5cm;outline:none;">SUBMIT</button></center>
                   
                </div>
                <div class="col-lg-2"></div>
            
            </div>
        </div>
        
        <script>
$(document).on('click', '.send_chat', function(){  //when we click on send chat button this block of code is executed
  var name = document.getElementById("report").value;
  name=name.trim();
  var name1='<?php echo $user; ?>';
  if(name!=""){ //this code will fetch the msg from text area field and stored it in chat_message
$.ajax({
   url:"insert_report.php",
   method:"POST",
   data:{name: name, name1:name1}, //here we write the data that we have to send to the server
   success:function(data)  //this function takes data from the server on successful completion of further request
   { 
    if(data==1)
    {
other();
    }
    else  if (data==-1){
        myFunction();
    }
    else{
      other1();
    }

   }
  })}
  else{
 myFunction();

}
 });
</script>

    </body>
</html>