<?php
if($_SESSION['user_role'] == 0){
  header("Location:{$hostname}/admin/post.php");
}

$user_id = $_GET['id'];

include "config.php";

$sql = "DELETE FROM user WHERE user_id = '{$user_id}'";

$result = mysqli_query($conn, $sql) or die("Query Failed");

if($result){
  header("Location:{$hostname}/admin/users.php");
}else{
  echo "<p style = 'color:red; margin: 10px 0;'>
  'Can't Delete the User Record'
  </p>";
}

mysqli_close($conn);

?>
