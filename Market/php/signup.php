<?php
session_start();

// Database connection configuration
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["phone"]) && isset($_POST["country"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $country = $_POST["country"];

        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $stmt = $conn->prepare("INSERT INTO users (username, password, phone, country) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed_password, $phone, $country);
        $stmt->execute();

        if ($stmt->affected_rows == 1) {
            // User registration successful, set session variables and redirect
            $_SESSION["username"] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            // Registration failed, display an error message
            $_SESSION["signup_error"] = "Error occurred during registration.";
            header("Location: index.php");
            exit();
        }

        $stmt->close();
    } else {
        // Redirect to the signup page if any required field is missing
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to the signup page if the form is not submitted
    header("Location: index.php");
    exit();
}

$conn->close();
?>