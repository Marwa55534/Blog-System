<?php
require_once '../../inc/connection.php';

// check , catch , validation , hashpass , insert , (login or home)
// user بيسجل لنفسه يدخل ع صفحه ال home / 
// لو سوبر ادمن بيدخل لحد يدخل ع صفحه اللوجن/ (user_id session  logout user_id session)

// check , catch , validation , hashpass , insert , home (user_id) or (name) in  session 

if(isset($_POST['submit'])){
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));
    $errors = [];

    // validation
    // name
    if(empty($name)){
        $errors[] = "name is required";
    }elseif(! is_string($name)){
        $errors[] = "name is must be string";
    }elseif(strlen($name)>25){
        $errors[] = "name is must be less than 25 char";
    }
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
    }elseif(strlen($password)<6){
        $errors[] = "Password is must be more than 6 char";
    }
// phone    
    if(empty($phone)){
        $errors[] = "phone is required";
    }elseif(strlen( $phone < 15)){
        $errors[] = "phone is must be more than 15";
    }

    // hashpass
    $passwordHashed = password_hash($password,PASSWORD_DEFAULT);

    //validation errors clrear => insert
    if(empty($errors)){
        $query = "insert into users(`name`,`email`,`password`,`phone`) 
        values('$name','$email','$passwordHashed','$phone')";
        $runQuery = mysqli_query($conn,$query);
        if($runQuery){
            header("location:../../Login.php");
        }else{
            header("location:../register.php"); 
        }
    }else{
        $_SESSION['errors'] = $errors;
        header("location:../register.php");
    }
   
}else{
    header("location:../register.php");
}
?> 