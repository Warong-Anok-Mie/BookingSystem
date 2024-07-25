<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bookings - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="signin.css">
    <style>
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

        .edit-btn, .delete-btn, .approve-btn, .reject-btn {
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

        .edit-btn {
            background-color: #2ecc71; /* Green */
            color: white;
            border: none;
        }

        .delete-btn {
            background-color: #e74c3c; /* Red */
            color: white;
            border: none;
        }

        .approve-btn {
            background-color: #3498db; /* Blue */
            color: white;
            border: none;
        }

        .reject-btn {
            background-color: #e67e22; /* Orange */
            color: white;
            border: none;
        }

        .edit-btn:hover, .delete-btn:hover, .approve-btn:hover, .reject-btn:hover {
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
            <h1>All Bookings</h1>
            <?php 
            // Ensure no output before this point
            if (!headers_sent()) {
                session_start();
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

            // Check if approval action is triggered
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve_id'])) {
                $receiptId = $_POST['approve_id'];

                // Query to fetch booking details
                $sql_select = "SELECT * FROM totalreceipt WHERE receipt_id = $receiptId";
                $result = $conn->query($sql_select);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();

                    // Display confirmation message
                    echo '<script>';
                    echo 'if(confirm("Do you want to approve this booking?")) {';
                    echo '  window.location.href = "approve_admin.php?receipt_id=' . $receiptId . '";';
                    echo '}';
                    echo '</script>';
                } else {
                    echo "<p>Error: Booking details not found.</p>";
                }
            }

            // Query to fetch totalreceipt data
            $sql_select = "SELECT receipt_id, username, table_id, phone, email, address, booking_date, start_time, end_time, price, num_chairs, w_username FROM totalreceipt";
            $result = $conn->query($sql_select);

            if ($result) {
                if ($result->num_rows > 0) {
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
                        echo '<form method="post">';
                        echo '<input type="hidden" name="approve_id" value="' . $row["receipt_id"] . '">';
                        echo '<button type="submit" class="approve-btn">Approve</button>';
                        echo '</form>';

                        // Edit button form
                        echo '<form method="post" action="edit_button.php">';
                        echo '<input type="hidden" name="edit_id" value="' . $row["receipt_id"] . '">';
                        echo '<button type="submit" class="edit-btn">Edit</button>';
                        echo '</form>';

                        // Delete button form
                        echo '<form method="post" action="delete_button.php">';
                        echo '<input type="hidden" name="delete_id" value="' . $row["receipt_id"] . '">';
                        echo '<button type="submit" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete?\')">Delete</button>';
                        echo '</form>';

                        echo '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "<p>No bookings found.</p>";
                }
            } else {
                $_SESSION['error'] = "Error fetching bookings: " . $conn->error;
                echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>

    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>
</html>
