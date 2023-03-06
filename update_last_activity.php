<?php

//update_last_activity.php

include('database_connection.php');

session_start();

$query = "UPDATE login_details SET last_activity = now() WHERE login_details_id = '".$_SESSION["login_details_id"]."'"; //this query will update the last activity column for the particulat user who is logged in

$statement = $connect->prepare($query);

$statement->execute();

?>
