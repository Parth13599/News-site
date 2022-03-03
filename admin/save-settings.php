<?php

include 'config.php';

if(empty($_FILES['logo']['name'])){

  $new_name = $_POST['old_logo'];
}
  $errors = array();

  $file_name = $_FILES['logo']['name'];
  $file_size = $_FILES['logo']['size'];
  $file_tmp = $_FILES ['logo']['tmp_name'];
  $file_type = $_FILES['logo']['type'];
  $ext = explode('.', $file_name);
  $file_ext = end($ext);

  $extension = array("jpeg","jpg","png");

  if(in_array($file_ext,$extension) == false){
    $errors[] = "This extension file not allowed. Upload jpeg or png file";
  }

  if($file_size > 2097152){
    $errors[] = "File size exceeded the limit";
  }
  $new_name = time(). "-". basename($file_name);
  $target = "images/".$new_name;
  $image_name = $new_name;

  if(empty($errors) == true){
    move_uploaded_file($file_tmp,$target);
  }else{
    print_r($errors);
    die();
  }


$website_name = $_POST['website_name'];
$footer_desc = $_POST['footer_desc'];

$sql = "UPDATE settings SET websitename = '{$website_name}', logo = '{$image_name}', footerdesc = '{$footer_desc}'";

$result = mysqli_query($conn, $sql);

if($result){
  header("Location:{$hostname}/admin/settings.php");
}else{
  echo "Query Failed";
}

?>
