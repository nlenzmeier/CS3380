<?php 

     if(isset($_POST['submit'])){
        session_start();
        include("../secure/database.php");
        $mysql = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($mysql->connect_errno){
             echo "Connection failed on line 5";
             exit();
         }
        $query = "SELECT * FROM userLogin WHERE name=?";
        $name = htmlspecialchars($_POST['name']);
        $password = htmlspecialchars($_POST['pass']);
        $stmt = $mysql->stmt_init();
        if (!$stmt->prepare($query)){
            exit();
        }
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        $rowcount=mysqli_num_rows($result);
        $row = $result->fetch_assoc();
        // echo $rowcount;
        // echo $password;
        // echo (string)password_verify($password, $row['password']);

        if($rowcount > 0 && password_verify($password, $row['password'])) {
            $_SESSION['name'] = $name;
            header('Location: http://cs3380.rnet.missouri.edu/~nalyv2/lab7/profile.php/');
        }
        else echo 'Invalid username or password';
   }

    // if(isset($_POST['submit'])){
    //     session_start();
    //     include "../secure/database.php";
    //     $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
    //     if($mysqli->connect_errno){
    //         echo "Connection failed on line 5";
    //         exit();
    //     }
    //     $query = "SELECT * FROM userLogin WHERE name=?";
    //     $stmt = $mysqli->stmt_init();
    //     if(!$stmt->prepare($query))
    //     {
    //         exit();
    //     }

    //     $name = $_POST['name'];
    //     $_SESSION['name'] = $name;
    //     $stmt->bind_param("s", $name);
    //     $name = htmlspecialchars($name);
    //     $stmt->execute();

    //     $passwordQuery = "SELECT * FROM userLogin WHERE password=?";
    //     $stmt2 = $mysqli->stmt_init();
    //     if(!$stmt2->prepare($passwordQuery))
    //     {
    //         exit();
    //     }

    //     $pass = $_POST['pass'];
    //     $_SESSION['pass'] = $pass;
    //     $stmt2->bind_param("s", $pass);
    //     $pass = htmlspecialchars($pass);
    //     $stmt2->execute();


    //     $result = $stmt->get_result();
    //     $exists = $result->num_rows;
    //     echo "Found: " . $exists;

    //     $pResult = $stmt2->get_result();
    //     $exists2 = $pResult->num_rows;
    //     echo "Found: " . $exists2;

    //     $result = $stmt->get_result();
    //     $rowcount=mysqli_num_rows($result);
    //     $row = $result->fetch_assoc();

    //     if($exists != 0 && password_verify($pass, $row['password'])){
    //     //if($exists != 0 && $exists2 != 0){
    //     //$query = "INSERT INTO userLogin VALUES(?,?)";
    //     	$stmt = $mysqli->stmt_init();
    //     	if(!$stmt->prepare($query)){
    //         	exit();
    //     	}
    //     	//$hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    //     	//$stmt->bind_param("ss", $_POST['name'], $hash);
    //     	$stmt->execute();
    //     	//echo "<hr>User created<br>";
    //     	header('Location: http://cs3380.rnet.missouri.edu/~nalyv2/lab7/profile.php');
    //     } 
    //     else {
    //     echo "<hr>User name is already taken";
    //     }
    //     $stmt->close();
    //     $mysqli->close();
    // }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Returning User</title>
    
    <script>
        $(function(){
            $("input[type=submit]").button();
        });
    </script>
    
</head>

<body>
	<p>Welcome back!</p>

	<form action="" method=POST>
  		Name:<br>
  		<input type=text name="name" required="required"> <br>
  		Password:<br>
  		<input type="text" name="pass" required="required">
  		<br><br>
  		<input type="submit" name="submit">
	</form>
</body>
</html>