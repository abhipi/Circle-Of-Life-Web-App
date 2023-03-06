<?php
$con = mysqli_connect('localhost','root','');

mysqli_select_db($con, 'chat');
$increment = $_GET['cout'];

mysqli_query($con, "UPDATE chats SET pin = pin + 1 WHERE chat_id = ".$increment."");
?>
