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

// Handle form submission after confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_reservation'])) {
    // Database connection details
    $hostname = "localhost:3307";
    $usernameDB = "root";
    $password = ""; // Replace with your database password
    $dbName = "anokmie1";

    // Create connection
    $connect = mysqli_connect($hostname, $usernameDB, $password, $dbName) or die ("CONNECTION FAILED");

    // Retrieve form data (Move this after creating connection)
    $phone = mysqli_real_escape_string($connect, $_POST["userphoneNum"]);
    $email = mysqli_real_escape_string($connect, $_POST["useremail"]);
    $address = mysqli_real_escape_string($connect, $_POST["useradd"]);
    $date = mysqli_real_escape_string($connect, $_POST["userbookDate"]);
    $startTime = mysqli_real_escape_string($connect, $_POST["userbookStartTime"]);
    $endTime = mysqli_real_escape_string($connect, $_POST["userbookEndTime"]);

    // Insert query (Use prepared statement for security)
    $sql = "INSERT INTO bookinginfo (username, userphoneNum, useremail, useradd, userbookDate, userbookStartTime, userbookEndTime) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare statement
    $stmt = mysqli_prepare($connect, $sql);
    if ($stmt) {
        // Bind parameters and execute statement
        mysqli_stmt_bind_param($stmt, "sssssss", $username, $phone, $email, $address, $date, $startTime, $endTime);
        mysqli_stmt_execute($stmt);

        // Check for successful insertion
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            mysqli_stmt_close($stmt);
            mysqli_close($connect);

            // Set session variables for booking details
            $_SESSION['userphoneNum'] = $phone;
            $_SESSION['useremail'] = $email;
            $_SESSION['useradd'] = $address;
            $_SESSION['userbookDate'] = $date;
            $_SESSION['userbookStartTime'] = $startTime;
            $_SESSION['userbookEndTime'] = $endTime;

            header("Location: chooseTable.php"); // Redirect after successful booking
            exit;
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>Warong Anok Mie Booking Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .booking-form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .booking-form input[type="text"],
        .booking-form input[type="tel"],
        .booking-form input[type="email"],
        .booking-form input[type="date"],
        .booking-form select {
            width: 100%;
            padding: 10px; /* Added padding for better textbox appearance */
            margin-bottom: 10px; /* Added margin between input fields */
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .booking-form input[type="submit"] {
            padding: 10px 20px; /* Increased padding for submit button */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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

    <h1 style="color: #FEA116; text-align: center; margin-top: 50px">Warong Anok Mie Booking Form</h1>
    <div class="booking-form">
        <form id="bookingForm" action="booking.php" method="post">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="username" value="<?php echo $username; ?>" readonly required>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="userphoneNum" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="useremail" required>
            </div>
            <div>
                <label for="address">Address:</label>
                <input type="text" id="address" name="useradd" required>
            </div>
            <div>
                <label for="date">Date:</label>
                <input type="date" id="date" name="userbookDate" required>
            </div>
            <div>
                <label for="time">Start Time:</label>
                <select name="userbookStartTime" class="form-control" required>
                    <option value="">- Select -</option>
                    <option value="08:00">08:00</option>
                    <option value="08:30">08:30</option>
                    <option value="09:00">09:00</option>
                    <option value="09:30">09:30</option>
                    <option value="10:00">10:00</option>
                    <option value="10:30">10:30</option>
                    <option value="11:00">11:00</option>
                    <option value="11:30">11:30</option>
                    <option value="12:00">12:00</option>
                    <option value="12:30">12:30</option>
                    <option value="13:00">13:00</option>
                    <option value="13:30">13:30</option>
                    <option value="14:00">14:00</option>
                    <option value="14:30">14:30</option>
                    <option value="15:00">15:00</option>
                    <option value="15:30">15:30</option>
                    <option value="16:00">16:00</option>
                    <option value="16:30">16:30</option>
                    <option value="17:00">17:00</option>
                    <option value="17:30">17:30</option>
                    <option value="18:00">18:00</option>
                    <option value="18:30">18:30</option>
                    <option value="19:00">19:00</option>
                    <option value="19:30">19:30</option>
                    <option value="20:00">20:00</option>
                    <option value="20:30">20:30</option>
                    <option value="21:00">21:00</option>
                    <option value="21:30">21:30</option>
                    <option value="22:00">22:00</option>
                    <option value="22:30">22:30</option>
                    <option value="23:00">23:00</option>
                    <option value="23:30">23:30</option>
                    <option value="24:00">24:00</option>
                </select>
            </div>
            <div>
                <label for="time">End Time:</label>
                <select name="userbookEndTime" class="form-control" required>
                    <option value="">- Select -</option>
                    <option value="08:30">08:30</option>
                    <option value="09:00">09:00</option>
                    <option value="09:30">09:30</option>
                    <option value="10:00">10:00</option>
                    <option value="10:30">10:30</option>
                    <option value="11:00">11:00</option>
                    <option value="11:30">11:30</option>
                    <option value="12:00">12:00</option>
                    <option value="12:30">12:30</option>
                    <option value="13:00">13:00</option>
                    <option value="13:30">13:30</option>
                    <option value="14:00">14:00</option>
                    <option value="14:30">14:30</option>
                    <option value="15:00">15:00</option>
                    <option value="15:30">15:30</option>
                    <option value="16:00">16:00</option>
                    <option value="16:30">16:30</option>
                    <option value="17:00">17:00</option>
                    <option value="17:30">17:30</option>
                    <option value="18:00">18:00</option>
                    <option value="18:30">18:30</option>
                    <option value="19:00">19:00</option>
                    <option value="19:30">19:30</option>
                    <option value="20:00">20:00</option>
                    <option value="20:30">20:30</option>
                    <option value="21:00">21:00</option>
                    <option value="21:30">21:30</option>
                    <option value="22:00">22:00</option>
                    <option value="22:30">22:30</option>
                    <option value="23:00">23:00</option>
                    <option value="23:30">23:30</option>
                    <option value="24:00">24:00</option>
                </select>
            </div>
            <button type="submit" name="confirm_reservation" class="hero-btn book" onclick="return confirmBooking()">Confirm Booking</button>
        </form>
    </div>
</section>
<script>
    function confirmBooking() {
        const currentDate = new Date();
        const selectedDate = document.getElementById("date").value;
        const selectedStartTime = document.querySelector('select[name="userbookStartTime"]').value;
        const selectedEndTime = document.querySelector('select[name="userbookEndTime"]').value;

        // Check if the selected date is earlier than today
        if (selectedDate < currentDate.toISOString().slice(0, 10)) {
            alert("Invalid date: Please select a date that is today or later.");
            return false;
        }

        // Check if the selected start time is earlier than the current time
        const currentTime = currentDate.toLocaleTimeString().slice(0, 5);
        if (selectedDate === currentDate.toISOString().slice(0, 10) && selectedStartTime < currentTime) {
            alert("Invalid start time: Please select a time that is later than the current time.");
            return false;
        }

        // Check if the selected end time is earlier than the selected start time
        if (selectedEndTime < selectedStartTime) {
            alert("Invalid end time: Please select an end time that is later than the start time.");
            return false;
        }

        return true;
    }
</script>
</body>
</html>
