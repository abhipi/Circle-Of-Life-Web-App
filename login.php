<?php

include('database_connection.php');

session_start();

$message = '';   //error
if(isset($_SESSION['user_id']))
{
 header('location:index.php');
}

if(isset($_POST["login"]))
{
 $query = "
   SELECT * FROM login 
    WHERE username = :username
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
    array(
      ':username' => $_POST["username"]
     )
  );
  $count = $statement->rowCount();
  if($count > 0)
 {
  $result = $statement->fetchAll();
    foreach($result as $row)
    {
      if(password_verify($_POST["password"], $row["password"]))
      {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $sub_query = "
        INSERT INTO login_details 
        (user_id) 
        VALUES ('".$row['user_id']."')
        ";
        $statement = $connect->prepare($sub_query);
        $statement->execute();
        $_SESSION['login_details_id'] = $connect->lastInsertId();
        header("location:groups.php");
      }
      else
      {
       $message = "<label>Wrong Password</label>";
       sleep(4);
       
      }
    }
 }
 else
 {
  $message = "<label>Wrong Username</label>";
  sleep(4);
  
 }
}

?>

<!DOCTYPE html>
<html>  
    <head>  
        <title>Circle Of Life</title>  
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
  z-index: 1;
  left: 48%;
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
  <link rel="stylesheet" href="CSS/login.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>
    <div class="nav-section">
    <nav>
    <img src="./images/image-removebg-preview (3).png" alt="@COL" class="im">
      <ul>
          <li><a href="./home.html">HOME</a></li>
          <li><a href="#">ABOUT</a></li>
          <li><a href="#">CONTACT&nbspUS</a></li>
          <li><a href="#">LOGIN</a></li>
    
      
      </ul>
   </nav>
    </div>

 


    <div class="container-fluid">
  
        <div class="container">
   <br />
   <br><br><br><br><br><br><br><br>
   <h3 style="text-align:center;">Login</a></h3><br />
      <br />
   <div class="panelpanel-default">
      
    <div class="panel-body">
     <form method="post">
    
      
      <div class="form-group">
        
       <label class="user">Enter Username</label>
       <center><br>
       <input type="text" name="username" class="form-control" required />
      </div>
      <div class="form-group"></center><br>
       <label class="pass" >Enter Password</label><center><br>
       <input  type="password" name="password" class="form-control" required />
      </div></center>
      <center>
        <br><br>
      <div class="but" >
      <input type="submit"  name="login" class="button" value="Login"  onclick="myFunction()"  />
      </div></center>
      <br><br><br><br><br><br><br>
      <div id="snackbar">Wrong Username Or Password</div>
      <script>
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }
</script>
      <div class= "not" style="text-align:center;">
       <label >Not a member?
       <a href="register.php">&nbspRegister</a>
      </div>
     </form>
    </div>
   </div>
  </div>
    </body>  
</html>



