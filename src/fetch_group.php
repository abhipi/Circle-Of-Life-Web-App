<?php 

include('database_connection.php');

session_start();

$userName = $_SESSION['username'];
$search_value = $_POST["search"];
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
		$sql = mysqli_query($con, "SELECT * FROM groups WHERE group_id = ".$row['group_id']." AND group_name LIKE '%".$search_value."%' ");
		while($row2 = mysqli_fetch_array($sql))
		{
			if ($row['read_chats'] < $row2['total_chats'])
			{
				$unread = $row2['total_chats'] - $row['read_chats'];
			//	echo $unread;
			}
		
      $out .= "<a href='chats.php?user=".urlencode($row1['user_id'])."&group=".urlencode($row2['group_id'])."&name=".urlencode($row2['group_name'])."' style='font-size:0.7cm;color:white;text-decoration:none;display:inline-block;width:14cm;padding-top:5px;padding-bottom:5px;padding-left:1cm;border-radius:0.5cm;' onmouseover='OnMouseIn (this)' onmouseout='OnMouseOut (this)'>". $row2['group_name']."</a><br>";
    }
    
	}

}
echo $out;
?>