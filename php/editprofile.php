<?php
session_start();
include("dbconn/config.php");

if(isset($_POST['edit_profile'])){
    $user_id = $_SESSION['user_id']; 
    $update_query = "UPDATE users SET ";
    $fieldsToUpdate = false; 

    if(isset($_POST['fname']) && !empty($_POST['fname'])){
        $firstName = mysqli_real_escape_string($con, $_POST['fname']);
        $update_query .= "firstName='$firstName', ";
        $_SESSION['firstname'] = $firstName;
        $fieldsToUpdate = true; 
    }

    if(isset($_POST['lname']) && !empty($_POST['lname'])){
        $lastName = mysqli_real_escape_string($con, $_POST['lname']);
        $update_query .= "lastName='$lastName', ";
        $_SESSION['lastname'] = $lastName;
        $fieldsToUpdate = true; 
    }

    if(isset($_POST['email']) && !empty($_POST['email'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $update_query .= "email='$email', ";
  
        $_SESSION['validemail'] = $email;
        $fieldsToUpdate = true; 
    }

    if($fieldsToUpdate){
        $update_query = rtrim($update_query, ', ');

        $update_query .= " WHERE id = '$user_id'";

        if (!mysqli_query($con, $update_query)) {
            echo "Error updating record: " . mysqli_error($con);
        } else {
            header("location:../editprofile.php");
            exit();
        }
    } else {
        $_SESSION['not_updated']="No fields are being updated!";
        header("location: ../editprofile.php");
        exit();

    }
} else {
    echo "Form not submitted!";
}
?>
