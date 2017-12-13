<?php
  session_start();
  include "secure/database.php";
  $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

  ?>

<html lang="en">
<head>
  <title>Administrator's Profile</title>
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
	
	#SearchUser{
	background: rgba(192,192,192,0.8);
	height:75%;
    width: 100%;
    height: auto;
	}
	
	#Space{
	 display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden
    height:75%;
	}
	
	#Space img {
    flex-shrink: 0;
 	height: 570px;
 	width: 570px;
      }
      
      .searchContainer{
          border: 1px solid white;
          padding: 5px;
          background: rgba(192,192,192,0.8);
            height:75%;
            width: 100%;
            height: auto;
          text-align: center;
      }
      
      .footerClass{
          position: relative;
          
      }
      
      .trainLogTable {
          max-width: 100%;
          overflow: scroll;
      }
      
      .modal-body {
  position: relative;
  padding: 15px;
    width: inherit;
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
          color: white;
          text-align: center;
      }
	
	
  </style>
</head>

<body>
<!--Ribbon for the admin page-->    
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
      <!--Icons for pop up windows to add to the database-->
    <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
            <li data-toggle="modal" data-target="#AddEquip"><a><span class="glyphicon glyphicon-user"></span> Add Equipment</a></li>
            <li data-toggle="modal" data-target="#TrainLogging"><a><span class="glyphicon glyphicon-user"></span> Train Logging</a></li>
            <li data-toggle="modal" data-target="#WebLog"><a><span class="glyphicon glyphicon-user"></span> Web Logging</a></li>   
            <li data-toggle="modal" data-target="#AddUser"><a><span class="glyphicon glyphicon-user"></span> Add User</a></li>
            <li data-toggle="modal" data-target="#EditProfile"><a><span class="glyphicon glyphicon-edit"></span> Edit Profile</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
      </ul>
    </div>
  </div>
</nav>

<body class="background">
   <div class="container">
      <div class="row">
          <div class="col-md-12"> 
              <!--Displays the user's first and last name-->
              <h1 color = "white" id="Welcome">Welcome <?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name']; ?></h1>
		  </div>
	  </div>
   </div>

   <div class="searchContainer">
      <div class="row">
<!--
            <div class="col-md-5 trainLogTable" id="TrainLog">          
                <h2>Train Log</h2>
            </div>
-->
        <?php  
          if (!isset($_SESSION['user']) && $_SESSION['user']['position'] != 0) {
      header("Location: http://cs3380.rnet.missouri.edu/~GROUP7/index.php");
  }

  if (!isset($_POST['username']) && !isset($_POST['type'])) {
    echo "Invalid request.";
    return;
  }

  $username = $_POST['username'];
  $stmt = $mysqli->prepare("DELETE FROM " . $_POST['type'] . " WHERE username = ?");
  $stmt->bind_param("s", $username);
  if (!$stmt->execute()) {
    echo $stmt->error;
    return;
  }

  $stmt = $mysqli->prepare("DELETE FROM employee WHERE username = ?");
  $stmt->bind_param("s", $username);
  if (!$stmt->execute()) {
    echo $stmt->error;
    return;
  }

  echo "Success. <a href='admin.php'>Go back.</a>";

?>
          
            <div class="col-md-2" id="Space">  
                <!--<img src="http://img.clipartall.com/train-track-clip-art-train-track-clipart-263_262.png">-->
            </div>
            <div class="col-md-5" id="SearchUser" >
                
       <!--Create a for to add update and deletion options for the admin-->
        <td>
        </td>   
          </div>
       </div>
       
</div>
</body>

<footer class="navbar-fixed-bottom footerClass">
	<div class="text-center">
 	<p class="text-muted">Copyright &copy; OFF THE RAILS 2017</p>
	</div>
</footer>

            

    
    </body>
   
                      

</html>

