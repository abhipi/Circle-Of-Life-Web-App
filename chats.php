<?php
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con, 'chat');

$group = $_GET['group'];
$user = $_GET['user'];
$name=$_GET['name'];

$sql = mysqli_query($con, "SELECT total_chats FROM groups WHERE group_id = '".$group."'");
while ($row = mysqli_fetch_array($sql))
{
    $total = $row['total_chats'];
    $sql1 = mysqli_query($con, "UPDATE users_groups SET read_chats = $total WHERE user_id = '".$user."' AND group_id = '".$group."'");
}
?>


<!DOCTYPE html>
<html>
<head>
<?php
	include('database_connection.php');

	session_start();
	
	$userName = $_SESSION['username'];
	
	$con = mysqli_connect('localhost','root','');
	mysqli_select_db($con, 'chat');
	
	global $out;
	$query2 = mysqli_query($con, "SELECT * FROM login WHERE username = '".$userName."'");
	
	while ($row1 = mysqli_fetch_array($query2))
	{
		$query = "SELECT * FROM `users_groups` WHERE user_id = ".$row1['user_id']."";
	
		$result = mysqli_query($con, $query);
		while ($row = mysqli_fetch_array($result))
		{
			$sql = mysqli_query($con, "SELECT * FROM groups WHERE group_id = ".$row['group_id']."");
			while($row2 = mysqli_fetch_array($sql))
			{
				if ($row['read_chats'] < $row2['total_chats'])
				{
					$unread = $row2['total_chats'] - $row['read_chats'];
					//echo $unread;
				}
				
				$out .= "<a href='chats.php?user=".urlencode($row1['user_id'])."&group=".urlencode($row2['group_id'])."&name=".urlencode($row2['group_name'])."' style='font-size:0.7cm;color:white;text-decoration:none;display:inline-block;width:14cm;padding-top:5px;padding-bottom:5px;padding-left:1cm;border-radius:0.5cm;' onmouseover='OnMouseIn (this)' onmouseout='OnMouseOut (this)'>". $row2['group_name']."</a><br>";
	
		  
		}
		
		}
	
	}
	
?>	
	<title>Circle Of Life</title>
	<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" href="css/chats.css">
<style>
  .name{
    padding: 5px 15px;
  }
</style>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript">
		
		console.log('before function');
		function chat()
		{
			var message = chatForm.message.value;
			if(message!="")
			{var xmlhttp = new XMLHttpRequest();
	    	xmlhttp.onreadystatechange = function()
	    	{
    	    	if(xmlhttp.readyState==4&&xmlhttp.status==200)
    	    	{
            		document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
        		}
    		}

    		xmlhttp.open('GET', 'insertChat.php?message='+message+'&user='+<?php echo $_GET['user'] ?>+'&group='+<?php echo $_GET['group'] ?>, true);
    		xmlhttp.send();

    		console.log('inside function');}
	
    	}

    	$(document).ready(function(e)
			{
    			$.ajax({cache: false});
    			setInterval(function()
    			{
        			$('#chatlogs').load('logs.php?group='+<?php echo $_GET['group'] ?>);
    			}, 200);
    		});
		$(document).ready(function(e){
			$("#scroll_to").animate({ scrollTop: $('#scroll_to').prop("scrollHeight")}, 1000);
			$.ajax({cache: false});
		});


    	console.log('after function');

	</script>
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
    <div class="inbox_msg" style="height:800px; width:600px;background:transparent;border-top-color:transparent;border-bottom-color:transparent;border-left-color:transparent;border-right-color:rgba(255,255,255,0.3);padding-left:1cm;" >
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
            
            if(!$out == "")
            {
              echo "<ul class='name' id='searc' style='padding-bottom:2cm;padding-left:0cm;'><br>";
              echo $out;
              echo "</ul>";
            }
            else{
              echo "No circles have been created yet";
            }
            ?>  
            
          </div>
        </div>
		
	</div>
	<div class="mesgs" style="height:810px;padding-top:0cm;">
		<center><div style="font-size:0.6cm;font-family:Quicksand;color:white;opacity:1;padding:0px;display:inline-block;"><?php echo $_GET['name']; ?></div><button onclick="leave()" style="float:right;display:inline-block;padding:5px 10px 5px 10px;font-size:0.4cm;border-color:transparent;border-radius:1cm;color:white;background-color:rgba(200, 35, 51,1);font-family:Quicksand;">Leave</button></center>
		<br>
			<div class="msg_history" id="scroll_to" style="height:650px;width:100%;background-color: #b6effc;padding:16px;overflow-y:auto;border-radius: 20px;box-shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.034), 0 6.7px 5.3px rgba(0, 0, 0, 0.048), 0 12.5px 10px rgba(0, 0, 0, 0.06), 0 22.3px 17.9px rgba(0, 0, 0, 0.072),  0 41.8px 33.4px rgba(0, 0, 0, 0.036),0 100px 80px rgba(0, 0, 0, 0.035);">
					
					<div id = "chatlogs" style="color:white;font-family:Quicksand;" >
					<br><br>
						<center>LOADING POSTS, PLEASE WAIT.........</center>					
					</div>
					<!--<a href="post_details.php">Add Comments</a>-->
					
			</div>
			<br>
			<form action="" method="POST" name="chatForm" style="color:white;height:50px;" accept-charset="utf-8">
			<!--<label for="message">Enter your message</label>-->
			<div class="type_msg">
				<div class="input_msg_write">
					<input type="text" class="write_msg" name="message" placeholder="Create a Post" required>
					<button class="msg_send_btn" name="sendMessage" type="submit" onclick="chat()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
			
				</div>
			</div>
					
			</form>
		</div>	
		</div>
<a href="#" class="float" onclick="one();">
<img src='./images/arrow.png' style='height:0.75cm;width:0.5cm;padding-top:0.4cm;'></a>
<style>
.float{
	position:fixed;
	width:40px;
	height:40px;
	bottom:110px;
	right:170px;
	background-color:#f0f0f5;
	color:#FFF;
	border-radius:100px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:22px;
}
</style>
</a>
</div>
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
   url:"fetch_group.php", //request to url link
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
   url:"fetch_group.php", //request to url link
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
		function OnMouseIn2 (elem) {
            elem.style.textDecoration="none";
                  }
        function OnMouseOut2 (elem) {
			elem.style.textDecoration="none";
        }
		function leave(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.open('POST', 'leaveGroup.php?userid='+<?php echo $_GET['user'] ?>+'&groupid='+<?php echo $_GET['group']?>, true);
			xmlhttp.send();
			location.replace("groups.php");
		}
		$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
function one()
{

	$("#scroll_to").animate({ scrollTop: $('#scroll_to').prop("scrollHeight")}, 1000);
			$.ajax({cache: false});
}
    </script>
	
</body>
</html>