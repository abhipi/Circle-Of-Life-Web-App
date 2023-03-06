<?php
include('database_connection.php');

session_start();

$con = mysqli_connect('localhost','root','');
mysqli_select_db($con, 'chat');

$message = $_REQUEST['message'];
$userid = $_REQUEST['user'];
$groupid = $_REQUEST['group'];

$message=mysqli_real_escape_string($con,$message);
mysqli_query($con, "INSERT INTO chats (message, user_id, group_id) VALUES ('$message', '$userid', '$groupid')");
$sql = mysqli_query($con, "SELECT * from chats WHERE message = '".$message."'");
while($row2 = mysqli_fetch_array($sql))
{
	mysqli_query($con, "INSERT INTO posts (body, user_id, chat_id) VALUES ('$message', '$userid',".$row2['chat_id'].")");
}
mysqli_query($con, "UPDATE groups SET total_chats = total_chats + 1 WHERE group_id = '".$groupid."'");

$query = mysqli_query($con, "SELECT * from chats ORDER BY chat_id DESC");

while ($row = mysqli_fetch_array($query))
{
	echo "USER ID: " . $row['user_id'] . "MESSAGE: " . $row['message'] . "</br>";
	
}
?>
