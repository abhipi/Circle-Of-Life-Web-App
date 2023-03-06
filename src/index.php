<!--
//index.php
!-->

<?php

include('database_connection.php');

session_start();

if(!isset($_SESSION['user_id']))
{
 header("location:login.php");
}

?>

<html>  
    <head>  
        <title>Circle Of Life</title> 
        <style>
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -120px;
  background-color: black;
  color: white;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
   top: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
  from { top: 0; opacity: 0;} 
  to { top: 30px; opacity: 1;}
}

@keyframes fadein {
  from {top: 0; opacity: 0;}
  to {top: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {top: 30px; opacity: 1;} 
  to {top: 0; opacity: 0;}
}

@keyframes fadeout {
  from {top: 30px; opacity: 1;}
  to {top: 0; opacity: 0;}
}
</style> 
<style>
.float{
	position:absolute;
	width:40px;
	height:40px;
	bottom:220px;
	right:7px;
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
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@100&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <link rel="stylesheet" href="./CSS/index.css" type="text/css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    </head>  
    <body> 
    <div class="nav-section" >
    <nav>
    <img src="./images/image-removebg-preview (3).png" alt="@COL" class="im">
    <h1 class="company"><?php echo $_SESSION['username'];  ?> </h1> 

      <ul>
          <li><a href="./groups.php" id="circles1">CIRCLES</a></li>
          <li><a href="./index.php">SOULS</a></li>
          <li><a href="./feedback.php" >FEEDBACK</a></li>
          <li><a href="./logout.php">LOGOUT</a></li>
    
      
      </ul>
   </nav>
    </div>    
    

        <div class="container">
   <br />
   <br><br><br><br><br>
   <h3 align="center" style="font-size:2cm;">Entwined Souls</a></h3><br />
   <br /><br>
   <div id="search-bar">
      <label style="color:white;font-size:0.6cm;font-weight:normal ;">Search&nbsp&nbsp&nbsp</label>
      <input type="text" id="search" autocomplete="off" value="" style="width:30%;height:5%;background-color:transparent;font-family:Quicksand;color:white;font-size:0.5cm;padding:20px 20px 20px 20px;border-radius:20px;border-color:#1aace188;outline: none;"></input>
    </div><br><br>
   <div class="table-responsive">
    
    <input type="hidden" id="is_active_group_chat_window" value="no" />
      <div id="user_details" class="tabl"></div>
    <div id="user_model_details"></div>
   </div>
  </div>
  <div id="snackbar">Go on!&nbsp&nbspType a message</div>
      <script>
function myFunction() {
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>
    </body>  
</html>  

<div id="group_chat_dialog" title="Group Chat Window">
 <div id="group_chat_history" style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;">

 </div>
 <div class="form-group">
  <textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea>
 </div>
 <div class="form-group" align="right">
  <button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info">Send</button>
 </div>
</div>



<script>  
$(document).ready(function(){
  get_first_time();
 fetch_user();
 update_last_activity(); // executed every 5 seconds
 update_chat_history_data();
 fetch_group_chat_history();
 setInterval(function(){ //this fuction is called very 5 seconds in order to update the user record
 update_last_activity(); // executed every 5 seconds
 fetch_user(); //update status of user
 update_chat_history_data();
 fetch_group_chat_history();
}, 5000);
$(function(){
  $("#search").focus().select();
});

function get_first_time()
{ 
  var search_term = "";
  $.ajax({
   url:"fetch_user.php", //request to url link
   method:"POST", // sends data to the server
   data : {search:search_term },
   success:function(data){  //if request complete successfully , data argument 
    $('#user_details').html(data); //data argument is passed
   }
  })


}
function fetch_user()
 {
  $("#search").on("keyup",function(){
       var search_term = $(this).val();
  $.ajax({
   url:"fetch_user.php", //request to url link
   method:"POST", // sends data to the server
   data : {search:search_term },
   success:function(data){  //if request complete successfully , data argument 
    $('#user_details').html(data); //data argument is passed
   }
  })
  })
 }
 function update_last_activity()
 {
  $.ajax({    //Ajax request
   url:"update_last_activity.php",  //request to url
   success:function()
   {

   }
  })
 }

 function make_chat_dialog_box(to_user_id, to_user_name)
 { 
  var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="'+to_user_name+'" style="background-color:white">';
  modal_content += '<div style="height:400px; overflow-y: auto; margin-bottom:24px; padding:16px; background-color: rgba(99, 223, 251,0.1); border-radius: 20px; box-shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.034), 0 6.7px 5.3px rgba(0, 0, 0, 0.048), 0 12.5px 10px rgba(0, 0, 0, 0.06), 0 22.3px 17.9px rgba(0, 0, 0, 0.072),  0 41.8px 33.4px rgba(0, 0, 0, 0.036),0 100px 80px rgba(0, 0, 0, 0.035);color:transparent;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  modal_content += fetch_user_chat_history(to_user_id); //we have added a function over here
  modal_content += '</div>';
  modal_content += '<div class="form-group">';
  modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message" style="background-color:white; font-family: Quicksand; color: black;font-size:15pt; height:3cm; border-color:#63dffb; border-radius:10px; width:100%;"></textarea>';
  modal_content += '</div><div class="form-group" align="center">';
  var a= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat" style="width:100%; height:1.3cm; background-color: rgba(99, 223, 251); border:none; font-family:Quicksand; font-size:15pt; border-radius:20px">SEND</button><a href="#" class="float" onclick="one('+to_user_id+');"><img src="./images/arrow.png" style="height:0.75cm;width:0.5cm;padding-top:0.4cm;"></a></div></div>';
  modal_content+=a;
  $('#user_model_details').html(modal_content);
  
 }

 $(document).on('click', '.start_chat', function(){ //when we click on start chat button this block of code is executed
  var to_user_id = $(this).data('touserid');  //this code fetch the value from data to touserid and store it in to_user_id
  var to_user_name = $(this).data('tousername');
  make_chat_dialog_box(to_user_id, to_user_name);
  $("#user_dialog_"+to_user_id).dialog({  //initailizing jquery dynamic box
   autoOpen:false,
   width:400,
    }).prev(".ui-dialog-titlebar").css({"background":"white","font-color":"white", "font-family":"Alegreya Sans SC", "font-size":"27px","color":"#63dffb","border":"none"});
       $('#user_dialog_'+to_user_id).dialog('open');
       one(to_user_id);
 });

 $(document).on('click', '.send_chat', function(){  //when we click on send chat button this block of code is executed
  var to_user_id = $(this).attr('id'); //fetches id attribute 
  var chat_message = $('#chat_message_'+to_user_id).val();
  if(chat_message!=""){ //this code will fetch the msg from text area field and stored it in chat_message
  $.ajax({
   url:"insert_chat.php",
   method:"POST",
   data:{to_user_id:to_user_id, chat_message:chat_message}, //here we write the data that we have to send to the server
   success:function(data)  //this function takes data from the server on successful completion of further request
   {
    $('#chat_message_'+to_user_id).val(''); // this code will clear the text area field value
    $('#chat_history_'+to_user_id).html(data); //this data argument is used to receive the conversation history between two persons
   }
  })}
  else{
    myFunction();
  }
 });

 function fetch_user_chat_history(to_user_id)//it will fetch particular user chat history
 {
  $.ajax({
   url:"fetch_user_chat_history.php",
   method:"POST",
   data:{to_user_id:to_user_id},
   success:function(data){
    $('#chat_history_'+to_user_id).html(data);// it will display data in div tag
   }
  })
 }

 function update_chat_history_data()//this function will fetch chat history messages and display it  
 {
  $('.chat_history').each(function(){// using this method we can fetch all html elements whose class is chat history
   var to_user_id = $(this).data('touserid');// this code will fetch value from touserid and store it in to_user_id var
   fetch_user_chat_history(to_user_id);
  });
 }

 $(document).on('click', '.ui-button-icon', function(){
  $('.user_dialog').dialog('destroy').remove();
 });

 $(document).on('focus', '.chat_message', function(){
  var is_type = 'yes';
  $.ajax({
   url:"update_is_type_status.php",
   method:"POST",
   data:{is_type:is_type},
   success:function()
   {

   }
  })
 });

 $(document).on('blur', '.chat_message', function(){
  var is_type = 'no';
  $.ajax({
   url:"update_is_type_status.php",
   method:"POST",
   data:{is_type:is_type},
   success:function()
   {
    
   }
  })
 });

 $('#group_chat_dialog').dialog({
 autoOpen:false,
 width:400
});

$('#circles').on('click',function(){
 $('#group_chat_dialog').dialog('open');
 $('#is_active_group_chat_window').val('yes');
 fetch_group_chat_history();
});

$('#send_group_chat').click(function(){
 var chat_message = $('#group_chat_message').val();
 var action = 'insert_data';
 if(chat_message != '')
 {
  $.ajax({
   url:"group_chat.php",
   method:"POST",
   data:{chat_message:chat_message, action:action},
   success:function(data){
    $('#group_chat_message').val('');
    $('#group_chat_history').html(data);
   }
  })
 }
});

function fetch_group_chat_history()
{
 var group_chat_dialog_active = $('#is_active_group_chat_window').val();
 var action = "fetch_data";
 if(group_chat_dialog_active == 'yes')
 {
  $.ajax({
   url:"group_chat.php",
   method:"POST",
   data:{action:action},
   success:function(data)
   {
    $('#group_chat_history').html(data);
   }
  })
 }
}

$(document).on('click', '.remove_chat', function(){
  var chat_message_id = $(this).attr('id');
  if(confirm("Are you sure you want to delete this message?"))
  {
   $.ajax({
    url:"remove_chat.php",
    method:"POST",
    data:{chat_message_id:chat_message_id},
    success:function(data)
    {
     update_chat_history_data();
    }
   })
  }
 });
 
}); 
function one(uid)
{

	$("#chat_history_"+uid).animate({ scrollTop: $('#chat_history_'+uid).prop("scrollHeight")}, 1000);
			$.ajax({cache: false});
} 
</script>
