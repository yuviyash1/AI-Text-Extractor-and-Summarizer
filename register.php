<?php 
   session_start();
   ?> 
   <!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" href="style/style.css">
       <title>SignUp</title>
   </head>
   <body>
         <div class="name" style="padding: 20px">
           <div class="box form-box">
               <header>SignUp</header>
              
               <form action="php/register.php" method="post">

                    <div class="field input">
                       <label for="fname">First Name</label>
                       <input type="text" name="fname" id="fname" autocomplete="off" required>
                   </div>
                   <div class="field input">
                       <label for="lname">Last Name</label>
                       <input type="text" name="lname" id="lname" autocomplete="off" required>
                   </div>

                   <!-- <div class="field input">
                       <label for="dob">Date of Birth</label>
                       <input type="date" name="dob" id="dob" required>
                   </div> -->

                   <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                   </div>

                   <?php
                    if(isset($_SESSION['email_error'])) {
                        echo '<div class="error">' . $_SESSION['email_error'] . '</div>';
                        unset($_SESSION['email_error']); 
                    }
                    ?>

                   <div class="field input">
                       <label for="password">Password</label>
                       <input type="password" name="password" id="password" autocomplete="off" required>
                   </div>

                   <div class="field input">
                       <label for="cpassword">Confirm Password</label>
                       <input type="password" name="cpassword" id="cpassword" autocomplete="off" required>
                   </div>

                        <?php
                    if(isset($_SESSION['error'])) {
                        echo '<div class="error">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']); 
                    }
                    ?>

                   <div class="field">
                       
                       <input type="submit" class="btn" name="register" value="Register" required>
                   </div>
                   <div class="links">
                       Already Registered? <a href="index.php">Login Here</a>
                   </div>
               </form>
           </div>
           
         </div>
   </body>
   </html>