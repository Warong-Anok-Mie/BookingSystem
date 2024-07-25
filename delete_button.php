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

// Check if delete form is submitted
if (isset($_POST['delete_id'])) {
    // Retrieve booking ID from form
    $delete_id = $_POST['delete_id'];

    // Prepare SQL statement to delete entry from receipts table
    $sql = "DELETE FROM receipts WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("i", $delete_id);

        // Execute statement
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Booking ID $delete_id deleted successfully.";
        } else {
            $_SESSION['error'] = "Error deleting booking ID $delete_id: " . $conn->error;
        }

        // Close statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing delete statement: " . $conn->error;
    }

    // Redirect back to the page after deletion
    header("Location: http://localhost/all-bookings.php");
    exit();
}

// Query to fetch receipts data
$sql = "SELECT id, username, userphoneNum, useremail, useradd, userbookDate, userbookStartTime, userbookEndTime, totalAmount FROM receipts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row using CSS grid layout
    echo '<div class="admin-grid">';
    while($row = $result->fetch_assoc()) {
        echo '<div class="admin-card">';
        echo '<h3>ID: ' . htmlspecialchars($row["id"]) . '</h3>';
        echo '<p>Username: ' . htmlspecialchars($row["username"]) . '</p>';
        echo '<p>Phone: ' . htmlspecialchars($row["userphoneNum"]) . '</p>';
        echo '<p>Email: ' . htmlspecialchars($row["useremail"]) . '</p>';
        echo '<p>Address: ' . htmlspecialchars($row["useradd"]) . '</p>';
        echo '<p>Booking Date: ' . htmlspecialchars($row["userbookDate"]) . '</p>';
        echo '<p>Start Time: ' . htmlspecialchars($row["userbookStartTime"]) . '</p>';
        echo '<p>End Time: ' . htmlspecialchars($row["userbookEndTime"]) . '</p>';
        echo '<p>Total Amount: ' . htmlspecialchars($row["totalAmount"]) . '</p>';
        
        // Delete button form
        echo '<form method="post" action="all-bookings.php">';
        echo '<input type="hidden" name="delete_id" value="' . $row["id"] . '">';
        echo '<button type="submit" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete?\')">Delete</button>';
        echo '</form>';

        echo '</div>';
    }
    echo '</div>';
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
