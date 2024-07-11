<?php
session_start();
include "DBConn.php";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['studentNumber'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $studentNumber = validate($_POST['studentNumber']);

    if (empty($username) || empty($password) || empty($studentNumber)) {
        header("Location: login.php?error=All fields are required");
        exit();
    } else {
        $sql = "SELECT * FROM tbluser WHERE username='$username' AND studentNumber='$studentNumber'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                
                if ($row['verification_status'] === 'unverified') {
                  header("Location: login.php?error=Your account is not verified");
                  exit();
              }

                if (password_verify($password, $row['password'])) {
                    $_SESSION['adminUsername'] = $username;
                    $userID = $row['userID'];
                    $_SESSION['user_id'] = $userID;
                    header("Location: userpage.php");
                    exit();
                } else {
                    header("Location: userpage.php?error=Incorrect password");
                    exit();
                }
            } else {
                header("Location: login.php?error=Incorrect username or student number");
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
    <title>Scholarly Savings | Login</title>
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
          <li id="nav_link"><a href= "create.php" id="nav_text">CREATE ACCOUNT</a></li>
          <li id="nav_link">LOGIN</li>
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
          <label id="form_heading">Login</label>
          <form id="form_info" method="post" action="login.php">
            <input type="text" id="username_box" name="username" placeholder="Username">
            <input type="text" id="username_box" name="studentNumber" placeholder="Student Number">
            <input type="text" id="username_box" name="password" placeholder="Password">
            <label id="login_text">Don't have an account? <a href="create.php" id="login_link">Create One!</a></label><br>
            <input type="submit" value="Login" id="login_button">
          </form>

          <label id="form_heading">Admin Login</label>
          <a href="admin(1).php"><button id="admin_login">Administrator Login</button></a>
        </div>

      </div>
    </main>


</body>
</html>