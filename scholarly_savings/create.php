<?php
session_start();
include "DBConn.php";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['studentNumber']) && isset($_POST['firstName']) && isset($_POST['surname'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $studentNumber = validate($_POST['studentNumber']);
    $firstName = validate($_POST['firstName']);
    $surname = validate($_POST['surname']);

    if (empty($username) || empty($password) || empty($studentNumber) || empty($firstName) || empty($surname)) {
        header("Location: admin.php?error=All fields are required");
        exit();
    } else {
        // Hashing the password using password_hash
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Set the verification status to "unverified"
        $verificationStatus = 'unverified';

        $sql = "INSERT INTO tbluser (username, password, studentNumber, firstName, surname, verification_status) VALUES ('$username', '$passwordHash', '$studentNumber', '$firstName', '$surname', '$verificationStatus')";
        
       
       if (mysqli_query($conn, $sql)) {
           header("Location: login.php");
           exit();
        } else {
           header("Location: admin.php?error=Registration failed");
            exit();
        }
    }

} 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarly Savings | Create Account</title>
    <link href="styles/styles.css" rel="stylesheet">
</head>
<body>
    <header>
    <div id="left">
      <img src="_images/slogo.png" id="logo" width="70px">
      </div>

      <div id="middle">
      <nav>
        <ul id="nav_content">
          <li id="nav_link">CREATE ACCOUNT</li>
          <li id="nav_link"><a href= "login.php" id="nav_text">LOGIN</a></li>
          <li id="nav_link"><a href= "admin(1).php" id="nav_text">ADMIN LOGIN</a></li>
        </ul>
      </nav>
      </div>  
      <div id="header_user">
        
      </div> 
    </header>

    <main>
      <div id="login_page">
        <div id="form_box">
          <label id="form_heading">Create Account</label>
          <form id="form_info" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <input type="text" id="ad_username" name="username" placeholder="Username">
                <input type="password" id="ad_password" name="password" placeholder="Password">
                <input type="text" id="username_box" name="studentNumber" placeholder="Student Number">
                <input type="text" id="username_box" name="firstName" placeholder="First Name">
                <input type="text" id="username_box" name="surname" placeholder="Surname">
                <label id="login_text">Already have an account?<a href="login.php" id="login_link"> Log In!</a></label><br>
                <input type="submit" value="Register" id="login_button">
            </form>
        </div>

      </div>
    </main>


</body>
</html>