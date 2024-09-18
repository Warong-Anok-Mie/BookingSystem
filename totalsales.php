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

// Query to fetch total sales for each month in a year
$sql = "SELECT YEAR(booking_date) AS year, MONTH(booking_date) AS month, SUM(price) AS total_sales
        FROM totalreceipt
        GROUP BY YEAR(booking_date), MONTH(booking_date)
        ORDER BY YEAR(booking_date), MONTH(booking_date)";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Sales - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
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
            <h2>Total Sales for Each Month</h2>
            <canvas id="salesChart"></canvas>
            <button onclick="printChart()">Print Chart to PDF</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var salesData = {
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
                $totalSales = $row['total_sales'];
                $monthName = date("F", mktime(0, 0, 0, $month, 1));

                if ($currentYear === null || $currentYear != $year) {
                    if ($currentYear !== null) {
                        echo "salesData.datasets.push({\n";
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

                $datasets[] = $totalSales;
                echo "salesData.labels.push('{$monthName}');\n";
            }

            if (!empty($datasets)) {
                echo "salesData.datasets.push({\n";
                echo "    label: '{$currentYear}',\n";
                echo "    data: " . json_encode($datasets) . ",\n";
                echo "    backgroundColor: 'rgba(54, 162, 235, 0.5)',\n";
                echo "    borderColor: 'rgba(54, 162, 235, 1)',\n";
                echo "    borderWidth: 1\n";
                echo "});\n";
            }
        }
        ?>

        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'bar',
            data: salesData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        function printChart() {
            var printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Print Chart</title>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<img src="' + salesChart.toBase64Image() + '">');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
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
