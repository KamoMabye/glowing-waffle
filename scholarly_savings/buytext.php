<?php
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

$sql = "SELECT * FROM tblbooks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarly Savings | Buy Textbooks</title>
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
          <li id="nav_link">BUY TEXTBOOKS</li>
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
        $resul = $conn->query("SELECT username FROM tbluser WHERE userID = $userID");

        if ($resul->num_rows == 1) {
            $row = $resul->fetch_assoc();
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
            <h1 id="form_heading">Buy Textbooks</h1><br>
          <hr id="lines"><br>
          
          <form action="addtocart.php" method="post">
            <div id="table_align">
        <table id="table_buy" border="1">
            <tr>
                <th id="nav_text">Title</th>
                <th id="nav_text">Author</th>
                <th id="nav_text">ISBN</th>
                <th id="nav_text">Price</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td id ='tab_info'>{$row['title']}</td>";
                echo "<td id ='tab_info'>{$row['author']}</td>";
                echo "<td id ='tab_info'>{$row['ISBN']}</td>";
                echo "<td id ='tab_info'>R{$row['price']}</td>";
                echo "<td><input type='checkbox' id ='checkboxes' name='selected_books[]' value='{$row['bookID']}'>Add to Cart</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <input type="submit" value="Add to Cart" id="manage_button">
            </div>  
    </form>
          
    </div>
        
    </main>
</body>
</html>