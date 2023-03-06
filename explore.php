<?php 

include('database_connection.php');

session_start();

$userName = $_SESSION['username'];

$con = mysqli_connect('localhost','root','');
mysqli_select_db($con, 'chat');
$group_id = array();
$name_id = array();
$unique = array();
global $output;
$query2 = mysqli_query($con, "SELECT * FROM login WHERE username = '".$userName."'");

while ($row1 = mysqli_fetch_array($query2))
{
	$query = "SELECT * FROM users_groups WHERE user_id = ".$row1['user_id']."";

	$result = mysqli_query($con, $query);
	while ($row = mysqli_fetch_array($result))
	{
		$group_id[] = $row['group_id']; 
	}

  $sql = mysqli_query($con, "SELECT * FROM groups");
  while($row2 = mysqli_fetch_array($sql))
  {
    $name_id[] = $row2['group_id'];
  }
  
  $arrlen1 = count($group_id);
  $arrlen2 = count($name_id);
  for($i = 0 ; $i < $arrlen2 ; $i++)
  {
    $flag = 0;
    for($j = 0 ; $j < $arrlen1 ; $j++)
    {
      if($name_id[$i] == $group_id[$j])
      {
        $flag = 1;
      }
    }

    if($flag == 0)
    {
      $unique[] = $name_id[$i];
    }
    
  }

  $arrlen3 = count($unique);
    if($arrlen3 != 0)
    {
      for($k = 0 ; $k < $arrlen3 ; $k++)
      {
        
              $gname = mysqli_query($con, "SELECT * FROM groups WHERE group_id = ".$unique[$k]."");
              while($row3 = mysqli_fetch_array($gname))
              {
                $output .= "<a href='exploreadd.php?user=".urlencode($row1['user_id'])."&group=".urlencode($row3['group_id'])."&name=".$_SESSION['username']."' style='font-size:0.7cm;color:white;text-decoration:none;display:inline-block;width:14cm;padding-top:5px;padding-bottom:5px;padding-left:1cm;border-radius:0.5cm;' onmouseover='OnMouseIn (this)' onmouseout='OnMouseOut (this)'>". $row3['group_name']."</a><br>";
              } 
               }

    }      //}
    else
    {
   
    }      

}

?>

<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

<link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="css/explore.css">
<style>
  .name{
    padding: 5px 15px;
  }
</style>
<title>Circle Of Life</title>
</head>
<body>
<div class="nav-section" >
    <nav>
    <img src="./images/image-removebg-preview (3).png" alt="@COL" class="im">
    <h1 class="company" style="top:0.5cm;"><?php echo $_SESSION['username'];  ?> </h1> 

      <ul style="height:2.5cm;padding-top:0cm;">
          <li style="float:right;"><a href="./logout.php">LOGOUT</a></li>
          <li style="float:right;"><a href="./feedback.php">FEEDBACK</a></li>
          <li style="float:right;"><a href="./index.php">SOULS</a></li>
          <li style="float:right;"><a href="./groups.php" id="circles1">CIRCLES</a></li>

      </ul>
   </nav>
    </div>
    
