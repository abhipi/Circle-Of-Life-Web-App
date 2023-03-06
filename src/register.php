<!--
//register.php
!-->

<?php

include('database_connection.php');

session_start();

$message = '';

if(isset($_SESSION['user_id']))
{
 header('location:index.php');
}

if(isset($_POST["register"]))
{
 $username = trim($_POST["username"]);
 $password = trim($_POST["password"]);
 $check_query = "
 SELECT * FROM login 
 WHERE username = :username
 ";
 $statement = $connect->prepare($check_query);
 $check_data = array(
  ':username'  => $username
 );
 if($statement->execute($check_data)) 
 {
  if($statement->rowCount() > 0)
  {
   $message = '<p><label>Username is already taken</label></p>';
   
  }
  else
  {
   if(empty($username))
   {
    $message = '<p><label>Username is required</label></p>';
  
   }
   if(empty($password))
   {
    $message = '<p><label>Password is required</label></p>';
    
   }
   else
   { if(strlen($password)<7)
    {
      $message = '<p><label>Password must have at least 7 characters</label></p>';
    }
   else{ if($password != $_POST['confirm_password'])
    {
     $message = '<p><label>Passwords do not match</label></p>';
     
    }
  }
   }
   if($message == '')
   {
    $data = array(
     ':username'  => $username,
     ':password'  => password_hash($password, PASSWORD_DEFAULT)
    );

    $query = "
    INSERT INTO login 
    (username, password) 
    VALUES (:username, :password)
    ";
    $statement = $connect->prepare($query);
    if($statement->execute($data))
    {
     $message = "<label>Registration Completed</label>";
    
     header("location: login.php");
    }
   }
  }
 }
}

?>

<html>  
    <head>  
        <title>Circle Of Life</title>  
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: black;
  color: white;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  top: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from { top: 0; opacity: 0;} 
  to { top: 30px; opacity: 1;}
}

@keyframes fadein {
  from {top: 0; opacity: 0;}
  to {top: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {top: 30px; opacity: 1;} 
  to {top: 0; opacity: 0;}
}

@keyframes fadeout {
  from {top: 30px; opacity: 1;}
  to {top: 0; opacity: 0;}
}
</style>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@100&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="./CSS/register.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body onload="myFunction()">  
    <div class="nav-section" >
    <nav>
    <img src="./images/image-removebg-preview (3).png" alt="@COL" class="im">

      <ul>
          <li><a href="./home.html">HOME</a></li>
          <li><a href="#">ABOUT</a></li>
          <li><a href="#">CONTACT&nbspUS</a></li>
          <li><a href="./login.php">LOGIN</a></li>
    
      
      </ul>
   </nav>
    </div>
 
    <div class="container-fluid">
        <div class="container">
   <br />
   <br><br><br><br><br><br><br><br>
   <h3 style="text-align:center;">Registration</a></h3><br />
   <br />
   
   <div class="panelpanel-default">
      
    <div class="panel-body">
     <form method="post">
      
      <div class="form-group">
       <label class="user">Enter Username</label>
       <center><br>
       <input type="text" name="username" class="form-control" required/>
      </div><br>
      <div class="form-group"></center>
       <label class="pass">Enter Password</label><center><br>
       <input type="password" name="password" class="form-control" required/>
      </div>
      <div class="form-group"></center><br>
       <label class="pass">Re-enter Password</label><center><br>
       <input type="password" name="confirm_password" class="form-control" required/>
      </div></center>
      <center><br><br>
      <div class="form-group">
       <input type="submit" name="register" class="button" value="Register" onclick="myFunction()" />
      </div></center><br><br><br><br><br>
      <div id="snackbar"><?php echo $message ?></div>
      <script>
function myFunction() {
  var y='<?php echo $message; ?>';
  if(y!=''){
 setTimeout(function(){
  var x = document.getElementById("snackbar");
   x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
 },2000);}
}
</script>
      <div  class="not" style="text-align:center;">
      <label >Already a member?
       <a href="login.php">&nbspLogin</a>
      </div>
     </form>
    </div>
   </div>
  </div>
    </body>  
</html>

