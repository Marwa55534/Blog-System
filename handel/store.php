<?php
require_once '../inc/connection.php';

if(! isset($_SESSION['user_id'])){ 
    header("location:../Login.php");
  
}else{ 

    
    $user_id = $_SESSION['user_id'];

// insert (submit , catch , valid , empty($errors) , insert)

if(isset($_POST['submit'])){
    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));

    // if(isset($_FILES['image']) && $_FILES['image']['name'])
    
    $image = $_FILES['image']; // ---- مينفعش ادخلها ف insert علشان هي array بدخل بدالها ال newName
    $imageName = $image['name'];
    $tmp_name = $image['tmp_name'];
    $size = $image['size']/(1024*1024);
    $ext =strtolower(pathinfo($imageName,PATHINFO_EXTENSION));
    $error = $image['error']; 
    $errors = [];

    $newName = uniqid().".$ext";
    //validation

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

    // image
    $array_ext = ["png","jpg","jpeg","gif"];
    if($error !=0){ // $error > 0
        $errors[] = "image is requerid";
    }elseif(! in_array($ext, $array_ext)){
        $errors[] = "image not correct";
    }elseif($size > 1){
        $errors[]= "image large size";
    }

    if(empty($errors)){
        $query = "insert into posts(`title`,`body`,`image`,`user_id`) 
        values('$title','$body','$newName','$user_id')";
        $runQuery = mysqli_query($conn,$query);
        if($runQuery){

    // if(isset($_FILES['image']) && $_FILES['image']['name']){}
            move_uploaded_file($tmp_name,"../uploads/$newName"); // من الي 

            $_SESSION['success'] = "post added successful";
            header("location:../index.php");
            // exit();
        }else{
            $_SESSION['errors'] = ['error while add post'];
            header("location:../addPost.php");
        }
    }else{
        $_SESSION['errors'] = $errors;  // ---- دي الايرورز بتاعت ال validation
        $_SESSION['title'] = $title;
        $_SESSION['body'] = $body;
        header("location:../addPost.php");
    }

}else{
    header("location:../addPost.php"); //location:../index.php
}
}