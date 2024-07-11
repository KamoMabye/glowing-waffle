<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarly Savings | Checkout</title>
    <link href="styles/styles.css" rel="stylesheet">
</head>
<body>
<div id="table_align">
<?php
session_start();
include "DBConn.php";

// Check if the user is logged in (adjust this part based on your authentication mechanism)
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$userID = $_SESSION['user_id'];

// Calculate the total number of books
$totalBooks = count($_SESSION['cart']);

// Calculate the total price
$totalPrice = 0;

//calculate the total price and update book quantities
foreach ($_SESSION['cart'] as $bookId) {
    // Fetch book details from the database
    $result = $conn->query("SELECT price, bookQuantity FROM tblbooks WHERE bookID = $bookId");

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Calculate the total price
        $totalPrice += $row['price'];

        // Decrease the quantity of the book in the database
        $newQuantity = $row['bookQuantity'] - 1;
        
        // Ensure the quantity doesn't go below zero
        if ($newQuantity < 0) {
            $newQuantity = 0;
        }

        // Update the quantity in the database
        $updateResult = $conn->query("UPDATE tblbooks SET bookQuantity = $newQuantity WHERE bookID = $bookId");

        if (!$updateResult) {
            echo "Error updating book quantity for bookID $bookId.";
            exit();
        }
    }
}

// Insert order details into the database
$currentDate = date('Y-m-d H:i:s');
$sql = "INSERT INTO tblaorder (userID, bookQuantity, totalPrice, orderDate) VALUES ($userID, $totalBooks, $totalPrice, '$currentDate')";
$result = $conn->query($sql);

if ($result) {
    // Clear the cart after successful checkout
    echo '<h2 id="form_heading">Transaction Receipt</h2>';
echo '<p id ="tab_info">Items Purchased:</p>';

$bookQuantities = array_count_values($_SESSION['cart']);
$totalAmount = 0; // Initialize total amount variable

foreach ($bookQuantities as $bookID => $quantity) {
    // Fetch item details from the database
    $result = $conn->query("SELECT * FROM tblbooks WHERE bookID = $bookID");

    if ($result) {
        $row = $result->fetch_assoc();
        
        // Calculate the total amount for each book
        $bookTotal = $row['price'] * $quantity;
        $totalAmount += $bookTotal; // Accumulate the total amount
        
        // Display the book details with quantity and total amount
        echo '<p id ="tab_info">' . $row['title'] . ' by ' . $row['author'] . ' - R' . $row['price'] . ' (Quantity: ' . $quantity . ', Total: R' . $bookTotal . ')</p>';
    } else {
        echo "Error fetching item details: " . $conn->error;
    }
}

$_SESSION['cart'] = [];

// Display the total amount for the entire receipt
echo '<p id ="tab_info">Total Amount: R' . $totalAmount . '</p>';
    unset($_SESSION['cart']);
    echo "<p id ='tab_info'>Checkout successful!</p>";
    echo "<a href='userpage.php'><button id='manage_button'>Home page</button></a>";
    echo "<a href='login.php'><button id='login_button'>Log Out</button></a><br>";

    
} else {
    echo "Error in checkout. Please try again.";
}

?>
</div>
</body>
</html>


