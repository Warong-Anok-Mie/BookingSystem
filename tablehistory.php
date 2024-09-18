<?php
// Database connection details (already defined in previous code)
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "anokmie1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch total time each table was selected based on table_id and month of the year
$sql = "SELECT YEAR(booking_date) AS year, MONTH(booking_date) AS month, t.table_id, t.table_name, COUNT(*) AS total_selections
        FROM totalreceipt tr
        JOIN tables t ON tr.table_id = t.table_id
        GROUP BY YEAR(booking_date), MONTH(booking_date), t.table_id
        ORDER BY YEAR(booking_date), MONTH(booking_date), t.table_id";

$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Selection History - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Adjusted container style */
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* Slideshow background */
        body {
            background-image: url('your-slideshow-image.jpg'); /* Replace with your actual slideshow background image */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Print button style */
        .print-button {
            display: block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #2ecc71;
            color: #fff;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .print-button:hover {
            background-color: #27ae60;
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
            <h2>Table Selection History</h2>
            <canvas id="tableHistoryChart"></canvas>
            <a href="#" class="print-button" onclick="printChart()">Print Chart</a>
        </div>
    </div>

    <script>
        var tableData = {
            labels: [],
            datasets: []
        };

        <?php
        $currentYear = null;
        $datasets = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $year = $row['year'];
                $month = $row['month'];
                $tableId = $row['table_id'];
                $tableName = $row['table_name'];
                $totalSelections = $row['total_selections'];
                $monthName = date("F", mktime(0, 0, 0, $month, 1));

                if ($currentYear === null || $currentYear != $year) {
                    if ($currentYear !== null) {
                        echo "tableData.datasets.push({\n";
                        echo "    label: '{$currentYear}',\n";
                        echo "    data: " . json_encode($datasets) . ",\n";
                        echo "    backgroundColor: 'rgba(54, 162, 235, 0.5)',\n";
                        echo "    borderColor: 'rgba(54, 162, 235, 1)',\n";
                        echo "    borderWidth: 1\n";
                        echo "});\n";
                        $datasets = [];
                    }
                    $currentYear = $year;
                }

                $datasets[] = $totalSelections;
                echo "tableData.labels.push('{$monthName} - Table ID: {$tableId}, Name: {$tableName}');\n";
            }

            if (!empty($datasets)) {
                echo "tableData.datasets.push({\n";
                echo "    label: '{$currentYear}',\n";
                echo "    data: " . json_encode($datasets) . ",\n";
                echo "    backgroundColor: 'rgba(54, 162, 235, 0.5)',\n";
                echo "    borderColor: 'rgba(54, 162, 235, 1)',\n";
                echo "    borderWidth: 1\n";
                echo "});\n";
            }
        }
        ?>

        var ctx = document.getElementById('tableHistoryChart').getContext('2d');
        var tableHistoryChart = new Chart(ctx, {
            type: 'bar',
            data: tableData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        function printChart() {
            var canvas = document.getElementById('tableHistoryChart');
            var win = window.open();
            win.document.write("<br><img src='" + canvas.toDataURL() + "'/>");
            win.print();
            win.location.reload();
        }

        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>
</html>
