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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $username = mysqli_real_escape_string($conn, $_POST['new-username']);
    $password = mysqli_real_escape_string($conn, $_POST['new-password']);
    $email = mysqli_real_escape_string($conn, $_POST['new-email']);
    $contact = mysqli_real_escape_string($conn, $_POST['new-contact']);
    $address = mysqli_real_escape_string($conn, $_POST['new-address']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Display error message directly on register.html
        echo "<script>alert('Invalid email format');</script>";
        exit(); // Stop further execution
    }

    // Validate password length
    if (strlen($password) < 6) {
        // Display error message directly on register.html
        echo "<script>alert('Password must be at least 6 characters long');</script>";
        exit(); // Stop further execution
    }

    // Check if username or email already exists
    $check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = mysqli_query($conn, $check_query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        // Display error message directly on register.html
        echo "<script>alert('Username or email already registered');</script>";
    } else {
        // Attempt insert query execution
        $insert_query = "INSERT INTO users (username, password, email, contact, address) VALUES ('$username', '$password', '$email', '$contact', '$address')";
        if (mysqli_query($conn, $insert_query)) {
            // Redirect to login page
            header("Location: login.html");
            exit();
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
    }
}

// Close connection
mysqli_close($conn);
?>
