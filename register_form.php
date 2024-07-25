<?php
session_start();
include_once 'config.php';

$errors = [];

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $user_type = $_POST['user_type'];

    // Basic input validation
    if(empty($name) || empty($email) || empty($password) || empty($cpassword)) {
        $errors[] = "All fields are required!";
    } elseif($password !== $cpassword) {
        $errors[] = "Password confirmation does not match!";
    } else {
        // Check if user already exists
        $query = "SELECT * FROM user_form WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            $errors[] = "User already exists!";
        } else {
            // Insert new user into database
            $hashed_password = md5($password); // Note: consider using more secure hashing methods
            $insert_query = "INSERT INTO user_form (name, email, password, user_type) VALUES ('$name', '$email', '$hashed_password', '$user_type')";

            if(mysqli_query($conn, $insert_query)) {
                $_SESSION['success_msg'] = "Registration successful! Please log in.";
                header('Location: login_form.php');
                exit;
            } else {
                $errors[] = "Registration failed. Please try again later.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register Form</title>

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/styles.css">
</head>
<body>
   
<div class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>

      <?php if(!empty($errors)): ?>
         <div class="error-msg">
            <?php foreach($errors as $error): ?>
               <p><?php echo $error; ?></p>
            <?php endforeach; ?>
         </div>
      <?php endif; ?>

      <input type="text" name="name" required placeholder="Enter your name">
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="password" name="cpassword" required placeholder="Confirm your password">
      <select name="user_type">
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Register Now" class="form-btn">
      <p>Already have an account? <a href="login_form.php">Login Now</a></p>
   </form>
</div>

</body>
</html>
