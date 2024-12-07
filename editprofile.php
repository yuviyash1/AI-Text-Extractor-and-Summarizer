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
    <title>Profile</title>
</head>
<body>
<nav class="navbar">
  <div class="navbar-brand">
    <img src="images/logo.png" alt="Logo">
  </div>
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="home/">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">AboutUs</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">ContactUs</a>
    </li>
  </ul>
  <div class="profile">
    <a href="php/logout.php" class="nav-link">Logout</a>
    <div class="profile-img">
      <a href="editprofile.php"><img src="images/profile.png" alt="Profile"></a>
    </div>
  </div>

</nav>

<div class="name edit-name">
    <div class="box form-box">
        <header>Edit Profile</header>
                    <?php
                    if(isset($_SESSION['not_updated'])) {
                        echo '<div class="error">' . $_SESSION['not_updated'] . '</div>';
                        unset($_SESSION['not_updated']); 
                    }
                    ?>
        <form action="php/editprofile.php" method="post">
            <div class="field input">
                <label for="fname">First Name</label>
                <input type="text" name="fname" id="fname" autocomplete="off" placeholder="<?php echo $_SESSION['firstname']; ?>" >
            </div>

            <div class="field input">
                <label for="lname">Last Name</label>
                <input type="text" name="lname" id="lname" autocomplete="off" placeholder="<?php echo $_SESSION['lastname']; ?>" >
            </div>

            <div class="field input">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" autocomplete="off" placeholder="<?php echo $_SESSION['validemail']; ?>" >
            </div>
            <?php
                    if(isset($_SESSION['error'])) {
                        echo '<div class="error">' . $_SESSION['email_error'] . '</div>';
                        unset($_SESSION['email_error']); 
                    }
                    ?>

            <div class="field">
                <input type="submit" class="btn" name="edit_profile" value="Save" required>
            </div>
        </form>
    </div>
</div>
</body>
</html>
