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
    $sql = "INSERT INTO home_info
            (father_name, father_age, father_life, father_educ_attain, father_occupation, father_employer_name, father_employer_add, 
            mother_name, mother_age, mother_life, mother_educ_attain, mother_occupation, mother_employer_name, mother_employer_add, 
            guardian_name, guardian_age, guardian_life, guardian_educ_attain, guardian_occupation, guardian_employer_name, guardian_employer_add,
            marital, num_children, num_bro, num_sis, num_employed, ordinal_pos, support, finances,
            allowance, income, quiet, share, share_with, residence)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters with proper types
        $stmt->bind_param("sissssssissssssisssssisiiiissssssss", 
            $_POST['father_name'], $_POST['father_age'], $_POST['father_life'], $_POST['father_educ_attain'], $_POST['father_occupation'], $_POST['father_employer_name'], $_POST['father_employer_add'],
            $_POST['mother_name'], $_POST['mother_age'], $_POST['mother_life'], $_POST['mother_educ_attain'], $_POST['mother_occupation'], $_POST['mother_employer_name'], $_POST['mother_employer_add'],
            $_POST['guardian_name'], $_POST['guardian_age'], $_POST['guardian_life'], $_POST['guardian_educ_attain'], $_POST['guardian_occupation'], $_POST['guardian_employer_name'], $_POST['guardian_employer_add'],
            $_POST['marital'], $_POST['num_children'], $_POST['num_bro'], $_POST['num_sis'], $_POST['num_employed'], $_POST['ordinal_pos'], $_POST['support'],
            $_POST['finances'], $_POST['allowance'], $_POST['income'], $_POST['quiet'], $_POST['share'], $_POST['share_with'], $_POST['residence']
        );

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Form data saved successfully.";
            // Redirect to next page upon successful submission
            header('Location: health.html');
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

