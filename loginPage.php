<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    <title>Warong Anok Mie Bookings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/brands.min.css" integrity="sha512-DJLNx+VLY4aEiEQFjiawXaiceujj5GA7lIY8CHCIGQCBPfsEG0nGz1edb4Jvw1LR7q031zS5PpPqFuPA8ihlRA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <h1>Warong Anok Mie Login Page</h1>
            <p>Welcome, please enter your credentials to login</p>

			<form id="round" action=" " method="post">
			
				<b>Username: </b><br>
			
				<input type = "text" name = "username"> <br>
			
				<b>Password: </b> <br>
				<input type = "password" name = "pass"> <br><br><br>
			
				<input type ="submit" value="Login" name="login"><br>

				<p>New user? <a href="registerPage.php">Click here</a> to register!</p>

			</form>
        </div>
    </section>

	<?php
		if(isset($_POST["login"])){

			$hostname = "localhost:3307";
    		$username = "root";
    		$password = "";
    		$dbname = "student";

   			$connect = mysqli_connect($hostname, $username, $password, $dbname)
    		OR DIE ("Connection failed");

    		$user = $_POST["username"];
    		$pass = $_POST["pass"];

    		$sql = "SELECT username, pass FROM anokmielogon WHERE username = '$user' AND pass = '$pass'";

    		$sendsql = mysqli_query($connect, $sql);

    		if($sendsql){
        		if(mysqli_num_rows($sendsql)>0){
					header("Location:passedlogin.php");
				}else{
					echo "Username or password incorrect";
				}

    		}else{
        		echo "Query failed!";
    		}
		}
	?>
</body>
</html>