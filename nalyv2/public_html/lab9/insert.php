<html>
    <head>
        <!--  I USE BOOTSTRAP BECAUSE IT MAKES FORMATTING/LIFE EASIER -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"><!-- Optional theme -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->
    </head>

<body class="container">
<br>
<a href="http://cs3380.rnet.missouri.edu/~nalyv2/lab9/lab9.php">Search</a>
<hr>
<form action="" method=POST>
  Name:<br>
  <input type=text name="name" required="required"> <br>
  Department:<br>
  <input type="text" name="department" required="required"><br>
  Course ID:<br>
  <input type=text name="course_id" required="required"> <br>    
    Start Time:<br>
    <select name="start" required="required">
        <option value="8:00:00">8:00:00 AM</option>
        <option value="8:30:00">8:30:00 AM</option>
        <option value="9:00:00">9:00:00 AM</option>
        <option value="9:30:00">9:30:00 AM</option>
        <option value="10:00:00">10:00:00 AM</option>
        <option value="10:30:00">10:30:00 AM</option>
        <option value="11:00:00">11:00:00 AM</option>
        <option value="11:30:00">11:30:00 AM</option>
        <option value="12:00:00">12:00:00 PM</option>
        <option value="12:30:00">12:30:00 PM</option>
        <option value="1:00:00">1:00:00 PM</option>
        <option value="1:30:00">1:30:00 PM</option>
        <option value="2:00:00">2:00:00 PM</option>
        <option value="2:30:00">2:30:00 PM</option>
        <option value="3:00:00">3:00:00 PM</option>
        <option value="3:30:00">3:30:00 PM</option>
        <option value="4:00:00">4:00:00 PM</option>
        <option value="4:30:00">4:30:00 PM</option>
        <option value="5:00:00">5:00:00 PM</option>
        <option value="5:30:00">5:30:00 PM</option>
        <option value="6:00:00">6:00:00 PM</option>
</select><br>
    End Time:<br>
     <select name="end" required="required">
        <option value="8:50:00">8:50:00 AM</option>
        <option value="9:15:00">9:15:00 AM</option>
        <option value="9:45:00">9:45:00 AM</option>
        <option value="9:50:00">9:50:00 AM</option>
        <option value="10:15:00">10:15:00 AM</option>
        <option value="10:45:00">10:45:00 AM</option> 
        <option value="10:50:00">10:50:00 AM</option>
        <option value="11:15:00">11:15:00 AM</option>
        <option value="11:45:00">11:45:00 AM</option>
        <option value="11:50:00">11:50:00 AM</option>
        <option value="12:15:00">12:15:00 PM</option>
        <option value="12:45:00">12:45:00 AM</option>
        <option value="12:50:00">12:50:00 PM</option>
        <option value="1:15:00">1:15:00 PM</option>
        <option value="1:45:00">1:45:00 AM</option>
        <option value="1:50:00">1:50:00 PM</option>
        <option value="2:15:00">2:15:00 PM</option>
        <option value="2:45:00">2:45:00 AM</option>
        <option value="2:50:00">2:50:00 PM</option>
        <option value="3:15:00">3:15:00 PM</option>
        <option value="3:45:00">3:45:00 AM</option>
        <option value="3:50:00">3:50:00 PM</option>
        <option value="4:15:00">4:15:00 PM</option>
        <option value="4:45:00">4:45:00 AM</option>
        <option value="4:50:00">4:50:00 PM</option>
        <option value="5:15:00">5:15:00 PM</option>
        <option value="5:45:00">5:45:00 AM</option>
        <option value="5:50:00">5:50:00 PM</option>
        <option value="6:15:00">6:15:00 PM</option>
</select><br>
    Days:<br>
     <select name="days" required="required">
        <option value="MWF">MWF</option>
        <option value="TTh">TTh</option>
</select>
    
  <br><br>
  <input type="submit" name="submit">
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
    $query = "SELECT * FROM classes WHERE name=? AND department=? AND course_id=? AND start=? AND end=? and days=?";
    $stmt = $mysqli->stmt_init();
    if(!$stmt->prepare($query))
    {
        exit();
    }
    $stmt->bind_param("ssssss", $_POST['name'], $_POST['department'], $_POST['course_id'], $_POST['start'], $_POST['end'], $_POST['days']);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows;
    echo "Found: " . $exists;
    /* If we wanted to print results:
        while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            foreach ($row as $r)
            {
                echo "$r ";
            }
            echo "<br>";
        }
    */
    if($exists == 0){
        $query = "INSERT INTO classes VALUES(?,?,?,?,?,?)";
        $stmt = $mysqli->stmt_init();
        if(!$stmt->prepare($query)){
            exit();
        }
        $stmt->bind_param("ssssss", $_POST['name'], $_POST['department'], $_POST['course_id'], $_POST['start'], $_POST['end'], $_POST['days']);
        $stmt->execute();
        echo "<hr>User created<br>";
    } else {
        echo "<hr>User name taken";
    }
    $stmt->close();
    $mysqli->close();
}
?>