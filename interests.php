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
    $sql = "INSERT INTO interests_form 
            (acads, fave_sub, least_fave_sub, hobbies, orgs, org_pos)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Convert arrays to strings or JSON
        $acads = isset($_POST['acads']) ? implode(",", $_POST['acads']) : "";
        $hobbies = isset($_POST['hobbies']) ? implode(",", $_POST['hobbies']) : "";
        $orgs = isset($_POST['orgs']) ? implode(",", $_POST['orgs']) : "";
        $org_pos = isset($_POST['org_pos']) ? implode(",", $_POST['org_pos']) : "";

        // Bind parameters with proper types
        $stmt->bind_param("ssssss", 
            $acads, $_POST['fave_sub'], $_POST['least_fave_sub'], 
            $hobbies, $orgs, $org_pos
        );

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Form data saved successfully.";
            // Redirect to next page upon successful submission
            header('Location: results.html');
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

