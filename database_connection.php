<?php

//database_connection.php

$connect = new PDO("mysql:host=localhost;dbname=chat", "root", "");

date_default_timezone_set("Asia/Kolkata");

function fetch_user_last_activity($user_id, $connect)
{
 $query = "SELECT * FROM login_details WHERE user_id = '$user_id' ORDER BY last_activity DESC LIMIT 1"; //this query will fetch the single user record with specific user_id from bottom of table
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['last_activity'];
 }
}
function getCurrentDateTime(){
    date_default_timezone_set("Asia/Calcutta");
    return date("Y-m-d H:i:s");
}
function getDateString($date){
    $dateArray = date_parse_from_format('Y/m/d', $date);
    $monthName = DateTime::createFromFormat('!m', $dateArray['month'])->format('F');
    return $dateArray['day'] . " " . $monthName  . " " . $dateArray['year'];
}

function getDateTimeDifferenceString($datetime){
    $currentDateTime = new DateTime(getCurrentDateTime());
    $passedDateTime = new DateTime($datetime);
    $interval = $currentDateTime->diff($passedDateTime);
    //$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
    $day = $interval->format('%a');
    $hour = $interval->format('%h');
    $min = $interval->format('%i');
    $seconds = $interval->format('%s');

    if($day > 7)
        return getDateString($datetime);
    else if($day >= 1 && $day <= 7 ){
        if($day == 1) return $day . " day ago";
        return $day . " days ago";
    }else if($hour >= 1 && $hour <= 24){
        if($hour == 1) return $hour . " hour ago";
        return $hour . " hours ago";
    }else if($min >= 1 && $min <= 60){
        if($min == 1) return $min . " minute ago";
        return $min . " minutes ago";
    }else if($seconds >= 1 && $seconds <= 60){
        if($seconds == 1) return $seconds . " second ago";
        return $seconds . " seconds ago";
    }
}
function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
{//this query will execute and fetch the rows with the two persons involved 
 $query = "SELECT * FROM chat_message WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') ORDER BY timestamp ASC";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '<ul class="list-unstyled" style="-webkit-border-radius: 10px;
 -moz-border-radius: 10px;
 -border-radius: 10px;
 border-radius: 10px;">';
 foreach($result as $row)
 {
  $user_name = '';
  $dynamic_background = '';
  $chat_message = '';
  if($row["from_user_id"] == $from_user_id)
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>This message has been deleted</em>';
    $user_name = '<b style="color:rgba(2, 45, 61,0.7)">You</b>'; //sender name as 'you'
   }
   else
   {
    $chat_message = $row['chat_message'];
    $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'" style="float:right;border-radius:0.5cm;">X</button><b style="color:rgba(2, 45, 61,0.7)">You</b>'; 
   }
   

   $dynamic_background = 'background-color:rgba(56, 196, 246,0.2);';
  }
  else
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>This message has been deleted</em>';
   }
   else
   {
    $chat_message = $row["chat_message"];
   }
   $user_name = '<b style="color:#4eaccf">'.get_user_name($row['from_user_id'], $connect).'</b>';//the person that receives the mail his name will be displayed using this get_user_name method
   $dynamic_background = 'background-color:rgba(56, 196, 246,0.1);';
  }
  $output .= '
  <li style="border-radius: 15px; font-family:Quicksand; padding-top:8px; padding-left:8px; padding-right:8px;color:black;'.$dynamic_background.'">
   <p>'.$user_name.'<br><br>'.$chat_message.'
    <div align="right" style="padding:6px">
      <small><em>'.getDateTimeDifferenceString($row['timestamp']).'</em></small>
    </div>
   </p>
  </li>
  ';
 }
 $output .= '</ul>';
 $query = "UPDATE chat_message SET status = '0' WHERE from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."' AND status = '1'";//here the content is read soo status is set to 0 that means read
 $statement = $connect->prepare($query);
 $statement->execute();
 return $output;
}

function get_user_name($user_id, $connect)
{
 $query = "SELECT username FROM login WHERE user_id = '$user_id'";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['username'];
 }
}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
 $query = "SELECT * FROM chat_message WHERE from_user_id = '$from_user_id' AND to_user_id = '$to_user_id' AND status = '1'"; //fetch chat history between two user and status 1 represents unseen msg
 $statement = $connect->prepare($query);
 $statement->execute();
 $count = $statement->rowCount();
 $output = '';
 if($count > 0)
 {
  $output = '<span style=" background:rgba(14, 146, 176,0.5);
  border-radius:50%;
  height: 26px;
  width: 26px;
  line-height: 26px;
  display: inline-block;
  text-align: center;
  margin-right: 6px;">'.$count.'</span>';
 }
 return $output;
}

function fetch_is_type_status($user_id, $connect)
{
 $query = "
 SELECT is_type FROM login_details 
 WHERE user_id = '".$user_id."' 
 ORDER BY last_activity DESC 
 LIMIT 1
 "; 
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  if($row["is_type"] == 'yes')
  {
   $output = ' - <small><em><span class="text-muted">Typing...</span></em></small>';
  }
 }
 return $output;
}


function fetch_group_chat_history($connect)
{
 $query = "
 SELECT * FROM chat_message 
 WHERE to_user_id = '0'  
 ORDER BY timestamp DESC
 ";
 $statement = $connect->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 $output = '<ul class="list-unstyled">';
 foreach($result as $row)
 {
  $user_name = '';
  $chat_message = '';
  $dynamic_background = '';

  if($row['from_user_id'] == $_SESSION['user_id'])
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>This message has been deleted</em>';
    $user_name = '<b class="text-success">You</b>';
   }
   else
   {
    $chat_message = $row['chat_message'];
    $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'" style="background-color:white">x</button>&nbsp;<b class="text-success">You</b>';
   }
   $dynamic_background = 'background-color:#ffe6e6;';
  }
  else
  {
   if($row["status"] == '2')
   {
    $chat_message = '<em>This message has been deleted</em>';
   }
   else
   {
    $chat_message = $row['chat_message'];
   }
   $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
   $dynamic_background = 'background-color:#ffffe6;';
  }
  $output .= '
  <li style="border-bottom:1px dotted #ccc;padding-top:8px; padding-left:8px; padding-right:8px;'.$dynamic_background.'">
   <p>'.$user_name.' - '.$chat_message.' 
    <div align="right">
      <small><em>'.getDateTimeDifferenceString($row['timestamp']).'</em></small>
    </div>
   </p>
   
  </li>
  ';
 }
 $output .= '</ul>';
 return $output;
}

?>

