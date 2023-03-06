<?php

$con = mysqli_connect('localhost','root','');

mysqli_select_db($con, 'chat');
$user = $_GET['user'];
$group = $_GET['group'];

$query = mysqli_query($con, "SELECT user_id FROM login WHERE username = '".$user."'");

while ($row = mysqli_fetch_array($query))
		{   
			mysqli_query($con, "INSERT INTO users_groups (user_id, group_id) VALUES ('".$row['user_id']."', $group)");
		}



?>
<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
	<style>
		body{
			background-color: cadetblue;
		}
		a{
			float:block;
			border: 0px;
			background-color: #0090CB;
			border-radius: 5px;
			padding : 5px;
			color: white;
		}
		.row{
			margin-top: 300px;
			height: 200px;
			padding: 10px;
			border: 0px;
			
		}
	</style>
	</head>
	<body>
	<div class="container">
		<div class="row" >
			<div class="col-lg-3"></div>
			<div class="col-lg-6" style="text-align:center; background-color:azure; border-radius: 5px; box-shadow: 2px 2px 2px 2px;">
				<h1><p><?php echo $user; ?> is Added to Your Group</p></h1>
				<a href="javascript:;" onclick = "history.back()">Click Here To Add More Friends</a>		
			</div>
			<div class="col-lg-3"></div>
		</div>
	</div>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>