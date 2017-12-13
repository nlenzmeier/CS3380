<!DOCTYPE html>
<html>
    <head>
        <!--  I USE BOOTSTRAP BECAUSE IT MAKES FORMATTING/LIFE EASIER -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->
    </head>

<body class="container">
<br>
<a href="http://cs3380.rnet.missouri.edu/~nalyv2/lab9/insert.php">Insert Into User</a>
<hr>
<form action="" method="POST" class="col-md-4 col-md-offset-5">
	Search: 
	<input type="text" name="search">
	<br><br>
	<input type="radio" name="radios" value="0" checked="check"> Name
	<input type="radio" name="radios" value="1"> Department
    <input type="radio" name="radios" value="2"> Course ID
	<br><br>
	<input class="btn btn-primary" type="submit" name="submit" value="Execute">
</form>

<?php
if(isset($_POST['submit'])){
	include "../secure/database.php";
    $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    if ($mysqli->connect_errno) { //Terminate script if there is a connection error
	    echo "Failed to connect to MySQLI on Line 30";
	    exit();
	}
	/**
	 * The big problem with my implementation of the search is that I am not using prepared statements.
	 * For you lab, you will need to change this code to use prepared statements.
	 */
    
    $param = "{$_POST['search']}%";
	if($_POST['radios'] == 0){
		$sql = "SELECT * FROM classes WHERE name LIKE ?";
	} elseif ($_POST['radios'] == 1){
		$sql = "SELECT * FROM classes WHERE department LIKE ?";
	}elseif ($_POST['radios'] == 2){
        $sql = "SELECT * FROM classes WHERE course_id LIKE ?";
    }
    $stmt = $mysqli->stmt_init() or die($mysqli->error . " line 45 ");
    
//    if(!$stmt->prepare($sql))
//    {
//        echo "Line 49";
//        print "Failed to prepare statement\n";
//        exit();
//    }
    echo $sql;
    $stmt->prepare($sql) or die ($mysqli->error);
	$stmt->bind_param("s", $param) or die ("Line 55");
    $stmt->execute() or die ("Line 56");
    $result = $stmt->get_result() or die("line 57");
    
    echo "<table class='table table-hover'>"; 
    echo "Number of Results: " . $result->num_rows; //Display number of results
    // Collect column names in a while loop and place mark them as headers in out table
    while($fieldInfo = mysqli_fetch_field($result)){
        echo "<th>". $fieldInfo->name. "</th>";
    } 
    echo "</thead>";
    
     //Execute query
    while($row = $result->fetch_array(MYSQLI_NUM)){ //Fetch the results as a numeric array
        echo "<tr>"; //Each element of the array is a row
        /*
         * Each row's data is stored in an array
         * Iterate that array and place each value
         * into the table
         */
        foreach($row as $r){
            echo "<td>" . $r . "</td>";
        }
        ?>
        <td>
        <form action="" method="POST">
          <input type="submit" name="delete" value="delete">
          </form>
        </td>
        <td>
        <form action="" method="POST">
          <input type="submit" name="update" value="update">
          </form>
        </td>
        <?php 
        echo "</tr>";
    }
    echo "</table>";
    $mysqli->close(); //Close mysql connection
}