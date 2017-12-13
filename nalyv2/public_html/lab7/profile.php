<?php
	session_start();
    if(empty($_SESSION)) {
        header('Location: http://cs3380.rnet.missouri.edu/~nalyv2/lab7/index.php/');
    }
    echo $_SESSION['name'] . ' has successfully logged';
    if(isset( $_POST['logoutBtn'] ) ) {
         header('Location: http://cs3380.rnet.missouri.edu/~nalyv2/lab7/index.php/}}');
         session_destroy();
    }

?>




<!DOCTYPE html>
<html>

<head>
	<title>Congratulations!</title>

</head>

<body>


<!-- 	// // echo "Congratulations," . $query = "SELECT * FROM userLogin WHERE name=?". "! You have been logged in!";

	// 	session_start();
	// 	if(!empty($_SESSION['name'])){
 //    		echo "Welcome, " . $_SESSION['name'] ."! You are logged in!" . "<br>";
 //    			echo "<a href='http://cs3380.rnet.missouri.edu/~nalyv2/lab7/'>Return Home</a>";
 //    	}
 //    	// if(isset($_SESSION['pass'])){
 //    	// 	echo "Your hashed password is: " . $_SESSION['pass'] . "<br>";
 //    	// }	
	// 	else{
 //    		echo "Session not created yet<br>";
 //    		echo "<a href='http://cs3380.rnet.missouri.edu/~nalyv2/lab7/'>Return Home</a>";
	// 	}

	// 	session_destroy(); -->
	
	<form action="" method="post">
        
            <button type="submit" name="logoutBtn">Logout</button>
        
        </form>




</body>

</html> 
