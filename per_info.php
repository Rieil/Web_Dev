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
    $sql = "INSERT INTO personal_info (date, surname, firstname, middlename, course, year, section, height, weight, complexion, cityaddress, provaddress, employer, contactperson, contactaddress, relationship, contactnumber, gender, age, civilstatus, religion, dob, pob, email, telno, mobileno, highschoolavg)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssssssssssssssssssssssss", 
            $date, $surname, $firstname, $middlename, $course, $year, $section, 
            $height, $weight, $complexion, $cityaddress, $provaddress, $employer, 
            $contactperson, $contactaddress, $relationship, $contactnumber, $gender, 
            $age, $civilstatus, $religion, $dob, $pob, $email, $telno, $mobileno, $highschoolavg
        );

        // Sanitize and set parameters
        $date = htmlspecialchars($_POST['date']);
        $surname = htmlspecialchars($_POST['surname']);
        $firstname = htmlspecialchars($_POST['firstname']);
        $middlename = htmlspecialchars($_POST['middlename']);
        $course = htmlspecialchars($_POST['course']);
        $year = htmlspecialchars($_POST['year']);
        $section = htmlspecialchars($_POST['section']);
        $height = htmlspecialchars($_POST['height']);
        $weight = htmlspecialchars($_POST['weight']);
        $complexion = htmlspecialchars($_POST['complexion']);
        $cityaddress = htmlspecialchars($_POST['cityaddress']);
        $provaddress = htmlspecialchars($_POST['provaddress']);
        $employer = htmlspecialchars($_POST['employer']);
        $contactperson = htmlspecialchars($_POST['contactperson']);
        $contactaddress = htmlspecialchars($_POST['contactaddress']);
        $relationship = htmlspecialchars($_POST['relationship']);
        $contactnumber = htmlspecialchars($_POST['contactnumber']);
        $gender = htmlspecialchars($_POST['gender']);
        $age = htmlspecialchars($_POST['age']);
        $civilstatus = htmlspecialchars($_POST['civilstatus']);
        $religion = htmlspecialchars($_POST['religion']);
        $dob = htmlspecialchars($_POST['dob']);
        $pob = htmlspecialchars($_POST['pob']);
        $email = htmlspecialchars($_POST['email']);
        $telno = htmlspecialchars($_POST['telno']);
        $mobileno = htmlspecialchars($_POST['mobileno']);
        $highschoolavg = htmlspecialchars($_POST['highschoolavg']);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Form data saved successfully.";
            header('Location: educ.html');
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

