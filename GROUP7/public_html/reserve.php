<!--Commented by Nicolle on 4/20/2017-->

<?php
    //create session for all of the PHP code below
  session_start();

  if (!isset($_SESSION['user'])) {
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Reserve Now!</title>
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
      
      .orderLog {
            border: 2px solid white;
            border-radius: 25px;
            padding: 20px;
            background: rgba(210, 180, 140, .5);
      }  
      

      
  </style>
</head>
    
<!-- making classy CSS for our user to ooooh and aaaaaah over -->    
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
        <li><a href="shop.php">Home</a></li>
        <li class="active"><a href="#">Reserve Cars</a></li>
        <li><a href="about.php">About</a></li>   
      </ul>
    </div>
  </div>
</nav>


<div class="container-fluid text-center">    
  <div class="row content">
    <div class="col-sm-8 text-left"> 
      <h1>Shop Now!</h1>
      <hr> 
        <div class="orderLog">
         <form action="" method="POST">
            
            <div>
                <h3>Train car type:</h3>
                    <!--create a drop down menu to prevent user errors-->
                    <select name="type">
                        <!--selected disabled for when the user wants to see everything displayed-->
                        <option selected <?php if(!isset($_POST[ 'type'])) echo "selected"; ?>>Choose a type</option>
                        <option value="coal car" <?php if(isset($_POST['type']) && $_POST['type'] == "coal car") echo "selected"; ?>>Coal</option>
                        <option value="locomotive" <?php if(isset($_POST['type']) && $_POST['type'] == "locomotive") echo "selected"; ?>>Locomotive</option>
                        <option value="box car" <?php if(isset($_POST['type']) && $_POST['type'] == "box car") echo "selected"; ?>>Box Car</option>
                        <option value="grain hopper" <?php if(isset($_POST['type']) && $_POST['type'] == "grain hopper") echo "selected"; ?>>Grain Hopper</option>
                        <option value="caboose" <?php if(isset($_POST['type']) && $_POST['type'] == "caboose") echo "selected"; ?>>Caboose</option>
                        <option value="flat bed" <?php if(isset($_POST['type']) && $_POST['type'] == "flat bed") echo "selected"; ?>>Flat Bed</option>
                    </select>
            </div>
             
            <div>
                <h3>Price Range:</h3>
                    <select name="price">
                        <option selected <?php if(!isset($_POST['price'])) echo "selected"; ?>>Choose a price range</option>
                        <!--created a for loop to generate prices and display it via select options-->
                        <!--create a drop down menu to prevent user errors-->
                        <?php
                            for($i=100; $i<1500; $i) {
                                echo "<option value='" . $i . "-" . ($i+100) . "' ";
                                if(isset($_POST['price']) && $_POST['price'] == $i . "-" . ($i+100)) {
                                    echo "selected";
                                }
                                echo ">" . $i . "-" . ($i+100) . "</option>"; 
                                $i+=100;
                            }
                        ?>
                    </select>
            </div>
             
            <div>
                <h3>Location From:</h3>
                    <!--create a drop down menu to prevent user errors-->
                    <select name="location">
                        <option selected <?php if(!isset($_POST['location'])) echo "selected"; ?>>Choose a city from</option>
                        <option value="Saint Louis" <?php if(isset($_POST['location']) && $_POST['location'] == "Saint Louis") echo "selected"; ?>>St. Louis, MO</option>
                        <option value="Kansas City" <?php if(isset($_POST['location']) && $_POST['location'] == "Kansas City") echo "selected"; ?>>Kansas City, MO</option>
                        <option value="Chicago" <?php if(isset($_POST['location']) && $_POST['location'] == "Chicago") echo "selected"; ?>>Chicago, IL</option>
                        <option value="Memphis"<?php if(isset($_POST['location']) && $_POST['location'] == "Memphis") echo "selected"; ?>>Memphis, TN</option>
                        <option value="Los Angeles" <?php if(isset($_POST['location']) && $_POST['location'] == "Los Angeles") echo "selected"; ?>>Los Angeles, CA</option>
                        <option value="San Diego" <?php if(isset($_POST['location']) && $_POST['location'] == "San Diego") echo "selected"; ?>>San Diego, CA</option>
                        <option value="San Francisco" <?php if(isset($_POST['location']) && $_POST['location'] == "San Francisco") echo "selected"; ?>>San Francisco, CA</option>
                        <option value="New York City" <?php if(isset($_POST['location']) && $_POST['location'] == "New York City") echo "selected"; ?>>New York City, NY</option>
                        <option value="Houston" <?php if(isset($_POST['location']) && $_POST['location'] == "Houston") echo "selected"; ?>>Houston, TX</option>
                        <option value="Dallas" <?php if(isset($_POST['location']) && $_POST['location'] == "Dallas") echo "selected"; ?>>Dallas, TX</option>
                        <option value="San Jose" <?php if(isset($_POST['location']) && $_POST['location'] == "San Jose") echo "selected"; ?>>San Jose, TX</option>
                        <option value="Austin" <?php if(isset($_POST['location']) && $_POST['location'] == "Austin") echo "selected"; ?>>Austin, TX</option>
                        <option value="Indianapolis" <?php if(isset($_POST['location']) && $_POST['location'] == "Indianapolis") echo "selected"; ?>>Indianapolis, IN</option>
                        <option value="Jacksonville" <?php if(isset($_POST['location']) && $_POST['location'] == "Jacksonville") echo "selected"; ?>>Jacksonville, FL</option>
                        <option value="Phoenix" <?php if(isset($_POST['location']) && $_POST['location'] == "Phoenix") echo "selected"; ?>>Phoenix, AZ</option>
                    </select>
           </div>
             <br><br>
           <div>
                <!--Submit button to display options based of user inputs-->
                <input type="submit" value="Check Available Listings">  
           </div>
             
         </form>
        </div>
    </div>
  </div>
</div>
    <footer>
        <div id="priceContainer">Price: $0.00</div>
        <div id="reserveButtonContainer">
            <button id="reserveButton" class="btn btn-info" onclick="reserveButtonClick()">Reserve</button>
            
            <!--JavaScript to keep track of the price as the user changes options-->
            <script>
                function reserveButtonClick() {
                    document.getElementById("reservationForm").submit();
                }
            </script>
        </div> 
    </footer>
    <script>
        //JavaScript to keep track of the price as the user changes options
        function radioClick(price) {
            document.getElementById("priceContainer").innerHTML = price;
        }
    </script>
    
    <?php
            echo "<div class='panel'>";

            include "secure/database.php";
            $link = new mysqli(HOST, USERNAME, PASSWORD, DBNAME);

            if (mysqli_connect_errno())
            {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }    

            function printResult($result) {
                // Print table headers
                echo "<form id='reservationForm' action='reserveCars.php' method='post'>";
                echo "<input type='hidden' name='doReserve' value='true'>";
                echo '<table class="table table-striped">';
                echo "<tr>";
                while($finfo = mysqli_fetch_field($result)) {
                    switch($finfo->name) {
                        case "serial_number":
                            $header = "Serial number";
                            break;
                        case "load_capacity":
                            $header = "Freight capacity";
                            break;
                        case "type":
                            $header = "Type";
                            break;
                        case "location":
                            $header = "Location";
                            break;
                        case "manufacturer":
                            $header = "Manufacturer";
                            break;
                        case "price":
                            $header = "Price";
                            break;
                    }
                    echo "<th>" . $header . "</th>";
                }
                echo "<th>Reserve</th>";
                echo "</tr>";

                // Print table rows
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo "<tr>";
                    $serial = $row["serial_number"];
                    foreach($row as $key => $value) {
                        switch($key) {
                            case "type":
                                switch($value) {
                                    case "grain hopper":
                                        $print = "Grain Hopper";
                                        break;
                                    case "coal car":
                                        $print = "Coal Car";
                                        break;
                                    case "locomotive":
                                        $print = "Locomotive";
                                        break;
                                    case "flat bed":
                                        $print = "Flat Bed";
                                        break;
                                    case "caboose":
                                        $print = "Caboose";
                                        break;
                                    case "box car":
                                        $print = "Box Car";
                                        break;
                                }
                                break;
                            case "price":
                                $print = sprintf("$%.02f", $value);
                                $price = $print;
                                break;
                            default:
                                $print = $value;
                                break;
                        }
                        echo "<td>" . $print . "</td>";
                    }
                    //sends to reserve one they have clicked and submitted their order
                    echo '<td><input type="radio" name="reserve" value="' . $serial . '" onclick="radioClick(' . "'Price: " . $price . "'" . ')"></td>';
                    echo "</tr>";
                }
                echo "</form>";
            }

    
            //create a blank SQL statement that we will concatenate if 
            //the user select certain criteria for their searches
            $where = "";
            //ERROR TESTING
            //var_dump($_POST['price']);
            //var_dump($_POST['location']);
            //var_dump($_POST['type']);
    
            //concatenating statements
            if(!empty($_POST['type'])) {
                if($_POST['type'] == "Choose a type"){
                    $where .="";
                }
                else{
                    $where .= " AND type='" . $_POST['type'] . "'";
                }
            }
            if(!empty($_POST['price'])) {
                if($_POST['price'] == "Choose a price range"){
                    $values[0]=0;
                    $values[1]=1700;
                }
                else{
                    $values = explode("-", $_POST['price']);
                }
                $where .= " AND price>= " . $values[0] . " AND price<= " . $values[1];
            
            }
            if(!empty($_POST['location'])) {
                if($_POST['location'] == "Choose a city from"){
                    $where .="";
                }
                else{
                    $where .= " AND location='" . $_POST['location'] . "'";
                }
            }
            //end concatenating statements
            
            //More error checking...
            //var_dump($where);
    
            //now we use our $where variable and insert it into our SQL select statement
            //so we can have everything our user wanted in one line
            //reservation_status = 0 IFF car is not reserved, 1 otherwise
            if($statement = mysqli_prepare($link, "SELECT serial_number, load_capacity, type, location, manufacturer, price FROM equipment WHERE reservation_status='0'" . $where)) {
                //error checking
                //var_dump($statement);
                mysqli_stmt_execute($statement);
                $result = mysqli_stmt_get_result($statement);
                printResult($result);
                mysqli_stmt_close($statement);
            }

            //close out session
            mysqli_close($link);

            echo "</div>";
        ?>
    
    
</body>
</html>
