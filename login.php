<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "pup_forms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentnumber = $_POST['studentnumber-login'];
    $password = $_POST['password-login'];

    $sql = "SELECT password FROM users WHERE studentnumber='$studentnumber'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login successful!";
            // Redirect to home page or other action
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that student number.";
    }
}

$conn->close();

