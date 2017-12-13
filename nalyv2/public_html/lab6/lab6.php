<!DOCTYPE html>
<html>
	<head>
		<title>Lab6</title>
	</head>
	<body>
		<form action="" method="post">
				<select id='queries' name='queries'>
					<option value='1'>Show all records</option>
					<option value='2'>Show Start Times</option>
					<option value='3'>Show all classes from a specific department</option>
					<option value='4'>Show Name and Course Id of classes that occur on MWF</option>
					<option value='5'>Show the length of all the classes</option>
			</select>
		<br>
		<input type='submit' value='Submit'>
		<br>
		<br>
		<br>
		</form>
		<?php
		    if (isset($_POST['queries'])) {
		        choice($_POST['queries']);
		    }

		    function choice($queries){
		    	//1) Connect  
		    	echo "<style>
					table, th, td{
						border: 1px solid black;
					}
					th, td{
						padding-right: 15px;
					}
					th{
						text-align: left;
					}
				</style>";
				include("../secure/database.php");
				$link = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error " . mysqli_error($link));
				if(!$link){
					echo "ERROR: Unable t connect to MYSQL" . PHP_EOL;
					echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
					echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
					exit;
				}
				else{
			        switch ($queries) {
			             case '1':
							$sql = "SELECT * FROM classes;";
							$result = $link->query($sql);
							if(!$result){
								die('Could not get data: ' . mysqli_error);
							}
							echo "Showing All Records In the Classes Table";
							echo "<br>";
							echo "<table>";
							while($fieldInfo = mysqli_fetch_field($result)){
								echo "<th>" . $fieldInfo->name . "</th>\n";
							}
							echo "<br>";
							while($row = $result->fetch_array(MYSQLI_NUM)){
								echo "<tr>";
								foreach($row as $data){
									echo "<td>" . $data . "</td>\n\n";
								}
								echo "</tr>";
							}
							echo "</table>";
							break;
						
						case '2':
							$sql = "SELECT name, start from classes;";
							$result = $link->query($sql);
							if(!$result){
								die('Could not get data: ' . mysqli_error);
							}
							echo "Showing the start time for each class";
							echo "<br>";
							echo "<table>";
							while($fieldInfo = mysqli_fetch_field($result)){
								echo "<th>" . $fieldInfo->name . "</th>\n";
							}
							echo "<br>";
							while($row = $result->fetch_array(MYSQLI_NUM)){
								echo "<tr>";
								foreach($row as $data){
									echo "<td>" . $data . "</td>\n\n";
								}
								echo "</tr>";
							}
							echo "</table>";
							break;
						case '3': 
							$sql = "SELECT name, course_id from classes where department ='CS';";
							$result = $link->query($sql);
							if(!$result){
								die('Could not get data: ' . mysqli_error);
							}
							echo "Showing all classes in the CS department";
							echo "<br>";
							echo "<table>";
							while($fieldInfo = mysqli_fetch_field($result)){
								echo "<th>" . $fieldInfo->name . "</th>\n";
							}
							echo "<br>";
							while($row = $result->fetch_array(MYSQLI_NUM)){
								echo "<tr>";
								foreach($row as $data){
									echo "<td>" . $data . "</td>\n\n";
								}
								echo "</tr>";
							}
							echo "</table>";
							break;
						case '4':
							$sql = "SELECT * from classes where days ='MWF';";
							$result = $link->query($sql);
							if(!$result){
								die('Could not get data: ' . mysqli_error);
							}
							echo "Showing classes that occur on MWF";
							echo "<br>";
							echo "<table>";
							while($fieldInfo = mysqli_fetch_field($result)){
								echo "<th>" . $fieldInfo->name . "</th>\n";
							}
							echo "<br>";
							while($row = $result->fetch_array(MYSQLI_NUM)){
								echo "<tr>";
								foreach($row as $data){
									echo "<td>" . $data . "</td>\n\n";
								}
								echo "</tr>";
							}
							echo "</table>";
							break;
						case '5':
							$sql = "SELECT name, timediff(end,start) from classes;";
							$result = $link->query($sql);
							if(!$result){
								die('Could not get data: ' . mysqli_error);
							}
							echo "Showing the Length of time for each class";
							echo "<br>";
							echo "<table>";
							while($fieldInfo = mysqli_fetch_field($result)){
								echo "<th>" . $fieldInfo->name . "</th>\n";
							}
							echo "<br>";
							while($row = $result->fetch_array(MYSQLI_NUM)){
								echo "<tr>";
								foreach($row as $data){
									echo "<td>" . $data . "</td>\n\n";
								}
								echo "</tr>";
							}
							echo "</table>";
							break;
			        }
			    mysqli_close($link);
			    }
		    }
		?>
	</body>
</html>