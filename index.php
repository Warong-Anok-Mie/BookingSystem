<!DOCTYPE html>
<html>
	<head>
		<title> localhost </title>
		
		<style>
			#button{
				width:15%;
				height:30px;
			}
			
			#textfield{
				width:50%;
			}
		</style>
	</head>
	
	<body>

	<h1 style = "text-align:center">CSC264 Survey</h1>

	<form action="student_info.php" method="post">

	<fieldset style="width:500px;margin:auto">
	<legend style="font-weight:bold">Student Information</legend>
	
		Student ID &emsp; &emsp; : &nbsp;
		<input type="text" id="textfield" name="id" placeholder = "Enter your Student ID"> <br><br>
		
		Full Name &emsp; &emsp; : &nbsp; 
		<input type="text" id="textfield" name="fullname" placeholder = "Enter your full name"> <br><br>
		
		E-mail &emsp; &emsp; &emsp; &nbsp; :  &nbsp;
		<input type="email" id="textfield" name="email" placeholder = "Enter your email"> <br><br>
		
		Phone Number &ensp; : &nbsp;
		<input type="text" id="textfield" name="phonenum" placeholder = "Enter your phone number"> <br><br>
		
	</fieldset><br>
	<fieldset style="width:500px;margin:auto">
	<legend style="font-weight:bold">Reference</legend>
	
		What kind of reference do you consider the most useful? <br><br>
		
		<input type="radio" name="reference" value="Text Books">
		Text Books 
		<input type="radio" name="reference" value="Lecture Slides">
		Lecture Slides
		<input type="radio" name="reference" value="Manual">
		Manual 

	</fieldset><br>
	
	<fieldset style="width:500px;margin:auto">
	<legend style="font-weight:bold">Local Server</legend>
		What local server do you enjoy using?<br><br>
		
		<select name="server">
		<option value="XAMPP"> XAMPP Server</option>
		<option value="WAMP">WAMP Server</option>
		</select>
	</fieldset>
	
	<p style="text-align:center">
	<input type="submit" id="button" value="Submit">
	<input type="button" id="button" value="Survey List" onClick="document.location.href='students_list.php'">
	</p>
	
	</form>
	
	</body>

</html>