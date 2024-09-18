<?php

        $hostname ="localhost:3307";
        $username ="root";
        $password ="";
        $dbname ="anokmie1";

        if (isset($_POST['submit'])) {
        $connect = mysqli_connect($hostname, $username, $password, $dbname) 
        OR DIE ("CONNECTION FAILED");

            $username = $_POST['username'];
            $password = $_POST['password'];
            $newpassword = $_POST['newpassword'];
            $confirmpassword = $_POST['confirmpassword'];

            if($new_password === $password) {
                echo "Password cannot be the same as current password!";
            }
            elseif ($newpassword !== $confirmpassword) {
                echo "Passwords do not match!";
    
        }
        else {
                $sql = "UPDATE admins SET password='$newpassword' WHERE username='$username'";
        }
        $sendsql = mysqli_query($connect, $sql);
    
        if($sendsql){
            if(mysqli_num_rows($sendsql)>0){
                echo "Update successful";
            }else{
                echo "Update not successful";
            }

        }else{
            echo "QUERY FAILED!";
        }
    }
?>
