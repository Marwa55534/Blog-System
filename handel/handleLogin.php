<?php
require_once '../inc/connection.php';

if(! isset($_SESSION['user_id'])){ 
    header("location:../Login.php");
  }


// check , catch , validation , check(email , password) , login

if(isset($_POST['submit'])){
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $errors = [];
 
       // validation
// email
    if(empty($email)){
        $errors[] = "email is required";
    }elseif(! filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "email invaild";
    }elseif(strlen($email)>25){
        $errors[] = "email is must be less than 25 char";
    }
// password 
    if(empty($password)){
        $errors[] = "Password is required";
    }

    
    
   if(empty($errors)){
    // check
    $query = "select * from users where `email`='$email'";
    $runQuery = mysqli_query($conn , $query);
    if(mysqli_num_rows($runQuery)==1){ // وقتها هنتشيك ع الباسورد
        // true check password
        $user = mysqli_fetch_assoc($runQuery); 

        $oldPassword = $user['password'];
        $name = $user['name'];
        $id = $user['id'];
        $verify = password_verify($password,$oldPassword);

        if($verify){
            $_SESSION['user_id'] = $id;
            $_SESSION['success'] = "welcom $name";
            header("location:../index.php");
        }else{
            $_SESSION['errors'] = ['Credintials not correct'];
            header("location:../Login.php");
        }
    }else{
        $_SESSION['errors'] = ['this account not found'];
        header("location:../Login.php");
    }
   }else{
    $_SESSION['errors'] = $errors;
    header("location:../Login.php");
   }

}else{
    header("location:../Login.php");
}   
  
  