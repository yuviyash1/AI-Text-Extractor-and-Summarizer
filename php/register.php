<?php
session_start();
include("dbconn/config.php");

if(isset($_POST['register'])){
    $firstName = mysqli_real_escape_string($con,$_POST['fname']);
    $lastName = mysqli_real_escape_string($con,$_POST['lname']);
    $dob = mysqli_real_escape_string($con,$_POST['dob']);
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $confirm_password = mysqli_real_escape_string($con,$_POST['cpassword']);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);

    if($result && mysqli_num_rows($result) == 0) {

        if($password == $confirm_password){
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

            $query = "INSERT INTO users(firstName,lastName,email,password,dob) VALUES ('$firstName','$lastName','$email','$hashed_password','$dob')";
            mysqli_query($con,$query);
            $_SESSION['success'] = "Registration Success. Please Login Here";
            header("location:../index.php");
            exit();
        } else {
            $_SESSION['error'] = "Passwords do not match";
            header("location: ../register.php");
            exit();        
        }
    } 
    else{
        $_SESSION['email_error'] = "Email already Exists";
        header("location: ../register.php");
    }   
}
?>
