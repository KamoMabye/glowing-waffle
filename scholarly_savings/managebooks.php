<?php
session_start();
include_once 'DBConn.php';
if (isset($_SESSION['adminID'])) {

  
} else {
  // Redirect to the admin login page if the user is not logged in
  header("Location: admin(1).php");
  exit();
}

$sql = "SELECT * FROM tblbooks";
$result = $conn->query($sql);

if (isset($_POST['insert'])) {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $message = "Successfully inserted.";

    if (empty($isbn) || empty($title) || empty($author) || empty($price)) {
        echo "Please fill in all the fields.";
    } else {
        //Once all fields have been filled in, the data will insert into the database
        $insertQuery = "INSERT INTO tblbooks (ISBN, title, author, price, bookQuantity) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, 'sssii', $isbn, $title, $author, $price, $quantity);

        if (mysqli_stmt_execute($insertStmt)) {
            echo "Successfully inserted.";
            header("Location: managebooks.php");
        } else {
            echo "Insert failed: " . mysqli_error($conn);
        }
    }
} elseif (isset($_POST['update'])) {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if (empty($isbn) || empty($title) || empty($author) || empty($price)) {
        echo "Please fill in all the fields.";
    } else {
        //Once all fields have been filled in, the data will be updated
        $updateQuery = "UPDATE tblbooks SET title = ?, author = ?, price = ?, bookQuantity = ? WHERE ISBN = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'ssiis', $title, $author, $price, $quantity, $isbn);

        if (mysqli_stmt_execute($updateStmt)) {
            echo "Record updated successfully.";
            header("Location: managebooks.php");
        } else {
            echo "Update failed: " . mysqli_error($conn);
        }
    }
} elseif (isset($_POST['delete'])) {
    $isbn = $_POST['isbn'];

    if (empty($isbn)) {
        echo "Please enter the ISBN to delete.";
    } else {
        //Once all fields have been filled in, the data will be deleted from the database
        $deleteQuery = "DELETE FROM tblbooks WHERE ISBN = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, 's', $isbn);

        if (mysqli_stmt_execute($deleteStmt)) {
            echo "Record deleted successfully.";
            header("Location: managebooks.php");
        } else {
            echo "Delete failed: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scholarly Savings | Manage Textbooks</title>
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
        <li id="nav_link"><a href="adminpage.php" id="nav_text">HOME</a></li>
          <li id="nav_link"><a href="verifyusers.php" id="nav_text">MANAGE USERS</a></li>
          <li id="nav_link">MANAGE TEXTBOOKS</li>
        </ul>
      </nav>
      </div>  
      <div id="header_user">
      </div> 
      
    </header>

    <main>
    <div id="admin_page">
          <div id="back">
            <h1 id="form_heading">Manage Textbooks</h1>
            <a href="adminpage.php"><button id="back_button"><</button></a>
        </div>
          <hr id="lines"><br>
          <div id="table_align">
          <table id="table_buy" border="1">
            <tr>
                <th id="nav_text">Title</th>
                <th id="nav_text">Author</th>
                <th id="nav_text">ISBN</th>
                <th id="nav_text">Price</th>
                <th id="nav_text">Quantity</th>
            </tr>

            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td id ='tab_info'>{$row['title']}</td>";
                echo "<td id ='tab_info'>{$row['author']}</td>";
                echo "<td id ='tab_info'>{$row['ISBN']}</td>";
                echo "<td id ='tab_info'>R{$row['price']}</td>";
                echo "<td id ='tab_info'>{$row['bookQuantity']}</td>";
                echo "</tr>";
            }
            ?>
        </table><br>

          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="text" id="username_box" name="isbn" placeholder="Enter the ISBN number" required><br>
        <input type="text" id="username_box" name="title" placeholder="Enter the Title" >
        <input type="text" id="username_box" name="author" placeholder="Enter the author" >
        <input type="number" id="username_box" name="price" min="0" placeholder="Enter the Price" >
        <input type="number" id="username_box" name="quantity" min="0" placeholder="Enter the Quantity" ><br>
        <button name="insert" id="login_button">Insert</button>
        <button name="update" id="login_button">Update</button>
        <button name="delete" id="login_button">Delete</button>
        </form>
            </div>  

    </div>
        
    </main>
</body>
</html>
