<!DOCTYPE html>
<html>

<head>
	<title>Lab 2</title>

</head>

<body>

	<form action="lab2.php" method="POST">
		
		Name: <input type="text" name="name">
		<br>
		
		Major:  
		<br>
		<input type="radio" name="major" value="Computer Science">Computer Science<br> <!--Give this and line 
		for "other" the same name (i.e. "major") because that way they can only choose one -->
		<input type="radio" name="major" value="Other" checked="checked">Other<br>
		
		Year: 
		<select name="year">
			<option value="Freshman">Freshman</option>
			<option value="Sophomore">Sophomore</option>
			<option value="Junior">Junior</option>
			<option value="Senior">Senior</option>
		</select>	
		<br>
		<input type="submit" name="submit" value="Submit">
	</form>

	<?php
		//C with $ in fron of variables
		if(isset($_POST['submit'])){
			echo "NAME: ".$_POST['name']."<br>";
			echo "MAJOR: " .$_POST['major']. "<br>";
			echo "YEAR: " .$_POST['year']."<br>";
			
			
		}

	?>

</body>

</html>
