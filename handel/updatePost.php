<?php

require_once '../inc/connection.php' ;

if(! isset($_SESSION['user_id'])){ 
  header("location:../Login.php");
} 

// if(isset($_POST['submit']) && isset($_GET['id'])) {
//   $id = $_GET['id'];

//   $query = "select * from posts where id = $id";
//   $runQuery = mysqli_query($conn,$query);

//   if(mysqli_num_rows($runQuery)==1){
//     $oldImage = mysqli_fetch_assoc($runQuery)['image'];
//   }


//   $title = trim(htmlspecialchars($_POST['title']));
//   $body = trim(htmlspecialchars($_POST['body']));
//   $image = $_FILES['image']; // ---- مينفعش ادخلها ف insert علشان هي array بدخل بدالها ال newName
//   $imageName = $image['name'];
//   $tmp_name = $image['tmp_name'];
//   $size = $image['size']/(1024*1024);
//   $ext =strtolower(pathinfo($imageName,PATHINFO_EXTENSION));
//   $error = $image['error'];
//   $errors = [];

//   $newName = uniqid().".$ext";


//    // title
//   if(empty($title)){
//     $errors[] = "title is requerid";
//   }elseif(is_numeric($title)){
//     $errors[]= "must be string";
//   }

// // body
//   if(empty($body)){
//     $errors[] = "body is requerid";
//   }elseif(is_numeric($body)){
//     $errors[]= "must be string";
//   }

// // image
//   $array_ext = ["png","jpg","jpeg","gif"];
//   if($error !=0){
//     $errors[] = "image is requerid";
//   }elseif(! in_array($ext, $array_ext)){
//     $errors[] = "image not correct";
//   }elseif($size > 1){
//     $errors[]= "image large size";
//   }else{
//   $newName = $oldImage ;
// }
//   if(empty($errors)){
//   $query = "update posts set `title`='$title' , `body`='$body' , `image`='$newName' where id = $id";
//   $runQuery = mysqli_query($conn , $query);
//   if($runQuery){
//     if(!empty($_FILES['image']['name'])){
//       unlink("../uploads/$oldImage");
//       move_uploaded_file($tmp_name,"../uploads/$newName");
//     }
//     $_SESSION['success'] = 'post updated successfuly';
//     header("location: ../viewPost.php?id=$id");
//   }else{
//     $_SESSION['errors'] = ['error'];
//     header("location: ../editPost.php");
//   }
//   }else{
//     $_SESSION['errors'] = $errors;
//     header("location:../index.php");
//   }
// }else{
//     header("location:../index.php");
// }


// submit , id , check , catch , validation , if(empty($errors)) , update

if(isset($_POST['submit']) && isset($_GET['id'])) {
  $id = $_GET['id'];

//   $title = trim(htmlspecialchars($_POST['title']));
//   $body = trim(htmlspecialchars($_POST['body']));

//   $errors = [];

//   // title
//   if(empty($title)){
//     $errors[] = "title is requerid";
//   }elseif(is_numeric($title)){
//     $errors[]= "must be string";
//   }

// // body
//   if(empty($body)){
//     $errors[] = "body is requerid";
//   }elseif(is_numeric($body)){
//     $errors[]= "must be string";
//   }

  $query = "select * from posts where id = $id";
  $runQuery = mysqli_query($conn,$query);

  if(mysqli_num_rows($runQuery)==1){
    $oldImage = mysqli_fetch_assoc($runQuery)['image'];

    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));
  
    $errors = [];
  
    // title
    if(empty($title)){
      $errors[] = "title is requerid";
    }elseif(is_numeric($title)){
      $errors[]= "must be string";
    }
  
  // body
    if(empty($body)){
      $errors[] = "body is requerid";
    }elseif(is_numeric($body)){
      $errors[]= "must be string";
    }

  if(!empty($_FILES['image']['name'])){ // 
    $image = $_FILES['image']; // ---- مينفعش ادخلها ف insert علشان هي array بدخل بدالها ال newName
    $imageName = $image['name'];
    $tmp_name = $image['tmp_name'];
    $size = $image['size']/(1024*1024);
    $ext =strtolower(pathinfo($imageName,PATHINFO_EXTENSION));
    $error = $image['error'];

    // image
  $array_ext = ["png","jpg","jpeg","gif"];
  if($error !=0){
    $errors[] = "image is requerid";
  }elseif(! in_array($ext, $array_ext)){ 
    $errors[] = "image not correct";
  }elseif($size > 1){
    $errors[]= "image large size";
  }

  $newName = uniqid().".$ext";
  }else{
    $newName = $oldImage;
  }

  if(empty($errors)){
    $query = "update posts set `title`='$title' , `body`='$body' , `image`='$newName' where id = $id";
    $runQuery = mysqli_query($conn , $query);
    if($runQuery){
      if(!empty($_FILES['image']['name'])){ 
        unlink("../uploads/$oldImage");
        move_uploaded_file($tmp_name,"../uploads/$newName");
      }

      $_SESSION['success'] = 'post updated successfuly';
      header("location: ../viewPost.php?id=$id");
    }else{
      $_SESSION['errors'] = ['error while update'];
      header("location:../editPost.php?id=$id"); 
    }
  }else{
    $_SESSION['errors'] = $errors;
    header("location:../editPost.php?id=$id"); 
  }
  }else{
    $_SESSION['errors'] = ['post not found'];
    header("location:../index.php");
  }

}else{
  header("location:../index.php");
}

























?>
