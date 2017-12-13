<?php
    session_start();
    include "secure/database.php";
    $mysqli = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

    if (!isset($_SESSION['user'])) {
        header("Location: http://cs3380.rnet.missouri.edu/~GROUP7/index.php");
    }

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
            <div class="col-md-2" id="Space">  
                <!--<img src="http://img.clipartall.com/train-track-clip-art-train-track-clipart-263_262.png">-->
            </div>
            <div class="col-md-5" id="SearchUser" >
                <h2>Search User</h2>
                <form action="" method="POST" class="col-md-4 col-md-offset-3" id="Search">
	               Search: 
	               <input type="text" name="search" placeholder="Last Name">
	               <br><br>
	               <input type="radio" name="radios" value="0" checked="check"> Conductor <br>
	               <input type="radio" name="radios" value="1"> Engineer
	               <br><br>
	               <input class="btn btn-primary" type="submit" name="submit2" value="Execute">
                </form>
                <style>
                    h1 {
                        text-align: center;
                    }
                </style>
                
                <?php
              if(isset($_POST['submit2'])){
               $param = "{$_POST['search']}%";
                  //conductor
               if($_POST['radios'] == 0){
		          $sql = "SELECT username, first_name, last_name, position FROM employee WHERE position=3 AND last_name LIKE ?";
	           } elseif ($_POST['radios'] == 1){
                   //engineer
		          $sql = "SELECT username, first_name, last_name, position FROM employee WHERE position=2 AND last_name LIKE ?";
               }
               $stmt = $mysqli->stmt_init() or die($mysqli->error . " line 45 ");
                //echo $sql;
                $stmt->prepare($sql) or die ($mysqli->error);
                $stmt->bind_param("s", $param) or die ("Line 163");
                $stmt->execute() or die ("Line 164");
                $result = $stmt->get_result() or die("line 165");
               echo "<div>";
               echo "<table class='table table-hover'>"; 
                echo "Number of Results: " . $result->num_rows; //Display number of results
                // Collect column names in a while loop and place mark them as headers in out table
                while($fieldInfo = mysqli_fetch_field($result)){
                    echo "<th>". $fieldInfo->name. "</th>";
                }    
                echo "</thead>";
    
                //Execute query
                while($row = $result->fetch_array(MYSQLI_NUM)){ //Fetch the results as a numeric array
                echo "<tr>"; //Each element of the array is a row
                foreach($row as $r){
                    echo "<td>" . $r . "</td>";
                }
                ?>
       <!--Create a for to add update and deletion options for the admin-->
        <td>
        <form action="deleteEmployee.php" method="POST">
            <!--Use this line below to pass the user's username type-->
          <input type="hidden" name="username" value='<?= $row[0]; ?>'>
            <input type="hidden" name="type" value="<?php if ($row[3] == 1) { echo "engineer"; } if ($row[3] == 2) { echo "conductor"; } ?>" />
            <input type="submit" name="delete" value="delete">
        </form>
        </td>
        <td>
        <form action="updateEmployee.php" method="POST">
              <!--Use this line below to pass the user's username type-->
           <input type="hidden" name="username" value='<?= $row[0]; ?>'> 
          <input type="submit" name="update" value="update">
          </form>
        </td>
       
        <?php 
        echo "</tr>";
        }
        echo "</table>"; 
        echo "</div>";
                  //$stmt->close();
        //$mysqli->close(); //Close mysql connection
           }
           
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

            
<!--FOR ADD USER-->
<div class="modal fade" id="AddUser" tabindex="-1" role="dialog"
aria-labelledby="AddEngineerLabel" aria-hidden="true">
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
            Add User
        </h4>
    </div>

       <!-- Modal Body -->
        <form id="thisIsID" method="post" class="form-horizontal" role="form">
            <div class="modal-body">
                <input type="hidden" name="action" value="register" />
                <div class="form-group copt hide">
                    <label class="col-sm-3 control-label"
                    for="username">Username</label>
                    <div class="col-sm-9">
                        <input type="number" name="username" min="1" max="999999" class="form-control"
                        id="username" placeholder="Username"/>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="username">Username</label>
                    <div class="col-sm-9">
                        <input type="text" name="username" class="form-control"
                        id="username" placeholder="Username"/>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="inputPassword3" >Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control"
                        id="password" placeholder="Password"/>
                    </div>
                </div>

                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="firstname">First Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="firstname" class="form-control"
                        id="firstname" placeholder="First Name"/>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="lastname">Last Name</label>
                    <div class="col-sm-9">
                        <input type="text" name="lastname" class="form-control"
                        id="lastname" placeholder="Last Name"/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"
                    for="position">Position</label>
                    <div class="col-sm-9">
                        <select id="registerPosition" class="form-control" name="position">
                            <option value="1">Engineer</option>
                            <option value="2">Conductor</option>
                        </select>
                    </div>
                </div>
            </div>

        <div class="modal-footer">
            <input type="submit" name="submit1" class="btn btn-primary" />
        </div>
    </form>
