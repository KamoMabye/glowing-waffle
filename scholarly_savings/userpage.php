<?php
// Start the session
session_start();
include "DBConn.php";

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Display the username
    
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarly Savings | User Homepage</title>
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
          <li id="nav_link"><a href="buytext.php" id="nav_text">BUY TEXTBOOKS</a></li>
          <li id="nav_link"><a href= "selltext.php" id="nav_text">SELL TEXTBOOKS</a></li>
          <li id="nav_link"><a href= "purchases.php" id="nav_text">PURCHASES</a></li>
        </ul>
      </nav>
      </div>  
      <div id="header_user">

      <?php
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Get the user ID from the session
        $userID = $_SESSION['user_id'];

        // Fetch the username from the database
        $result = $conn->query("SELECT username FROM tbluser WHERE userID = $userID");

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $username = $row['username'];
            echo "<p>Welcome, $username!</p>";
        } 
    } 
    ?>
        <a href="cart.php"><img src="_images/baglogo.png" id="logo" width="50px"></a>
      </div> 
      
    </header>

    <main>
    <div id="admin_page">
          <h1 id="form_heading">User Page</h1><br>
          <hr id="lines">
          <div id="ad_info">
            <div>
              <h2 id="ad_headings">Buy Textbooks</h2>
              <p>Find textbooks that you would like to buy.</p>
            </div>
            <a href="buytext.php"><button id="verify_button">Buy Textbooks</button></a>
          </div>
          <div id="ad_info">
            <div>
              <h2 id="ad_headings">Sell Textbooks</h2>
              <p>Request for a book you would like to sell</p>
            </div>
            <a href="selltext.php"><button id="manage_button">Sell Textbooks</button></a>
          </div>
          <div id="ad_info">
            <div>
              <h2 id="ad_headings">Purchases Made</h2>
              <p>Take a look at your previous purchases</p>
            </div>
            <a href="purchases.php"><button id="manage_button">Books Purchased</button></a>
          </div>
          <div id="ad_info">
            <div>
              <h2 id="ad_headings">Log Out</h2>
              <p>Log Out of the website.</p>
            </div>
            <a href="login.php"><button id="logout_button">Log Out</button></a>
          </div>
          
    </div>
        
    </main>

</body>
</html>