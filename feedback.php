<?php

$con = mysqli_connect('localhost','root','');

mysqli_select_db($con, 'chat');

session_start();

$user = $_SESSION['username'];

if(isset($_POST['feeds'])){
    if($_POST['improve'] == ""){
        echo "Please enter valid text inside the textbox";
    }
    else{
        $text = $_POST['improve'];
        $text=mysqli_real_escape_string($con,$text);
        mysqli_query($con, "INSERT INTO feedbacks (username, feedback) VALUES ('$user','$text')");
    }
}
?>
<!DOCTYPE html>
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
    </head>
    <body>
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
            <center><h1 style="font-size:2cm;color:white;padding:0px;">Feedback</h1></center><br>
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <form name="feed" method="POST" style="text-align:center;">
                       <center> <textarea name="improve" class="form-control" rows="5" cols="100" style="border-radius: 1cm;padding:1cm 1cm 1cm 1cm;color:white;font-family:Quicksand;" required></textarea><br>
                        <button name="feeds" type="submit" class="btn btn-info" value="" style="background-color :#1aace188;width:7cm; border-radius:1cm; height:2cm;border-color:transparent;font-size:0.5cm;">SUBMIT</button></center>
                    </form>
                </div>
                <div class="col-lg-2"></div>
            
            </div>
            <br><br><br><br><br><br><br>
            <div class= "not" style="text-align:center;font-size:15pt;color:white;">
       <label>
       <a href="./report.php" style="color:white;text-decoration:none;">Report</a>&nbsp a user</label>
      </div>
        </div>
    </body>
</html>