</div>
</div>
    
    <?php
        if(isset($_POST['submit1'])){
            if($mysqli->connect_errno){
                echo "Connection failed";
                exit();
            }
            
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            //Hash password (to meet requirements)
            $passhash = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
            
            $query = "SELECT * FROM employee WHERE username=? AND password=? AND first_name=? AND last_name=? AND position=?";
            $stmt = $mysqli->stmt_init();
            if(!$stmt->prepare($query))
            {
                exit();
            }
            $stmt->bind_param("sssss", $_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['position']);
            $stmt->execute();
            $result = $stmt->get_result();
            $exists = $result->num_rows;
            echo "Found: " . $exists;
    
            if($exists == 0){
                $query = "INSERT INTO employee VALUES(?,?,?,?,?)";
                $stmt = $mysqli->stmt_init();
                if(!$stmt->prepare($query)){
                    exit();
                }
                $stmt->bind_param("sssss", $username, $passhash, $_POST['firstname'], $_POST['lastname'], $_POST['position']);
                $stmt->execute();
                echo "<hr>User created<br>";
            } else {
                echo "<hr>User name taken";
            }
            $stmt->close();
            $mysqli->close();
        }
    ?>
    
    
</div>

<!--FOR CHANGING PASSWORD!!!    -->
<div class="modal fade" id="EditProfile" tabindex="-1" role="dialog"
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
                        <input type="password" class="form-control" 
                        name="oldPass" placeholder = "Old Password"  />
                    </div>
                    </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"
                          for="NewPassword" >New Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control"
                            name="newPass1" placeholder = "New Password"  />
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
                
                $sql = "SELECT * FROM website_Login;";
							$result = $mysqli->query($sql);
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
    
    
    

<!--FOR TRAIN LOG!!!!-->
 <div class="modal fade" id="TrainLogging" tabindex="-1" role="dialog"
