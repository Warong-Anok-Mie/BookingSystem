<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .profile-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 20px auto;
            text-align: left;
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <section class="header">
        <nav class="navbar">
            <div class="brand-title">
                <img src="img/WARONG.jpg" alt="Logo" class="logo">
                Warong Anok Mie
            </div>
            <a href="#" class="toggle-button">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </a>
            <div class="navbar-links">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="contactus.html">Contact</a></li>
                    <li><a href="profile.php" class="hero-btn book">Profile</a></li>
                </ul>
            </div>
        </nav>
        <div class="text-box">
            <h1>User Profile</h1>
            <p>View and update your profile details below</p>

            <div id="profile-info" class="profile-box">
                <?php
                    session_start();

                    $hostname = "localhost:3307";
                    $username = "root";
                    $password = "";
                    $dbname = "anokmie";

                    $connect = mysqli_connect($hostname, $username, $password, $dbname)
                    OR DIE ("Connection failed");

                    if(isset($_SESSION['username'])){
                        $user = $_SESSION['username'];
                        echo "<p><b>Welcome, " . htmlspecialchars($user) . "</b></p>";
                    } else {
                        echo "<p>Session error. Please <a href='anokmielogin.php'>login</a> again.</p>";
                    }
                ?>
            </div>

            <div id="bookings" class="profile-box">
                <h2>Approved Bookings</h2>
                <table>
                    <tr>
                        <th>Booking ID</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Table Number</th>
                    </tr>
                    <?php
                        if(isset($_SESSION['username'])){
                            $user = $_SESSION['username'];

                            $query = "SELECT * FROM receipts WHERE w_username = '$user' AND status = 'approved'";
                            $result = mysqli_query($connect, $query);

                            if($result && mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<tr>";
                                    echo "<td>" . $row['booking_id'] . "</td>";
                                    echo "<td>" . $row['booking_date'] . "</td>";
                                    echo "<td>" . $row['booking_time'] . "</td>";
                                    echo "<td>" . $row['table_number'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No approved bookings found.</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>

            <form id="update-form" class="profile-box" action="" method="post">
                <label for="new-password"><b>New Password:</b></label><br>
                <input type="password" id="new-password" name="new_password" required><br><br>

                <label for="confirm-password"><b>Confirm New Password:</b></label><br>
                <input type="password" id="confirm-password" name="confirm_password" required><br><br>

                <input type="submit" value="Update Password" name="update">
            </form>

            <?php
                if(isset($_POST['update'])){
                    $new_password = mysqli_real_escape_string($connect, $_POST['new_password']);
                    $confirm_password = mysqli_real_escape_string($connect, $_POST['confirm_password']);

                    if($new_password === $confirm_password){
                        $update_sql = "UPDATE logins SET w_password = '$new_password' WHERE w_username = '$user'";
                        if(mysqli_query($connect, $update_sql)){
                            echo "<script>alert('Password updated successfully');</script>";
                        } else {
                            echo "<script>alert('Error updating password');</script>";
                        }
                    } else {
                        echo "<script>alert('Passwords do not match');</script>";
                    }
                }
            ?>
        </div>
    </section>
</body>
</html>
