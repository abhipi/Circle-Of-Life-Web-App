<?php
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con, 'chat');
session_start();
	$user_id = $_SESSION['user_id'];
	$_SESSION['p_id']=$_GET['pid'];
	// get post with id 1 from database
	$post_query_result = mysqli_query($con, "SELECT * FROM posts WHERE id=".$_SESSION['p_id']."");
	$post = mysqli_fetch_assoc($post_query_result);
	$post_id = $_GET['pid'];
	$userName=$_GET['name'];
	$page_id=$_GET['page_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Circle Of Life</title>
	<!-- Bootstrap CSS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap Javascript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="scripts.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">		
  <link href="./CSS/post_details.css" rel="stylesheet" type="text/css">
  <link href="./CSS/comments.css" rel="stylesheet" type="text/css">
	</script>
	
</head>
<body style="overflow-y:scroll;scroll-behavior: auto;">
<div class="nav-section" >
    <nav>
    <img src="./images/image-removebg-preview (3).png" alt="@COL" class="im">
    <h1 class="company" style="top:0.22cm;"><?php echo $userName;  ?> </h1> 

      <ul style="height:2.5cm;padding-top:0cm;">
          <li style="float:right;"><a href="./logout.php">LOGOUT</a></li>
          <li style="float:right;"><a href="./feedback.php">FEEDBACK</a></li>
          <li style="float:right;"><a href="./index.php">SOULS</a></li>
          <li style="float:right;"><a href="./groups.php" id="circles1">CIRCLES</a></li>

      </ul>
   </nav>
    </div>
	<div class="container" style="padding-top:3cm;">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 post" style="display:block;">

<center><h1 style="font-size:1.5cm;"><?php echo $post['title'] ?></h1><br></center>

<p style="word-wrap:break-word;font-style:Quicksand;font-size:0.75cm;"><?php echo $post['body']; ?></p>
</div>
</div>
<br><br>
<div class="row" style="padding-bottom:4cm; height:100%;">
<div class="msg_history" id="scroll_to" style="height:650px;width:100%;background-color: #b6effc;padding-right:16px;padding-left:16px;padding-top:16px;padding-bottom:16px;overflow-y:auto;border-radius: 20px;box-shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.034), 0 6.7px 5.3px rgba(0, 0, 0, 0.048), 0 12.5px 10px rgba(0, 0, 0, 0.06), 0 22.3px 17.9px rgba(0, 0, 0, 0.072),  0 41.8px 33.4px rgba(0, 0, 0, 0.036),0 100px 80px rgba(0, 0, 0, 0.035);">
<div class="comments" style="height:100%; padding-bottom:2cm;"></div>
</div>
</div>
<a href="#" class="float" onclick="one();">
<img src='./images/arrow.png' style='height:0.75cm;width:0.5cm;padding-top:0.4cm;'></a>
<style>
.float{
	position:absolute;
	width:40px;
	height:40px;
	bottom:-30px;
	right:350px;
	background-color:#f0f0f5;
	color:#FFF;
	border-radius:100px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}

.my-float{
	margin-top:22px;
}
</style>

</div>
<script>
var counter=0;
const comments_page_id = '<?php echo $page_id; ?>';
const uname='<?php echo $userName; ?>';

function get()
{	fetch("comments.php?page_id=" + comments_page_id+"&uname="+uname).then(response => response.text()).then(data => {
	document.querySelector(".comments").innerHTML = data;
	document.querySelectorAll(".comments .write_comment_btn, .comments .reply_comment_btn").forEach(element => {
		element.onclick = event => {
			counter=1;
			event.preventDefault();
			document.querySelectorAll(".comments .write_comment").forEach(element => element.style.display = 'none');
			document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "']").style.display = 'block';
			document.querySelector("div[data-comment-id='" + element.getAttribute("data-comment-id") + "'] input[name='name']").focus();
		
		};
	});
	document.querySelectorAll(".comments .write_comment form").forEach(element => {
		element.onsubmit = event => {
			event.preventDefault();
			fetch("comments.php?page_id=" + comments_page_id+"&uname="+uname, {
				method: 'POST',
				body: new FormData(element)
			}).then(response => response.text()).then(data => {
				element.parentElement.innerHTML = data;
			});
			window.location.reload();
		};
	});
});

}
get();
setInterval(function(){ //this fuction is called very 5 seconds in order to update the user record
 if(counter==0)
 window.location.reload();
 
}, 60000);
function countl(id)
			{	var xmlhttp = new XMLHttpRequest();
				var name='<?php echo $userName; ?>';
				xmlhttp.open('POST', 'count_comment_like.php?id='+id+'&name='+name);
				xmlhttp.send();
				window.location.reload();
			}
			$(document).ready(function(e)
			{
				$.ajax({cache: false});
			});
function one()
{

	$("#scroll_to").animate({ scrollTop: $('#scroll_to').prop("scrollHeight")}, 1000);
			$.ajax({cache: false});
}
</script>			
</body>
</html>