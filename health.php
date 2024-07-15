<?php
// Database connection parameters
$servername = "localhost:3307"; // Update the port if necessary
$username = "root";
$password = "";
$dbname = "pup_forms_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO health_info 
            (health_vision, vision_prob, health_hearing, hearing_prob, health_speech, speech_prob,
            health_general, genhealth_prob, psychiatrist, psychia_dates, psychia_why, psychologist, psycho_dates, psycho_why,
            counselor, counsel_dates, counsel_why)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters with proper types
        $stmt->bind_param("sssssssssssssssss", 
            $_POST['health_vision'], $_POST['vision_prob'], $_POST['health_hearing'], $_POST['hearing_prob'], $_POST['health_speech'],
            $_POST['speech_prob'], $_POST['health_general'], $_POST['genhealth_prob'], $_POST['psychiatrist'], $_POST['psychia_dates'],
            $_POST['psychia_why'], $_POST['psychologist'], $_POST['psycho_dates'], $_POST['psycho_why'], $_POST['counselor'],
            $_POST['counsel_dates'], $_POST['counsel_why']
        );

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Form data saved successfully.";
            // Redirect to next page upon successful submission
            header('Location: interests.html');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
// Close the connection
$conn->close();

