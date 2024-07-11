<?php
session_start();
include "DBConn.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    //Makes sure that the username and password fields are filled in
    if (empty($username) || empty($password)) {
        header("Location: admin(1).php?error=All fields are required");
        exit();
    } else {
        $sql = "SELECT * FROM tbladmin WHERE adminUsername='$username'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
          if (mysqli_num_rows($result) === 1) {
              $row = mysqli_fetch_assoc($result);
              // Checks if the password given is the same as the one in the database      
              if ($password === $row['adminPassword']) {      
                  $_SESSION['adminID'] = $row['adminID'];      
                  $_SESSION['adminUsername'] = $username;     
                  header("Location: adminpage.php");      
                  exit();      
              } else {
                  header("Location: admin(1).php?error=Incorrect password");
      
                  exit();
      
              }
            } else {
                header("Location: admin(1).php?error=Incorrect username or student number");
                exit();
            }
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
    <title>Scholarly Savings | Admin Login</title>
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
          <label id="form_heading">Admin Login</label>
          <form id="form_info" method="post" action="admin(1).php">
            <input type="text" id="ad_username" name="username" placeholder="Username">
            <input type="text" id="ad_password" name="password" placeholder="Password">
            <input type="submit" value="Login" id="login_button">
          </form>

          <label id="form_heading">Student Login</label>
          <a href="login.php"><button id="admin_login">Student Login</button></a>
        </div>

      </div>
    </main>
</body>
</html>