<?php

session_start();
include "DBConn.php";

// Checking if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if selected_books is set in the POST data
    if (isset($_POST['selected_books']) && is_array($_POST['selected_books'])) {
        // Initialize the cart array in the session if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Add selected books to the cart array
        foreach ($_POST['selected_books'] as $bookId) {
            // Add the book to the cart
            $_SESSION['cart'][] = $bookId;
        }
    }
}

// Redirect back to the buytext display page
header("Location: buytext.php");
?>
