<?php

//fetch_user.php

include('database_connection.php');

session_start();

$search_value = $_POST["search"];

$query = "SELECT * FROM login WHERE user_id != '".$_SESSION['user_id']."' AND username LIKE '%{$search_value}%'";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$output = '
<table class="table table-bordered table-striped">
 <tr>
  <th width="50%"  style="text-align: center">Username</th>
  <th width="20%"  style="text-align: center">Status</th>
  <th width="30%" style="text-align: center">Actions</th>
 </tr>
';

foreach($result as $row)
{$col='';
 $status = '';
 $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');  //Date time argument here we get unix time in seconds and we minus 10 seconds
 $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);  // it will convert unix time to current date time format
 $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);
 if($user_last_activity > $current_timestamp)
 {
  $status = 'Online';
  $col='rgba(114, 191, 114, 0.2)';
 }
 else
 {
  $status = 'Offline';
  $col='transparent';
 }
 $output .= '
 <tr style="background-color:transparent">
  <td style=" text-align: center;color: white; font-size: 17pt"><p>'.$row['username'].'<span style="float:right">'.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).'</span> </p>'.fetch_is_type_status($row['user_id'], $connect).'</td>
  <td style="text-align: center; color: white; font-size: 17pt; background-color: '.$col.'">'.$status.'</td>
  <td class="cell" align="center"><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'" style=" width: 10cm; height: 1cm; color:white; font-size:13pt; background-color: transparent; border: none">LAUNCH CHAT</button></td>
 </tr>
 ';
}

$output .= '</table><style>

.cell:hover{
    background-color: #1aace14b;

}
*:focus {
    box-shadow: none !important;
    outline: 0 !important;
}


</style>';

echo $output;

?>