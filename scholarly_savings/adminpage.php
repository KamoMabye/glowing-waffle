<?php
session_start();
include "DBConn.php";
if (isset($_SESSION['adminID'])) {

  
} else {
  // Redirect to the login page if the user is not logged in
  header("Location: admin(1).php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarly Savings | Admin</title>
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
          <li id="nav_link">HOME</li>
          <li id="nav_link"><a href="verifyusers.php" id="nav_text">MANAGE USERS</a></li>
          <li id="nav_link"><a href= "managebooks.php" id="nav_text">MANAGE TEXTBOOKS</a></li>
        </ul>
      </nav>
      </div>  
      <div id="header_user">
      </div> 
      
    </header>

    <main>
    <div id="admin_page">
          <h1 id="form_heading">Administration</h1><br>
          <hr id="lines">
          <div id="ad_info">
            <div>
              <h2 id="ad_headings">Manage Users</h2>
              <p>Add and Verify new users.</p>
            </div>
            <a href="verifyusers.php"><button id="verify_button">Manage Users</button></a>
          </div>
          <div id="ad_info">
            <div>
              <h2 id="ad_headings">Manage Textbooks</h2>
              <p>Add, Edit and Delete Textbooks from the Database.</p>
            </div>
            <a href="managebooks.php"><button id="manage_button">Manage Textbooks</button></a>
          </div>
          <div id="ad_info">
            <div>
              <h2 id="ad_headings">Log Out</h2>
              <p>Log Out of the website.</p>
            </div>
            <a href="admin(1).php"><button id="logout_button">Log Out</button></a>
          </div>
          
    </div>
        
    </main>

</body>
</html>