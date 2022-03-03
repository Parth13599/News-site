<?php

include 'config.php';

if(empty($_FILES['new-image']['name'])){
  $new_name = $_POST['old-image'];
}else{
  $errors = array();

  $file_name = $_FILES['new-image']['name'];
  $file_size = $_FILES['new-image']['size'];
  $file_tmp = $_FILES['new-image']['tmp_name'];
  $file_type = $_FILES['new-image']['type'];
  $file_ext = strtolower(end(explode('.',$file_name)));

  $extension = array("jpeg","jpg","png");

  if(in_array($file_ext,$extension) == false){
    $errors[] = "File Extension didn't match. Upload a file with the extension jpeg or png";
  }

  if($file_size > 2097152){
    $errors[] = "File size exceed the limit 2MB. UPload a file within 2MB";
  }

  $new_name = time(). "-". basename($file_name);
  $target = "upload/".$new_name;
  $image_name = $new_name;

  if(empty($errors) == true){
    move_uploaded_file($file_tmp,$target);
  }else{
    print_r($errors);
    die();
  }

}

  $post_id = $_POST['post_id'];
  $title = $_POST['post_title'];
  $description = $_POST['postdesc'];
  $category = $_POST['category'];


$sql = "UPDATE post SET title = '{$title}', description = '{$description}', category = {$category}, post_img = '{$image_name}'
WHERE post_id = {$post_id};";
if($_POST['old_category'] != $_POST['category']){
  $sql .= "UPDATE category SET post = (post - 1) WHERE category_id = {$_POST['old_category']};";
  $sql .= "UPDATE category SET post = (post + 1) WHERE category_id = {$_POST['category']};";
}



$result = mysqli_multi_query($conn, $sql) or die("Query Failed");

if($result){
  header("Location:{$hostname}/admin/post.php");
}else{
echo "Query Failed";
}

 ?>
