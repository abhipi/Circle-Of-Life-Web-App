<?php
$con = mysqli_connect('localhost','root','');

mysqli_select_db($con, 'chat');

$userid = $_GET['user'];
$groupid = $_GET['group'];
$userName=$_GET['name']

?>

<!DOCTYPE html>
<html>
<head>
	<title>Circle Of Life</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="./CSS/NewGroup.css" type="text/css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
</head>
<body>

<div class="nav-section" style="position: fixed; top: 0px;">
    <nav>
    <img src="./images/image-removebg-preview (3).png" alt="@COL" class="im">
    <h1 class="company" style="top:0.5cm;"><?php echo $userName;  ?> </h1> 

      <ul style="height:2.5cm;padding-top:0cm;">
          <li style="float:right;"><a href="./logout.php">LOGOUT</a></li>
          <li style="float:right;"><a href="./feedback.php">FEEDBACK</a></li>
          <li style="float:right;"><a href="./index.php">SOULS</a></li>
          <li style="float:right;"><a href="./groups.php" id="circles1">CIRCLES</a></li>

      </ul>
   </nav>
    </div>

	<script type="text/javascript">
		
		function my()
		{   var z =document.myForm.myF.value;
			var y =document.myForm.myField.value;
			var xmlhttp = new XMLHttpRequest();
			
			xmlhttp.open('POST', 'addGroupMembers.php?user='+y+'&group='+z, true);
    		xmlhttp.send();
					
		}
		$(document).ready(function(e)
			{
    			$.ajax({cache: false});
    			
    		});
			

	</script>
    <div class="container" style="padding-top:3cm;">
	<center><br><br><br><br><br><br><br><br>  
    <form name="myForm" method="POST" >    
	<div class="row" >
	        <div class="col-lg-4"></div>
            <div class="col-lg-4" style="text-align: center; margin-top: 30px; border:none; ">
            
		        <label><h1 style="font-size:1.5cm;color:white;">Want to join this Circle?</h1></label></br></br>
				<input type="hidden" name="myF" value="<?php echo $groupid; ?>"></input> 
				<input type="hidden" name="myField" value="<?php echo $userName; ?>"></input>
				<button type="submit" name="insertGroup" onclick="my()" id="join" class="btn btn-info" style="width: 10cm;background-color:rgba(0,0,0,0.3);font-size:0.5cm;border-radius:1cm;border:none;"><a href="./groups.php" style="text-decoration:none;color:white;display:inline-block;width:100%;height:100%;padding:20px 20px 20px 20px;">Click Here</a></button>
				 
				</div>
            <div class="col-lg-4"></div>
            
        </div>
		</form></div>
	

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!--<script>
	var action = "call_this";
	function addfriends(){
		$.ajax({
		method: "POST",
		url : 'addMembers.php',
		data:{group:$newGroupId,action:"call_this"},
		success:function(data){
			//alert(html);
		}
	});
}
	</script>-->
</body>
</html>