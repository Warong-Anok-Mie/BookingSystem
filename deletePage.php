<!DOCTYPE html

<html>
	<head>
		<title> localhost </title>
		 <style>
			#round {
				border-radius: 25px;
				background: lightblue;
				padding: 20px;
				width: 200px;
				height: 250px;
			}
		</style>
		
	</head>
	
	<body>
	
	<h1>Delete Page</h1>
	

 
		<form id="round" action=" " method="post">
			
            <b>Username: </b><br>
			
			<input type = "text" name = "username"> <br>
			
			<b>Password: </b> <br>
			<input type = "password" name = "pass"> <br><br><br>
			
			<input type ="submit" value="Delete" name="delete"><br>

		</form>

        <?php
            if(isset($_POST["delete"])) {

                    $hostname= "localhost: 3307";
                    $username= "root";
                    $password= "";
                    $dbname= "student";

                    //connect website to db
                    $connect = mysqli_connect($hostname,$username,$password, $dbname) OR DIE ("CONNECTION FAILED");
                
                    //collect data 
                    $user = $_POST["username"];
                    $pass = $_POST["pass"];

                    $sql = "DELETE FROM login WHERE username='$user' AND password = '$pass'"; 
                   

                    $sendsql = mysqli_query($connect, $sql);


                   if($sendsql) {
                        if(mysqli_affected_rows($connect) == 0) {
                            echo "Delete not successful";
                        }
                        else { 
                            echo "Delete successful";
                        }
                    }else {
                        echo "QUERY FAILED";
                    }
                }
        ?>

	
	</body>