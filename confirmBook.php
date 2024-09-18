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

// Database connection details
$hostname = "localhost:3307";
$usernameDB = "root";
$password = ""; // Replace with your database password
$dbName = "anokmie1";

// Create connection
$connect = mysqli_connect($hostname, $usernameDB, $password, $dbName) or die ("Connection failed: " . mysqli_connect_error());

// Query to retrieve booking information
$sql = "SELECT * FROM bookinginfo WHERE username = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $bookingInfo = mysqli_fetch_assoc($result);
    if ($bookingInfo) {
        $userphoneNum = htmlspecialchars($bookingInfo['userphoneNum']);
        $useremail = htmlspecialchars($bookingInfo['useremail']);
        $useradd = htmlspecialchars($bookingInfo['useradd']);
        $userbookDate = htmlspecialchars($bookingInfo['userbookDate']);
        $userbookStartTime = htmlspecialchars($bookingInfo['userbookStartTime']);
        $userbookEndTime = htmlspecialchars($bookingInfo['userbookEndTime']);
    } else {
        echo "Error: No booking information found for this user.";
        exit;
    }
} else {
    echo "Error: " . mysqli_error($connect);
    exit;
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($connect);

// Retrieve total amount from session or default to 0
$totalAmount = isset($_SESSION['total_amount']) ? $_SESSION['total_amount'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>Warong Anok Mie Booking Confirmation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .booking-details {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
            padding: 30px; /* Increased padding for a bigger section */
            background-color: #f2f2f2;
            border-radius: 5px;
            max-width: 400px; /* Increased max-width for a wider section */
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Added box-shadow for depth */
            text-align: center;
        }

        .booking-details div {
            margin-bottom: 15px; /* Adjusted margin-bottom for spacing */
        }

        .pay-button {
            padding: 12px 24px; /* Adjusted padding for a slightly larger button */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 16px;
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

    <h1 style="color: #FEA116; text-align: center; margin-top: 50px">Warong Anok Mie Booking Confirmation</h1>
    <div class="booking-details">
        <div>
            <strong>Name:</strong> <?php echo $username; ?>
        </div>
        <div>
            <strong>Phone:</strong> <?php echo $userphoneNum; ?>
        </div>
        <div>
            <strong>Email:</strong> <?php echo $useremail; ?>
        </div>
        <div>
            <strong>Address:</strong> <?php echo $useradd; ?>
        </div>
        <div>
            <strong>Booking Date:</strong> <?php echo $userbookDate; ?>
        </div>
        <div>
            <strong>Start Time:</strong> <?php echo $userbookStartTime; ?>
        </div>
        <div>
            <strong>End Time:</strong> <?php echo $userbookEndTime; ?>
        </div>
        <div>
            <strong>Total Amount:</strong> <?php echo $totalAmount; ?>
        </div>
        <button class="pay-button" onclick="confirmPayment()">Pay Now</button>
    </div>
</section>

<script>
    function confirmPayment() {
        if (confirm("Confirm payment?")) {
            window.location.href = "receipt.php";
        }
    }
</script>

</body>
</html>
