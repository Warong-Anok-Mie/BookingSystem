<?php
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.html");
    exit();
}

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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $id = $_POST['id'];
    $username = $_POST['username'];
    $userphoneNum = $_POST['userphoneNum'];
    $useremail = $_POST['useremail'];
    $useradd = $_POST['useradd'];
    $userbookDate = $_POST['userbookDate'];
    $userbookStartTime = $_POST['userbookStartTime'];
    $userbookEndTime = $_POST['userbookEndTime'];
    $totalAmount = $_POST['totalAmount'];

    // Prepare SQL statement to update booking details
    $sql_update = "UPDATE receipts SET username=?, userphoneNum=?, useremail=?, useradd=?, userbookDate=?, userbookStartTime=?, userbookEndTime=?, totalAmount=? WHERE id=?";
    $stmt = $conn->prepare($sql_update);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssssssssi", $username, $userphoneNum, $useremail, $useradd, $userbookDate, $userbookStartTime, $userbookEndTime, $totalAmount, $id);

        // Execute statement
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Booking ID $id updated successfully.";
            header("Location: http://localhost/AnokMie/allbookings.php");
            exit();
        } else {
            $_SESSION['error'] = "Error updating booking ID $id: " . $conn->error;
            header("Location: http://localhost/AnokMie/allbookings.php");
            exit();
        }

        // Close statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing update statement: " . $conn->error;
        header("Location: http://localhost/AnokMie/allbookings.php");
        exit();
    }
}

// Close connection
$conn->close();
?>
