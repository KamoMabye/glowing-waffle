<?php
session_start();
include "DBConn.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['index'])) {
    $index = $_POST['index'];

    // Check if the index exists in the cart array
    if (isset($_SESSION['cart'][$index])) {
        // Remove the item from the cart array
        unset($_SESSION['cart'][$index]);

        // Reset array keys to maintain a sequential array
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

// Redirect back to the view cart page
header("Location: cart.php");
?>
