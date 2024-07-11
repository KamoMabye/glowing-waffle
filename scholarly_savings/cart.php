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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedItems'])) {
    // Add selected items to the cart
    $_SESSION['cart'] = array_merge($_SESSION['cart'], $_POST['selectedItems']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookId'])) {
    $bookIdToRemove = $_POST['bookId'];

    if (($key = array_search($bookIdToRemove, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]); // Remove the book from the cart
    }
}

// Initialize total price to 0 if it's not set in the session
if (!isset($_SESSION['totalPrice'])) {
  $_SESSION['totalPrice'] = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarly Savings | Cart</title>
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
        <div id="buy_head">
            <h1 id="form_heading">Cart</h1><br>
        </div>
          <hr id="lines"><br>
          
          <div id="table_align">
          <?php
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

        echo "<table id='table_buy' border='1'>";
        echo "<tr><th id='nav_text'>Title</th><th id='nav_text'>Author</th><th id='nav_text'>ISBN</th><th id='nav_text'>Price</th><th id='nav_text'>Quantity</th></tr>";
        
        $totalPrice = 0;
    
    // associative array to store the quantity of each book
    $bookQuantities = array_count_values($_SESSION['cart']);

    foreach ($bookQuantities as $bookId => $quantity) {
        // Fetch item details from the database
        $result = $conn->query("SELECT * FROM tblbooks WHERE bookID = $bookId");
        $book = $result->fetch_assoc();

        // Calculate the total amount for each book
        $bookTotal = $book['price'] * $quantity;
        $totalPrice += $bookTotal; // Accumulate the total amount

        echo "<tr>";
        echo "<td id ='tab_info'>{$book['title']}</td>";
        echo "<td id ='tab_info'>{$book['author']}</td>";
        echo "<td id ='tab_info'>{$book['ISBN']}</td>";
        echo "<td id ='tab_info'>R{$book['price']}</td>";
        echo "<td id ='tab_info'>{$quantity}</td>";
        echo "<td id ='tab_info'>R{$bookTotal}</td>";
        echo "<td><form method='post' action='cart.php'>
                <input type='hidden' name='bookId' value='$bookId'>
                <input type='submit' value='Remove' id='remove_button'>
                </form></td>";
        echo "</tr>";
    }
    
    echo "<tr><td colspan='5'></td><td id ='tab_info'>R$totalPrice</td><td id ='tab_info'>Total</td></tr>";
    echo "</table>";

    echo "<form method='post' action='checkout.php'>";
    echo "<input type='submit' value='Checkout' id='manage_button'>";
    echo "</form>";
} else {
    echo "<p>Your cart is empty.</p><br>";
}
    ?>

    <br><br>
    <p><a href="buytext.php" id="login_link">Continue Shopping</a></p>
    </div>
    </div>
        
    </main>
</body>
</html>