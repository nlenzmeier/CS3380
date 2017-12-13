<!DOCTYPE html>
<html>

<head>
	<title>Lab 6</title>
</head>

<body>
	<form action="lab6.php" method="POST">
	


<?php

	

	//echo "Hello World!";
	//if(isset($_POST['submit'])){
		//1: connect to database
        $link = mysqli_connect("localhost", "nalyv2", "Tilla012");
        
        if(!$link){
		echo "Error: Unable to connect to MySql" . PHP_EOL;
		echo "Debugging errno: " . mysqli_connect_errno(). PHP_EOL;
		echo "Debugging error:" . mysqli_connect_error(). PHP_EOL;
		exit;	
	   }
        echo "Winner" . PHP_EOL;
        mysqli_close($link);
		//2: query database (switch statement)
//        switch($_POST['query']){
//            case 1: 
//                $sql = "SELECT * FROM classes;";
//            case 2: 
//                
//                
//        }
        //$result = MySqli_query($link, $sql);
		//3: display result
	   
	//}


?>

</body>
</html>
