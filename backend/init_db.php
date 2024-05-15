<?php

require_once 'config.php';

$conn = mysqli_connect($host, $user, $password) or die('Connection failed');

$sql = "CREATE DATABASE IF NOT EXISTS $database";

if (mysqli_query($conn, $sql)) {
    echo "<p>Database created successfully</p>";
} else {
    echo "<p>Error creating database: " . mysqli_error($conn)."</p>";
}

$conn = mysqli_connect($host, $user, $password, $database) or die('Connection failed');

$sql = "CREATE TABLE IF NOT EXISTS users (
    serial INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "<p>The users table was created successfully</p>";
} else {
    echo "<p>Error creating the users table: " . mysqli_error($conn)."</p>";
}

$sql = "CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    text TEXT NOT NULL,
    link TEXT NOT NULL,
    image VARCHAR(255),
    user_serial INT NOT NULL,
    FOREIGN KEY (user_serial) REFERENCES users (serial)
)";

if (mysqli_query($conn, $sql)) {
    echo "<p>The notes table was created successfully</p>";
} else {
    echo "<p>Error creating the notes table: " . mysqli_error($conn)."</p>";
}

mysqli_close($conn);
?>
