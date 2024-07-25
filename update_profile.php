<?php
session_start();

// Database connection details
$servername = "localhost:3307"; // Replace with your server name if different
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "anokmie"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminUsername = $_POST['username'];
    $adminEmail = $_POST['email'];
    $adminPhone = $_POST['phone'];

    $adminid = intval($_SESSION['aid']);
    
    // Check if admin exists in the database
    $checkSql = "SELECT * FROM admins WHERE ID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $adminid);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Update admin profile in the database
        $updateSql = "UPDATE admins SET username=?, email=?, phone=? WHERE ID=?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("sssi", $adminUsername, $adminEmail, $adminPhone, $adminid);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Profile updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update profile. Please try again.";
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Account not found.";
    }

    $checkStmt->close();
}

$conn->close();

header("Location: profile_settings.html");
exit();
?>
