<?php 

//IGNORE!!!!!!!!!!!!!!!!!!!!!!!!!!!!! NOT FOR OUR USE RN

    if(isset($_POST['submit'])){
        session_start();
        include "../secure/database.php";
        $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
        if($mysqli->connect_errno){
            echo "Connection failed on line 5";
            exit();
        }
        $query = "SELECT * FROM employee WHERE username=?";
        $stmt = $mysqli->stmt_init();
        if(!$stmt->prepare($query))
        {
            exit();
        }
        $username = $_POST['username'];
        $_SESSION['username'] = $username;
        $stmt->bind_param("s", $username);
        $name = htmlspecialchars($username);
        $stmt->execute();

        $result = $stmt->get_result();
        $exists = $result->num_rows;
        echo "Found: " . $exists;

        //echo $_POST['position'];
        
        
        if($exists == 0){
        $query = "INSERT INTO employee VALUES(?,?,?,?)";
        $stmt = $mysqli->stmt_init();
        if(!$stmt->prepare($query)){
            exit();
        }
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        echo $hash;
        $stmt->bind_param("ssss", $_POST['username'], $hash, $_POST['firstname'], $_POST['lastname']);
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