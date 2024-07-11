<?php
session_start();
include "DBConn.php";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Get user ID from the session
        $userId = $_SESSION['user_id'];

        // Get other form data
        $title = $_POST["title"];
        $author = $_POST["author"];

    // Check if an image file is selected
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Define the target directory for storing uploaded images
        $targetDir = "_uploads/";
        
        // Generate a unique filename to prevent overwriting existing files
        $fileName = uniqid() . '_' . basename($_FILES["image"]["name"]);
        
        // Set the target path for the uploaded file
        $targetPath = $targetDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath)) {
            // Connection to your database (replace with your database connection code)


            // Insert the book details into the database
            $sql = "INSERT INTO tbluserbooks (title, author, bookImage, userID) VALUES ('$title', '$author', '$fileName', '$userId')";
            if ($conn->query($sql) === TRUE) {
                // Redirect the user back to the form with a success message
                header("Location: selltext.php?success=1");
                exit();
            } else {
                // Redirect the user back to the form with an error message
                header("Location: selltext.php?error=1");
                exit();
            }

            // Close the database connection
            $conn->close();
        } else {
            echo "Error uploading the image.";
        }
    } else {
        header("Location: selltext.php?error=1");
        exit();
        echo "Please select an image for the book.";
    }
    
}
else {
    // Handle the case where the user is not logged in
    header("Location: selltext.php?error=1");
    exit();
    echo "Please log in to add a book.";
}
}
?>
