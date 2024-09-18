<?php
session_start();

// Database connection details (as previously defined)
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

// Check if receipt_id is set via GET for approval
if (isset($_GET['receipt_id'])) {
    $receiptId = $_GET['receipt_id'];

    // Insert into approvaltable
    $insertSql = "INSERT INTO approvaltable (receipt_id, username, table_id, phone, email, address, booking_date, start_time, end_time, price, num_chairs, w_username)
                  SELECT receipt_id, username, table_id, phone, email, address, booking_date, start_time, end_time, price, num_chairs, w_username
                  FROM totalreceipt
                  WHERE receipt_id = $receiptId";

    if ($conn->query($insertSql) === TRUE) {
        // Update status in tables table to 'approved'
        $updateSql = "UPDATE tables SET status = 'approved' WHERE table_id = (SELECT table_id FROM totalreceipt WHERE receipt_id = $receiptId)";

        if ($conn->query($updateSql) === TRUE) {
            // Redirect to allbookings.php after approval
            header("Location: allbookings.php");
            exit;
        } else {
            echo "Error updating status: " . $conn->error;
        }
    } else {
        echo "Error inserting into approvaltable: " . $conn->error;
    }
}

// Check if unapprove_id is set via POST
if (isset($_POST['unapprove_id'])) {
    $unapproveId = $_POST['unapprove_id'];

    // Update status in tables table to 'available'
    $updateSql = "UPDATE tables SET status = 'available' WHERE table_id = (SELECT table_id FROM approvaltable WHERE receipt_id = $unapproveId)";

    if ($conn->query($updateSql) === TRUE) {
        // Remove from approvaltable
        $deleteSql = "DELETE FROM approvaltable WHERE receipt_id = $unapproveId";

        if ($conn->query($deleteSql) === TRUE) {
            // Redirect to approve_admin.php after unapproval
            header("Location: approve_admin.php");
            exit;
        } else {
            echo "Error deleting from approvaltable: " . $conn->error;
        }
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

// Fetch data from approvaltable
$sql = "SELECT * FROM approvaltable";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Bookings - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="signin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <style>
        /* Include your existing styles here */
        /* Additional styles for the dropdown and other styles */
        .dropdown {
            position: relative;
            display: inline-block;
            margin-top: 20px; /* Adjust as needed */
        }

        .dropdown .dropdown-header {
            color: #bdc3c7;
            font-size: 14px;
            cursor: pointer;
        }

        .dropdown .dropdown-content {
            display: none;
            position: absolute;
            background-color: #34495e;
            width: 200px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            margin-top: 5px;
        }

        .dropdown .dropdown-content a {
            color: #ecf0f1;
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .dropdown .dropdown-content a:hover {
            background-color: #3b4b61;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }

        /* Styles for the grid */
        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjust minimum width as needed */
            gap: 20px;
            margin-top: 20px;
            justify-items: center; /* Center align items */
        }

        .admin-card {
            background-color: #f2f2f2;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center align text */
        }

        .admin-card h3 {
            margin-top: 0;
        }

        .admin-card p {
            margin: 5px 0;
        }

        .delete-btn, .reject-btn {
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        .delete-btn {
            background-color: #e74c3c; /* Red */
            color: white;
            border: none;
        }

        .reject-btn {
            background-color: #e67e22; /* Orange */
            color: white;
            border: none;
        }

        .delete-btn:hover, .reject-btn:hover {
            filter: brightness(85%);
        }

        /* Adjusted margin for sidebar and main content */
        .sidebar {
            margin-right: 20px; /* Increase margin from the right */
        }

        .main-content {
            margin-left: 240px; /* Adjusted margin from the left */
            padding-left: 20px; /* Added padding for separation */
            margin-top: 20px; /* Added top margin */
        }

        /* Center align the admin-grid */
        .admin-grid {
            margin: 20px auto; /* Center horizontally and add top margin */
            max-width: 1200px; /* Limit the maximum width */
        }

        /* Table styles */
        table {
            width: 100%; /* Set table width to 100% */
            margin: 20px auto; /* Center align and add top margin */
            background-color: white; /* White background */
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
            table-layout: fixed; /* Fix table layout */
        }

        th, td {
            padding: 8px; /* Adjust padding */
            border: 1px solid #ddd;
            text-align: left;
            overflow: hidden; /* Prevent overflow */
            text-overflow: ellipsis; /* Add ellipsis for overflow text */
            white-space: normal; /* Allow wrapping */
        }

        th {
            background-color: #f4f4f4;
        }

        td:nth-child(5), td:nth-child(6) {
            /* Adjust width of Email and Address columns */
            min-width: 250px; /* Set minimum width for Email and Address columns */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .success-message, .error-message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
        }

        .success-message {
            background-color: #2ecc71;
            color: white;
        }

        .error-message {
            background-color: #e74c3c;
            color: white;
        }

        /* Print button style */
        .print-btn {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .print-btn:hover {
            background-color: #2980b9;
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
            <li><a href="admin_page.html">Admin Dashboard</a></li>
            <li><a href="manage-subadmins.php">Manage Sub Admins</a></li>
            <li><a href="allbookings.php">All Bookings</a></li>
            <li><a href="approve_admin.php">Approved Bookings</a></li>
            <li><a href="totalsales.php">Total Sales Record</a></li>
            <li><a href="tablehistory.php">Tables History Record</a></li>
            <li><a href="manage_users.php">Manage Users</a></li> <!-- New Manage Users link -->
            <li class="dropdown">
                <span class="dropdown-header">Account Settings</span>
                <div class="dropdown-content">
                    <a href="changepassword.html">Change Password</a>
                    <a href="#" onclick="confirmLogout()">Logout</a>
                    <a href="profile_settings.php">Profile Settings</a>
                </div>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h1>Accepted Bookings</h1>
            <?php 
            if ($result && $result->num_rows > 0) {
                // Output data of each row using a table
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Receipt ID</th>';
                echo '<th>Username</th>';
                echo '<th>Table ID</th>';
                echo '<th>Phone</th>';
                echo '<th>Email</th>';
                echo '<th>Address</th>';
                echo '<th>Booking Date</th>';
                echo '<th>Start Time</th>';
                echo '<th>End Time</th>';
                echo '<th>Price</th>';
                echo '<th>Number of Chairs</th>';
                echo '<th>Waiter Username</th>';
                echo '<th>Actions</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["receipt_id"] . '</td>';
                    echo '<td>' . $row["username"] . '</td>';
                    echo '<td>' . $row["table_id"] . '</td>';
                    echo '<td>' . $row["phone"] . '</td>';
                    echo '<td>' . $row["email"] . '</td>';
                    echo '<td>' . $row["address"] . '</td>';
                    echo '<td>' . $row["booking_date"] . '</td>';
                    echo '<td>' . $row["start_time"] . '</td>';
                    echo '<td>' . $row["end_time"] . '</td>';
                    echo '<td>' . $row["price"] . '</td>';
                    echo '<td>' . $row["num_chairs"] . '</td>';
                    echo '<td>' . $row["w_username"] . '</td>';
                    echo '<td>';

                    // Unapprove button form with JavaScript confirmation
                    echo '<button type="button" onclick="confirmUnapprove(' . $row["receipt_id"] . ')" class="reject-btn">Unapprove</button>';

                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';

                // Print to PDF button
                echo '<button class="print-btn" onclick="printToPDF()">Print to PDF</button>';
            } else {
                echo "<p>No accepted bookings found.</p>";
            }
            ?>
        </div>
    </div>

    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }

        function confirmUnapprove(receiptId) {
            if (confirm('Are you sure you want to unapprove?')) {
                // Create a hidden form
                var form = document.createElement('form');
                form.method = 'post';
                form.action = 'approve_admin.php'; // Adjust action URL as needed

                // Create a hidden input to send the unapprove_id
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'unapprove_id';
                input.value = receiptId; // Pass the receiptId parameter
                form.appendChild(input);

                // Append the form to the document body and submit
                document.body.appendChild(form);
                form.submit();
            }
        }

        function printToPDF() {
            var currentDate = new Date().toLocaleString();
            
            // Select the table to be printed
            var table = document.querySelector('table');

            // Use html2canvas to capture table as image
            html2canvas(table).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');
                var pdf = new jsPDF();

                // Add image to PDF
                pdf.addImage(imgData, 'PNG', 10, 10, 180, 150);

                // Add text with current date
                pdf.text('Printed on: ' + currentDate, 10, 170);

                // Save PDF
                pdf.save('table.pdf');
            });
        }
        // JavaScript to toggle dropdown menu
        document.addEventListener('DOMContentLoaded', function () {
            var dropdownHeaders = document.querySelectorAll('.dropdown .dropdown-header');

            dropdownHeaders.forEach(function (dropdownHeader) {
                dropdownHeader.addEventListener('click', function () {
                    var dropdown = this.parentElement;
                    dropdown.classList.toggle('show');
                });
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', function (e) {
                var dropdowns = document.querySelectorAll('.dropdown');
                dropdowns.forEach(function (dropdown) {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('show');
                    }
                });
            });
        });
    </script>
</body>
</html>
