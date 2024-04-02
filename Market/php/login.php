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
    // Check if username and password are provided
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Validate user credentials from the database
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                // Authentication successful, set session variables and redirect
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                header("Location: user.html");
                exit();
            } else {
                // Authentication failed, display an error message
                $_SESSION["login_error"] = "Invalid username or password.";
                header("Location: registration.html");
                exit();
            }
        } else {
            // Authentication failed, display an error message
            $_SESSION["login_error"] = "Invalid username or password.";
            header("Location: registration.html");
            exit();
        }

        $stmt->close();
    } else {
        // Redirect to the login page if username or password is missing
        header("Location: registration.html");
        exit();
    }
} else {
    // Redirect to the login page if the form is not submitted
    header("Location: registration.html");
    exit();
}

$conn->close();
?>