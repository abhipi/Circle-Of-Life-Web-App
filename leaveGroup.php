<?php
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con, 'chat');
session_start();
$username = $_SESSION['username'];
$user_id = $_GET['userid'];
$group_id = $_GET['groupid'];

mysqli_query($con, "DELETE FROM users_groups WHERE user_id = $user_id AND group_id = $group_id");
header("location:groups.php");
?>