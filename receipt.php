<?php
session_start(); // Start or resume session

// Check if username session variable is set
if (!isset($_SESSION['username'])) {
    // Redirect to login if username is not set
    header("Location: anokmielogin.php");
    exit;
}

// Ensure $_SESSION['username'] is safe to use in HTML output
$username = htmlspecialchars($_SESSION['username']);

// Connect to database (replace with your database credentials)
$hostname = "localhost:3307";
$usernameDB = "root";
$password = ""; // Replace with your database password
$dbName = "anokmie1";

// Create database connection
$conn = new mysqli($hostname, $usernameDB, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL to fetch receipt details from totalreceipt table
$sql_select = "SELECT username, phone, email, address, booking_date, start_time, end_time, price, num_chairs FROM totalreceipt WHERE username = ? ORDER BY receipt_id DESC LIMIT 1";
$stmt_select = $conn->prepare($sql_select);

if (!$stmt_select) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt_select->bind_param("s", $username);

if (!$stmt_select->execute()) {
    die("Execute failed: (" . $stmt_select->errno . ") " . $stmt_select->error);
}

$stmt_select->bind_result($db_username, $phone, $email, $address, $date, $startTime, $endTime, $price, $num_chairs);

if (!$stmt_select->fetch()) {
    die("Fetch failed: (" . $stmt_select->errno . ") " . $stmt_select->error);
}

$stmt_select->close();

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>Receipt</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f2f2f2;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #FEA116;
        }
        .receipt-details {
            margin-top: 30px;
        }
        .receipt-details p {
            margin-bottom: 10px;
        }
        .print-btn {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
        }
        .print-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<section class="header">
        <nav class="navbar">
            <div class="brand-title">
                <img src="img/WARONG.jpg" alt="Logo" class="logo">
                Warong Anok Mie
            </div>
            <a href="#" class="toggle-button">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </a>
            <div class="navbar-links">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="anokmielogin.php" class="hero-btn book">Book a Table</a></li>
                </ul>
            </div>
        </nav>
    <div class="container">
        <h1>Booking Receipt</h1>

        <div class="receipt-details">
            <p><strong>Username:</strong> <?php echo $db_username; ?></p>
            <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Address:</strong> <?php echo $address; ?></p>
            <p><strong>Date:</strong> <?php echo $date; ?></p>
            <p><strong>Time:</strong> <?php echo $startTime . ' to ' . $endTime; ?></p>
            <p><strong>Price:</strong> <?php echo number_format($price, 2); ?> RM</p>
            <p><strong>Chairs:</strong> <?php echo $num_chairs; ?></p>
        </div>

        <!-- Print button -->
        <button class="print-btn" onclick="window.print()">Print PDF</button>
    </div>
</body>
</html>
