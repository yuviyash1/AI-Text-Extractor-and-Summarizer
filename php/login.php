<?php 
session_start();
include("dbconn/config.php");

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($con, $query);

    if($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password'])) { 
            $_SESSION['user_id'] = $row['id'];

            $_SESSION['validemail'] = $row['email'];
            $_SESSION['firstname'] = $row['firstName'];
            $_SESSION['lastname'] = $row['lastName'];
            $_SESSION['dob'] = $row['dob'];

            header("Location:../home");
            exit();
        } else {
            $_SESSION['loginerror'] = "Invalid Email or Password";
            header("location:../index.php"); 
            exit();
        }
    } else {
        $_SESSION['loginerror'] = "Invalid Email or Password";
        header("location:../index.php");
        exit();
    }
}

mysqli_close($con);
?>
