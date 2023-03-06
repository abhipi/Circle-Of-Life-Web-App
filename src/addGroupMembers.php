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

        header("location:groups.php");

?>
