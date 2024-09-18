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

// Function to delete receipts for a user
if (isset($_POST['delete_user']) && isset($_POST['w_username'])) {
    $w_username = $_POST['w_username'];
    $delete_sql = "DELETE FROM totalreceipt WHERE w_username = ?";
    
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $w_username);
    
    // Display confirmation prompt using JavaScript
    echo '<script>
            var confirmed = confirm("Are you sure you want to delete receipts for username ' . $w_username . '?");
            if (confirmed) {
                document.getElementById("deleteForm_' . $w_username . '").submit();
            }
          </script>';
}

// Query to fetch w_username and aggregated receipt_ids
$sql = "SELECT w_username, GROUP_CONCAT(receipt_id ORDER BY receipt_id) AS receipt_ids
        FROM totalreceipt
        GROUP BY w_username";

$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipts for Users - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <style>
        /* Additional styles */
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .action-buttons button {
            padding: 8px 16px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .action-buttons button.delete-button {
            background-color: #f44336;
            color: white;
        }

        .action-buttons button.delete-button:hover {
            background-color: #d32f2f;
        }

        .action-buttons button.print-button {
            background-color: #4CAF50;
            color: white;
        }

        .action-buttons button.print-button:hover {
            background-color: #45a049;
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
            <h2>Receipts for Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Receipt IDs</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['w_username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['receipt_ids']) . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<form id='deleteForm_" . htmlspecialchars($row['w_username']) . "' method='post' style='display: inline;'>";
                            echo "<input type='hidden' name='w_username' value='" . htmlspecialchars($row['w_username']) . "' />";
                            echo "<button type='submit' name='delete_user' class='delete-button'>Delete</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No data found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Print to PDF button -->
            <div class="action-buttons">
                <button onclick="printTableToPDF()" class="print-button">Print to PDF</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script>
        
        function confirmLogout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'logout.php';
            }
        }

        function printTableToPDF() {
            var doc = new jsPDF();
            doc.text('Receipts for Users', 20, 10);
            doc.autoTable({ html: 'table' });
            doc.save('receipts.pdf');
        }
        
    </script>
</body>
</html>
