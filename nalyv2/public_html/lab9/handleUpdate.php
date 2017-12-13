<?php
	if(isset($_POST['submit'])){
        include "../secure/database.php";
        $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if ($mysqli->connect_errno) { //Terminate script if there is a connection error
	       echo "Failed to connect to MySQLI on Line 30";
	       exit();
	    }
		$query = "UPDATE classes SET name=?, department=?, start=?, end=?, days=? WHERE course_id=?";
    	$stmt = $mysqli->stmt_init();
    	$stmt->prepare($query) or die("Prepare error: ".mysqli_error($mysqli));

    	$stmt->bind_param("ssssss", $_POST['name'], $_POST['department'], $_POST['start'], $_POST['end'], $_POST['days'], $_POST['course_id']);
    	$stmt->execute() or die ($mysqli->error);
        echo ("Update successful!");
	}
?>
<br>
<a href="http://cs3380.rnet.missouri.edu/~nalyv2/lab9/lab9.php">Search</a>