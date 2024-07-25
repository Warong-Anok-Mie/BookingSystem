<?php
session_start();
error_reporting(0);

// Check if there's an error message from a previous login attempt
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$msg = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
unset($_SESSION['error']); // Clear the error message once displayed
unset($_SESSION['msg']); // Clear the success message once displayed

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

// Delete functionality
if (isset($_POST['delete_id'])) {
    $id_to_delete = $_POST['delete_id'];
    $sql_delete = "DELETE FROM admins WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $id_to_delete);

    if ($stmt->execute()) {
        $msg = "Row deleted successfully.";
    } else {
        $error = "Error deleting row: " . $conn->error;
    }

    $stmt->close();
}

// Edit functionality
if (isset($_POST['edit_id'])) {
    $id_to_edit = $_POST['edit_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Prepare update statement
    $sql_update = "UPDATE admins SET username = ?, email = ?, phone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssi", $username, $email, $phone, $id_to_edit);

    if ($stmt->execute()) {
        $msg = "Admin details updated successfully.";
    } else {
        $error = "Error updating admin details: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sub Admins - Warong Anok Mie</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="signin.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
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

        /* Styles for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff; /* White background */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        /* Adjusted sidebar and main content styles */
        .sidebar {
            width: 250px; /* Adjust as needed */
            float: left; /* Keep sidebar floated */
            padding: 20px;
            background-color: #2c3e50; /* Sidebar background color */
            color: #ecf0f1; /* Sidebar text color */
            height: 100%; /* Full height sidebar */
        }

        .main-content {
            margin-left: 250px; /* Adjust based on sidebar width */
            padding: 20px;
        }

        .card {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #f0f0f0;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }

        .card-title {
            margin: 0;
            font-size: 18px;
        }

        /* Button style */
        .btn {
            margin-top: 10px;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: #3498db;
            color: white;
            border: none;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
        }

        .delete-btn:hover {
            background-color: #c0392b;
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
            <h1>Manage Sub Admins</h1>
            <?php
            if (!empty($msg)) {
                echo '<div class="alert alert-success">' . $msg . '</div>';
            }
            if (!empty($error)) {
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sub Admin Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="deleteForm" method="POST">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT id, username, email, phone FROM admins";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    $count = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr data-id='" . $row['id'] . "'>";
                                        echo "<td>" . $count . "</td>";
                                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                        echo "<td>
                                                <button type='button' class='edit-btn btn' onclick='confirmEdit(" . $row['id'] . ")'>Edit</button>
                                                <button type='button' class='delete-btn btn' onclick='confirmDelete(" . $row['id'] . ")'>Delete</button>
                                              </td>";
                                        echo "</tr>";
                                        $count++;
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No sub admins found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example1').DataTable();
        });
    </script>
</body>

</html>

<?php
// Close connection
$conn->close();
?>
