<?php
$hostname = "localhost: 3307";
$username = "root";
$password = "";
$dbname = "anokmie";

// Create a connection to the database
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$feedback = $_POST['feedback'];

$sql = "INSERT INTO userfeedback (username, useremail, userMessage) VALUES ('$name', '$email', '$feedback')";

if ($conn->query($sql) === TRUE) {
    header("Location: feedback.html?submitted=true");
    exit();
} else {
    echo "Error: ". $sql. "<br>". $conn->error;
}
$conn->close();

header("Location: feedback.html");
exit();