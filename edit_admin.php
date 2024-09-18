<?php
session_start();
error_reporting(0);

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

// Initialize variables
$id = $_GET['id'] ?? '';
$username = '';
$email = '';
$phone = '';

// Fetch admin details based on ID
if (!empty($id)) {
    $sql = "SELECT username, email, phone FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];
        $phone = $row['phone'];
    } else {
        $_SESSION['error'] = "Admin not found.";
        header("Location: manage-subadmins.php");
        exit();
    }

    $stmt->close();
}

// Handle form submission for updating admin details
if (isset($_POST['edit_submit'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update admin details in the database
    $sql_update = "UPDATE admins SET username = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssi", $username, $email, $phone, $id);

    if ($stmt->execute()) {
        $_SESSION['msg'] = "Admin details updated successfully.";
        header("Location: manage-subadmins.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating admin details: " . $conn->error;
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="signin.css">
    <style>
        /* Additional styles for the form */
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #FEA116;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
            
        }
         /* Additional styles for the dropdown */
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
            <li><a href="all-bookings.php">All Bookings</a></li>
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
        <div class="container">
            <h1>Edit Admin</h1>
            <?php
            if (!empty($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            <div class="form-container">
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
                    </div>
                    <button type="submit" name="edit_submit" class="btn">Confirm</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'admin_login.html'; // Redirect to logout page
            }
            // If cancel, do nothing
        }

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this row?')) {
                // Submit the form to delete the row
                document.getElementById('deleteForm').innerHTML += '<input type="hidden" name="delete_id" value="' + id + '">';
                document.getElementById('deleteForm').submit();
            }
            // If cancel, do nothing
        }

        function confirmEdit(id) {
            if (confirm('Are you sure you want to edit this admin?')) {
                window.location.href = 'edit_admin.php?id=' + id; // Redirect to edit page with admin ID
            }
            // If cancel, do nothing
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
