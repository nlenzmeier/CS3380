<?php
  session_start();

  if (!isset($_SESSION['user'])) {
    header("Location: index.php");
  }
include "secure/database.php";
$mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);
if ($mysqli->connect_errno) { //Terminate script if there is a connection error
	   echo "Failed to connect to MySQLI on Line 30";
	   exit(); 
}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Welcome!</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */

      .background {
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            padding: 112px;
            background-image: url(photos/danish_train_desktop.png);
            background-attachment: fixed;
            border: 1px solid black;
            background-size: 100% 100%;
      }

    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}

    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
    }

    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
      
      #prevLog {
          color: white;
          
      }
      
  </style>
</head>
<body class="background">
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="logout.php">Off the Rails!</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="shop.php">Home</a></li>
        <li><a href="reserve.php">Reserve Cars</a></li>
        <li><a href="about.php">About</a></li>
      </ul>
<!--
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
-->
    </div>
  </div>
</nav>

<div class="container-fluid text-center">
  <div class="row content">
<!--
    <div class="col-sm-2 sidenav">
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </div>
-->
    <div class="col-sm-8 text-left">
      <h1>Welcome</h1>
      <p>We have a wide range of trains and cars for all of your traveling needs!<br>
        Click and on the above tags to learn more about the company, our products, and more.</p>
      <hr>
        
        <h2 color="white" id="prevLog">Your Previous Logs with Off The Rails!:</h2>
        <?php
        echo "<div class='panel'>";

            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }    
                
                echo "<div class='panel'>";
                echo '<table class="table table-striped">';
                echo "<tr>";
                
                $query = "SELECT * FROM website_Login WHERE user=?;";
                    $stmt = $mysqli->stmt_init();
//                    if(!$stmt->prepare($query))
//                    {
//                        echo "Statement error";
//                    }
                    $stmt->prepare($query);
                    $userid = $_SESSION['user']['company_id'];
                    $stmt->bind_param("s", $userid);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
							//$result = $mysqli->query($query);
							if(!$result){
								die('Could not get data: ' . mysqli_error);
							}
							//echo "Showing the start time for each class";
							echo "<br>";
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
                
                echo "</div></div>";
             ?>   
        
        
    </div>

  </div>
</div>
</body>
</html>
