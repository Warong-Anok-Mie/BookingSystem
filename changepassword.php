<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="signin.css">
    <style>
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

        /* Styles for the form container */
        .container {
            margin: 20px;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .container h1 {
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .success-message {
            color: green;
            margin-bottom: 10px;
        }

        form {
            max-width: 400px;
            margin: auto;
        }

        form label {
            display: block;
            margin-bottom: 10px;
        }

        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #45a049;
        }

        /* Adjusting spacing between sidebar and main content */
        .main-content {
            margin-left: 250px; /* Width of sidebar + additional margin */
            padding: 20px;
            margin-top: 20px; /* Space between sidebar and main content */
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
        <div class="container create-account-container">
            <h1>Change Password</h1>
            <?php 
            session_start(); 
            if (isset($_SESSION['msg'])) { ?>
                <div class="success-message"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
            <?php } ?>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php } ?>
            ?>
            <form action="changePass.php" method="POST" onsubmit="return validateForm()">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current-password" required>
                
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new-password" required>

                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                
                <button type="submit" name="change_password">Change Password</button>
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

        function validateForm() {
            var newPassword = document.getElementById("new-password").value;
            var confirmPassword = document.getElementById("confirm-password").value;

            if (newPassword !== confirmPassword) {
                alert("New password and confirm password must match.");
                return false;
            }

            return true;
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
