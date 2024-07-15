<?php
$servername = "localhost:3307";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "pup_forms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $studentnumber = $_POST['studentnumber'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    $sql = "INSERT INTO users (firstname, lastname, studentnumber, password)
            VALUES ('$firstname', '$lastname', '$studentnumber', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
