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
          <li id="nav_link"><a href="userpage.php" id="nav_text">HOME</a></li>
          <li id="nav_link"><a href="buytext.php" id="nav_text">BUY TEXTBOOKS</a></li>
          <li id="nav_link"><a href= "selltext.php" id="nav_text">SELL TEXTBOOKS</a></li>
          <li id="nav_link">PURCHASES</li>
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
          <h1 id="form_heading">Purchases</h1><br>
          <hr id="lines"><br>
          <div id="table_align">
          <?php

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Get the user ID from the session
    $userID = $_SESSION['user_id'];

    // Fetch orders from the database for the user
    $result = $conn->query("SELECT * FROM tblaorder WHERE userID = $userID");

    if ($result->num_rows > 0) {
        // Display orders in a table
        echo "<table id='table_buy' border='1'>";
        echo "<tr><th id='nav_text'>Order Number</th><th id='nav_text'>Book Quantity</th><th id='nav_text'>Total Price</th><th id='nav_text'>Order Date</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td id ='tab_info'>{$row['orderID']}</td>";
            echo "<td id ='tab_info'>{$row['bookQuantity']}</td>";
            echo "<td id ='tab_info'>R{$row['totalPrice']}</td>";
            echo "<td id ='tab_info'>{$row['orderDate']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        // Display a message if no orders are found
        echo "<p>No orders found for the user.</p>";
    }
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}
?>
          </div>
          
    </div>
        
    </main>

</body>
</html>