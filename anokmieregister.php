<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login.css">
    <script src="script.js" defer></script>
    <title>Warong Anok Mie Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* General styles for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .brand-title img.logo {
            width: 50px;
            height: 50px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .navbar-links ul {
            list-style: none;
            padding: 0;
        }

        .navbar-links ul li {
            display: inline;
            margin: 0 10px;
        }

        .navbar-links ul li a {
            color: #fff;
            text-decoration: none;
        }

        .text-box {
            padding: 40px 20px;
            text-align: center;
        }

        .login-form {
            background-color: #fff;
            padding: 30px;
            max-width: 400px;
            margin: 0 auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: left;
        }

        .login-form h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .login-form label {
            color: #333;
            font-weight: bold;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .login-form input[type="submit"] {
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .login-form input[type="submit"]:hover {
            background-color: #555;
        }

        .login-form p {
            margin-top: 20px;
            text-align: center;
            color: #333;
        }

        .login-form p a {
            color: #f0ba08;
            text-decoration: none;
        }

        .login-form p a:hover {
            text-decoration: underline;
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
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="anokmielogin.php" class="hero-btn book">Book a Table</a></li>
                </ul>
            </div>
        </nav>
        <div class="text-box">
            <h1>Warong Anok Mie Register Page</h1>
            <p>Please fill in all the required fields.</p>
            <div class="login-form">
                <h2>Register</h2>
                <form id="round" action="" method="post">
                    <label for="username"><b>Username:</b></label>
                    <input type="text" id="username" name="username" required>
                    
                    <label for="pass"><b>Password:</b></label>
                    <input type="password" id="pass" name="pass" required>
                    
                    <input type="submit" value="Register" name="register">
                    
                    <p>Already have an account? <a href="anokmielogin.php">Click here</a> to login!</p>
                </form>
            </div>
        </div>
    </section>

    <?php
        if(isset($_POST["register"])){
            $hostname = "localhost:3307";
            $username = "root";
            $password = "";
            $dbname = "anokmie1";

            $connect = mysqli_connect($hostname, $username, $password, $dbname)
            OR DIE ("CONNECTION FAILED");

            $user = mysqli_real_escape_string($connect, $_POST["username"]);
            $pass = mysqli_real_escape_string($connect, $_POST["pass"]);

            $sql = "SELECT * from logins where w_username='$user'";
            $sendsql = mysqli_query($connect, $sql);

            if($sendsql){
                if(mysqli_num_rows($sendsql) > 0){
                    echo "<script>alert('Username already exists');</script>";
                } else {
                    $insert_sql = "INSERT INTO logins (w_username, w_password) VALUES ('$user', '$pass')";
                    $insert_result = mysqli_query($connect, $insert_sql);

                    if($insert_result){
                        echo "<script>alert('Successfully Registered');</script>";
                        header("Location: index.html");        
                    } else {
                        echo "<script>alert('Registration failed');</script>";
                    }
                }
            } else {
                echo "<script>alert('Check connection');</script>";
            }
        }
    ?>
</body>
</html>