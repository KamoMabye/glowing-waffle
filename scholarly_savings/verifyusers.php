<?php
session_start();
include 'DBConn.php';
    // Handle form submission for user verification
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify'])) {
        // Loop through the submitted user IDs and verify them
        foreach ($_POST['verify'] as $user_id) {
            $query = "UPDATE tbluser SET verification_status = 'verified' WHERE userID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
        }
        header("Location: verifyusers.php");
        exit();
    }

// Fetch unverified users for display
$unverifiedUsersQuery = "SELECT * FROM tbluser WHERE verification_status = 'unverified'";
$unverifiedUsersResult = $conn->query($unverifiedUsersQuery);

if (isset($_POST['insert'])) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $student = $_POST['studentNumber'];
    $password = $_POST['password'];
    $verify = $_POST['verified'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $message = "Successfully inserted.";

    if (empty($username) || empty($firstname) || empty($surname) || empty($student) || empty($password)) {
        echo "Please fill in all the fields.";
    } else {
        // Perform insert with MySQLi
        $insertQuery = "INSERT INTO tbluser (username, password, studentNumber, firstname, surname, verification_status) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, 'ssssss', $username, $hashedPassword, $student, $firstname, $surname, $verify);

        if (mysqli_stmt_execute($insertStmt)) {
            echo "Successfully inserted.";
            header("Location: verifyusers.php");
        } else {
            echo "Insert failed: " . mysqli_error($conn);
        }
    }

} elseif (isset($_POST['update'])) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $surname = $_POST['surname'];
    $student = $_POST['studentNumber'];
    $password = $_POST['password'];
    $verify = $_POST['verified'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    if (empty($username) || empty($firstname) || empty($surname) || empty($student) || empty($password)) {
        echo "Please fill in all the fields.";
    } else {
        // Perform update with MySQLi
        $updateQuery = "UPDATE tbluser SET username = ?, password = ?, firstname = ?, surname = ?, verification_status =? WHERE studentNumber = ?";
        $updateStmt = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'ssssss', $username, $hashedPassword, $firstname, $surname, $verify, $student);

        if (mysqli_stmt_execute($updateStmt)) {
            echo "Record updated successfully.";
            header("Location: verifyusers.php");
        } else {
            echo "Update failed: " . mysqli_error($conn);
        }
    }
} elseif (isset($_POST['delete'])) {
    $student = $_POST['studentNumber'];

    if (empty($student)) {
        echo "Please enter the Student Number to delete.";
    } else {
        // Perform delete with MySQLi
        $deleteQuery = "DELETE FROM tbluser WHERE studentNumber = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, 's', $student);

        if (mysqli_stmt_execute($deleteStmt)) {
            echo "Record deleted successfully.";
            header("Location: verifyusers.php");
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
    <title>Scholarly Savings | Verify Users</title>
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
          <li id="nav_link">MANAGE USERS</li>
          <li id="nav_link"><a href= "managebooks.php" id="nav_text">MANAGE TEXTBOOKS</a></li>
        </ul>
      </nav>
      </div>  
      <div id="header_user">
      </div> 
      
    </header>

    <main>
    <div id="admin_page">
        <div id="back">
            <h1 id="form_heading">Verify Users</h1>
            <a href="adminpage.php"><button id="back_button"><</button></a>
        </div>

        <hr id="lines">

        <div id="table_align">
        <form method="post" action="">
            <?php if ($unverifiedUsersResult->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $unverifiedUsersResult->fetch_assoc()): ?>
                        <li>
                            <input type="checkbox" name="verify[]" value="<?php echo $row['userID']; ?>">
                            <?php echo $row['username']; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <button type="submit" name="submit" id="verify_butt">Verify Selected Users</button>
            <?php else: ?>
                <p>No unverified users.</p>
            <?php endif; ?>
        </form>
        </div>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="text" id="username_box" name="studentNumber" placeholder="Enter the Student Number" required><br>
        <input type="text" id="username_box" name="firstname" placeholder="Enter the First Name" >
        <input type="text" id="username_box" name="surname" placeholder="Enter the Surname" >
        <input type="text" id="username_box" name="username" placeholder="Enter the Username" >
        <input type="text" id="username_box" name="password" placeholder="Enter the Password" > 
        <Select id="verifications" name="verified">
            <option value="verified">verified</option>
            <option value="unverified">unverified</option>
        </Select><br>
        <button name="insert" id="login_button">Add</button>
        <button name="update" id="login_button">Update</button>
        <button name="delete" id="login_button">Delete</button>
        </form>

    </div>
        
    </main>
</body>
</html>