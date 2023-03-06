<?php
session_start();
$user=$_SESSION['username'];
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con, 'chat');

$group = $_GET['group'];

$query = mysqli_query($con, "SELECT * FROM chats WHERE group_id = '$group' ORDER BY chat_id ASC");

while($row = mysqli_fetch_array($query))
{
	$sql = mysqli_query($con, "SELECT * FROM posts WHERE chat_id = ".$row['chat_id']."");
	while($row1 = mysqli_fetch_array($sql))
	{
		$fetch = mysqli_query($con, "SELECT * FROM login WHERE user_id = ".$row['user_id']."");
			while($row2 = mysqli_fetch_array($fetch)){
			$currentpost = $row['chat_id'];
			if($row['pin']!=1)
			{if($row2['username']!=$user)
			{echo "<div style='font-family:Quicksand;border-color:transparent; background-color:rgba(56, 196, 246,0.2);padding-left:1cm;padding-top:10px;padding-bottom:10px;border-radius:1cm;color:rgba(0,0,0,0.6);'><div style='font-size:0.5cm;font-weight:bold;padding-right:0.5cm;'>".$row2['username']."<button type='button' class='btn btn-danger btn-xs remove_chat' style='float:right;font-size:0.3cm;padding:5px 10px 5px 10px;border-radius:0.5cm;' onclick='change(\"".$currentpost."\")'>X</button></div><div style='font-size:0.5cm;padding-right:1cm;padding-left:0cm;word-wrap:break-word;'>" . $row['message'] . "</div></br> <a href='post_details.php?pid=".urlencode($row1['id'])."&name=".$row2['username']."&page_id=".$row['chat_id']."' onmouseover='OnMouseIn2(this)' onmouseout='OnMouseOut2(this)' style='color:white;text-decoration:none;'>Comments</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <button id='like' onclick='count(\"".$currentpost."\",\"".$user."\")' style='border:none; background-color:transparent; border-radius: 5px; color: white;height:1cm;padding-bottom:0.3cm;'><img src='./images/heart.png' style='height:1cm;width:1cm;'></button><button style='border:transparent;background-color:rgba(255,255,255,0.6); border-radius: 50px;padding-right:10px;padding-left:10px;padding-top:2px;padding-bottom:2px; color:black;'> ".$row['likes']."</button><br></div><br>";
			}
			else{
				echo "<div style='font-family:Quicksand;border-color:transparent; background-color:rgba(56, 196, 246,0.2);padding-left:1cm;padding-top:10px;padding-bottom:10px;padding-left:1cm;border-radius:1cm;color:rgba(0,0,0,0.6);'><div style='font-size:0.5cm;font-weight:bold;padding-right:0.5cm;'>You<button type='button' class='btn btn-danger btn-xs remove_chat' style='float:right;font-size:0.3cm;padding:5px 10px 5px 10px;border-radius:0.5cm;' onclick='change(\"".$currentpost."\")'>X</button></div><div style='font-size:0.5cm;padding-right:1cm;padding-left:0cm;word-wrap:break-word;'>" . $row['message'] . "</div></br> <a href='post_details.php?pid=".urlencode($row1['id'])."&name=".$row2['username']."&page_id=".$row['chat_id']."' onmouseover='OnMouseIn2(this)' onmouseout='OnMouseOut2(this)' style='color:white;text-decoration:none;'>Comments</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <button id='like' onclick='count(\"".$currentpost."\",\"".$user."\")' style='border:none; background-color:transparent; border-radius: 5px; color: white;height:1cm;padding-bottom:0.3cm;'><img src='./images/heart.png' style='height:1cm;width:1cm;'></button><button style='border:transparent;background-color:rgba(255,255,255,0.6); border-radius: 50px;padding-right:10px;padding-left:10px;padding-top:2px;padding-bottom:2px; color:black;'> ".$row['likes']."</button><br></div><br>";
			}
			}
			else{
			if($row2['username']!=$user)
			{echo "<div style='font-family:Quicksand;border-color:transparent; background-color:rgba(56, 196, 246,0.2);padding-left:1cm;padding-top:10px;padding-bottom:10px;padding-left:1cm;border-radius:1cm;color:rgba(0,0,0,0.6);'><div style='font-size:0.5cm;font-weight:bold;padding-right:0.5cm;'>".$row2['username']."</div><div style='font-size:0.5cm;padding-right:1cm;padding-left:0cm;word-wrap:break-word;'>This message was deleted</div></div><br>";
			}
			else{
				echo "<div style='font-family:Quicksand;border-color:transparent; background-color:rgba(56, 196, 246,0.2);padding-left:1cm;padding-top:10px;padding-bottom:10px;padding-left:1cm;border-radius:1cm;color:rgba(0,0,0,0.6);'><div style='font-size:0.5cm;font-weight:bold;padding-right:0.5cm;'>You</div><div style='font-size:0.5cm;padding-right:1cm;padding-left:0cm;word-wrap:break-word;'>This message was deleted</div></div><br>";
				}

			}
		}

	}
}
?>
<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<script type="text/javascript">
			function count(number,id)
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('POST', 'countlike.php?id='+number+'&name='+id, true);
				xmlhttp.send();
			}
			function change(pin)
			{
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.open('POST', 'msgdelete.php?cout='+pin, true);
				xmlhttp.send();
			}
			$(document).ready(function(e)
			{
				$.ajax({cache: false});
			});
		</script>
	</body>
</html>

