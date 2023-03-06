<?php
$con = mysqli_connect('localhost','root','');

mysqli_select_db($con, 'chat');
$comment_id = $_GET['id'];
$name=$_GET['name'];
//$uid=mysqli_query($con,"SELECT * FROM  `login` WHERE 'username' = '.$name.' ");
$uid=mysqli_query($con,"SELECT * FROM  login WHERE username= '".$name."' ");
$iid=mysqli_fetch_array($uid);
$id=$iid['user_id'];
$q=mysqli_query($con,"SELECT * FROM like_system_comments WHERE comment_id=".$comment_id." AND user_id=".$id."");
if($q->num_rows==0)
{

mysqli_query($con,"INSERT INTO like_system_comments (comment_id, user_id, value) VALUES ('$comment_id', '$id', '1')");

}
//else alter the value column and implement like
$row=mysqli_query($con,"SELECT * FROM like_system_comments WHERE comment_id=".$comment_id." AND user_id=".$id."");
$row1=mysqli_fetch_array($row);
$value=$row1['value'];
mysqli_query($con, "UPDATE comments SET likes = likes + ".$value." WHERE id = ".$comment_id."");
$value = $value * -1;
mysqli_query($con, "UPDATE like_system_comments SET value = ".$value." WHERE comment_id=".$comment_id." AND user_id=".$id.""); 

?>