<?php
include_once 'DBConn.php';

$sql_create_db = "CREATE DATABASE IF NOT EXISTS bookstore";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database 'bookstore' created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}


$conn->select_db("bookstore");


$sql_create_tblUser = "CREATE TABLE IF NOT EXISTS tblUser (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    studentNumber VARCHAR(100) NOT NULL,
    firstName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    verification_status VARCHAR(50) NOT NULL
)";
if ($conn->query($sql_create_tblUser) === TRUE) {
    echo "Table 'tblUser' created successfully<br>";
} else {
    echo "Error creating table 'tblUser': " . $conn->error;
}


$sql_create_tblAdmin = "CREATE TABLE IF NOT EXISTS tblAdmin (
    adminID INT AUTO_INCREMENT PRIMARY KEY,
    adminUsername VARCHAR(50) NOT NULL,
    adminPassword VARCHAR(255) NOT NULL
)";
if ($conn->query($sql_create_tblAdmin) === TRUE) {
    echo "Table 'tblAdmin' created successfully<br>";
} else {
    echo "Error creating table 'tblAdmin': " . $conn->error;
}

$sql_create_tblAorder = "CREATE TABLE IF NOT EXISTS tblAorder (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    bookQuantity INT NOT NULL,
    totalPrice DECIMAL(10,2) NOT NULL,
    orderDate DATE DEFAULT NULL
)";
if ($conn->query($sql_create_tblAorder) === TRUE) {
    echo "Table 'tblAorder' created successfully<br>";
} else {
    echo "Error creating table 'tblAorder': " . $conn->error;
}

$sql_create_tblBooks = "CREATE TABLE IF NOT EXISTS tblBooks (
    bookID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    ISBN VARCHAR(15) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    bookQuantity INT NOT NULL
)";
if ($conn->query($sql_create_tblBooks) === TRUE) {
    echo "Table 'tblBooks' created successfully<br>";
} else {
    echo "Error creating table 'tblBooks': " . $conn->error;
}

$sql_create_tblBooks = "CREATE TABLE IF NOT EXISTS tbluserbooks (
    userbookID INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    author VARCHAR(100) NOT NULL,
    bookImage VARCHAR(255) NOT NULL,
    userID int NOT NULL
)";
if ($conn->query($sql_create_tblBooks) === TRUE) {
    echo "Table 'tbluserbooks' created successfully<br>";
} else {
    echo "Error creating table 'tbluserbooks': " . $conn->error;
}

$conn->close();
?>
