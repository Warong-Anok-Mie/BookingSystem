<?php
session_start();

// Database connection details
$servername = "localhost:3307"; // Replace with your server name if different
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "anokmie"; // Replace with your database name

// Check if approve form is submitted
if (isset($_POST['approve_id'])) {
    // Retrieve booking ID from form
    $approve_id = $_POST['approve_id'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to update booking status to 'Approved'
    $sql_update = "UPDATE receipts SET status = 'Approved' WHERE id = ?";
    $stmt = $conn->prepare($sql_update);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("i", $approve_id);

        // Execute statement
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Booking ID $approve_id approved successfully.";
        } else {
            $_SESSION['error'] = "Error approving booking ID $approve_id: " . $conn->error;
        }

        // Close statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing update statement: " . $conn->error;
    }

    // Close connection
    $conn->close();

    // Redirect back to allbookings.php after approval
    header("Location: http://localhost/AnokMie/allbookings.php");
    exit();
} else {
    $_SESSION['error'] = "No booking ID provided.";
    header("Location: http://localhost/AnokMie/allbookings.php");
    exit();
}
?>