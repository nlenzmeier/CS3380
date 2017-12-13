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

<html lang="en">
<head>
  <title>Engineer's Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }

    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 450px}


    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;

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

   h2 {
    text-align: center;
	}

	#TrainLog{
	background-color: #9E9E9E;
	height:75%;

	}

	#profile{
	background: rgba(192,192,192,0.8);
	height:75%;
    width: 100%;
    height: auto;
    display: table;
	}
      
      .background {
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            padding: 112px;
            background-image: url(photos/employee.jpg);
            background-attachment: fixed;
            border: 1px solid black;
            background-size: 100% 100%;
      }
      
      #welcome {
          text-align: center;
          color: white;
      }
      
      .footerClass{
          position: relative;
          
      }


  </style>
</head>

<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="logout.php">OFF THE RAILS</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav navbar-right">
          <li data-toggle="modal" data-target="#WebLog"><a><span class="glyphicon glyphicon-user"></span> Web Logging</a></li>
       <li data-toggle="modal" data-target="#EditProfile"><a href="#"><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
      </ul>
    </div>
  </div>
</nav>

<body class="background">

   <div class="container">
      <div class="row">

          <div class="col-md-12">
              <h1 color = "white" id="Welcome">Welcome <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']; ?></h1>
		  </div>

	  </div>
   </div>

   <div class="container">
      <div class="row">
          <div class="col-md-9" id="profile">
                <h2>Profile Information</h2>
              
              <?php
        echo "<div class='panel'>";

            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }    
                
                echo "<div class='panel'>";
                echo '<table class="table table-striped">';
                echo "<tr>";
                
                $query = "SELECT * FROM engineer WHERE username=?;";
                    $stmt = $mysqli->stmt_init();
//                    if(!$stmt->prepare($query))
//                    {
//                        echo "Statement error";
//                    }
                    $stmt->prepare($query);
                    $userid = $_SESSION['user']['username'];
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
    
    
       <div class="container">
      <div class="row">
          <div class="col-md-9" id="profile">
                <h2>Train Log</h2>
              
              <?php
        echo "<div class='panel'>";

            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }    
                
                echo "<div class='panel'>";
                echo '<table class="table table-striped">';
                echo "<tr>";
                
                $query = "SELECT * FROM travel_Log WHERE username=?;";
                    $stmt = $mysqli->stmt_init();
//                    if(!$stmt->prepare($query))
//                    {
//                        echo "Statement error";
//                    }
                    $stmt->prepare($query);
                    $userid = $_SESSION['user']['username'];
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

<footer class="navbar-fixed-bottom footerClass">
	<div class="text-center">
 	<p class="text-muted">Copyright &copy; OFF THE RAILS 2017</p>
	</div>
</footer>


   <!-- Modal -->
<div class="modal fade" id="EditProfile" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Change Password
                </h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <form id="thisIsID" method="post" class="form-horizontal" role="form">
                  <div class="form-group">
                    <label  class="col-sm-4 control-label"
                              for="OldPassword">Old Password</label>
                    <div class="col-sm-8">
                        <input type="password" name="oldPass" class="form-control"
                         placeholder = "Old Password"  />
                    </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"
                          for="NewPassword" >New Password</label>
                    <div class="col-sm-8">
                        <input type="password" name="newPass1" class="form-control"
                            id="NewPassword" placeholder = "New Password"  />
                    </div>
                  </div>

                    <div class="form-group">
                    <label  class="col-sm-4 control-label"
                              for="NewPassword">Confirm New Password</label>
                    <div class="col-sm-8">
                        <input type="password" name="newPass2" class="form-control"
                          placeholder = "Confirm New Password" />
                    </div>
                  </div>
                   <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button onclick="submitForm()" name="update" class="btn btn-primary">Submit</button>
                
                
                   <?php
//	               include "secure/database.php";
//
//                    $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

                if (isset($_POST['update'])) {
                    $oldPassHash = password_hash(htmlspecialchars($_POST['oldPass']), PASSWORD_DEFAULT);

                    if (!password_verify($_POST['oldPass'], $_SESSION['user']['password'])) {
                      echo "Old password does not match.";
                      return;
                    }

                    if (empty($_POST['oldPass']) || empty($_POST['newPass1']) || empty($_POST['newPass2'])) {
                      echo "All password fields are required.";
                      return;
                    }

                    if ($_POST['newPass1'] != $_POST['newPass2']) {
                      echo "New passwords do not match.";
                      return;
                    }

                    $username = $_SESSION['user']['username'];
                    $newPass = password_hash(htmlspecialchars($_POST['newPass1']), PASSWORD_DEFAULT);
                    $stmt = $mysqli->prepare("UPDATE employee SET password = ? WHERE username = ?");
                    $stmt->bind_param("ss", $newPass, $username);
                    if ($stmt->execute()) {
                      $_SESSION['user']['password'] = $newPass;
                      echo "Password has been updated.";
                      return;
                    } else {
                      echo "Error updating password.";
                      return;
                    }
                  }
	         
			     ?>
                

                <script type="text/javascript">
                    function submitForm(){
                        document.getElementById("thisIsID").submit();
                    }
                </script>

            </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    
    
<!--FOR WEB LOG!!!!-->
 <div class="modal fade" id="WebLog" tabindex="-1" role="dialog"
aria-labelledby="mySecondModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <button type="button" class="close"
            data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
            Web Logging
        </h4>
    </div>

        <!-- Modal Body -->
            <div class="modal-body">
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
                    $userid = $_SESSION['user']['username'];
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
</div>       

    </body>

</html>









