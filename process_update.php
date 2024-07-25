<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_username']) || !isset($_SESSION['admin_email']) || !isset($_SESSION['admin_phone'])) {
    $_SESSION['error'] = "You are not logged in!";
    header("Location: admin_login.html");
    exit();
}

// Check if form is submitted for update
if (isset($_POST['update_profile'])) {
    // Database connection details
    $servername = "localhost:3307"; // Your server name
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "anokmie"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape user inputs for security
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);

    // SQL update statement
    $sql = "UPDATE admins SET username='$username', email='$email', phone='$phone' WHERE username='{$_SESSION['admin_username']}'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['msg'] = "Successfully updated!";
    } else {
        $_SESSION['error'] = "Error updating record: " . $conn->error;
    }

    // Close connection
    $conn->close();
}

// Redirect back to profile settings page
header("Location: profile_settings.php");
exit();
?>
