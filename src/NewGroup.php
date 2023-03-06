<?php 

//global $friend;

$userName = $_GET['nname'];
$idcounter=0;
$con = mysqli_connect('localhost','root','');

mysqli_select_db($con, 'chat');

//echo "<label>Add Members</label></br></br>";
$count = 0;
if(isset($_POST['insertGroup']))
{
	if($_POST['groupName'] != "" && $_GET['nname'] != "")
	{
		
		$userName = $_GET['nname'];
		$groupName = $_POST['groupName'];

			$unique = mysqli_query($con, "SELECT * from groups");

			while($col = mysqli_fetch_array($unique))
			{				
				if($_POST['groupName'] == $col['group_name'])
				{
					$count = $count + 1;
				}
			}

			if($count > 0)
			{
				echo "<div class='row'><div class='col-lg-4'></div><div class='col-lg-4' style='text-align: center;'><p class='fade' style='font-size:0.5cm;'>This circle already exists</p></div><div class='col-lg-4'></div></div>";			  
			}
			else
			{	
				$query2 = mysqli_query($con, "SELECT user_id FROM login WHERE username = '".$userName."'");

				while ($row1 = mysqli_fetch_array($query2))
				{
					$query1 = mysqli_query($con, "INSERT INTO groups (group_name, creator_id) VALUES ('$groupName', '".$row1['user_id']."')");
					$creatorId = $row1['user_id'];
				}

				$query3 = mysqli_query($con, "SELECT group_id FROM groups WHERE group_name = '$groupName'");

				while ($row = mysqli_fetch_array($query3))
				{
					$newGroupId = $row['group_id'];
				}

				$query = "SELECT * FROM `login` WHERE username != '".$userName."'";
				//echo "new group id is ".$newGroupId;
				$result = mysqli_query($con, $query);
				echo '<script>
				setInterval(function(){ 
				var x= document.getElementById("remove");
				x.style.display="none";},10);			
				</script><div class="row" style="margin-top: 100px;">
					<div class="col-lg-3"></div>
					<div class="col-lg-6" style="text-align: center;">
					<br><br><br><br>
						<h1 style="text-align:center;font-size:1.5cm;color:white">Add Members</h1><br><br>';
				while ($row = mysqli_fetch_array($result))
				{
					//echo "<a href='addMembers.php?user=".urlencode($row['username'])."&group=".urlencode($newGroupId)."'>". $row['username']."</a><br>";
					$current = $row['username'];
					$block = "block";
					$hide = "none";
					echo "<button id='add".$idcounter."' onclick='add(\"".$current."\",\"".$newGroupId."\",\"".$idcounter."\")' style='display: \"".$block."\"; :active{display: \"".$hide."\";};width:5cm;padding:20px 20px 20px 20px;font-size:0.5cm; color: white; background-color:rgba(0,0,0,0.3);border-color:transparent;border-radius:1cm;'>". $row['username']."</button><br><br><br>";
						$idcounter+=1;
				}
				echo "</div>
					<div class='col-lg-3'></div>    
					</div>";
				echo "</br></br>";
				mysqli_query($con, "INSERT INTO users_groups (user_id, group_id) VALUES ('$creatorId', '$newGroupId')");
			}		
		}
		else
			echo "Circle Name Missing";
}
 

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
  <style>
		.fade{
			background-color:black; 
			color:white; 
			animation-name:fadebar; 
			animation-duration:3s; 
			opacity: 1;
			height:2cm;
			padding:20px 20px 20px 20px;
			text-align: center;
			display:block;
			width: 300px;
			position: relative;
			top: 1cm;
			left: 150px;
		}

		@keyframes fadebar
		{
			from{opacity: 1;
			display: block;} 
			to{opacity: 0;
			display: none;}
		}

	</style>
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
	
    <div class="container" id='remove'  style="padding-top:3cm;">
	<center><br><br><br><br><br><br><br><br>
        <div class="row">
	        <div class="col-lg-4"></div>
            <div class="col-lg-4" style="border:none;position:fixed;left: 33%;top:33%;">
            <form name = "groupForm" method="POST">
		        <label><h3 style="text-align:center;font-size:1.5cm;">Enter &nbspCircle &nbspName</h3></label></br></br>
		        <input type="text" name="groupName" class="form-control" required/></br></br>
		        <button name="insertGroup" type="submit" class="button">Submit</button>
	        </div>
            <div class="col-lg-4" style="background-color:transparent;"></div>
            </form>
        </div>
    </div>
	<script type="text/javascript">
		function add(username,id,x)
		{
			var xmlhttp = new XMLHttpRequest();
			var but1=document.getElementById("add"+x);
			but1.style.display="none";
			xmlhttp.open('POST', 'addMembers.php?user='+username+'&group='+id, true);
    		xmlhttp.send();
		}
		$(document).ready(function(e)
			{
    			$.ajax({cache: false});
    			
    		});

	</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script> function my(){ var x = document.getElementById('snackbar'); x.className = 'show'; setTimeout(function(){ x.className = x.className.replace('show', ''); }, 3000);}</script>
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
</center>
</body>
</html>