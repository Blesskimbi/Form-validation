<?php
// connection.php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "premock";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $fname = $conn->real_escape_string(trim($_POST['fname']));
    $lname = $conn->real_escape_string(trim($_POST['lname']));
    $faname = $conn->real_escape_string(trim($_POST['faname']));
    $dateofbirth = $conn->real_escape_string(trim($_POST['dateofbirth']));
    $tel = $conn->real_escape_string(trim($_POST['tel']));
    $hsname = $conn->real_escape_string(trim($_POST['hsname']));
    $p_address = $conn->real_escape_string(trim($_POST['p_address']));
    $level = $conn->real_escape_string(trim($_POST['level']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $program = $conn->real_escape_string(trim($_POST['program']));

    // Validate required fields
    if (empty($fname) || empty($lname) || empty($faname) || empty($dateofbirth) || empty($tel) || empty($hsname) || empty($p_address) || empty($level) || empty($email) || empty($program)) {
        echo "All fields are required.";
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Prepare the SQL query
    $sql = "INSERT INTO studentform (Firstname, Lastname, Fathername, DateofBirth, Tel, Highschoolname, parmanentaddress, yourlevel, email, degreeprogram) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssssssssss", $fname, $lname, $faname, $dateofbirth, $tel, $hsname, $p_address, $level, $email, $program);

        // Execute the query
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>
