<!--for CS3380!-->

<?php 

    if(isset($_POST['submit'])){
        session_start();
        include "../secure/database.php";
        $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($mysqli->connect_errno){
            echo "Connection failed on line 5";
            exit();
        }
        $query = "SELECT * FROM userLogin WHERE name=?";
        $stmt = $mysqli->stmt_init();
        if(!$stmt->prepare($query))
        {
            exit();
        }
        $name = $_POST['name'];
        $_SESSION['name'] = $name;
        $stmt->bind_param("s", $name);
        $name = htmlspecialchars($name);
        $stmt->execute();

        $result = $stmt->get_result();
        $exists = $result->num_rows;
        echo "Found: " . $exists;

        if($exists == 0){
        $query = "INSERT INTO userLogin VALUES(?,?)";
        $stmt = $mysqli->stmt_init();
        if(!$stmt->prepare($query)){
            exit();
        }
        $hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        echo $hash;
        $stmt->bind_param("ss", $_POST['name'], $hash);
        $stmt->execute();
        echo "<hr>User created<br>";
        header('Location: http://cs3380.rnet.missouri.edu/~nalyv2/lab7/profile.php');
        } else {
        echo "<hr>User name is already taken";
        }
        $stmt->close();
        $mysqli->close();
}

?>


<!DOCTYPE html>
<html>

<head>
	<title>Register</title>
    
    <script>
        $(function(){
            $("input[type=submit]").button();
        });
    </script>
    
</head>

<body>

<p>Welcome, new user!</p>

<form action="" method=POST>
  Name:<br>
  <input type=text name="name" required="required"> <br>
  Password:<br>
  <input type="text" name="pass" required="required">
  <br><br>
  <input type="submit" name="submit">
  <a href='http://cs3380.rnet.missouri.edu/~nalyv2/lab7/login.php'>Already have an account?</a>
</form>

</body>


</html>
