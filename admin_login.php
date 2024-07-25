<?php
session_start();

// Check if there's an error message from a previous login attempt
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
unset($_SESSION['error']); // Clear the error message once displayed
unset($_SESSION['msg']); // Clear the success message once displayed

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

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_admin'])) {
    $adminUsername = $_POST['admin-username'];
    $adminPassword = $_POST['admin-password'];

    // Validate admin credentials
    $sql = "SELECT * FROM admins WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $adminUsername, $adminUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        // Verify password
        if (password_verify($adminPassword, $admin['password'])) {
            // Password correct
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_phone'] = $admin['phone'];
            $_SESSION['msg'] = "Successfully logged in!";
            echo "<script>alert('Successfully logged in!'); window.location.href = 'admin_page.html';</script>";
            exit();
        } else {
            // Invalid password
            $_SESSION['msg'] = "Invalid password!";
            echo "<script>alert('Invalid password!'); window.location.href = 'admin_login.html';</script>";
            exit();
        }
    } else {
        // Admin not found
        $_SESSION['msg'] = "Admin not found!";
        echo "<script>alert('Admin not found!'); window.location.href = 'admin_login.html';</script>";
        exit();
    }

    // Close prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