<div class="container" style="padding-top:3cm;">
<!--<h3 class=" text-center">Messaging</h3>-->
    <div class="row">
      <div class="inbox_msg" style="height:800px; width:600px;background:transparent;border-top-color:transparent;border-bottom-color:transparent;border-left-color:transparent;border-right-color:rgba(255,255,255,0.3);padding-left:1cm;">
        <div class="inbox_people" style="height:800px;width:600px;background:transparent;border-top-color:transparent;border-bottom-color:white;border-left-color:transparent;border-right-color:transparent;">
          <div class="headind_srch" style="background:transparent;border-top-color:transparent;border-bottom-color:rgba(255,255,255,0.3);border-left-color:transparent;border-right-color:transparent;height:1.75cm;" >
            <div style="width:100%;" class="recent_heading">
              <ul style="list-style-type: none; float:inline-block;margin: 0;padding: 0;overflow: hidden;">
              <form action='groups.php?nname=<?php echo $userName ?>' method="POST">
                    <button type="submit" style="float: left; text-align:center; width:22%;border-radius:20px;background-color:#1aace10c;border-color:transparent;padding-left:30px;font-size:0.5cm;" class="btn btn-info" onmouseover="OnMouseIn1 (this)" onmouseout="OnMouseOut1 (this)"><li style="text-align:center;">Circles</li></button>
                  </form>
                  <form action='explore.php?nname=<?php echo $userName ?>' method="POST">
                    <button type="submit" style="float: left;text-align:center;border-radius:20px;background-color:#1aace10c;border-color:transparent;font-size:0.5cm;padding-left:30px;width:22%;margin-left:45px;" class="btn btn-info" onmouseover="OnMouseIn1 (this)" onmouseout="OnMouseOut1 (this)"><li style="text-align:center;">Explore</li></button>
                  </form>
                  <form action='NewGroup.php?nname=<?php echo $userName ?>' method="POST">
                    <button type="submit" style="float:left;  text-align:center;border-radius:20px;background-color:#1aace10c;border-color:transparent;padding-left:25px;font-size:0.5cm;width:25%;margin-left:48px;" class="btn btn-info" onmouseover="OnMouseIn1 (this)" onmouseout="OnMouseOut1 (this)"><li style="text-align:center;">New Circle</li></button>
                  </form>
              </ul>  
            </div>
            
          </div>
          <div class="inbox_chat" style="height:800px; width:600px;overflow:auto;">
          <br>
          <div id="search-bar" style="padding-left:1cm; padding-bottom:0.5cm;">
      <label style="color:white;font-size:0.6cm;">Search&nbsp&nbsp&nbsp</label>
      <input type="text" id="search" autocomplete="off" value="" style="width:70%;height:2%;background-color:transparent;font-family:Quicksand;color:white;font-size:0.5cm;padding:10px 10px 10px 10px;border-radius:20px;border-color: rgba(61, 165, 193,0.3);outline: none;"></input>
    </div><br>
            <?php
            
            if(!$output == "")
            {
              echo "<ul class='name' id='searc' style='padding-bottom:2cm;padding-left:0cm;'>";
              echo $output;
              echo "</ul>";
            }
            else{
              echo "<div style='font-size:0.6cm;font-family:Alegreya Sans SC;color:white;padding-left:4cm;'>Create a circle!</div>";
            }
            ?>  
            
          </div>
        </div>
        
      
      
    </div>
    <div class="mesgs">
			<div class="msg_history" style="height:650px;background-image:url('./images/image-removebg-preview (3).png');background-repeat: no-repeat;padding-bottom:0cm;background-position: center;">
					
					
			</div>
          </div>
         
          </div></div>
<script type="text/javascript">
$(document).ready(function(){
  get_circle_first_time();
});
setInterval(function(){ //this fuction is called very 5 seconds in order to update the user record
 get_circle();
 
}, 500);
$(function(){
  $("#search").focus().select();
});
function get_circle_first_time()
 {
 
       var search_term ="";
  $.ajax({
   url:"explore_group.php", //request to url link
   method:"POST", // sends data to the server
   data : {search:search_term },
   success:function(data){  //if request complete successfully , data argument 
    $('#searc').html(data); //data argument is passed
   }
  })

 }
function get_circle()
 {
  $("#search").on("keyup",function(){
       var search_term = $(this).val();
  $.ajax({
   url:"explore_group.php", //request to url link
   method:"POST", // sends data to the server
   data : {search:search_term },
   success:function(data){  //if request complete successfully , data argument 
    $('#searc').html(data); //data argument is passed
   }
  })
  })
 }
        function OnMouseIn (elem) {
            elem.style.backgroundColor="#1aace127";
                  }
        function OnMouseOut (elem) {
          elem.style.backgroundColor="transparent";
        }
        function OnMouseIn1 (elem) {
            elem.style.backgroundColor="#1aace147";
                  }
        function OnMouseOut1 (elem) {
          elem.style.backgroundColor="#1aace10c";
        }
    </script>
    </body>
    </html>