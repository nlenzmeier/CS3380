

<!DOCTYPE html>
<html>
    <head>
       <title>Lab 9</title>
        
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
        session_start();
        include "../secure/database.php";
        $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($mysqli->connect_errno){
            echo "Connection failed";
            exit();
        }
        
        if($_POST['radios'] == 0){
            $stmt = mysqli_prepare($mysqli, "SELECT * FROM classes WHERE `name` LIKE '" . $_POST['search'] . "%';");
        }
        if($_POST['radios'] == 1){
            $stmt = mysqli_prepare($mysqli, "SELECT * FROM classes WHERE `department` LIKE '" . $_POST['search'] . "%';");
        }
        if($_POST['radios'] == 2){
            $stmt = mysqli_prepare($mysqli, "SELECT * FROM classes WHERE `course_id` LIKE '" . $_POST['search'] . "%';");
        }
        
        
//        $stmt = $mysqli->stmt_init();
//        if(!$stmt->prepare($stmt))
//        {
//            echo "ERROR!!!";
//            exit();
//        }
        
        $result = $mysqli->query($stmt); //Execute query
        echo "<table class='table table-hover'>"; 
        echo "Number of Results: " . $result->num_rows; //Display number of results
        // Collect column names in a while loop and place mark them as headers in out table
        while($fieldInfo = mysqli_fetch_field($result)){
            echo "<th>". $fieldInfo->name. "</th>";
        } 
        echo "</thead>";
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
?>
    
    
    
</body> 
</html>


