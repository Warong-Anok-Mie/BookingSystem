<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $adminUsername = $_POST['admin-username'];
    $adminEmail = $_POST['admin-email'];
    $adminOldPassword = $_POST['admin-old-password'];
    $adminNewPassword = $_POST['admin-new-password'];

    // Check if admin username and email match in the database
    $sql = "SELECT * FROM admins WHERE username = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $adminUsername, $adminEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        // Verify old password
        if (password_verify($adminOldPassword, $admin['password'])) {
            // Update admin password
            $hashedPassword = password_hash($adminNewPassword, PASSWORD_BCRYPT); // Hash the new password
            $updateSql = "UPDATE admins SET password = ? WHERE username = ? AND email = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sss", $hashedPassword, $adminUsername, $adminEmail);

            if ($updateStmt->execute()) {
                echo "Password updated successfully!";
                // Redirect to login page after displaying success message
                header("Refresh: 3; URL=admin_login.html"); // Redirect after 3 seconds
                exit();
            } else {
                echo "Error updating password: " . $updateStmt->error;
            }
        } else {
            echo "Old password incorrect!";
        }
    } else {
        echo "Admin not found or credentials do not match!";
    }

    // Close statements
    $stmt->close();
    if (isset($updateStmt)) {
        $updateStmt->close();
    }
}

$conn->close();
?>