aria-labelledby="mySecondModalLabel" aria-hidden="true">
<div class="modal-dialog" style="display:table;">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <button type="button" class="close"
            data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
            Train Logging
        </h4>
    </div>

        <!-- Modal Body -->
            <div class="modal-body" style="display:table;">
             <?php  
                
                echo "<div class='panel'>";

            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }    
                
                echo "<div class='panel'>";
                echo '<table class="table table-striped">';
                echo "<tr>";
                
                $sql = "SELECT * FROM equipment WHERE reservation_status='1';";
							$result = $mysqli->query($sql);
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
    
    
  
    
<!-- ADD EQUIPMENT!!! -->    
<div class="modal fade" id="AddEquip" tabindex="-1" role="dialog"
aria-labelledby="AddEngineerLabel" aria-hidden="true">
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
            Add Equipment
        </h4>
    </div>

       <!-- Modal Body -->
        <form id="thisIsID" method="post" class="form-horizontal" role="form">
            <div class="modal-body">
                <input type="hidden" name="action" value="register" />
                <div class="form-group copt">
                    <label class="col-sm-3 control-label"
                    for="username">Serial Number</label>
                    <div class="col-sm-9">
                        <input type="number" name="serial_number" min="1" max="99999999" class="form-control"
                        id="username" placeholder="Serial Number"/>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="username">Load Capacity</label>
                    <div class="col-sm-9">
                        <input type="text" name="load_capacity" class="form-control"
                        id="username" placeholder="Load Capacity"/>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="inputPassword3">Type</label>
                    <div class="col-sm-9">
                        <select id="registerPosition" class="form-control" name="type">
                        <!--selected disabled -->
                        <option selected>Choose a type</option>
                        <option value="coal car">Coal</option>
                        <option value="locomotive">Locomotive</option>
                        <option value="box car">Box Car</option>
                        <option value="grain hopper">Grain Hopper</option>
                        <option value="caboose">Caboose</option>
                        <option value="flat bed">Flat Bed</option>
                    </select>
                    </div>
                </div>

                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="firstname">Train ID Number</label>
                    <div class="col-sm-9">
                        <select id="registerTrain" class="form-control" name="train_id_number">
                            <?php
                                $stmt = $mysqli->prepare("SELECT id_number FROM train");
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result && $result->num_rows) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id_number'] . "'>" . $row['id_number'] . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"
                    for="position">Location</label>
                    <div class="col-sm-9">
                        <select id="registerPosition" class="form-control" name="location">
                            <option selected>Choose a city from</option>
                            <option value="Saint Louis">St. Louis, MO</option>
                            <option value="Kansas City">Kansas City, MO</option>
                            <option value="Chicago">Chicago, IL</option>
                            <option value="Memphis">Memphis, TN</option>
                            <option value="Los Angeles">Los Angeles, CA</option>
                            <option value="San Diego">San Diego, CA</option>
                            <option value="San Francisco">San Francisco, CA</option>
                            <option value="New York City">New York City, NY</option>
                            <option value="Houston">Houston, TX</option>
                            <option value="Dallas">Dallas, TX</option>
                            <option value="San Jose">San Jose, TX</option>
                            <option value="Austin">Austin, TX</option>
                            <option value="Indianapolis">Indianapolis, IN</option>
                            <option value="Jacksonville">Jacksonville, FL</option>
                            <option value="Phoenix">Phoenix, AZ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="lastname">Manufacturer</label>
                    <div class="col-sm-9">
                        <select id="registerPosition" class="form-control" name="manufacturer">
                            <option selected>Choose a city from</option>
                            <option value="American Railcar">American Railcar</option>
                            <option value="Vertex Railcar">Vertex Railcar</option>
                            <option value="Trinity Industries">Trinity Industries</option>
                            <option value="Greenbrier">Greenbrier</option>
                        </select>    
                    </div>
                </div>
                <div class="form-group opt">
                    <label class="col-sm-3 control-label"
                    for="lastname">Price</label>
                    <div class="col-sm-9">
                        <input type="text" name="price" class="form-control"
                        id="lastname" placeholder="Price"/>
                    </div>
                </div>
                
                
            </div>

        <div class="modal-footer">
            <input type="submit" name="add" class="btn btn-primary" value="Add To Table"/>
        </div>
    </form>
</div>
</div>
    
    <?php
        if(isset($_POST['add'])){
            if($mysqli->connect_errno){
                echo "Connection failed";
                exit();
            }
            
            $query = "SELECT * FROM equipment WHERE serial_number=?";
            $stmt = $mysqli->stmt_init();
            if(!$stmt->prepare($query))
            {
                echo "Statement error";
            }
            $stmt->bind_param("s", $_POST['serial_number']);
            $stmt->execute();
            $result = $stmt->get_result();
            $exists = $result->num_rows;
            echo "Found: " . $exists;
    
            if($exists == 0){
                $query = "INSERT INTO equipment VALUES (?,?,?,?,?,?,?,'0')";
                //last number set to zero to indicate that it is unreserved
                $stmt = $mysqli->prepare($query);
                
                //created variables here to help keep track of the POST and to eliminate typos
                $serial_number = $_POST['serial_number'];
                $load_capacity = $_POST['load_capacity'];
                $type = $_POST['type'];
                $train_id_number = $_POST['train_id_number'];
                $location = $_POST['location'];
                $manufacturer = $_POST['manufacturer'];
                $price = $_POST['price'];
                
                //i = integer, s = string
                $stmt->bind_param("iisissi", $serial_number, $load_capacity, $type, $train_id_number, $location, $manufacturer, $price);
                //if everything runs smoothly, print confirmation
                if ($stmt->execute()) {
                    echo "<hr>debug user created :)<br>";
                } else {
                    echo $stmt->error;
                }
            } else {
                echo "<hr>debug User name taken";
            }
            $stmt->close();
            $mysqli->close();
        }
    ?>
    
    
</div>   
    
    
    </body>
   
                      

</html>
  