<?php
session_start();

// Database connection details
$servername = "localhost:3307"; // Replace with your server name if different
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "anokmie1"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if edit form is submitted
if (isset($_POST['edit_id'])) {
    // Retrieve booking ID from form
    $edit_id = $_POST['edit_id'];

    // Query to fetch booking details based on ID
    $sql_select = "SELECT * FROM receipts WHERE id = ?";
    $stmt = $conn->prepare($sql_select);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("i", $edit_id);

        // Execute statement
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch data
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $phone = $row['userphoneNum'];
            $email = $row['useremail'];
            $address = $row['useradd'];
            $bookingDate = $row['userbookDate'];
            $startTime = $row['userbookStartTime'];
            $endTime = $row['userbookEndTime'];
            $totalAmount = $row['totalAmount'];

            // Store booking ID in session for update process
            $_SESSION['edit_id'] = $edit_id;
        } else {
            $_SESSION['error'] = "Booking ID $edit_id not found.";
            header("Location: http://localhost/allbookings.php");
            exit();
        }

        // Close statement
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing select statement: " . $conn->error;
        header("Location: http://localhost/allbookings.php");
        exit();
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="signin.css">
    <style>
        /* Adjusted margin for form */
        .edit-form {
            max-width: 600px; /* Optionally limit the maximum width */
            margin: 20px auto; /* Center align horizontally and add top margin */
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .edit-form h2 {
            margin-top: 0;
        }

        .edit-form input[type="text"], 
        .edit-form input[type="email"], 
        .edit-form input[type="tel"], 
        .edit-form textarea {
            width: calc(100% - 20px); /* Adjusted width */
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-size: 16px;
        }

        .edit-form input[type="submit"] {
            background-color: #3498db; /* Blue */
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .edit-form input[type="submit"]:hover {
            background-color: #2980b9; /* Darker blue */
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="brand-title">
            <img src="img/WARONG.jpg" alt="Logo" class="logo">
            <span class="brand-text">Warong Anok Mie</span>
        </div>

        <ul class="sidebar-menu">
            <li><a href="manage-subadmins.php">Manage Sub Admins</a></li>
            <li class="active"><a href="allbookings.php">All Bookings</a></li>
            <li><a href="new-bookings.php">New Bookings</a></li>
            <li><a href="accepted-bookings.php">Accepted Bookings</a></li>
            <li><a href="rejected-bookings.php">Rejected Bookings</a></li>
            <li class="dropdown">
                <span class="dropdown-header">Account Settings</span>
                <div class="dropdown-content">
                    <a href="changepassword.html">Change Password</a>
                    <a href="#" onclick="confirmLogout()">Logout</a>
                    <a href="profile_settings.html">Profile Settings</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="edit-form">
            <h2>Edit Booking</h2>
            <?php 
            if (isset($_SESSION['error'])) { ?>
                <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php } ?>
            <form action="update_booking.php" method="post">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br>
                
                <label for="phone">Phone:</label><br>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required><br>
                
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
                
                <label for="address">Address:</label><br>
                <textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($address); ?></textarea><br>
                
                <label for="bookingDate">Booking Date:</label><br>
                <input type="date" id="bookingDate" name="bookingDate" value="<?php echo htmlspecialchars($bookingDate); ?>" required><br>
                
                <label for="startTime">Start Time:</label><br>
                <input type="time" id="startTime" name="startTime" value="<?php echo htmlspecialchars($startTime); ?>" required><br>
                
                <label for="endTime">End Time:</label><br>
                <input type="time" id="endTime" name="endTime" value="<?php echo htmlspecialchars($endTime); ?>" required><br>
                
                <label for="totalAmount">Total Amount:</label><br>
                <input type="number" id="totalAmount" name="totalAmount" value="<?php echo htmlspecialchars($totalAmount); ?>" required><br>
                
                <input type="submit" value="Update">
            </form>
        </div>
    </div>

    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }
    </script>
</body>
</html>
