<?php
// Database connection details
$servername = "localhost:3307"; // Replace with your server name if different
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "anokmie1"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminUsername = $_POST['admin-username'];
    $adminEmail = $_POST['admin-email'];
    $adminPhone = $_POST['admin-phone'];
    $adminPassword = $_POST['admin-password'];
    $confirmPassword = $_POST['confirm-password'];

    // Check if passwords match
    if ($adminPassword !== $confirmPassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Check if admin username or email already exists
    $sql = "SELECT * FROM admins WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $adminUsername, $adminEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Admin with this username or email already exists!";
    } else {
        // Insert new admin into the database
        $hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT); // Hash the password for security
        $sql = "INSERT INTO admins (username, email, phone, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $adminUsername, $adminEmail, $adminPhone, $hashedPassword);

        if ($stmt->execute()) {
            // Display success message and then redirect to admin_page.html
            echo "Registered successfully!";
            header("Refresh: 2; URL=admin_page.html"); // Redirect after 2 seconds
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
