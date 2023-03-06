<?php

$con = mysqli_connect('localhost','root','');

mysqli_select_db($con, 'chat');
$name=$_POST['name'];
$name1=$_POST['name1'];
$uuid=mysqli_query($con,"SELECT * FROM  login WHERE username= '".$name."' ");

if($uuid->num_rows==0)
{
echo -1;

}
else{
$uid=mysqli_query($con,"SELECT * FROM  login WHERE username= '".$name."' ");
$iid=mysqli_fetch_array($uid);
$id=$iid['user_id'];
$uid1=mysqli_query($con,"SELECT * FROM  login WHERE username= '".$name1."' ");
$iid1=mysqli_fetch_array($uid1);
$id1=$iid1['user_id'];
$check=mysqli_query($con,"SELECT * FROM  report_check WHERE uid_r= '".$id1."' AND uid_t='".$id."'");
    if($check->num_rows>0)
    {
            echo -2;
    }
    else{

$qq=mysqli_query($con,"SELECT * FROM reports WHERE uid=".$id."");
if($qq->num_rows==0)
{
    mysqli_query($con,"INSERT INTO reports (uid, uname, report) VALUES ('$id', '$name', '1')");

}
else{
    $row1=mysqli_fetch_array($qq);
    $value=$row1['report'];
    $value=$value+1;
    mysqli_query($con, "UPDATE reports SET  report = ".$value." WHERE uid=".$id.""); 

}
mysqli_query($con,"INSERT INTO report_check (uid_r, uid_t) VALUES ('$id1', '$id')");
echo 1;
}
}
?>