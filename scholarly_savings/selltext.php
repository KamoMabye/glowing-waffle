
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
    <title>Scholarly Savings | Sell Textbooks</title>
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
          <li id="nav_link">SELL TEXTBOOKS</li>
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
        <h1 id="form_heading">Sell Textbooks</h1><br>   
        <hr id="lines"><br> 
        <?php
    // Display messages based on query parameters
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p style='color: green;'>Book added successfully!</p>";
    } elseif (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "<p style='color: red;'>Error adding the book. Please try again.</p>";
    } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
        echo "<p style='color: red;'>Please log in to add a book.</p>";
    }
    ?>

        <form action="userbooks.php" method="post" enctype="multipart/form-data">
            <input type="text" id="username_box" placeholder="Book Title" name="title">
            <input type="text" id="username_box" placeholder="Author" name="author">
            <input type="file" name="image" accept="image/*" required>
            <input type="submit" id="login_button" value="Add Book">

        </form>

        <h2 id="form_heading">Your Books</h2><br>
        <hr id="lines"><br> 

    <?php
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        // Get user ID from the session
        $userId = $_SESSION['user_id'];

        // Retrieve the user's books from the database
        $sql = "SELECT title, author, bookImage FROM tbluserbooks WHERE userID = '$userId'";
        $result = $conn->query($sql);

        // Display the user's books
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<strong>Title:</strong> " . $row['title'] . "<br>";
                echo "<strong>Author:</strong> " . $row['author'] . "<br>";
                echo "<img src='_uploads/" . $row['bookImage'] . "' alt='Book Image' style='max-width: 100px;'><br>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No books added yet.</p>";
        }

        // Close the database connection
        $conn->close();
    }
    ?>
          
    </div>
        
    </main>
</body>
</html>