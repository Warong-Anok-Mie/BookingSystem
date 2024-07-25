<?php

        $hostname = "localhost:3307";
        $username = "root";
        $password = "";
        $dbname = "student";

        $connect = mysqli_connect($hostname, $username, $password, $dbname) 
        OR DIE ("CONNECTION FAILED");

        $user = $_GET["username"];
        $pass = $_GET["password"];
        $newpass = $_GET["newpassword"];

        $sql = "SELECT * FROM login WHERE username='$user' AND password='$pass'";

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

?>