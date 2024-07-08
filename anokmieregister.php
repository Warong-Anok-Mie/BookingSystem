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
            <h1>Warong Anok Mie Register Page</h1>
            <p>Please fill in all the required fields.</p>

			<form id="round" action="" method="post">
			
				<b>Username: </b><br>
			
				<input type = "text" name = "username"> <br>
			
				<b>Password: </b> <br>
				<input type = "text" name = "pass"> <br>
			
				<input type ="submit" value="Register" name="register"><br>

				<p>Already have an account? <a href="anokmielogin.php">Click here</a> to login!</p>

			</form>
        </div>
    </section>

    <?php

		if(isset($_POST["register"])){

		    $hostname = "localhost:3307";
		    $username = "root";
		    $password = "";
		    $dbname = "webapp";

		    $connect = mysqli_connect($hostname, $username, $password, $dbname)
		    OR DIE ("CONNECTION FAILED");

            $user = mysqli_real_escape_string($connect, $_POST["username"]);
            $pass = mysqli_real_escape_string($connect, $_POST["pass"]);

            $sql = "SELECT * from weblogin where w_username='$user' AND w_password='$pass'";
            
		    $sendsql = mysqli_query($connect, $sql);

		    if($sendsql){
			    if(mysqli_num_rows($sendsql)>0){
                    echo "<script>alert('Username already exist');</script>";
			    }else {
                    $insert_sql = "INSERT INTO weblogin (w_username, w_password) VALUES ('$user', '$pass')";

                    $insert_result = mysqli_query($connect, $insert_sql);

                    if($insert_result){
                        echo "<script>alert('Successfully Register');</script>";
                        storeUsername($user);
                        echo "<script>changeParentPage('index.php');</script>";        
                    }else{
                        echo "<script>alert('Register failed');</script>";
                    }
			    }
		    } else {
			echo "<script>alert('Check connection');</script>";
		    }
		}
	?>
</body>
</html>