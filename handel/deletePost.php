<?php
require_once '../inc/connection.php';

if(! isset($_SESSION['user_id'])){ 
    header("location:../Login.php");
  }else{ 

// check id , submit ,
    
if(isset($_POST['submit']) && (isset($_GET['id']))){

    $id =(int) $_GET['id'];

    $query = "select id from posts where id = $id";
    $runQuery = mysqli_query($conn,$query);
    if(mysqli_num_rows($runQuery)==1){

        $post = mysqli_fetch_assoc($runQuery);
        if(! empty($post)){ // هتشيك ان الصوره موجوده 
            unlink("../uploads/{$post['image']}");  //  unlink("../uploads/".$post['image']);
        }
        $query = "delete from posts where id =$id";
        $runQuery = mysqli_query($conn,$query);
        if($runQuery){
            $_SESSION['success'] = 'post deleted successful';
            header("location:../index.php");
        }else{ 
            $_SESSION['errors'] = ['error while delete'];
            header("location:../index.php");
        }
    }else{
        $_SESSION['errors'] = ['post not found'];
        header("location:../index.php");
        // مينفعش ارجع لصفحه ال view 
        // view محتاجه id
    }
}else{
    $_SESSION['errors'] = ['please choose coorect operation'];
    header("location:../index.php");
}
}