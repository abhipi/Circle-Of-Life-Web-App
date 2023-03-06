<?php 

include('database_connection.php');

session_start();

$userName = $_SESSION['username'];
$search_value = $_POST["search"];
$con = mysqli_connect('localhost','root','');
mysqli_select_db($con, 'chat');
$group_id = array();
$name_id = array();
$unique = array();
global $output;
$query2 = mysqli_query($con, "SELECT * FROM login WHERE username = '".$userName."'");

while ($row1 = mysqli_fetch_array($query2))
{
	$query = "SELECT * FROM users_groups WHERE user_id = ".$row1['user_id']."";

	$result = mysqli_query($con, $query);
	while ($row = mysqli_fetch_array($result))
	{
		$group_id[] = $row['group_id']; 
	}

  $sql = mysqli_query($con, "SELECT * FROM groups WHERE group_name LIKE '%".$search_value."%' ");
  while($row2 = mysqli_fetch_array($sql))
  {
    $name_id[] = $row2['group_id'];
  }
  
  $arrlen1 = count($group_id);
  $arrlen2 = count($name_id);
  for($i = 0 ; $i < $arrlen2 ; $i++)
  {
    $flag = 0;
    for($j = 0 ; $j < $arrlen1 ; $j++)
    {
      if($name_id[$i] == $group_id[$j])
      {
        $flag = 1;
      }
    }

    if($flag == 0)
    {
      $unique[] = $name_id[$i];
    }
    
  }

  $arrlen3 = count($unique);
    if($arrlen3 != 0)
    {
      for($k = 0 ; $k < $arrlen3 ; $k++)
      {
        
              $gname = mysqli_query($con, "SELECT * FROM groups WHERE group_id = ".$unique[$k]."");
              while($row3 = mysqli_fetch_array($gname))
              {
                $output .= "<a href='exploreadd.php?user=".urlencode($row1['user_id'])."&group=".urlencode($row3['group_id'])."&name=".$_SESSION['username']."' style='font-size:0.7cm;color:white;text-decoration:none;display:inline-block;width:14cm;padding-top:5px;padding-bottom:5px;padding-left:1cm;border-radius:0.5cm;' onmouseover='OnMouseIn (this)' onmouseout='OnMouseOut (this)'>". $row3['group_name']."</a><br>";
              } 
               }

    }      //}
    else
    {
   
    }      

}
echo $output;
?>