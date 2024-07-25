<?php
session_start(); // Start or resume session

// Redirect to login if session variables are not set (user not logged in)
if (!isset($_SESSION['admin_username']) || !isset($_SESSION['admin_email']) || !isset($_SESSION['admin_phone'])) {
    header("Location: admin_login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="signin.css">
    <style>
        /* Additional styles for the dropdown and form */
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

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="email"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .error-message {
            color: #c0392b;
            margin-bottom: 10px;
        }

        .success-message {
            color: #27ae60;
            margin-bottom: 10px;
        }
    </style>
</head>
<body><div class="sidebar">
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
            <li><a href="tablehistory">Tables History Record</a></li>
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
        <div class="container create-account-container">
            <h1>Profile Settings</h1>
            <?php if (isset($_SESSION['msg'])) { ?>
                <div class="success-message"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
            <?php } ?>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php } ?>
            <form action="process_update.php" method="POST" onsubmit="return confirm('Are you sure you want to update your profile?');">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['admin_username']); ?>" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['admin_email']); ?>" required>

                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($_SESSION['admin_phone']); ?>" required>
                
                <button type="submit" name="update_profile">Update</button>
            </form>
        </div>
    </div>

    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'admin_login.html'; // Redirect to logout page
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
